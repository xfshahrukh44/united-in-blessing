<?php

namespace App\Http\Controllers;

use App\Models\Boards;
use App\Models\GiftLogs;
use App\Models\UserBoards;
use Illuminate\Http\Request;

class GiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application
     * @return \Illuminate\Http\RedirectResponse
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Routing\Redirector
     */
    public function index()
    {
        try {
            if (request()->ajax()) {
                return datatables()->of(GiftLogs::orderByDesc('created_at')->where('status', '!=', 'accepted')->with('sender', 'receiver', 'board')->get())
                    ->addIndexColumn()
                    ->addColumn('sent_by', function ($data) {
                        return $data->sender->username . ' (' . $data->sender->first_name . ' ' . $data->sender->last_name . ')';
                    })
                    ->addColumn('sent_to', function ($data) {
                        return $data->receiver->username . ' (' . $data->receiver->first_name . ' ' . $data->receiver->last_name . ')';
                    })
                    ->addColumn('board_id', function ($data) {
                        return $data->board->board_number;
                    })
                    ->addColumn('amount', function ($data) {
                        return '$ ' . $data->amount;
                    })
                    ->addColumn('action', function ($data) {
                        return '<a title="Edit" href="' . route('admin.gift.edit', $data->id) . '" class="btn btn-dark btn-sm"><i class="fas fa-pencil-alt"></i></a>&nbsp;<button title="Delete" type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                    })
                    ->rawColumns(['sent_by', 'sent_to', 'board_id', 'amount', 'action'])
                    ->make(true);
            }
        } catch (\Exception $ex) {
            return redirect('/')->with('error', $ex->getMessage());
        }
        return view('admin.gifts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $data['boards'] = Boards::all();

        return view('admin.gifts.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $gift = GiftLogs::where('id', $id)->with('sender', 'receiver', 'board')->firstOrFail();
        return view('admin.gifts.edit', compact('gift'));
    }

    /**
     * Update gift status.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id, $status = null)
    {
        // if theres status in request
        if ($request)
            $status = $request->status;

        GiftLogs::where('id', $id)
            ->update([
                'status' => $status,
            ]);

        $gift = GiftLogs::where('id', $id)->first();

        if ($status == 'accepted') {
            $response = $this->giftFromOtherMembersOfSameMatrix($id);
            if ($response) {
                $createBoard = BoardController::create($gift->amount, $gift->board->board_number);
                if ($createBoard instanceof \Exception) {
                    return redirect()->back()->with('error', $createBoard->getMessage());
                }

                $addUserToBoard = $this->addUsersToBoard($gift, $createBoard);

                if ($addUserToBoard instanceof \Exception) {
                    return redirect()->back()->with('error', $addUserToBoard->getMessage());
                }
            }
        }

        return redirect()->route('admin.gift.index')->with('success', 'Status Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gift = GiftLogs::find($id);
        $gift->delete();
        echo 1;
    }

    protected function siblings($user)
    {
        return UserBoards::where('parent_id', $user->parent_id)
            ->where('board_id', $user->board_id)
            ->where('user_id', '!=', $user->user_id)
            ->first();
    }

    // Check if other members of the same matrix have gifted
    public function giftFromOtherMembersOfSameMatrix($id)
    {
        $gift = GiftLogs::where('id', $id)->first();
        $board = UserBoards::where('user_id', $gift->sent_by)
            ->where('board_id', $gift->board_id)
            ->first();

        // Get Sibling
        $sibling = $this->siblings($board);

        if (!is_null($sibling)) {
            // check if sibling has already gifted
            $siblingGift = GiftLogs::where('sent_by', $sibling->user_id)
                ->where('board_id', $sibling->board_id)
                ->first();

            if ($siblingGift->status == 'accepted') {
                // Get parent and then sibling of parent to check if cousins have gifted
                $parent = $sibling->board_parent($gift->board_id);
                $sibling = $this->siblings($parent);

                // Get it's children
                foreach ($sibling->boardChildren($gift->board_id) as $newbie) {
                    $siblingGift = GiftLogs::where('sent_by', $newbie->user_id)
                        ->where('board_id', $newbie->board_id)
                        ->first();

                    if ($siblingGift->status == 'accepted') {
                        $sibling = $this->siblings($newbie);

                        if (!is_null($sibling)) {
                            $siblingGift = GiftLogs::where('sent_by', $sibling->user_id)
                                ->where('board_id', $sibling->board_id)
                                ->first();

                            if ($siblingGift->status == 'accepted') {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    } else {
                        return false;
                    }
                }
            }
        }
    }

    public function addUsersToBoard($gift, $newBoard)
    {
        try {
            //  Get Details of selected newbie to find the matrix and it's parent
            $newbie = UserBoards::where('user_id', $gift->sent_by)
                ->where('board_id', $gift->board_id)
                ->first();

            // Pregrad will become the grad
            $grad = $newbie->parent->parent;

            $addGradToBoard = UserBoardsController::create($grad->user_id, $newBoard->id, null, 'grad', null);
            if ($addGradToBoard instanceof \Exception)
                throw $addGradToBoard;

            foreach ($grad->boardChildren($gift->board_id) as $pregrad) {
                $addPregradsToBoard = UserBoardsController::create($pregrad->user_id, $newBoard->id, $grad->user_id, 'pregrad', $pregrad->position);
                if ($addPregradsToBoard instanceof \Exception)
                    throw $addPregradsToBoard;

                foreach ($pregrad->boardChildren($gift->board_id) as $undergrad) {
                    $addUndergradToBoard = UserBoardsController::create($undergrad->user_id, $newBoard->id, $pregrad->user_id, 'undergrad', $undergrad->position);
                    if ($addUndergradToBoard instanceof \Exception)
                        throw $addUndergradToBoard;
                }
            }

            return true;
        } catch (\Exception $exception) {
            return $exception;
        }


    }
}
