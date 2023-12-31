<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use App\Models\Boards;
use App\Models\GiftLogs;
use App\Models\RemoveUserRequest;
use App\Models\UserBoards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
                //->where('status', '!=', 'accepted')
                return datatables()->of(GiftLogs::has('sender')->has('receiver')->orderByDesc('created_at')->with('sender', 'receiver', 'board')->groupBy('sent_by', 'sent_to')->get())
                    ->addIndexColumn()
                    ->addColumn('sent_by', function ($data) {
                        return $data->sender ? $data->sender->username . ' (' . $data->sender->first_name . ' ' . $data->sender->last_name . ')' : '---';
                    })
                    ->addColumn('sent_to', function ($data) {
                        $grad = get_board_grad($data->board_id) ?? $data->receiver;
//                        return $data->receiver ? $data->receiver->username . ' (' . $data->receiver->first_name . ' ' . $data->receiver->last_name . ')' : '---';
                        return $grad ? $grad->username . ' (' . $grad->first_name . ' ' . $grad->last_name . ')' : '---';
                    })
                    ->addColumn('board_number', function ($data) {
                        return $data->board->board_number ?? '---';
                    })
                    ->addColumn('amount', function ($data) {
                        return '$ ' . $data->amount;
                    })
                    ->addColumn('status', function ($data) {
                        return ucfirst($data->status);
                    })
                    ->addColumn('action', function ($data) {
                        if($data->status === 'accepted') {
                            return '---';
                        }
                        return $data->board != null ? '<a disabled title="Edit" href="' . route('admin.gift.edit', $data->id) . '" class="btn btn-dark btn-sm"><i class="fas fa-pencil-alt"></i></a> &nbsp;<button title="Delete" type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>' : '&nbsp;<button title="Delete" type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';

//                        return '<a disabled title="Edit" href="' . route('admin.gift.edit', $data->id) . '" class="btn btn-dark btn-sm"><i class="fas fa-pencil-alt"></i></a>&nbsp;<button title="Delete" type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                    })
                    ->rawColumns(['sent_by', 'sent_to', 'board_number', 'amount', 'action', 'status'])
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

//    /**
//     * Update gift status.
//     *
//     * @param \Illuminate\Http\Request $request
//     * @param int $id
//     * @return \Illuminate\Http\RedirectResponse
//     */
//    public function update(Request $request, $id, $status = null)
//    {
//        DB::beginTransaction();
//        // if there's status in request
//        if ($request)
//            $status = $request->status;
//
//        GiftLogs::where('id', $id)
//            ->update([
//                'status' => $status,
//            ]);
//
//        $gift = GiftLogs::where('id', $id)->first();
//
//        // check if gift status is accepted
//        if ($status == 'accepted') {
//            // get user who's gift has been accepted
//            $boardUser = UserBoards::where('user_id', $gift->sent_by)
//                ->where('board_id', $gift->board_id)
//                ->first();
//
//            // check if other newbies in the same matrix has gifted
//            $response = $this->giftFromOtherMembersOfSameMatrix($boardUser);
//
//            if ($response) {
//                // create new board of same amount to move the users of the same matrix
//                $createBoard = BoardController::create($gift->amount, $gift->board->board_number);
//                if ($createBoard instanceof \Exception) {
//                    DB::rollBack();
//                    return redirect()->back()->with('error', $createBoard->getMessage());
//                }
//
//                // move users of the same matrix to the new board
//                $addUserToBoard = $this->addUsersToBoard($gift, $createBoard);
//                if ($addUserToBoard instanceof \Exception) {
//                    DB::rollBack();
//                    return redirect()->back()->with('error', $addUserToBoard->getMessage());
//                }
//
//                // If all the newbies in the same matrix has gifted then take there grand parent and find it's sibling
//                // to check if newbies in other matrix have gifted.
//                $grandParent = $boardUser->board_parent($boardUser->board_id)->board_parent($boardUser->board_id);
//                $sibling = $this->siblings($grandParent);
//                $undergrads = $sibling->boardChildren($sibling->board_id);
//                $newbies = $undergrads[0]->boardChildren($sibling->board_id);
//
//                // start checking from the left most newbie in the other matrix
//                $response = $this->giftFromOtherMembersOfSameMatrix($newbies[0]);
//
//                if ($response) {
////                    Set board status to retired
//                    $board = Boards::where('id', $sibling->board_id)->update([
//                        'status' => 'retired',
//                    ]);
//
//                    // Get grad to move in the new board.
//                    $grad = UserBoards::where('board_id', $sibling->board_id)->where('user_board_roles', 'grad')->first();
//                    $gradInvitedBy = $grad->user->invitedBy;
//
////                    dd($createBoard);
////                    dd($grad->user->invitedBy);
//
//                    // define board values
//                    $boardValues = array('100', '400', '1000', '2000');
//                    $arrayPosition = array_search($grad->board->amount, $boardValues);
//
//                    for ($y = 1; $y < 3; $y++) {
//                        if (array_key_exists($arrayPosition, $boardValues)) {
//                            // check inviters for upto 7 positions
//                            for ($x = 1; $x < 8; $x++) {
//                                if (!empty($gradInvitedBy)) {
//                                    // find same level board of grad's inviter
//                                    $sameLevelBoard = UserBoards::where('user_id', $gradInvitedBy->id)
//                                        ->where('user_board_roles', '!=', 'newbie')
//                                        ->where('board_id', '!=', $grad->board_id)
//                                        ->whereHas('board', function ($q) use ($grad, $boardValues, $arrayPosition) {
//                                            $q->where('amount', $boardValues[$arrayPosition]);
//                                        })
//                                        ->has('newbies', '<', 8)
//                                        ->first();
//
//                                    // check if same level is not found
//                                    if (is_null($sameLevelBoard)) {
//                                        $gradInvitedBy = $gradInvitedBy->invitedBy;
//
//                                        // check if inviter not found
//                                        if (is_null($gradInvitedBy)) {
//                                            break;
//                                        }
//                                    } else {
//                                        break;
//                                    }
//                                }
//                            }
//
//
//                            if (empty($gradInvitedBy)) {
////                                // Move grad to upper level board
////                                if ($y == 2) {
////                                    $upperLevelBoard = Boards::where('amount', $boardValues[$arrayPosition])->has('newbies', '<', 8)->first();
////                                    dd(UserBoards::where('board_id', $upperLevelBoard->id)->get());
////                                }
////
////                                // Move grad to same level board
////                                $leftPregrad = UserBoards::where('board_id', $createBoard->id)->where('user_board_roles', 'pregrad')->where('position', 'left')->first();
////                                $undergrads = $leftPregrad->boardChildren($createBoard->id);
//
//                                // check if inviter is admin
//                                if ($grad->user->invitedBy->username == 'admin') {
//                                    if ($y == 1) {
//                                        $sameLevelBoard = UserBoards::where('board_id', $createBoard->id)
//                                            ->has('newbies', '<', 8)
//                                            ->first();
//
//                                    } elseif($y == 2){
//                                        $upperLevelBoard = Boards::where('amount', $boardValues[$arrayPosition])->has('newbies', '<', 8)->first();
//                                        $sameLevelBoard = UserBoards::where('board_id', $upperLevelBoard->id)->first();
//                                    }
////                                    UserBoardsController::create($grad->user->id, $createBoard->id, $undergrads[0]->user->id, 'newbie', 'left');
//                                }
//                            }
//
//                            if ($sameLevelBoard) {
//                                $userPlacement = RegisterController::getPositionToPlaceUserInBoard($sameLevelBoard);
//
//                                // Add User to the board
//                                UserBoards::create([
//                                    'user_id' => $grad->user_id,
//                                    'board_id' => $sameLevelBoard->board_id,
//                                    'parent_id' => $userPlacement['parent_id'],
//                                    'user_board_roles' => $userPlacement['role'] != '' ? $userPlacement['role'] : 'newbie',
//                                    'position' => $userPlacement['position']
//                                ]);
//
//                                // Get grad of the board to send the gift
//                                $boardGrad = UserBoards::where('board_id', $sameLevelBoard->board_id)
//                                    ->where('user_board_roles', 'grad')
//                                    ->with('user', 'board')
//                                    ->first();
//
//                                // Create gift log
//                                GiftLogs::create([
//                                    'sent_by' => $grad->user_id,
//                                    'sent_to' => $boardGrad->user_id,
//                                    'board_id' => $sameLevelBoard->board_id,
//                                    'amount' => $sameLevelBoard->board->amount,
//                                    'status' => 'pending',
//                                ]);
//                            }
//                        }
//
//                        $arrayPosition++;
//                    }
//                }
//            }
//
////            dd('Hello Nehal');
//            DB::commit();
//            $msg = 'Status Updated Successfully';
//        } else {
//            DB::beginTransaction();
//            RemoveUserRequest::updateOrCreate(
//                [
//                    'user_id' => $gift->sent_by,
//                    'board_id' => $gift->board_id,
//                    'requested_by' => Auth::user()->id,
//                ],
//                [
//                    'status' => 'pending',
//                ]
//            );
//
//            DB::commit();
////            $msg = 'Your Request  to Remove "' . $gift->sender->username . '" from "' . $gift->board->board_number . '" has been submitted to the Admin.';
//            $msg = 'Your Request has been submitted to the Admin.';
//        }
//
//        if (Auth::user()->role == 'admin') {
//            return redirect()->route('admin.gift.index')->with('success', 'Status Updated Successfully');
//        } else {
//            return redirect()->back()->with('success', $msg);
//        }
//
//    }

    public function update(Request $request, $id, $status = null, $redirect = true)
    {
        if ($request)
            $status = $request->status;

        $gift = GiftLogs::where('id', $id)->first();
        $gift->status = $status;
        $gift->save();


        if ($status == 'accepted') {
            //if all gifts accepted
            if (board_is_ready_to_retire($gift->board_id)) {
                //mark board as retired
                $board = Boards::find($gift->board_id);
                $board->status = 'retired';
                $board->save();

                //split board
                $split_board_res = split_board($board->id);
                if ($split_board_res == false) {
                    return redirect()->back()->with('error', 'Split board failed');
                }

                //add grad to left-split board as newbie
                add_previous_boards_grad_as_newbie($split_board_res['left_board_id']);

                //add grad to upper-value board
                if ($board->amount != '2000') {
                    $res = add_grad_to_upper_value_board($board->id);
                    $res = add_grad_to_same_value_board($board->id);
                }
            }
        }

        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin.gift.index')->with('success', 'Status Updated Successfully');
        } else {
            return redirect()->back()->with('success', 'Status Updated Successfully');
        }
    }

    /**
     * Update gift status.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateOld(Request $request, $id, $status = null, $redirect = true)
    {
        DB::beginTransaction();
        // if there's status in request
        if ($request)
        {
            $status = $request->status;
        }

        GiftLogs::where('id', $id)
            ->update([
                'status' => $status,
            ]);

        $gift = GiftLogs::where('id', $id)->first();

        // check if gift status is accepted
        if ($status == 'accepted') {
            // get user who's gift has been accepted
            $boardUser = UserBoards::where('user_id', $gift->sent_by)
                ->where('board_id', $gift->board_id)
                ->first();

            // check if other newbies in the same matrix has gifted
            $response = $this->giftFromOtherMembersOfSameMatrix($boardUser);

            if ($response) {
                // create new board of same amount to move the users of the same matrix
                $createBoard = BoardController::create($gift->amount, $gift->board->board_number, 'auto');
                if ($createBoard instanceof \Exception) {
                    DB::rollBack();
                    return redirect()->back()->with('error', $createBoard->getMessage());
                }

                // move users of the same matrix to the new board
                $addUserToBoard = $this->addUsersToBoard($gift, $createBoard);
                if ($addUserToBoard instanceof \Exception) {
                    DB::rollBack();
                    return redirect()->back()->with('error', $addUserToBoard->getMessage());
                }

                // If all the newbies in the same matrix has gifted then take there grand parent and find it's sibling
                // to check if newbies in other matrix have gifted.
                $grandParent = $boardUser->board_parent($boardUser->board_id)->board_parent($boardUser->board_id);
                $sibling = $this->siblings($grandParent);
                $undergrads = [];
                if ($sibling) {
                    $undergrads = $sibling->boardChildren($sibling->board_id);
                }

                $newbies = [];
                $response = null;
                if (count($undergrads) > 0) {
                    $newbies = $undergrads[0]->boardChildren($sibling->board_id);
                    if (!empty($newbies) && count($newbies) > 0)
                        $response = $this->giftFromOtherMembersOfSameMatrix($newbies[0]);
                }
                // start checking from the left most newbie in the other matrix


                if ($response) {
//                    Set board status to retired
                    $board = Boards::where('id', $sibling->board_id)->update([
                        'status' => 'retired',
                    ]);

                    // Get grad to move in the new board.
                    $grad = UserBoards::where('board_id', $sibling->board_id)->where('user_board_roles', 'grad')->first();
                    $gradInvitedBy = $grad->user->invitedBy;

//                    dd($createBoard);
//                    dd($grad->user->invitedBy);

                    // define board values
//                    $boardValues = array('50', '100', '200', '400', '500', '1000', '2000');
                    $boardValues = array('100', '400', '1000', '2000');
                    $arrayPosition = array_search($grad->board->amount, $boardValues);

                    //old logic (add grad as newbie)
                    for ($y = 1; $y < 3; $y++) {
                        if (array_key_exists($arrayPosition, $boardValues)) {
                            // check inviters for upto 7 positions
                            for ($x = 1; $x < 8; $x++) {
                                if (!empty($gradInvitedBy)) {
                                    // find same level board of grad's inviter
                                    if($grad->user->invitedBy->username == 'admin') {
                                        $pregrad = UserBoards::where('board_id', $grad->board->id)
                                            ->where('user_board_roles', 'pregrad')
                                            ->where('position', 'left')
                                            ->first();
                                        $gradInvitedBy = $pregrad->user;
                                    }
                                    $sameLevelBoard = UserBoards::where('user_id', $gradInvitedBy->id)
                                        ->where('user_board_roles', '!=', 'newbie')
                                        ->where('board_id', '!=', $grad->board_id)
                                        ->whereHas('board', function ($q) use ($grad, $boardValues, $arrayPosition) {
                                            $q->where('amount', $boardValues[$arrayPosition]);
                                        })
                                        ->has('newbies', '<', 8)
                                        ->first();

                                    // check if same level is not found
                                    if (is_null($sameLevelBoard)) {
                                        $gradInvitedBy = $gradInvitedBy->invitedBy;

                                        // check if inviter not found
                                        if (is_null($gradInvitedBy)) {
                                            break;
                                        }
                                    } else {
                                        break;
                                    }
                                }
                            }


                            if (empty($gradInvitedBy)) {
//                                // Move grad to upper level board
//                                if ($y == 2) {
//                                    $upperLevelBoard = Boards::where('amount', $boardValues[$arrayPosition])->has('newbies', '<', 8)->first();
//                                    dd(UserBoards::where('board_id', $upperLevelBoard->id)->get());
//                                }
//
//                                // Move grad to same level board
//                                $leftPregrad = UserBoards::where('board_id', $createBoard->id)->where('user_board_roles', 'pregrad')->where('position', 'left')->first();
//                                $undergrads = $leftPregrad->boardChildren($createBoard->id);

                                // check if inviter is admin
                                //dd($grad->user->invitedBy);
                                if ($grad->user->invitedBy->username == 'admin') {
                                    if ($y == 1) {
                                        $sameLevelBoard = UserBoards::where('board_id', $createBoard->id)
                                            ->has('newbies', '<', 8)
                                            ->first();

                                    } elseif ($y == 2) {
                                        $upperLevelBoard = Boards::where('amount', $boardValues[$arrayPosition])->has('newbies', '<', 8)->first();
                                        $sameLevelBoard = UserBoards::where('board_id', $upperLevelBoard->id)->first();
                                    }
//                                    UserBoardsController::create($grad->user->id, $createBoard->id, $undergrads[0]->user->id, 'newbie', 'left');
                                }
                            }

                            if ($sameLevelBoard) {
                                $userPlacement = RegisterController::getPositionToPlaceUserInBoard($sameLevelBoard);

                                $user_board_check = UserBoards::where([
                                    'user_id' => $grad->user_id,
                                    'board_id' => $sameLevelBoard->board_id,
                                    'user_board_roles' => $userPlacement['role'] != '' ? $userPlacement['role'] : 'newbie',
                                ])->get();

                                if (count($user_board_check) == 0) {
                                    // Add User to the board
                                    UserBoards::create([
                                        'user_id' => $grad->user_id,
                                        'board_id' => $sameLevelBoard->board_id,
                                        'parent_id' => $userPlacement['parent_id'],
                                        'user_board_roles' => $userPlacement['role'] != '' ? $userPlacement['role'] : 'newbie',
                                        'position' => $userPlacement['position']
                                    ]);

                                    // Get grad of the board to send the gift
                                    $boardGrad = UserBoards::where('board_id', $sameLevelBoard->board_id)
                                        ->where('user_board_roles', 'grad')
                                        ->with('user', 'board')
                                        ->first();

                                    // Create gift log
                                    GiftLogs::create([
                                        'sent_by' => $grad->user_id,
                                        'sent_to' => $boardGrad->user_id,
                                        'board_id' => $sameLevelBoard->board_id,
                                        'amount' => $sameLevelBoard->board->amount,
                                        'status' => 'pending',
                                    ]);
                                }

                                break;

                            }
                        }

                        $arrayPosition++;
                    }

                    //new logic
                    if ($grad->board->amount != '2000') {
                        $upgraded_board_amount = $boardValues[$arrayPosition + 1];
                        Log::info('$upgraded_board_amount' . $upgraded_board_amount);

                        $inviters = get_inviter_tree($grad->user->id, 10);

                        $inviter_as_parent_found = false;
                        foreach ($inviters as $inviter_id) {
                            $member = UserBoards::whereHas('board', function ($q) use ($upgraded_board_amount) {
                                return $q->where('amount', $upgraded_board_amount)->where('status', 'active');
                            })->where('user_id', $inviter_id)->first();

                            if (!$member) {
                                continue;
                            }

                            if (!all_undergrads_filled($member->board_id)) {
                                continue;
                            }


                            $board = Boards::find($member->board_id);
                            Log::info('PROMOTION | upgraded amount: ' . $upgraded_board_amount);
                            Log::info('PROMOTION | board id: ' . $board->id);
                            $inviter_as_parent_found = add_newbie_to_board2($board, $grad->user);
                            break;
                        }

                        //if $inviter_as_parent_found is still false
                        if (!$inviter_as_parent_found) {
                            $member = UserBoards::whereHas('board', function ($q) use ($upgraded_board_amount) {
                                return $q->where('amount', $upgraded_board_amount)->where('status', 'active');
                            })
                            ->whereNotExists(function ($q) use($grad) {
                                return $q->where('user_id', $grad->user->id);
                            })
                            ->has('newbies', '<', 8)->has('undergrads', '=', 4)->orderBy('created_at', 'ASC')->first();

                            if ($member) {
                                $board = Boards::find($member->board_id);
                                Log::info('PROMOTION | upgraded amount: ' . $upgraded_board_amount);
                                Log::info('PROMOTION | board id: ' . $board->id);
                                add_newbie_to_board2($board, $grad->user);
                            }
                        }
                    }

//                    //old logic transform
//                    $current_board = Boards::find($gift->board_id);
//                    $boards = Boards::where([
//                        'previous_board_number' => $current_board->board_number,
//                        'amount' => $current_board->amount
//                    ])->get();
//
//                    foreach ($boards as $board) {
//                        if (!all_undergrads_filled($board->id)) {
//                            continue;
//                        }
//
//                        $parent_and_position = get_left_most_undergrad_parent_and_position($board->id);
//                        $parent = $parent_and_position['parent'];
//                        $position = $parent_and_position['position'];
//
//                        add_user_to_board($grad->user, $board->id, $parent->user_id, 'newbie', $position);
//                        break;
//                    }
                }
            }

            DB::commit();
            $msg = 'Status Updated Successfully';

            //new logic 2
            if ($first_board = Boards::find($gift->board_id)) {
                if ($first_board->status == 'retired') {
                    if ($board = Boards::where('previous_board_number', $first_board->board_number)->orderBy('board_number', 'DESC')->first()) {
                        if (UserBoards::where('board_id', $board->id)->where('user_board_roles', 'newbie')->count() == 0) {
                            add_previous_boards_grad_as_newbie($board->id);
                        }
                    }

                    if ($board = Boards::where('previous_board_number', $first_board->board_number)->orderBy('board_number', 'ASC')->first()) {
                        if (UserBoards::where('board_id', $board->id)->where('user_board_roles', 'newbie')->count() > 0) {
                            UserBoards::where([
                                'board_id' => $board->id,
                                'user_id' => $first_board->grad()->id,
                                'user_board_roles' => 'newbie'
                            ])->forceDelete();
                        }
                    }
                }
            }
        } else {
            DB::beginTransaction();
            RemoveUserRequest::updateOrCreate(
                [
                    'user_id' => $gift->sent_by,
                    'board_id' => $gift->board_id,
                    'requested_by' => Auth::user()->id,
                ],
                [
                    'status' => 'pending',
                ]
            );

            DB::commit();
//            $msg = 'Your Request  to Remove "' . $gift->sender->username . '" from "' . $gift->board->board_number . '" has been submitted to the Admin.';
            $msg = 'Your Request has been submitted to the Admin.';
        }

        if (!$redirect) {
            return true;
        }

        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin.gift.index')->with('success', 'Status Updated Successfully');
        } else {
            return redirect()->back()->with('success', $msg);
        }

    }


    public function acceptAllGifts(Request $request)
    {
        $pendingIncomingGifts = GiftLogs::whereHas('board', function ($q) {
            return $q->whereHas('members', function ($q) {
                return $q->where('user_board_roles', 'grad')->where('user_id', Auth::id());
            });
        })->where('status', 'pending')->with('board', 'sender')->orderBy('created_at', 'ASC')->get();

        $request['status'] = 'accepted';
        foreach ($pendingIncomingGifts as $gift) {
            $this->update($request, $gift->id, 'accepted', false);

            //new logic 2
            if ($first_board = Boards::find($gift->board_id)) {
                if ($first_board->status == 'retired') {
                    if ($board = Boards::where('previous_board_number', $first_board->board_number)->orderBy('board_number', 'DESC')->first()) {
                        if (UserBoards::where('board_id', $board->id)->where('user_board_roles', 'newbie')->count() == 0) {
                            add_previous_boards_grad_as_newbie($board->id);
                        }
                    }

                    if ($board = Boards::where('previous_board_number', $first_board->board_number)->orderBy('board_number', 'ASC')->first()) {
                        if (UserBoards::where('board_id', $board->id)->where('user_board_roles', 'newbie')->count() > 0) {
                            UserBoards::where([
                                'board_id' => $board->id,
                                'user_id' => $first_board->grad()->id,
                                'user_board_roles' => 'newbie'
                            ])->forceDelete();
                        }
                    }
                }
            }
        }

        return redirect()->back();
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
    public function giftFromOtherMembersOfSameMatrix($boardUser)
    {
        $user_board = $boardUser;

        // Get Sibling
        $sibling = $this->siblings($boardUser);

        if (!is_null($sibling)) {
            // check if sibling has already gifted
            $siblingGift = GiftLogs::where('sent_by', $sibling->user_id)
                ->where('board_id', $sibling->board_id)
                ->first();

            if (!is_null($siblingGift)) {
                if ($siblingGift->status == 'accepted') {
                    // Get parent and then sibling of parent to check if cousins have gifted
                    $parent = $sibling->board_parent($sibling->board_id);
                    $sibling = $this->siblings($parent);

                    // Get it's children
                    if ($sibling) {
                        foreach ($sibling->boardChildren($sibling->board_id) as $newbie) {
                            $siblingGift = GiftLogs::where('sent_by', $newbie->user_id)
                                ->where('board_id', $newbie->board_id)
                                ->first();

                            if (!$siblingGift) {
                                return false;
                            }

                            if ($siblingGift->status == 'accepted') {
                                $sibling = $this->siblings($newbie);

                                if (!is_null($sibling)) {
                                    $siblingGift = GiftLogs::where('sent_by', $sibling->user_id)
                                        ->where('board_id', $sibling->board_id)
                                        ->first();

                                    if ($siblingGift->status == 'accepted') {
//                                        //if all undergrads have given gifts
//                                        if ($user_board->user_board_roles == 'undergrad') {
//                                            //add grad of previous board as a newbie
//                                            $board = Boards::find($user_board->board_id);
//                                            if (is_null($board->previous_board_number)) {
//                                                return false;
//                                            }
//                                            if (!$previous_board = Boards::where('board_number', $board->previous_board_number)->first()) {
//                                                return false;
//                                            }
//                                            if (!$grad = $previous_board->grad()) {
//                                                return false;
//                                            }
//
//                                            $potential_parents = [];
//                                            $potential_parents_left = UserBoards::where('board_id', $board->id)->where('user_board_roles', 'undergrad')
//                                                ->whereHas('parent', function ($q) {
//                                                    return $q->where('position', 'left');
//                                                })
//                                                ->orderBy('position', 'ASC')->get();
//                                            $potential_parents_right = UserBoards::where('board_id', $board->id)->where('user_board_roles', 'undergrad')
//                                                ->whereHas('parent', function ($q) {
//                                                    return $q->where('position', 'right');
//                                                })
//                                                ->orderBy('position', 'ASC')->get();
//                                            foreach ($potential_parents_left as $item) {
//                                                $potential_parents []= $item;
//                                            }
//                                            foreach ($potential_parents_right as $item) {
//                                                $potential_parents []= $item;
//                                            }
//                                            foreach ($potential_parents as $key => $board_member) {
//                                                if ($board_member->child_nodes()->count() >= 2) {
//                                                    unset($potential_parents[$key]);
//                                                }
//                                            }
//                                            if (count($potential_parents) == 0) {
//                                                return false;
//                                            }

//                                            //reset index
//                                            $potential_parents = array_values($potential_parents);
//
////                                            $parent = $potential_parents->first();
//                                            $parent = $potential_parents[0];
//                                            if ($parent->child_nodes()->count() == 0) {
//                                                $position = 'left';
//                                            } else {
//                                                $position = 'right';
//                                            }
//
//                                            UserBoards::create([
//                                                'user_id' => $grad->user->id,
//                                                'username' => $grad->user->username,
//                                                'board_id' => $board->id,
//                                                'parent_id' => $parent->user_id,
//                                                'user_board_roles' => 'newbie',
//                                                'position' => $position,
//                                            ]);
//
//                                            GiftLogs::create([
//                                                'sent_by' => $grad->user->id,
//                                                'sent_to' => $parent->user_id,
//                                                'board_id' => $board->id,
//                                                'amount' => $board->amount,
//                                                'status' => 'pending',
//                                            ]);
//
//                                            return false;
//                                        }
                                        //if matrix role is not newbie
                                        if ($user_board->user_board_roles != 'newbie') {
                                            return false;
                                        }
                                        return true;
                                    } else {
                                        return false;
                                    }
                                }
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
            Log::info('BEGIN: addUsersToBoard');
            //  Get Details of selected newbie to find the matrix and it's parent
            $newbie = UserBoards::with('parent.parent')->where('user_id', $gift->sent_by)
                ->where('board_id', $gift->board_id)
                ->first();

            // Pregrad will become the grad
//            $grad = $newbie->parent->parent;
            $grad = $newbie->board_parent($gift->board_id)->board_parent($gift->board_id);

            if ($grad) {
                Log::info('$grad found');
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
            }
        } catch (\Exception $exception) {
            return $exception;
        }
    }
}
