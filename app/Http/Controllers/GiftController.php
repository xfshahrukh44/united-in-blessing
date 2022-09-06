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

//        if ($status == 'accepted') {
//            $gift = GiftLogs::where('id', $id)->first();
//            $board = UserBoards::where('user_id', $gift->sent_by)
//                ->where('board_id', $gift->board_id)
//                ->first();
//
//            $sibling = $this->siblings($board);
//
//            $giftDetails = GiftLogs::where('sent_by', $sibling->user_id)
//                ->where('board_id', $sibling->board_id)
//                ->first();
//
//            if ($giftDetails->status == 'accepted'){
//                dd($giftDetails->status);
//            }
//        }

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
    public function giftFromOtherMembers($gift)
    {
        // Check if sibling has gifted or not
        $sibling = UserBoards::where('parent_id', $gift->user);
    }
}
