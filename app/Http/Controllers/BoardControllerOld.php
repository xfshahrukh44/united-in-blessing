<?php

namespace App\Http\Controllers;

use App\Models\Boards;
use App\Models\UserBoards;

class BoardControllerOld extends Controller
{
    public function index($board_id)
    {
        $board = Boards::where('id', $board_id)->first();
        $rawData = UserBoards::where('board_id', $board_id)->with('user')->get();

        $grad = $rawData->where('user_board_roles', 'grad')->first();
        $pregrad = $rawData->where('user_board_roles', 'pregrad');
        $left = $rawData->where('position', 'left')->where('user_board_roles', 'undergrad');
        $right = $rawData->where('position', 'right')->where('user_board_roles', 'undergrad');

        $order = ['pregrad', 'undergrad'];
        $left = collect($left)->sortBy(function ($item) use ($order) {
            return array_search($item->user_board_roles, $order);
        });

        $right = collect($right)->sortBy(function ($item) use ($order) {
            return array_search($item->user_board_roles, $order);
        });

        $data = [];
        $data['grad'] = $grad;

        $data['pregradLeft']['pregrad'] = $pregrad->where('position', 'left');
        $data['pregradLeft']['undergrad'] = $left;
        $data['pregradLeft']['undergrad']['newbie'] = [];

        $data['pregradRight']['pregrad'] = $pregrad->where('position', 'right');
        $data['pregradRight']['undergrad'] = $right;
        $data['pregradRight']['undergrad']['newbie'] = [];


        $boardUsers = collect($data);
//        dd($boardUsers);

        $boardGrad = UserBoards::where('board_id', $board_id)->where('user_board_roles', 'grad')->with('user')->first();
        $boardPreGrad = UserBoards::where('board_id', $board_id)->where('user_board_roles', 'pregrad')->with('user')->get();

        return view('board', compact('board', 'boardUsers', 'boardGrad', 'boardPreGrad'));
    }
}
