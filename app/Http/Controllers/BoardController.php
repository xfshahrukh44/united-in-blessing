<?php

namespace App\Http\Controllers;

use App\Models\Boards;
use App\Models\User;
use App\Models\UserBoards;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    public function index($board_id)
    {
        $board = Boards::find($board_id);
        $gifts = $board->gifts->keyBy('sent_by');

//        dd($gifts);

        $rawData = UserBoards::where('board_id', $board_id)->with('user', 'children')->get();

        $grad = $rawData->where('user_board_roles', 'grad');

        $order = ['grad', 'pregrad', 'undergrad', 'newbie'];
        $rawData = collect($rawData)->sortBy(function ($item) use ($order) {
            return array_search($item->user_board_roles, $order);
        });

        $data = [];
        $data['grad'] = $grad;

//        $data1 = [];

        $boardUsers = $data;

        $boardGrad = UserBoards::where('board_id', $board_id)->where('user_board_roles', 'grad')->with('user')->first();
        $boardPreGrad = UserBoards::where('board_id', $board_id)->where('user_board_roles', 'pregrad')->with('user')->get();

        $invitees = User::where('invited_by', Auth::user()->id)->get();

        $inviteesCount = $invitees->count();

       /* $data1['count'] = $inviteesCount;

        $boardUsers1 = $data1;*/
        //dd($boardUsers);
        //return view('board', compact('board', 'boardUsers', 'boardGrad', 'boardPreGrad'));
        return view('board', compact('board', 'boardUsers', 'boardGrad', 'boardPreGrad', 'inviteesCount', 'gifts'));
    }

    public function create(){

    }
}
