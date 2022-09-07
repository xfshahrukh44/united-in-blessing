<?php

namespace App\Http\Controllers;

use App\Models\GiftLogs;
use App\Models\User;
use App\Models\UserBoards;
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

        $inviter = User::where('id', Auth::user()->id)
            ->with('invitedBy')
            ->first();

        $invitees = User::where('invited_by', Auth::user()->id)->get();

        $pendingIncomingGifts = GiftLogs::where('sent_to', Auth::user()->id)->where('status', 'pending')->with('board', 'sender')->get();
        $pendingOutgoingGifts = GiftLogs::where('sent_by', Auth::user()->id)->where('status', '!=', 'accepted')->with('board', 'receiver')->get();

        return view('home', compact('userBoards', 'inviter', 'invitees', 'pendingIncomingGifts', 'pendingOutgoingGifts'));
//        return view('home', compact('userBoards', 'inviter', 'invitees','inviteesCount', 'pendingIncomingGifts', 'pendingOutgoingGifts'));
    }
}
