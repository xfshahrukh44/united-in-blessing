<?php

use App\Models\UserProfileChangedLogs;

if(!function_exists('generateUserProfileLogs')){
    function generateUserProfileLogs($user_id, $key, $value, $old_value, $message, $status){
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
