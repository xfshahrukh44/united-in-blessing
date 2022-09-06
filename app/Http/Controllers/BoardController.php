<?php

namespace App\Http\Controllers;

use App\Models\Boards;
use App\Models\UserBoards;

class BoardController extends Controller
{
    public function index($board_id)
    {
        $board = Boards::where('id', $board_id)->first();
        $rawData = UserBoards::where('board_id', $board_id)->with('user', 'children')->get();

        $grad = $rawData->where('user_board_roles', 'grad');

        $order = ['grad', 'pregrad', 'undergrad', 'newbie'];
        $rawData = collect($rawData)->sortBy(function ($item) use ($order) {
            return array_search($item->user_board_roles, $order);
        });

        $data = [];
        $data['grad'] = $grad;

        $boardUsers = $data;

        $boardGrad = UserBoards::where('board_id', $board_id)->where('user_board_roles', 'grad')->with('user')->first();
        $boardPreGrad = UserBoards::where('board_id', $board_id)->where('user_board_roles', 'pregrad')->with('user')->get();

        return view('board', compact('board', 'boardUsers', 'boardGrad', 'boardPreGrad'));
    }

    public function create(){

    }
}
