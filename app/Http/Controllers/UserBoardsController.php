<?php

namespace App\Http\Controllers;

use App\Models\Boards;
use App\Models\GiftLogs;
use App\Models\UserBoards;
use Illuminate\Database\Eloquent\Model;
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
//        dd($request->all());
        $board = Boards::find($id);
        $input = $request->all();

        try {
            // Check if grad has changed
            $grad = UserBoards::where('board_id', $id)->where('user_board_roles', 'grad')->first();

            if (!$grad) {
                $grad = new UserBoards();

                $grad->user_id = $input['grad'];
                $grad->board_id = $board->id;
                $grad->user_board_roles = 'grad';
                $grad->position = 'left';

                $grad->save();
            } else {
                $grad_children = $grad->boardChildren($id);
                $grad->user_id = $input['grad'];

                if ($grad->isDirty()) {
                    $this->updateMember($grad, $grad_children);
                }
            }

            // Check if pregrads have changed
            foreach ($input['pregrad'] as $parent => $pregrads) {
                foreach ($pregrads as $position => $pregrad) {
                    if ($pregrad) {
                        ${'pregrad_' . $position} = UserBoards::where('board_id', $id)
                            ->where('user_board_roles', 'pregrad')
                            ->where('position', $position)
                            ->where('parent_id', $parent)
                            ->first();

                        if (!${'pregrad_' . $position}) {
                            // Pregrad Not Found! Creating A New One
                            ${'pregrad_' . $position} = new UserBoards();

                            ${'pregrad_' . $position}->user_id = $pregrad;
                            ${'pregrad_' . $position}->board_id = $board->id;
                            ${'pregrad_' . $position}->parent_id = $parent;
                            ${'pregrad_' . $position}->user_board_roles = 'pregrad';
                            ${'pregrad_' . $position}->position = $position;

                            ${'pregrad_' . $position}->save();

                            // creating giftlog for this
                            createGiftLog($pregrad, $grad->user_id, $id, $board->amount, 'pending');

                        } else {
                            // Replacing pregrad
                            $old_pregrad = ${'pregrad_' . $position};
                            $new_pregrad = clone $old_pregrad;
                            ${'pregrad_' . $position . '_children'} = $old_pregrad->boardChildren($id);
                            $new_pregrad->user_id = $pregrad;

//                            if (${'pregrad_' . $position}->isDirty()) {
                            if ($new_pregrad !== $old_pregrad) {
                                $this->updateMember($new_pregrad, ${'pregrad_' . $position . '_children'});

                                // update gift log
                                createGiftLog($pregrad, $grad->user_id, $id, $board->amount, null, $old_pregrad->user_id);
                            }
                        }
                    }
                }
            }

            // Check if undergrads have changed
            foreach ($input['undergrads'] as $parent => $undergrads) {
                foreach ($undergrads as $position => $undergrad) {
                    if ($undergrad){
                        ${'undergrad_' . $position} = UserBoards::where('board_id', $id)
                            ->where('user_board_roles', 'undergrad')
                            ->where('position', $position)
                            ->where('parent_id', $parent)
                            ->first();

                        if (!${'undergrad_' . $position}){
                            ${'undergrad_' . $position} = new UserBoards();

                            ${'undergrad_' . $position}->user_id = $undergrad;
                            ${'undergrad_' . $position}->board_id = $board->id;
                            ${'undergrad_' . $position}->parent_id = $parent;
                            ${'undergrad_' . $position}->user_board_roles = 'undergrad';
                            ${'undergrad_' . $position}->position = $position;

                            ${'undergrad_' . $position}->save();

                            // creating giftlog for this
                            createGiftLog($undergrad, $grad->user_id, $id, $board->amount, 'pending');
                        } else{
                            // Replacing Undergrad
                            $old_undergrad = ${'undergrad_' . $position};
                            $new_undergrad = clone $old_undergrad;

                            ${'undergrad_' . $position . '_children'} = $old_undergrad->boardChildren($id);
                            $new_undergrad->user_id = $undergrad;

//                            if(${'undergrad_' . $position}->isDirty()){
                            if($new_undergrad !== $old_undergrad){
                                $this->updateMember($new_undergrad, ${'undergrad_' . $position . '_children'});

                                // update gift log
                                createGiftLog($undergrad, $grad->user_id, $id, $board->amount, null, $old_undergrad->user_id);
                            }
                        }
                    }
                }
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

                        $old_newbie = null;
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

                            if (!is_null($old_newbie)) {
                                $giftlog = GiftLogs::where('board_id', $id)
                                    ->where('sent_by', $old_newbie)
                                    ->first();
                            } else {
                                $giftlog = new GiftLogs();
                            }

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

    public function updateMember($new_pregrad, $children)
    {
        foreach ($children as $child) {
            $child->parent_id = $new_pregrad->user_id;
            $child->save();
        }
        $new_pregrad->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($board_id, $user_id)
    {
        try {
            $user = UserBoards::where('board_id', $board_id)->where('user_id', $user_id)->first();
            $user->delete();

            $gift = GiftLogs::where('board_id', $board_id)->where('sent_by', $user_id)->first();
            $gift->delete();

            return redirect()->back()->with('success', 'User Removed from the board');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
