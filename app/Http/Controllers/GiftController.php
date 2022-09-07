<?php

namespace App\Http\Controllers;

use App\Models\GiftLogs;
use App\Models\UserBoards;
use Illuminate\Http\Request;

class GiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update gift status.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id, $status)
    {
        GiftLogs::where('id', $id)
            ->update([
                'status' => $status,
            ]);

        $gift = GiftLogs::where('id', $id)->first();

        if ($status == 'accepted') {
            $response = $this->giftFromOtherMembersOfSameMatrix($id);
            if ($response) {
                $createBoard = BoardController::create($gift->amount);
                if ($createBoard instanceof \Exception) {
                    return redirect()->back()->with('error', $createBoard->getMessage());
                }

                $addUserToBoard = $this->addUsersToBoard($gift, $createBoard);

                if ($addUserToBoard instanceof \Exception) {
                    return redirect()->back()->with('error', $addUserToBoard->getMessage());
                }
            }
        }

        return redirect()->back()->with('success', 'Status Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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

        $sibling = $this->siblings($board);

        $siblingGift = GiftLogs::where('sent_by', $sibling->user_id)
            ->where('board_id', $sibling->board_id)
            ->first();


        if ($siblingGift->status == 'accepted') {
            $parent = $sibling->parent;
            $sibling = $this->siblings($parent);

            foreach ($sibling->children as $newbie) {
                $siblingGift = GiftLogs::where('sent_by', $newbie->user_id)
                    ->where('board_id', $newbie->board_id)
                    ->first();
                if ($siblingGift->status == 'accepted') {
                    $sibling = $this->siblings($newbie);
                    $siblingGift = GiftLogs::where('sent_by', $sibling->user_id)
                        ->where('board_id', $sibling->board_id)
                        ->first();

                    if ($siblingGift->status == 'accepted') {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
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

            foreach ($grad->children as $pregrad) {
                $addPregradsToBoard = UserBoardsController::create($pregrad->user_id, $newBoard->id, $grad->user_id, 'pregrad', $pregrad->position);
                if ($addPregradsToBoard instanceof \Exception)
                    throw $addPregradsToBoard;

                foreach ($pregrad->children as $undergrad) {
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
