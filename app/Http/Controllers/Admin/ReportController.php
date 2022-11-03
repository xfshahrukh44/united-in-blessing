<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Boards;
use App\Models\GiftLogs;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PDF;

class ReportController extends Controller
{
    protected $gift;

    public function __construct()
    {
        $this->gift = new GiftLogs();
    }

    public function index(Request $request)
    {
        if ($request->post()) {
            $gift = $this->getRequestedData($request);

        }

        $data['users'] = User::all();
        $data['boards'] = Boards::all();
        $data['gifts'] = $gift->get();
        $data['total'] = $gift->sum('amount');

        return view('admin.reports.generate', $data);
    }

    public function generatePDF(Request $request)
    {
        $gift = $this->getRequestedData($request);

        try {
            PDF::SetTitle('Hello World');
            PDF::AddPage();
            PDF::Write(0, 'Hello World');
//            PDF::Output('hello_world.pdf');
            PDF::Output(public_path('upload\reports\hello_world.pdf'));

            return 'PDF Created Successfully';
        } catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    private function getRequestedData($request)
    {
        $gift = $this->gift;

        if (!empty($request->sent_by)) {
            $gift = $gift->where('sent_by', $request->sent_by);
        }

        if (!empty($request->received_by)) {
            $gift = $gift->where('sent_to', $request->received_by);
        }

        if (!empty($request->board_id)) {
            $gift = $gift->where('board_id', $request->board_id);
        }

        if (!empty($request->amount)) {
            $gift = $gift->where('amount', $request->amount);
        }

        if (!empty($request->date_range)) {
            $dateRange = explode('-', $request->date_range);
            $startDate = date('Y-m-d', strtotime(trim($dateRange[0])));
            $endDate = date('Y-m-d', strtotime(trim($dateRange[1])));

            $gift = $gift->whereBetween('updated_at', [$startDate, $endDate]);
        }

        return $gift;
    }
}
