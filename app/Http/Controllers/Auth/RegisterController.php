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

                    // Get user Board where newbie count is less than 8
                    // Check if the inviter is not newbie
                    if (is_null(UserBoards::where('user_id', $inviter->id)->where('user_board_roles', '!=', 'newbie')->has('newbies', '<', 8)->first())) {
                        $fail("There's no place left in the board or the person that invited you is 'newbie' in the board. Please try again later.");
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
        $parent_id = $role = '';
        $position = 'left';

        $invited_user = User::where('username', $data['inviters_username'])->first();

        $invited_user_board = UserBoards::where('user_id', $invited_user->id)
            ->has('newbies', '<', 8)
            ->first();

        $board_member = $invited_user_board->boardChildren($invited_user_board->board_id);

        switch ($invited_user_board->user_board_roles) {
            case('grad'):
                foreach ($invited_user_board->boardChildren($invited_user_board->board_id) as $pregrad) {
                    if ($pregrad->boardChildren($invited_user_board->board_id)->count() < 2) {
                        $parent_id = $pregrad->user_id;
                        $role = 'undergrad';

                        foreach ($pregrad->boardChildren($invited_user_board->board_id) as $undergrad) {
                            if ($undergrad->position == 'left')
                                $position = 'right';
                        }
                    } else {
                        foreach ($pregrad->boardChildren($invited_user_board->board_id) as $undergrad) {
                            if ($undergrad->boardChildren($invited_user_board->board_id)->count() < 2) {
                                $parent_id = $undergrad->user_id;

                                foreach ($undergrad->boardChildren($invited_user_board->board_id) as $child) {
                                    if ($child->position == 'left')
                                        $position = 'right';
                                }

                                break;
                            }
                        }
                    }

                    if ($parent_id != '') {
                        break;
                    }
                }
                break;

            case('pregrad'):
                if ($invited_user_board->boardChildren($invited_user_board->board_id)->count() < 2) {
                    $parent_id = $invited_user_board->user_id;
                    $role = 'undergrad';

                    foreach ($invited_user_board->boardChildren($invited_user_board->board_id) as $undergrad) {
                        if ($undergrad->position == 'left')
                            $position = 'right';
                    }
                } else {
                    foreach ($invited_user_board->boardChildren($invited_user_board->board_id) as $undergrads) {
                        // undergrads
                        if ($undergrads->boardChildren($invited_user_board->board_id)->count() < 2) {
                            $parent_id = $undergrads->user_id;

                            foreach ($undergrads->boardChildren($invited_user_board->board_id) as $child) {
                                if ($child->position == 'left')
                                    $position = 'right';
                            }
                        } else {
                            $sibling = $this->siblings($undergrads);

                            if ($sibling->boardChildren($invited_user_board->board_id)->count() < 2) {
                                $parent_id = $sibling->user_id;

                                foreach ($sibling->boardChildren($invited_user_board->board_id) as $child) {
                                    if ($child->position == 'left')
                                        $position = 'right';
                                }
                            } else {
                                $sibling = $this->siblings($invited_user_board);

                                foreach ($sibling->boardChildren($invited_user_board->board_id) as $undergrad) {
                                    // Undergrad
                                    if ($undergrad->boardChildren($invited_user_board->board_id)->count() < 2) {
                                        $parent_id = $undergrad->user_id;

                                        if ($undergrad->position == 'left')
                                            $position = 'right';

                                        break;
                                    }
                                }
                            }
                        }

                        if ($parent_id != '') {
                            break;
                        }
                    }
                }
                break;

            case('undergrad'):
                if ($invited_user_board->boardChildren($invited_user_board->board_id)->count() < 2) {
                    $parent_id = $invited_user_board->user_id;

                    foreach ($invited_user_board->boardChildren($invited_user_board->board_id) as $child) {
                        if ($child->position == 'left')
                            $position = 'right';
                    }
                } else {
                    // Get Siblings
                    $sibling = $this->siblings($invited_user_board);

                    if ($sibling->boardChildren($invited_user_board->board_id)->count() < 2) {
                        $parent_id = $sibling->user_id;

                        foreach ($sibling->boardChildren($invited_user_board->board_id) as $child) {
                            if ($child->position == 'left')
                                $position = 'right';
                        }
                    } else {
                        $parent = $invited_user_board->parent;
                        $sibling = $this->siblings($parent);

                        foreach ($sibling->boardChildren($invited_user_board->board_id) as $child) {
                            if ($child->boardChildren($invited_user_board->board_id)->count() < 2) {
                                $parent_id = $child->user_id;

                                foreach ($child->boardChildren($invited_user_board->board_id) as $newbie) {
                                    if ($child->position == 'left')
                                        $position = 'right';
                                }

                                break;
                            }
                        }
                    }
                }

                break;

//            case('newbie'):
//                if ($this->siblings($invited_user_board) == null) {
//                    $parent_id = $invited_user_board->parent_id;
//
//                    if ($invited_user_board->position == 'left')
//                        $position = 'right';
//                } else {
//                    $parent = $invited_user_board->parent;
//                    $sibling = $this->siblings($parent);
//
//                    if ($sibling->boardChildren($invited_user_board->board_id)->count() < 2) {
//                        $parent_id = $sibling->user_id;
//
//                        foreach ($sibling->boardChildren($invited_user_board->board_id) as $child) {
//                            $parent_id = $child->parent_id;
//
//                            if ($child->position == 'left')
//                                $position = 'right';
//
//                            break;
//                        }
//                    } else {
//                        // Pregrad
//                        $parent = $parent->parent;
//                        $sibling = $this->siblings($parent);
//
//                        foreach ($sibling->boardChildren($invited_user_board->board_id) as $undergrad) {
//                            if ($undergrad->boardChildren($invited_user_board->board_id)->count() < 2) {
//                                $parent_id = $undergrad->user_id;
//
//                                if ($undergrad->position == 'left')
//                                    $position = 'right';
//
//                                break;
//                            }
//                        }
//                    }
//                }
//                break;
        }

        // Create User
        $user = User::create([
            'invited_by' => $invited_user->id,
            'username' => $data['username'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
        ]);

        // Add User to the board
        UserBoards::create([
            'user_id' => $user->id,
            'board_id' => $invited_user_board->board_id,
            'parent_id' => $parent_id,
            'user_board_roles' => $role != '' ? $role : 'newbie',
            'position' => $position
        ]);

        // Get grad of the board to send the gift
        $boardGrad = UserBoards::where('board_id', $invited_user_board->board_id)
            ->where('user_board_roles', 'grad')
            ->with('user', 'board')
            ->first();

        // If role is empty so it means that the new user is newbie and create a gift log to send the gift to the admin.
        if (empty($role)) {
            GiftLogs::create([
                'sent_by' => $user->id,
                'sent_to' => $boardGrad->user_id,
                'board_id' => $invited_user_board->board_id,
                'amount' => $boardGrad->board->amount,
                'status' => 'pending',
            ]);
        }

        $userLogs = generateUserProfileLogs($user->id, 'username', $data['username'], 0, 'New Account Created', 'accepted');

        return $user;
    }

    protected function siblings($user)
    {
        return UserBoards::where('parent_id', $user->parent_id)
            ->where('board_id', $user->board_id)
            ->where('user_id', '!=', $user->user_id)
            ->first();
    }
}
