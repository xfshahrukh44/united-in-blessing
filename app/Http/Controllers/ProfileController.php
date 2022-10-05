<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index(){
        return view('profile');
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required',
            'user_image' => 'mimes:jpg,jpeg,png',
        ]);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if($request->file('user_image')){
            $file = $request->file('user_image');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('upload/user'), $fileName);
            $user_image = $fileName;
        }

        try {
            $user = User::updateOrCreate(
                [
                    'id' => Auth::user()->id,
                ],
                [
                    'first_name' => $request['first_name'],
                    'last_name' => $request['last_name'],
                    'email' => $request['email'],
                    'phone' => $request['phone'],
                    'user_image' => $user_image ?? null,
                ]
            );

            return redirect()->back()->with('success', 'Profile Updated Successfully');
        } catch (\Exception $exception){
            return redirect()->back()->withErrors(['error' => $exception->getMessage()])->withInput();
        }


    }
}
