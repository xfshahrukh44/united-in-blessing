<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Override login method
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|alpha_dash',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if(User::where('username', $request['username'])->where('is_blocked', 'yes')->first())
            return redirect()->back()
                ->with("error", "You are currently blocked from the portal. Please contact the admin.")
                ->withInput();

        $credentials = $request->only('username', 'password');
        $credentials['is_blocked'] = 'no';

        $user = User::where('username', '=', $request['username'])->first();
        if($user) {
            $hasher = app('hash');
            if ($hasher->check($request['password'], $user->password)) {
                if(Auth::attempt($credentials)) {
                    if ($user->role == 'admin') {
                        return redirect()->route('dashboard');
                    } else {
                        return redirect()->route('home');
                    }
                }
            } else {
                return redirect()->back()
                    ->with("error", "Invalid password.")
                    ->withInput();
            }
        } else {
            return redirect()->back()
                ->with("error", "Invalid username.")
                ->withInput();
        }
        return redirect()->back()
            ->with("error", "These credentials do not match our records.")
            ->withInput();
    }
}
