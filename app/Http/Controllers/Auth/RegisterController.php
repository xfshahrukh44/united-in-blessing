<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\GiftLogs;
use App\Models\User;
use App\Models\UserBoards;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'inviters_username' => ['required', 'alpha_dash', function ($attribute, $val, $fail) {
                if (!$val) return;

                if (!User::where('username', $val)->exists()) {
                    $fail($attribute . ' not found.');
                } else {
                    $inviter = User::where('username', $val)->first();

//                    $userBoard = UserBoards::where('user_id', $inviter->id)
//                        ->first();
//
//                    switch ($userBoard->user_board_roles){
//                        case('grad'):
//                            dd('grad');
//
//                        case('pregrad'):
////                            dd('pregrad');
//                            $userBoard->has('children', '<', 2);
//                            dd($userBoard->children);
//
//                        case('undergrad'):
//                            dd('undergrad');
//
//                        case('newbie'):
//                            dd('newbie');
//                    }

                    if (is_null(UserBoards::where('user_id', $inviter->id)->has('children', '<', 2)->first())) {
                        $fail("There's no place left in the board. Please try again later.");
                    }
                }
            }],
            'username' => ['required', 'alpha_dash', 'unique:user_profile_changed_logs,value'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $invited_user = User::where('username', $data['inviters_username'])->first();

        $invited_user_board_id = UserBoards::where('user_id', $invited_user->id)
            ->has('children', '<', 2)
            ->first();

        $position = 'left';

        foreach ($invited_user_board_id->children as $child) {
            if ($child->position == 'left')
                $position = 'right';
        }

        $user = User::create([
            'invited_by' => $invited_user->id,
            'username' => $data['username'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
        ]);

        UserBoards::create([
            'user_id' => $user->id,
            'board_id' => $invited_user_board_id->board_id,
            'parent_id' => $invited_user_board_id->user_id,
            'user_board_roles' => 'newbie',
            'position' => $position
        ]);

        $boardGrad = UserBoards::where('board_id', $invited_user_board_id->board_id)
            ->where('user_board_roles', 'grad')
            ->with('user', 'board')
            ->first();

        GiftLogs::create([
            'sent_by' => $user->id,
            'sent_to' => $boardGrad->user_id,
            'board_id' => $invited_user_board_id->board_id,
            'amount' => $boardGrad->board->amount,
        ]);

        $userLogs = generateUserProfileLogs($user->id, 'username', $data['username'], 0, 'New Account Created', 'accepted');

        return $user;
    }
}
