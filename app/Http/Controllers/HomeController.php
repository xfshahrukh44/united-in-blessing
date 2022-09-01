<?php

namespace App\Http\Controllers;

use App\Models\UserBoards;
use http\Client\Curl\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userBoards = UserBoards::where('user_id', Auth::user()->id)
            ->with('user', 'board', 'boardGrad')
            ->get();

        return view('home', compact('userBoards'));
    }
}
