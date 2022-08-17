<?php

namespace App\Http\Controllers;

use App\Models\User;
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
    public function requestChange(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required|alpha_dash|unique:users',
            'email' =>   'required|string|email',
            'username_change_message' => 'required|string',
        ]);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

//        Check if email exists
        $userDetails = User::where('email', $request['email'])->first();
        if (is_null($userDetails)){
            return redirect()->back()->withErrors(["email" => "We can't find a user with that email address."])->withInput();
        }

        return redirect()->back()->with('success', 'Request Generated Successfully');
    }
}
