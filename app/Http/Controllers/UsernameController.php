<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfileChangedLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsernameController extends Controller
{
    public function index()
    {
        return view('auth.username.forgot');
    }

    /**
     * Request username change
     * @param Request $request
     */
    public function requestChange(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|alpha_dash|unique:user_profile_changed_logs,value',
            'email' => ['required', 'string', 'email', function ($attribute, $val, $fail) {
                if (!$val) return;

                if (!User::where('email', $val)->exists()) {
                    $fail("We can't find a user with that " . $attribute . " address.");
                }
            }],
            'username_change_message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Get User Details
        $user = $this->getUserDetails($request['email']);

        // Check if request is in pending state
        if(UserProfileChangedLogs::where('user_id', $user->id)->where('key', 'username')->where('status', 'pending')->exists()){
            return redirect()->back()->withErrors(['username' => 'A request has already been generated. Please wait while we are working on your previous request.']);
        }

        // Generate User Logs
        $userLogs = generateUserProfileLogs($user->id, 'username', $request['username'], $user->username, $request['username_change_message'], 'pending');

        return redirect()->back()->with('success', 'Request Generated Successfully');
    }

    public function getUserDetails($email)
    {
        return User::where('email', $email)->first();
    }
}
