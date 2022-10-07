<?php

namespace App\Http\Controllers;

use App\Models\Boards;
use App\Models\GiftLogs;
use App\Models\UserBoards;
use Illuminate\Http\Request;

class UserBoardsController extends Controller
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
     * @return \Exception|\Illuminate\Http\Response
     */
    public static function create($user_id, $board_id, $parent_id, $role, $position)
    {
        try {
            return UserBoards::create([
                'user_id' => $user_id,
                'board_id' => $board_id,
                'parent_id' => $parent_id,
                'user_board_roles' => $role,
                'position' => $position,
            ]);
        } catch (\Exception $exception) {
            return $exception;
        }
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
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
//         dd($request->all());
        $board = Boards::find($id);
        $input = $request->all();

        try {
            // Check if grad has changed
            $grad = UserBoards::where('board_id', $id)->where('user_board_roles', 'grad')->first();
            $grad_children = $grad->boardChildren($id);
            $grad->user_id = $input['grad'];

            if ($grad->isDirty()) {
                $this->updateMember($grad, $grad_children);
            }

            // Check if left pregrad has changed
            $pregrad_left = UserBoards::where('board_id', $id)->where('user_board_roles', 'pregrad')->where('position', 'left')->first();
            $pregrad_left_children = $pregrad_left->boardChildren($id);
            $pregrad_left->user_id = $input['pregrad_left'];

            if ($pregrad_left->isDirty()) {
                $this->updateMember($pregrad_left, $pregrad_left_children);
            }

            // Check if right pregrad has changed
            $pregrad_right = UserBoards::where('board_id', $id)->where('user_board_roles', 'pregrad')->where('position', 'right')->first();
            $pregrad_right_children = $pregrad_right->boardChildren($id);
            $pregrad_right->user_id = $input['pregrad_right'];

            if ($pregrad_right->isDirty()) {
                $this->updateMember($pregrad_right, $pregrad_right_children);
            }

            // Check if left undergrad under left pregrad has changed
            $undergrad_left_left = UserBoards::where('board_id', $id)
                ->where('user_board_roles', 'undergrad')
                ->where('position', 'left')
                ->where('parent_id', $pregrad_left->user_id)
                ->first();
            $undergrad_left_left_children = $undergrad_left_left->boardChildren($id);
            $undergrad_left_left->user_id = $input['undergrad_1_left'];

            if ($undergrad_left_left->isDirty()) {
                $this->updateMember($undergrad_left_left, $undergrad_left_left_children);
            }

            // Check if right undergrad under left pregrad has changed
            $undergrad_left_right = UserBoards::where('board_id', $id)
                ->where('user_board_roles', 'undergrad')
                ->where('position', 'right')
                ->where('parent_id', $pregrad_left->user_id)
                ->first();
            $undergrad_left_right_children = $undergrad_left_right->boardChildren($id);
            $undergrad_left_right->user_id = $input['undergrad_2_right'];

            if ($undergrad_left_right->isDirty()) {
                $this->updateMember($undergrad_left_right, $undergrad_left_right_children);
            }

            // Check if left undergrad under right pregrad has changed
            $undergrad_right_left = UserBoards::where('board_id', $id)
                ->where('user_board_roles', 'undergrad')
                ->where('position', 'left')
                ->where('parent_id', $pregrad_right->user_id)
                ->first();
            $undergrad_right_left_children = $undergrad_right_left->boardChildren($id);
            $undergrad_right_left->user_id = $input['undergrad_3_left'];

            if ($undergrad_right_left->isDirty()) {
                $this->updateMember($undergrad_right_left, $undergrad_right_left_children);
            }

            // Check if right undergrad under right pregrad has changed
            $undergrad_right_right = UserBoards::where('board_id', $id)
                ->where('user_board_roles', 'undergrad')
                ->where('position', 'right')
                ->where('parent_id', $pregrad_right->user_id)
                ->first();
            $undergrad_right_right_children = $undergrad_right_right->boardChildren($id);
            $undergrad_right_right->user_id = $input['undergrad_4_right'];

            if ($undergrad_right_right->isDirty()) {
                $this->updateMember($undergrad_right_right, $undergrad_right_right_children);
            }

            // Newbies
            foreach ($input['newbie'] as $parent => $newbie) {
                // Check if newbie has changed
                foreach ($newbie as $position => $user) {
                    if ($user) {
                        $new_newbie = UserBoards::where('board_id', $id)
                            ->where('user_board_roles', 'newbie')
                            ->where('position', $position)
                            ->where('parent_id', $parent)
                            ->first();

                        if (!$new_newbie)
                            $new_newbie = new UserBoards();
                        else
                            $old_newbie = $new_newbie->user_id;

                        $new_newbie->user_id = $user;

                        if ($new_newbie->isDirty()) {
                            $new_newbie->board_id = $id;
                            $new_newbie->parent_id = $parent;
                            $new_newbie->user_board_roles = 'newbie';
                            $new_newbie->position = $position;
//                            dd($new_newbie);

                            $new_newbie->save();

                            $giftlog = GiftLogs::where('board_id', $id)
                                ->where('sent_by', $old_newbie)
                                ->first();

                            if (!$giftlog)
                                $giftlog = new GiftLogs();

                            $giftlog->sent_by = $user;
                            $giftlog->sent_to = $grad->user_id;
                            $giftlog->board_id = $id;
                            $giftlog->amount = $board->amount;
                            $giftlog->status = 'pending';

                            $giftlog->save();
                        }

                    }

                }
            }

            return redirect()->back()->with('success', 'Board Updated Successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function updateMember($position, $children)
    {
        foreach ($children as $child) {
            $child->parent_id = $position->user_id;
            $child->save();
        }
        $position->save();
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
}
