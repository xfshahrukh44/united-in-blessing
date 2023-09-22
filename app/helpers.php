<?php

use App\Models\Boards;
use App\Models\GiftLogs;
use App\Models\User;
use App\Models\UserBoards;
use App\Models\UserProfileChangedLogs;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Log;

if (!function_exists('generateUserProfileLogs')) {
    function generateUserProfileLogs($user_id, $key, $value, $old_value, $message, $status)
    {
        return UserProfileChangedLogs::create([
            'user_id' => $user_id,
            'key' => $key,
            'value' => $value,
            'old_value' => $old_value,
            'message' => $message,
            'status' => $status,
        ]);
    }
}

if (!function_exists('createGiftLog')) {
    function createGiftLog($sent_by = null, $sent_to = null, $board_id = null, $amount = null, $status = null, $old_sent_by = null)
    {
        if (!empty($old_sent_by)){
            $giftlog = GiftLogs::where('board_id', $board_id)->where('sent_by', $old_sent_by)->first();
        } else{
            $giftlog = new GiftLogs();
        }

        if (!empty($sent_by)){
            $giftlog->sent_by = $sent_by;
        }

        if (!empty($sent_to)){
            $giftlog->sent_to = $sent_to;
        }

        if (!empty($board_id)){
            $giftlog->board_id = $board_id;
        }

        if (!empty($amount)){
            $giftlog->amount = $amount;
        }

        if (!empty($status)){
            $giftlog->status = $status;
        }

        return $giftlog->save();
    }
}

function get_board_grad ($board_id) {
    $board = Boards::find($board_id);
    return $board && $board->grad() && $board->grad()->user ? $board->grad()->user : null;
}

function all_undergrads_filled ($board_id) {
    $board_members = UserBoards::where('board_id', $board_id)->get();

    if ($board_members->where('user_board_roles', 'pregrad')->count() < 2) {
        return false;
    }

    if ($board_members->where('user_board_roles', 'undergrad')->count() < 4) {
        return false;
    }

    return true;
}

function board_is_ready_to_retire ($board_id) {
    $board_members = UserBoards::where('board_id', $board_id)->get();

    if (
        $board_members->where('user_board_roles', 'newbie')->count() < 8 ||
        $board_members->where('user_board_roles', 'undergrad')->count() < 4 ||
        $board_members->where('user_board_roles', 'pregrad')->count() < 2 ||
        $board_members->where('user_board_roles', 'grad')->count() < 1
    ) { return false; }

    if (GiftLogs::where([ 'board_id' => $board_id, 'status' => 'pending' ])->count() > 0) {
        return false;
    }

    return true;
}

function generate_new_board_number () {
//    $last_board = Boards::orderBy('created_at', 'DESC')->whereNotNull('board_number')->first();
    $board_count = Boards::orderBy('created_at', 'DESC')->count();

//    return strval($board_count + 1) ?? null;

    for ($i = 1; $i < 1000001; $i++) {
        if (Boards::where('board_number', strval($i))->first()) {
            continue;
        }

        return strval($i);
    }
}

function split_board ($board_id) {
    try {
        if ($board = Boards::find($board_id)) {
//            $grad = $board->grad();

            $pregrad_1 = $board->pregrad('left');
            $pregrad_2 = $board->pregrad('right');

            $undergrad_1 = $board->undergrad('left', $pregrad_1->user_id);
            $undergrad_2 = $board->undergrad('right', $pregrad_1->user_id);
            $undergrad_3 = $board->undergrad('left', $pregrad_2->user_id);
            $undergrad_4 = $board->undergrad('right', $pregrad_2->user_id);

            $newbie_1 = $board->newbie('left', $undergrad_1->user_id);
            $newbie_2 = $board->newbie('right', $undergrad_1->user_id);
            $newbie_3 = $board->newbie('left', $undergrad_2->user_id);
            $newbie_4 = $board->newbie('right', $undergrad_2->user_id);
            $newbie_5 = $board->newbie('left', $undergrad_3->user_id);
            $newbie_6 = $board->newbie('right', $undergrad_3->user_id);
            $newbie_7 = $board->newbie('left', $undergrad_4->user_id);
            $newbie_8 = $board->newbie('right', $undergrad_4->user_id);

            $left_board = Boards::create([
                'board_number' => generate_new_board_number(),
                'previous_board_number' => $board->board_number,
                'amount' => $board->amount,
                'status' => 'active',
            ]);

            $right_board = Boards::create([
                'board_number' => generate_new_board_number(),
                'previous_board_number' => $board->board_number,
                'amount' => $board->amount,
                'status' => 'active',
            ]);

            //add users to left board
            add_user_to_board($pregrad_1->user, $left_board->id, null, 'grad', null, false);
            add_user_to_board($undergrad_1->user, $left_board->id, $pregrad_1->user_id, 'pregrad', 'left', false);
            add_user_to_board($undergrad_2->user, $left_board->id, $pregrad_1->user_id, 'pregrad', 'right', false);
            add_user_to_board($newbie_1->user, $left_board->id, $undergrad_1->user_id, 'undergrad', 'left', false);
            add_user_to_board($newbie_2->user, $left_board->id, $undergrad_1->user_id, 'undergrad', 'right', false);
            add_user_to_board($newbie_3->user, $left_board->id, $undergrad_2->user_id, 'undergrad', 'left', false);
            add_user_to_board($newbie_4->user, $left_board->id, $undergrad_2->user_id, 'undergrad', 'right', false);

            //add users to right board
            add_user_to_board($pregrad_2->user, $right_board->id, null, 'grad', null, false);
            add_user_to_board($undergrad_3->user, $right_board->id, $pregrad_2->user_id, 'pregrad', 'left', false);
            add_user_to_board($undergrad_4->user, $right_board->id, $pregrad_2->user_id, 'pregrad', 'right', false);
            add_user_to_board($newbie_5->user, $right_board->id, $undergrad_3->user_id, 'undergrad', 'left', false);
            add_user_to_board($newbie_6->user, $right_board->id, $undergrad_3->user_id, 'undergrad', 'right', false);
            add_user_to_board($newbie_7->user, $right_board->id, $undergrad_4->user_id, 'undergrad', 'left', false);
            add_user_to_board($newbie_8->user, $right_board->id, $undergrad_4->user_id, 'undergrad', 'right', false);

            return [
                'left_board_id' => $left_board->id,
                'right_board_id' => $right_board->id,
            ];
        }

        return false;
    } catch (\Exception $e) {
        Log::error('function split_board failed: ' . $e->getMessage());
        return false;
    }
}

function add_grad_to_upper_value_board ($board_id) {
    if ($board = Boards::find($board_id)) {
        $grad = $board->grad();
        $boardValues = array('100', '400', '1000', '2000');
        $upgraded_board_amount = $boardValues[array_search($board->amount, $boardValues) + 1];

        $inviters = get_inviter_tree($grad->user->id, 10);

        $inviter_as_parent_found = false;
        foreach ($inviters as $inviter_id) {
            $member = UserBoards::whereHas('board', function ($q) use ($upgraded_board_amount) {
                return $q->where('amount', $upgraded_board_amount)->where('status', 'active');
            })->where('user_id', $inviter_id)->first();

            if (!$member) {
                continue;
            }

            if (!all_undergrads_filled($member->board_id)) {
                continue;
            }

            $board = Boards::find($member->board_id);
            Log::info('PROMOTION | upgraded amount: ' . $upgraded_board_amount);
            Log::info('PROMOTION | board id: ' . $board->id);
            $inviter_as_parent_found = add_newbie_to_board2($board, $grad->user);
            break;
        }

        //if $inviter_as_parent_found is still false
        if (!$inviter_as_parent_found) {
            $member = UserBoards::whereHas('board', function ($q) use ($upgraded_board_amount) {
                return $q->where('amount', $upgraded_board_amount)->where('status', 'active');
            })
                ->whereNotExists(function ($q) use($grad) {
                    return $q->where('user_id', $grad->user->id);
                })
                ->has('newbies', '<', 8)->has('undergrads', '=', 4)->orderBy('created_at', 'ASC')->first();

            if ($member) {
                $board = Boards::find($member->board_id);
                Log::info('PROMOTION | upgraded amount: ' . $upgraded_board_amount);
                Log::info('PROMOTION | board id: ' . $board->id);
                add_newbie_to_board2($board, $grad->user);
            }
        }

        return true;
    }

    return false;
}

function add_grad_to_same_value_board ($board_id) {
    if ($board = Boards::find($board_id)) {
        $grad = $board->grad();
        $boardValues = array('100', '400', '1000', '2000');
        $upgraded_board_amount = $boardValues[array_search($board->amount, $boardValues)];

        $inviters = get_inviter_tree($grad->user->id, 10);

        $inviter_as_parent_found = false;
        foreach ($inviters as $inviter_id) {
            $member = UserBoards::whereHas('board', function ($q) use ($upgraded_board_amount) {
                return $q->where('amount', $upgraded_board_amount)->where('status', 'active');
            })->where('user_id', $inviter_id)->where('user_id', '!=', $grad->user_id)->first();

            if (!$member) {
                continue;
            }

            if (!all_undergrads_filled($member->board_id)) {
                continue;
            }

            $board = Boards::find($member->board_id);
            Log::info('PROMOTION | upgraded amount: ' . $upgraded_board_amount);
            Log::info('PROMOTION | board id: ' . $board->id);
            $inviter_as_parent_found = add_newbie_to_board2($board, $grad->user);
            break;
        }

        //if $inviter_as_parent_found is still false
        if (!$inviter_as_parent_found) {
            $member = UserBoards::whereHas('board', function ($q) use ($upgraded_board_amount) {
                return $q->where('amount', $upgraded_board_amount)->where('status', 'active');
            })
                ->whereNotExists(function ($q) use($grad) {
                    return $q->where('user_id', $grad->user->id);
                })
                ->has('newbies', '<', 8)->has('undergrads', '=', 4)->orderBy('created_at', 'ASC')->first();

            if ($member) {
                $board = Boards::find($member->board_id);
                Log::info('PROMOTION | upgraded amount: ' . $upgraded_board_amount);
                Log::info('PROMOTION | board id: ' . $board->id);
                add_newbie_to_board2($board, $grad->user);
            }
        }

        return true;
    }

    return false;
}

function add_previous_boards_grad_as_newbie ($board_id) {
    $board = Boards::find($board_id);
    if (is_null($board->previous_board_number)) {
        return false;
    }
    if (!$previous_board = Boards::where('board_number', $board->previous_board_number)->first()) {
        return false;
    }

    if ($previous_board->status != 'retired') {
        return false;
    }

    if (!$grad = $previous_board->grad()) {
        return false;
    }

    return add_newbie_to_board2($board, $grad->user);
}

function add_newbie_to_board ($board, $user) {
    $potential_parents = [];
    $potential_parents_left = UserBoards::where('board_id', $board->id)->where('user_board_roles', 'undergrad')
        ->whereHas('parent', function ($q) {
            return $q->where('position', 'left');
        })
        ->orderBy('position', 'ASC')->get();
    $potential_parents_right = UserBoards::where('board_id', $board->id)->where('user_board_roles', 'undergrad')
        ->whereHas('parent', function ($q) {
            return $q->where('position', 'right');
        })
        ->orderBy('position', 'ASC')->get();
    foreach ($potential_parents_left as $item) {
        $potential_parents []= $item;
    }
    foreach ($potential_parents_right as $item) {
        $potential_parents []= $item;
    }
    foreach ($potential_parents as $key => $board_member) {
        if ($board_member->child_nodes()->count() >= 2) {
            unset($potential_parents[$key]);
        }
    }
    if (count($potential_parents) == 0) {
        return false;
    }

    //reset index
    $potential_parents = array_values($potential_parents);

    $parent = $potential_parents[0];
    if ($parent->child_nodes()->count() == 0) {
        $position = 'left';
    } else {
        $position = 'right';
    }

    UserBoards::create([
        'user_id' => $user->id,
        'username' => $user->username,
        'board_id' => $board->id,
        'parent_id' => $parent->user_id,
        'user_board_roles' => 'newbie',
        'position' => $position,
    ]);

    GiftLogs::create([
        'sent_by' => $user->id,
        'sent_to' => $parent->user_id,
        'board_id' => $board->id,
        'amount' => $board->amount,
        'status' => 'pending',
    ]);

    return true;
}

function add_newbie_to_board2 ($board, $user) {
    $user_board_check = UserBoards::where([
        'user_id' => $user->id,
        'board_id' => $board->id,
//        'user_board_roles' => 'newbie',
    ])->get();

    if (count($user_board_check) > 0) {
        return false;
    }

    $potential_parents = [];
    $potential_parents_left = UserBoards::where('board_id', $board->id)->where('user_board_roles', 'undergrad')
        ->whereHas('parent', function ($q) {
            return $q->where('position', 'left');
        })
        ->orderBy('position', 'ASC')->get();
    $potential_parents_right = UserBoards::where('board_id', $board->id)->where('user_board_roles', 'undergrad')
        ->whereHas('parent', function ($q) {
            return $q->where('position', 'right');
        })
        ->orderBy('position', 'ASC')->get();
    foreach ($potential_parents_left as $item) {
        $potential_parents []= $item;
    }
    foreach ($potential_parents_right as $item) {
        $potential_parents []= $item;
    }
    foreach ($potential_parents as $key => $board_member) {
        if ($board_member->child_nodes()->count() >= 2) {
            unset($potential_parents[$key]);
        }
    }
    if (count($potential_parents) == 0) {
        return false;
    }

    //reset index
    $potential_parents = array_values($potential_parents);

    $parent = $potential_parents[0];
    if ($parent->child_nodes()->count() == 0) {
        $position = 'left';
    } else {
        $position = 'right';
    }

    UserBoards::create([
        'user_id' => $user->id,
        'username' => $user->username,
        'board_id' => $board->id,
        'parent_id' => $parent->user_id,
        'user_board_roles' => 'newbie',
        'position' => $position,
    ]);

    GiftLogs::create([
        'sent_by' => $user->id,
        'sent_to' => $parent->user_id,
        'board_id' => $board->id,
        'amount' => $board->amount,
        'status' => 'pending',
    ]);

    if ($board->creation_method == 'manual' && all_undergrads_filled($board->id)) {
        add_previous_boards_grad_as_newbie($board->id);
    }

    return true;
}

function get_inviter_tree ($user_id, $range) {
    $user = User::find($user_id);
    $inviters = [$user->invited_by];

    for ($i = 1; $i < $range; $i++) {
        $user = User::find($inviters[count($inviters) - 1]) ?? null;

        if ($user->invited_by == '0') {
            break;
        }

        $inviters []= $user->invited_by ?? null;
    }

    return $inviters;
}

function auto_fill_board($board_id) {
    $pregrad_count = UserBoards::where('board_id', $board_id)->where('user_board_roles', 'pregrad')->count();
    for ($i = 0; $i < (2 - $pregrad_count); $i++) {
        $parent_and_position = get_parent_and_position($board_id, 'grad');
        $parent = $parent_and_position['parent'];
        $position = $parent_and_position['position'];

        $user = create_user_for_board($parent->user_id);

        add_user_to_board($user, $board_id, $parent->user_id, 'pregrad', $position);
    }


    $undergrad_count = UserBoards::where('board_id', $board_id)->where('user_board_roles', 'undergrad')->count();
    for ($i = 0; $i < (4 - $undergrad_count); $i++) {
        $parent_and_position = get_parent_and_position($board_id, 'pregrad');
        $parent = $parent_and_position['parent'];
        $position = $parent_and_position['position'];

        $user = create_user_for_board($parent->user_id);

        add_user_to_board($user, $board_id, $parent->user_id, 'undergrad', $position);
    }


    $newbie_count = UserBoards::where('board_id', $board_id)->where('user_board_roles', 'newbie')->count();
    for ($i = 0; $i < (8 - $newbie_count); $i++) {
        $parent_and_position = get_parent_and_position($board_id, 'undergrad');
        $parent = $parent_and_position['parent'];
        $position = $parent_and_position['position'];

        $user = create_user_for_board($parent->user_id);

        add_user_to_board($user, $board_id, $parent->user_id, 'newbie', $position);
    }

    return true;
}

function create_user_for_board ($inviter_id) {
    $faker = Faker::create();

    return User::create([
        'invited_by' => $inviter_id,
        'username' => $faker->unique()->userName,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->email,
        'phone' => $faker->phoneNumber,
        'password' => Hash::make('Pa$$w0rd!'),
    ]);
}

function add_user_to_board ($user, $board_id, $parent_id, $role, $position, $create_gift_logs = true) {
    $board = Boards::find($board_id);

    $user_board_check = UserBoards::where([
        'user_id' => $user->id,
        'username' => $user->username,
        'board_id' => $board_id,
    ])->get();

    if (count($user_board_check) == 0) {
        UserBoards::create([
            'user_id' => $user->id,
            'username' => $user->username,
            'board_id' => $board_id,
            'parent_id' => $parent_id,
            'user_board_roles' => $role,
            'position' => $position
        ]);

        if ($create_gift_logs) {
            GiftLogs::create([
                'sent_by' => $user->id,
                'sent_to' => $parent_id,
                'board_id' => $board_id,
                'amount' => $board->amount,
                'status' => 'pending',
            ]);
        }

        if ($board->creation_method == 'manual' && all_undergrads_filled($board->id)) {
            add_previous_boards_grad_as_newbie($board->id);
        }
    }

}

function get_parent_and_position ($board_id, $parent_role) {
    $potential_parents = UserBoards::where('board_id', $board_id)
        ->where('user_board_roles', $parent_role)
        ->orderBy('position', 'ASC')
        ->get();

    foreach ($potential_parents as $key => $board_member) {
        if ($board_member->child_nodes()->count() >= 2) {
            unset($potential_parents[$key]);
        }
    }

    $parent = $potential_parents->first();

    if ($parent->child_nodes()->count() == 0) {
        $position = 'left';
    } else {
        $position = 'right';
    }

    return [
        'parent' => $parent,
        'position' => $position
    ];
}

function get_left_most_undergrad_parent_and_position ($board_id) {
    $potential_parents = [];
    $potential_parents_left = UserBoards::where('board_id', $board_id)->where('user_board_roles', 'undergrad')
        ->whereHas('parent', function ($q) {
            return $q->where('position', 'left');
        })
        ->orderBy('position', 'ASC')->get();
    $potential_parents_right = UserBoards::where('board_id', $board_id)->where('user_board_roles', 'undergrad')
        ->whereHas('parent', function ($q) {
            return $q->where('position', 'right');
        })
        ->orderBy('position', 'ASC')->get();
    foreach ($potential_parents_left as $item) {
        $potential_parents []= $item;
    }
    foreach ($potential_parents_right as $item) {
        $potential_parents []= $item;
    }
    foreach ($potential_parents as $key => $board_member) {
        if ($board_member->child_nodes()->count() >= 2) {
            unset($potential_parents[$key]);
        }
    }
    if (count($potential_parents) == 0) {
        return false;
    }

    //reset index
    $potential_parents = array_values($potential_parents);

    $parent = $potential_parents[0];
    if ($parent->child_nodes()->count() == 0) {
        $position = 'left';
    } else {
        $position = 'right';
    }

    return [
        'parent' => $parent,
        'position' => $position
    ];
}

function system_invitees_count ($user_id) {
    return User::where('invited_by', $user_id)->count() ?? 0;
}

function purge_user ($user_id) {
    try {
        //remove gift logs
        GiftLogs::where('sent_by', $user_id)->delete();
        GiftLogs::where('sent_to', $user_id)->delete();

        //remove user
        User::where('id', $user_id)->forceDelete();

        //remove user_boards and re-activate the boards
        UserBoards::where('user_id', $user_id)->forceDelete();
        $user_boards_where_parent = UserBoards::where('parent_id', $user_id);
        Boards::whereIn('id', $user_boards_where_parent->pluck('board_id'))->where('status', 'retired')->update([ 'status' => 'active' ]);
        $user_boards_where_parent->forceDelete();

        //remove user_profile_changed_logs
        UserProfileChangedLogs::where('user_id', $user_id)->forceDelete();

        return true;
    } catch (\Exception $e) {
        Log::error('function: purge_user() failed: ' . $e->getMessage());
        return false;
    }
}

function purge_board ($board_id) {
    try {
        Log::info('purging board: ' . $board_id);
        //remove boards
        if ($board = Boards::find($board_id)) {
            //remove gift logs
            GiftLogs::where('board_id', $board_id)->delete();

            //remove user_boards and re-activate the boards
            UserBoards::where('board_id', $board_id)->forceDelete();

            if (!is_null($board->board_number)) {
                foreach (Boards::where('previous_board_number', $board->board_number)->pluck('id') as $child_board_id) {
                    purge_board($child_board_id);
                }
            }

            $board->forceDelete();

            return true;
        }

        return false;
    } catch (\Exception $e) {
        Log::error('function: purge_board() failed: ' . $e->getMessage());
        return false;
    }
}
