<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArchivedUser;
use App\Models\Boards;
use App\Models\GiftLogs;
use App\Models\User;
use App\Models\UserBoards;
use App\Models\UserProfileChangedLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $users = User::whereRole('user')->orderBy('created_at', 'ASC')->get();
        try {
            if (request()->ajax()) {
                return datatables()->of($users)
                    ->addIndexColumn()
                    ->addColumn('name', function ($data) {
                        return $data->first_name . ' ' . $data->last_name;
                    })
                    ->addColumn('action', function ($data) use ($users) {
                        $elementId = $users->count() === 1 ? 'ok_delete' : $data->id;
                        $class = $users->count() === 1 ? '' : 'delete';
//                        return '<a title="Edit" href="user/edit/' . $data->id . '" class="btn btn-dark btn-sm"><i class="fas fa-pencil-alt"></i></a>&nbsp;<button title="Delete" type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                        return '<a title="Edit" href="user/edit/' . $data->id . '" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a><a title="View" href="user/show/' . $data->id . '" class="ml-2 btn btn-secondary btn-sm"><i class="fas fa-eye"></i></a><button title="Delete" type="button"  name="delete" id="' . $elementId . '" data-deleting_id="' . $data->id . '" class="'.$class.' btn btn-danger btn-sm ml-2"><i class="fa fa-trash"></i></button>';
                    })
                    ->rawColumns(['name', 'action'])
                    ->make(true);
            }
        } catch (\Exception $ex) {
            return redirect('/')->with('error', $ex->getMessage());
        }

        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create($id = null)
    {
        $user = User::with('invitedBy');
        $password = UserProfileChangedLogs::where('key', 'password');
        if(!empty($id)) {
            $user = $user->where('id', $id);
            $password = $password->where('user_id', $id);
        }
//        $data['user'] = $user->firstOrFail();
        $data['password'] = $password->latest()->first();
        return view('admin.users.create', $data);
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
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required|string',
            'user_image' => 'mimes:jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $inviter = User::where('username', $request->inviters_username)->first();
            $board_ids_inviter_is_part_of = Boards::where('status', 'active')->whereHas('user_boards', function($q) use ($inviter) {
                return $q->where('user_id', $inviter->id);
            })->pluck('id');

            $boards_with_children_space = [];
            $boards_with_any_space = [];
            foreach ($board_ids_inviter_is_part_of as $board_id) {
                $children_count = UserBoards::where('board_id', $board_id)->where('parent_id', $inviter->id)->count();
                $member_count = UserBoards::where('board_id', $board_id)->count();

                if ($children_count < 2) {
                    $boards_with_children_space []= $board_id;
                }

                if ($member_count < 15) {
                    $boards_with_any_space []= $board_id;
                }
            }

            if (count($boards_with_children_space) == 0) {
                if (count($boards_with_any_space) == 0) {
                    return redirect()->back()->with('error', 'NO SPACE FOUND FOR USER');
                }
                $destination_board_id = $boards_with_any_space[0];
            } else {
                $destination_board_id = $boards_with_children_space[0];
            }

            $pregrad_count = UserBoards::where('board_id', $destination_board_id)->where('user_board_roles', 'pregrad')->count();
            if ($pregrad_count > 1) {
                $undergrad_count = UserBoards::where('board_id', $destination_board_id)->where('user_board_roles', 'undergrad')->count();
                if ($undergrad_count > 3) {
                    $newbie_count = UserBoards::where('board_id', $destination_board_id)->where('user_board_roles', 'newbie')->count();
                    if ($newbie_count > 7) {
                        return redirect()->back()->with('error', 'NO SPACE FOUND FOR USER');
                    } else {
                        $user_board_role = 'newbie';
                        $parent_role = 'undergrad';
                    }
                } else {
                    $user_board_role = 'undergrad';
                    $parent_role = 'pregrad';
                }
            } else {
                $user_board_role = 'pregrad';
                $parent_role = 'grad';
            }

            $potential_parents = UserBoards::where('board_id', $destination_board_id)->where('user_board_roles', $parent_role)->orderBy('position', 'ASC')->get();

            foreach ($potential_parents as $key => $board_member) {
                if ($board_member->child_nodes()->count() >= 2) {
                    unset($potential_parents[$key]);
                }
            }

            if (count($potential_parents) == 0) {
                return redirect()->back()->with('error', 'NO SPACE FOUND FOR USER');
            }

            $parent = $potential_parents->first();
            if ($parent->child_nodes()->count() == 0) {
                $position = 'left';
            } else {
                $position = 'right';
            }

            if($request->new_user_id) {
                $userId = $request->new_user_id;
                User::where('id', $userId)->update([
                    'username' => $request->username,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'role' => 'user',
                    'password' => Hash::make($request->password)
                ]);

                $oldUser = User::find($userId);
                ArchivedUser::create([
                    'invited_by' => $inviter->id,
                    'username' => $oldUser->username,
                    'first_name' => $oldUser->first_name,
                    'last_name' => $oldUser->last_name,
                    'email' => $oldUser->email,
                    'phone' => $oldUser->phone,
                    'role' => 'user',
                    'password' => Hash::make($oldUser->password),
                    'replaced_by' => $userId
                ]);
            } else {
                $user = User::create([
//                    'invited_by' => $inviter->id,
                    'invited_by' => $parent->user_id,
                    'username' => $request->username,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'role' => 'user',
                    'password' => Hash::make($request->password)
                ]);
                $userId = $user->id;

                $user_board = UserBoards::create([
                    'user_id' => $userId,
                    'username' => $request->username,
                    'board_id' => $destination_board_id,
                    'parent_id' => $parent->user_id,
                    'user_board_roles' => $user_board_role,
                    'position' => $position,
                ]);

                $destination_board = Boards::find($destination_board_id);
                GiftLogs::create([
                    'sent_by' => $userId,
                    'sent_to' => $parent->user_id,
                    'board_id' => $destination_board_id,
                    'amount' => $destination_board->amount,
                    'status' => 'pending',
                ]);

            }

            generateUserProfileLogs($userId, 'username', $request->username, 0, 'New Account Created', 'accepted');
            generateUserProfileLogs($userId, 'password', $request->password, 0, 'New Account Created', 'accepted');

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
    public function destroy($id, Request $request)
    {
        $usersCount = User::whereRole('user')->orderByDesc('created_at')->get()->count();
        if ($usersCount === 1 && empty($request['new_user_id'])) {
            $user = User::find($request->delete_user_id);
            $user->delete();
            DB::commit();
            echo 1;
        } else {
            DB::beginTransaction();
            if (!empty($request['new_user_id'])) {
                try {
                    // Replace deleting user invitees with the selected user.
                    $this->replaceUserInvitees($request);
                    $this->replaceUserInBoards($request);
                    $this->replaceGiftLogs($request);

                    $user = User::find($id);
                    $user->delete();
                    DB::commit();
                    echo 1;
                } catch (\Exception $exception) {
                    DB::rollBack();
                    echo $exception->getMessage();
                }
            } else {
                DB::rollBack();
                echo 'Please Select a User to Replace With';
            }
        }
    }

    private function replaceUserInvitees($request)
    {
        User::where('invited_by', $request['delete_user_id'])->update(['invited_by' => $request['new_user_id']]);
    }

    private function replaceUserInBoards($request)
    {
        UserBoards::where('parent_id', $request['delete_user_id'])->update(['parent_id' => $request['new_user_id']]);
        UserBoards::where('user_id', $request['delete_user_id'])->update(['user_id' => $request['new_user_id']]);
    }

    private function replaceGiftLogs($request)
    {
        GiftLogs::where('sent_by', $request['delete_user_id'])->update(['sent_by' => $request['new_user_id']]);
        GiftLogs::where('sent_to', $request['delete_user_id'])->update(['sent_to' => $request['new_user_id']]);
    }
}
