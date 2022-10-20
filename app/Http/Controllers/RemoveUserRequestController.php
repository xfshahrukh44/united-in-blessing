<?php

namespace App\Http\Controllers;

use App\Models\GiftLogs;
use App\Models\RemoveUserRequest;
use App\Models\UserBoards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RemoveUserRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (request()->ajax()) {
                return datatables()->of(RemoveUserRequest::orderByDesc('created_at')->where('status', 'pending')->get())
                    ->addIndexColumn()
                    ->addColumn('user_id', function ($data) {
                        return $data->user->username . ' (' . $data->user->first_name . ' ' . $data->user->last_name . ')';
                    })
                    ->addColumn('board_id', function ($data) {
                        return $data->board->board_number;
                    })
                    ->addColumn('requested_by', function ($data) {
                        $userPosition = UserBoards::where('board_id', $data->board_id)->where('user_id', $data->requested_by)->first();
                        return $userPosition->user_board_roles;
                    })
                    ->addColumn('status', function ($data) {
                        return '<select class="form-control requestStatus"><option value="pending" data-id="' . $data->id . '">pending</option><option value="accepted" data-id="' . $data->id . '">accepted</option><option value="rejected" data-id="' . $data->id . '">rejected</option></select>';
                        return $data->status;
                    })
//                    ->addColumn('action', function ($data) {
//                        return '<a title="Edit" href="' . route('admin.gift.edit', $data->id) . '" class="btn btn-dark btn-sm"><i class="fas fa-pencil-alt"></i></a>&nbsp;<button title="Delete" type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
//                    })
                    ->rawColumns(['user_id', 'requested_by', 'status', 'action'])
                    ->make(true);
            }
        } catch (\Exception $ex) {
            return redirect('/')->with('error', $ex->getMessage());
        }
        return view('admin.removeUserRequest.index');
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
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return string
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $removeRequest = RemoveUserRequest::where('id', $id)->first();
            $removeRequest->status = $request['value'];
            $removeRequest->save();

            if ($request['value'] == 'accepted') {
                $userBoard = UserBoards::where('board_id', $removeRequest->board_id)->where('user_id', $removeRequest->user_id)->where('user_board_roles', 'newbie')->delete();
            } else {
                $gift = GiftLogs::where('board_id', $removeRequest->board_id)->where('sent_by', $removeRequest->user_id)->first();
                $gift->status = 'pending';
                $gift->save();
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return $exception->getMessage();
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
        //
    }
}
