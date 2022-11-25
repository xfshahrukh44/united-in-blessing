<?php

namespace App\Http\Controllers;

use App\Models\Boards;
use App\Models\User;
use App\Models\UserBoards;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

            return view('board', compact('board', 'boardGrad', 'gifts'));
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }

    public function createForm()
    {
        $input['boards'] = Boards::all();
        $input['users'] = User::all();
        return view('admin.boards.create', $input);
    }

    public static function create($amount = null, $previous_board_number = null)
    {
        $latest_board = Boards::all();
        $request = Request::capture() ?? null;

        if ($request->has('board_number')) {
            $validator = Validator::make($request->all(), [
                'board_number' => ['required', 'unique:boards,board_number'],
                'previous_board_number' => [function ($attribute, $val, $fail) {
                    if (!$val) return;

                    if (!Boards::where('board_number', $val)->exists()) {
                        $fail(str_replace('_', ' ', $attribute) . ' not found');
                    }
                }],
                'amount' => 'required|numeric',
                'status' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
            }
        } else {
            $request = null;
        }

        DB::beginTransaction();
        try {
            $board = Boards::create([
                'board_number' => ($request) ? ($request->board_number ?? $request->board_number) : 'board-' . ($latest_board->count() + 1),
                'previous_board_number' => ($request) ? ($request->previous_board_number ?? $request->previous_board_number) : $previous_board_number,
                'amount' => ($request) ? ($request->amount ?? '') : (string)((int)$amount),
            ]);

            if ($request) {
                $grad = UserBoards::create([
                    'user_id' => $request->grad,
                    'board_id' => $board->id,
                    'user_board_roles' => 'grad',
                    'position' => 'left',
                ]);
            }

            DB::commit();
            if ($request) {
                return redirect()->back()->with('success', 'New board created successfully');
            } else {
                return $board;
            }

        } catch (\Exception $exception) {
            DB::rollBack();
            return $exception;
        }
    }

    public function boards()
    {
        try {
            if (request()->ajax()) {
                return datatables()->of(Boards::orderByDesc('created_at')->get())
                    ->addIndexColumn()
                    ->addColumn('amount', function ($data) {
                        return '$ ' . $data->amount;
                    })
                    ->addColumn('action', function ($data) {
                        return '<a title="Show" href="' . route('board.index', $data->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                            <a title="Edit" href="board/edit/' . $data->id . '" class="btn btn-dark btn-sm"><i class="fas fa-pencil-alt"></i></a>
                            <a title="Users" href="' . route('admin.board.members', $data->id) . '" class="btn btn-secondary btn-sm"><i class="fas fa-users"></i></a>
                            <button title="Delete" type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                    })
                    ->rawColumns(['amount', 'action'])
                    ->make(true);
            }
        } catch (\Exception $ex) {
            return redirect('/')->with('error', $ex->getMessage());
        }

        return view('admin.boards.index');
    }

    public function edit($id)
    {
        $data['board'] = Boards::find($id);

        return view('admin.boards.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $board = Boards::find($id);

        $validator = Validator::make($request->all(), [
            'board_number' => ['required', 'unique:boards,board_number,' . $id],
            'previous_board_number' => [function ($attribute, $val, $fail) {
                if (!$val) return;

                if (!Boards::where('board_number', $val)->exists()) {
                    $fail(str_replace('_', ' ', $attribute) . ' not found');
                }
            }],
            'amount' => 'required|numeric',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            redirect()->back()->with('error', $validator->getMessageBag())->withInput();
        }

        try {
            $board->update($request->all());

            return redirect()->back()->with('success', 'Board Updated Successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        $board = Boards::find($id);
        $board->delete();

        UserBoards::where('board_id', $id)->each(function ($board, $key) {
            $board->delete();
        });
        echo 1;
    }

    public function boardMembers($id)
    {
//        $board = UserBoards::where('board_id', $id)->first();
//        $users = User::all();
//
//        return view('admin.boards.members', compact('board', 'users'));

        try {
            $users = User::whereRole('user')->get();
            $board = Boards::find($id);
            $gifts = $board->gifts->keyBy('sent_by');
            $boardGrad = UserBoards::where('board_id', $id)
                ->where('user_board_roles', 'grad')
                ->with(['user', 'children'])
                ->get();

            return view('admin.boards.members', compact('users', 'board', 'boardGrad', 'gifts'));
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function previousBoardGrad(Request $request)
    {
        $board = Boards::where('board_number', $request->previous_board_number)->first();
        $grad = UserBoards::where('board_id', $board->id)->where('user_board_roles', 'grad')->first();

        return $grad->user->username;
    }
}
