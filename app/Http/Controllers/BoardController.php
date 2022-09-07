<?php

namespace App\Http\Controllers;

use App\Models\Boards;
use App\Models\User;
use App\Models\UserBoards;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    public function index($board_id)
    {
        $board = Boards::find($board_id);
        $gifts = $board->gifts->keyBy('sent_by');
//        $rawData = UserBoards::where('board_id', $board_id)->with(['user', 'children'])->get();

        $rawData = UserBoards::where('board_id', $board_id)->with(['user',
            'children' => function ($q) use ($board_id) {
                $q->where('board_id', $board_id);
            },
            'children.children' => function ($q) use ($board_id) {
                $q->where('board_id', $board_id);
            },
            'children.children.children' => function ($q) use ($board_id) {
                $q->where('board_id', $board_id);
            },
        ])->get();

        $grad = $rawData->where('user_board_roles', 'grad');

        $order = ['grad', 'pregrad', 'undergrad', 'newbie'];
        $rawData = collect($rawData)->sortBy(function ($item) use ($order) {
            return array_search($item->user_board_roles, $order);
        });

        $data = [];
        $data['grad'] = $grad;

        $boardUsers = $data;

//        $boardGrad = UserBoards::where('board_id', $board_id)->where('user_board_roles', 'grad')->with('user')->first();
//        $boardPreGrad = UserBoards::where('board_id', $board_id)->where('user_board_roles', 'pregrad')->with('user')->get();

//        return view('board', compact('board', 'boardUsers', 'boardGrad', 'boardPreGrad'));
        return view('board', compact('board', 'boardUsers', 'gifts'));
        $invitees = User::where('invited_by', Auth::user()->id)->get();

        $inviteesCount = $invitees->count();

       /* $data1['count'] = $inviteesCount;

        $boardUsers1 = $data1;*/
        //dd($boardUsers);
        //return view('board', compact('board', 'boardUsers', 'boardGrad', 'boardPreGrad'));
        return view('board', compact('board', 'boardUsers', 'boardGrad', 'boardPreGrad', 'inviteesCount', 'gifts'));
    }

    public static function create($amount)
    {
        $latest_board = Boards::all();

        try {
            return Boards::create([
                'board_number' => 'board-' . ($latest_board->count() + 1),
                'amount' => (string)((int)$amount),
            ]);
        } catch (\Exception $exception) {
            return $exception;
        }
    }
}
