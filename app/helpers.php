<?php

use App\Models\GiftLogs;
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
