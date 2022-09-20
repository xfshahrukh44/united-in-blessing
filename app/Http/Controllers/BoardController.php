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
        try {
            $board = Boards::find($board_id);
            $gifts = $board->gifts->keyBy('sent_by');
            $boardGrad = UserBoards::where('board_id', $board_id)
                ->where('user_board_roles', 'grad')
                ->with(['user', 'children'])
                ->get();

            return view('board-new', compact('board', 'boardGrad', 'gifts'));
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
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
