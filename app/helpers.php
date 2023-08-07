<?php

use App\Models\Boards;
use App\Models\GiftLogs;
use App\Models\User;
use App\Models\UserBoards;
use App\Models\UserProfileChangedLogs;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

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

function add_previous_boards_grad_as_newbie ($board_id) {
    $board = Boards::find($board_id);
    if (is_null($board->previous_board_number)) {
        return false;
    }
    if (!$previous_board = Boards::where('board_number', $board->previous_board_number)->first()) {
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
        'user_board_roles' => 'newbie',
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

function add_user_to_board ($user, $board_id, $parent_id, $role, $position) {
    $board = Boards::find($board_id);
    UserBoards::create([
        'user_id' => $user->id,
        'username' => $user->username,
        'board_id' => $board_id,
        'parent_id' => $parent_id,
        'user_board_roles' => $role,
        'position' => $position
    ]);

    GiftLogs::create([
        'sent_by' => $user->id,
        'sent_to' => $parent_id,
        'board_id' => $board_id,
        'amount' => $board->amount,
        'status' => 'pending',
    ]);

    if ($board->creation_method == 'manual' && all_undergrads_filled($board->id)) {
        add_previous_boards_grad_as_newbie($board->id);
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
