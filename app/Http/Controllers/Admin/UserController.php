<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfileChangedLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display users.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function index(Request $request)
    {
        try {
            if (request()->ajax()) {
                return datatables()->of(User::whereRole('user')->orderByDesc('created_at')->get())
                    ->addIndexColumn()
                    ->addColumn('name', function ($data) {
                        return $data->first_name . ' ' . $data->last_name;
                    })
                    ->addColumn('action', function ($data) {
//                        return '<a title="Edit" href="user/edit/' . $data->id . '" class="btn btn-dark btn-sm"><i class="fas fa-pencil-alt"></i></a>&nbsp;<button title="Delete" type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                        return '<a title="Edit" href="user/edit/' . $data->id . '" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a><a title="View" href="user/show/' . $data->id . '" class="ml-2 btn btn-secondary btn-sm"><i class="fas fa-eye"></i></a>';
                    })
                    ->rawColumns(['name', 'action'])
                    ->make(true);
            }
        } catch (\Exception $ex) {
            return redirect('/')->with('error', $ex->getMessage());
        }
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'username' => 'required|alpha_dash|unique:user_profile_changed_logs,value,',
            'inviters_username' => ['required', 'alpha_dash', function ($attribute, $val, $fail) {
                if (!$val) return;

                if (!User::where('username', $val)->exists()) {
                    $fail($attribute . ' not found');
                }
            }],
            'phone' => 'required',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'user_image' => 'mimes:jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $inviter = User::where('username', $request->inviters_username)->first();

            $user = User::create([
                'invited_by' => $inviter->id,
                'username' => $request->username,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role' => 'user',
                'password' => Hash::make($request->password),
            ]);

            $userLogs = generateUserProfileLogs($user->id, 'username', $request->username, 0, 'New Account Created', 'accepted');
            $passLogs = generateUserProfileLogs($user->id, 'password', $request->password, 0, 'New Account Created', 'accepted');

            return redirect()->back()->with('success', 'New User Created Successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['user'] = User::where('id', $id)->firstOrFail();
        $data['password'] = UserProfileChangedLogs::where('user_id', $id)->where('key', 'password')->latest()->first();

        return view('admin.users.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $old_user = $user->toArray();

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'username' => 'required|alpha_dash|unique:user_profile_changed_logs,value,' . $user->id . ',user_id|unique:users,username,' . $user->id,
            'invited_by' => 'required|alpha_dash',
            'phone' => 'required',
            'user_image' => 'mimes:jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->getMessageBag())->withInput();
        }

        $input = $request->all();

        // Get Inviters username
        $inviter = User::where('username', $request->invited_by)->first();

        // Check if inviters username is correct
        if ($inviter) {
            $input['invited_by'] = $inviter->id;
        } else {
            return redirect()->back()->with('error', "Inviters username not found");
        }

        $user->username = $request->username;

        // Check if username has been changed
        if ($user->isDirty('username')) {
            generateUserProfileLogs($user->id, 'username', $user->username, $old_user['username'], 'Username changed by admin', 'accepted');
        }

        // Check if password has been changed
        if (Hash::check($request->password, $user->password)) {
            // Password didn't changed
            unset($input['password']);
        } else {
            // Password Changed
            $input['password'] = Hash::make($request->password);
            generateUserProfileLogs($user->id, 'password', $request->password, '', 'Password changed by admin', 'accepted');
        }

        $user->update($input);
        return back()->with('success', 'User Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        echo 1;
    }
}
