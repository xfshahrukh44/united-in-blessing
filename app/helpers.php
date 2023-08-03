<?php

use App\Models\Boards;
use App\Models\GiftLogs;
use App\Models\User;
use App\Models\UserBoards;
use App\Models\UserProfileChangedLogs;

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

    return add_newbie_to_board($board, $grad->user);
}

function add_newbie_to_board ($board, $user) {
    $user_board_check = UserBoards::where([
        'user_id' => $user->id,
        'board_id' => $board->id,
        'user_board_roles' => 'newbie',
    ])->first();

    if ($user_board_check) {
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
