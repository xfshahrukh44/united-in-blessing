<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use App\Models\Boards;
use App\Models\GiftLogs;
use App\Models\RemoveUserRequest;
use App\Models\UserBoards;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
                        return $data->receiver ? $data->receiver->username . ' (' . $data->receiver->first_name . ' ' . $data->receiver->last_name . ')' : '---';
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
                        return '<a disabled title="Edit" href="' . route('admin.gift.edit', $data->id) . '" class="btn btn-dark btn-sm"><i class="fas fa-pencil-alt"></i></a>&nbsp;<button title="Delete" type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
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

    /**
     * Update gift status.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id, $status = null)
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
            //dd($boardUser);

            // check if other newbies in the same matrix has gifted
            $response = $this->giftFromOtherMembersOfSameMatrix($boardUser);

            if ($response) {
                // create new board of same amount to move the users of the same matrix
                $createBoard = BoardController::create($gift->amount, $gift->board->board_number);
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
                $sibling = null;
                if($grandParent) {
                    $sibling = $this->siblings($grandParent);
                }

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
                    $boardValues = array('100', '400', '1000', '2000');
                    $arrayPosition = array_search($grad->board->amount, $boardValues);

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
                        }

                        $arrayPosition++;
                    }
                }
            }

//            dd('Hello Nehal');
            DB::commit();
            $msg = 'Status Updated Successfully';
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

        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin.gift.index')->with('success', 'Status Updated Successfully');
        } else {
            return redirect()->back()->with('success', $msg);
        }

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
//    public function giftFromOtherMembersOfSameMatrix($boardUser)
//    {
//        switch ($boardUser->user_board_roles) {
//
//            // check if user who's gift is accepted is undergrad
//            case 'undergrad':
//                // get newbies of this undergrad
//                $newbies = $boardUser->boardChildren($boardUser->board_id);
//
//                // check if there are two newbies else return false
//                if ($newbies->count() > 1) {
//                    foreach ($newbies as $key => $newbie) {
//                        $gift = GiftLogs::where('sent_by', $newbie->user_id)
//                            ->where('board_id', $newbie->board_id)
//                            ->first();
//
//                        if (!empty($gift)) {
//                            if ($gift->status !== 'accepted') {
//                                return false;
//                            }
//                        }
//                        if ($key === 1) {
//                            //Get Sibling
//                            $sibling = $this->siblings($boardUser);
//                            $siblingGift = GiftLogs::where('sent_by', $sibling->user_id)
//                                ->where('board_id', $sibling->board_id)
//                                ->first();
//                            if (!is_null($siblingGift)) {
//                                if ($siblingGift->status == 'accepted') {
//                                    // Get it's children
//                                    if (!is_null($sibling)) {
//                                        foreach ($sibling->boardChildren($sibling->board_id) as $newbie) {
//                                            $siblingGift = GiftLogs::where('sent_by', $newbie->user_id)
//                                                ->where('board_id', $newbie->board_id)
//                                                ->first();
//
//                                            if ($siblingGift->status == 'accepted') {
//                                                $sibling = $this->siblings($newbie);
//
//                                                if (!is_null($sibling)) {
//                                                    $siblingGift = GiftLogs::where('sent_by', $sibling->user_id)
//                                                        ->where('board_id', $sibling->board_id)
//                                                        ->first();
//
//                                                    if ($siblingGift->status == 'accepted') {
//                                                        return true;
//                                                    } else {
//                                                        return false;
//                                                    }
//                                                }
//                                            } else {
//                                                return false;
//                                            }
//                                        }
//                                    } else {
//                                        return false;
//                                    }
//                                }
//                            }
//                        }
//                    }
//                } else {
//                    return false;
//                }
//                break;
//
//            case 'pregrad':
//                // get newbies of this pregrad
//                $newbies = $boardUser->boardChildren($boardUser->board_id);
//
//                // check if there are two newbies else return false
//                if ($newbies->count() > 1) {
//                    foreach ($newbies as $key => $newbie) {
//                        $gift = GiftLogs::where('sent_by', $newbie->user_id)
//                            ->where('board_id', $newbie->board_id)
//                            ->first();
//
//                        if (!empty($gift)) {
//                            if ($gift->status !== 'accepted') {
//                                return false;
//                            }
//                        }
//                        if ($key === 1) {
//                            //Get Sibling
//                            $sibling = $this->siblings($boardUser);
//                            $siblingGift = GiftLogs::where('sent_by', $sibling->user_id)
//                                ->where('board_id', $sibling->board_id)
//                                ->first();
//                            if (!is_null($siblingGift)) {
//                                if ($siblingGift->status == 'accepted') {
//                                    // Get it's children
//                                    if (!is_null($sibling)) {
//                                        foreach ($sibling->boardChildren($sibling->board_id) as $newbie) {
//                                            $siblingGift = GiftLogs::where('sent_by', $newbie->user_id)
//                                                ->where('board_id', $newbie->board_id)
//                                                ->first();
//
//                                            if ($siblingGift->status == 'accepted') {
//                                                $sibling = $this->siblings($newbie);
//
//                                                if (!is_null($sibling)) {
//                                                    $siblingGift = GiftLogs::where('sent_by', $sibling->user_id)
//                                                        ->where('board_id', $sibling->board_id)
//                                                        ->first();
//
//                                                    if ($siblingGift->status == 'accepted') {
//                                                        return true;
//                                                    } else {
//                                                        return false;
//                                                    }
//                                                }
//                                            } else {
//                                                return false;
//                                            }
//                                        }
//                                    } else {
//                                        return false;
//                                    }
//                                }
//                            }
//                        }
//                    }
//                } else {
//                    return false;
//                }
//                break;
//            case 'newbie':
//                //dd($boardUser->user_board_roles);
//                // get newbies of this undergrad
//                $newbies = $boardUser->boardChildren($boardUser->board_id);
//                //dd($newbies);
//                if ($newbies->count() > 1) {
//
//                }
//        }
//
//        //dd('Hello Nehal');
//    }

    public function checkGiftStatusOfSameMatrix($pregrad)
    {
        try {
            $pregradGift = GiftLogs::where('sent_by', $pregrad->user_id)
                ->where('board_id', $pregrad->board_id)
                ->first();

            if (!is_null($pregradGift)) {
                if ($pregradGift->status == 'accepted') {
                    if ($pregrad->user_board_roles != 'newbie'){
                        $undergrads = $pregrad->boardChildren($pregrad->board_id);

                        if ($undergrads->count() > 1){
                            foreach ($undergrads as $undergrad){
                                if(!$this->checkGiftStatusOfSameMatrix($undergrad)){
                                    return false;
                                }
                            }

                        } else{
                            return false;
                        }
                    }
                    return true;

                } else{
                    return false;
                }
            } else{
                return false;
            }

        } catch (\Exception $exception) {
            return false;
        }

    }

    // Check if other members of the same matrix have gifted
    public function giftFromOtherMembersOfSameMatrix($boardUser)
    {
        switch ($boardUser->user_board_roles){
            case 'pregrad':
                $pregrad = $boardUser;
                return $this->checkGiftStatusOfSameMatrix($pregrad);
                break;

            case 'undergrad':
                $pregrad = $boardUser->board_parent($boardUser->board_id);
                return $this->checkGiftStatusOfSameMatrix($pregrad);
                break;

            case 'newbie':
                $pregrad = $boardUser->board_parent($boardUser->board_id)->board_parent($boardUser->board_id);
                return $this->checkGiftStatusOfSameMatrix($pregrad);
                break;

            default:
                return false;
                break;
        }

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
                    if(!is_null($sibling)) {
                        foreach ($sibling->boardChildren($sibling->board_id) as $newbie) {
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
            $user = UserBoards::where('user_id', $gift->sent_by)
                ->where('board_id', $gift->board_id)
                ->first();

            if ($user->user_board_roles == 'pregrad'){
                // Pregrad will become the grad
                $grad = $user;
            } elseif ($user->user_board_roles == 'undergrad'){
                // Pregrad will become the grad
                $grad = $user->board_parent($user->board_id);
            } elseif($user->user_board_roles == 'newbie'){
                // Pregrad will become the grad
                $grad = $user->board_parent($user->board_id)->board_parent($user->board_id);
            }

            $addGradToBoard = UserBoardsController::create($grad->user_id, $newBoard->id, null, 'grad', null);
            if ($addGradToBoard instanceof \Exception)
                throw $addGradToBoard;

            foreach ($grad->boardChildren($gift->board_id) as $pregrad) {
                $addPregradsToBoard = UserBoardsController::create($pregrad->user_id, $newBoard->id, $grad->user_id, 'pregrad', $pregrad->position);
                if ($addPregradsToBoard instanceof \Exception)
                    throw $addPregradsToBoard;

                foreach ($pregrad->boardChildren($gift->board_id) as $key => $undergrad) {
                    $addUndergradToBoard = UserBoardsController::create($undergrad->user_id, $newBoard->id, $pregrad->user_id, 'undergrad', $undergrad->position);
                    if ($addUndergradToBoard instanceof \Exception)
                        throw $addUndergradToBoard;

//                    if($key == 0) /***** Get First undergrad id for use in the parent newbie *****/
//                    {
//                        /***** Add the old board grad in the new left board as a Newbies *****/
//                        if ($pregrad->position == 'left') {
//                            UserBoardsController::create($gift->sent_to, $newBoard->id, $undergrad->user_id, 'newbie', $undergrad->position);
//                            if ($addUndergradToBoard instanceof \Exception)
//                                throw $addUndergradToBoard;
//                        }
//                    }

                }
            }

            return true;
        } catch (\Exception $exception) {
            return $exception;
        }
    }

//    public function addUsersToBoard($gift, $newBoard)
//    {
//        try {
//            //  Get Details of selected newbie to find the matrix and it's parent
//            $newbie = UserBoards::where('user_id', $gift->sent_by)
//                ->where('board_id', $gift->board_id)
//                ->first();
//
//            dd($newbie);
//            // Pregrad will become the grad
//            $grad = $newbie->parent->parent;
//
//            $addGradToBoard = UserBoardsController::create($grad->user_id, $newBoard->id, null, 'grad', null);
//            if ($addGradToBoard instanceof \Exception)
//                throw $addGradToBoard;
//
//            foreach ($grad->boardChildren($gift->board_id) as $pregrad) {
//                $addPregradsToBoard = UserBoardsController::create($pregrad->user_id, $newBoard->id, $grad->user_id, 'pregrad', $pregrad->position);
//                if ($addPregradsToBoard instanceof \Exception)
//                    throw $addPregradsToBoard;
//
//                foreach ($pregrad->boardChildren($gift->board_id) as $undergrad) {
//                    $addUndergradToBoard = UserBoardsController::create($undergrad->user_id, $newBoard->id, $pregrad->user_id, 'undergrad', $undergrad->position);
//                    if ($addUndergradToBoard instanceof \Exception)
//                        throw $addUndergradToBoard;
//                }
//            }
//
//            return true;
//        } catch (\Exception $exception) {
//            return $exception;
//        }
//    }
}
