<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Boards;
use App\Models\GiftLogs;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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
        $gift = $this->getRequestedData($request);

        $data['users'] = User::all();
        $data['boards'] = Boards::all();
        $data['gifts'] = $gift;
        $data['total'] = $gift->sum('amount');

        return view('admin.reports.generate', $data);
    }

    public function generatePDF(Request $request)
    {
        $gift = $this->getRequestedData($request);

        try {
            $pdf = new TcpdfController(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            // set document information
            $pdf->SetTitle('Report - United In Blessing');

            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // Add a page
            // This method has several options, check the source code documentation for more information.
            $pdf->AddPage();

            // column titles
            $header = array('No', 'Sent By', 'Received By', 'Board Number', 'Value', 'Date');

            // data loading
            $data = $pdf->LoadData($gift);

            // print colored table
            $pdf->ColoredTable($header, $data);

            $totalAmount = $gift->sum('amount');
            $pdf->cell('180', '10', 'Total: $' . number_format($totalAmount, '2', '.', ','), 0, true, 'R', false, '', 0, false, "T", 'C');

            // ---------------------------------------------------------

            // Close and output PDF document
            // This method has several options, check the source code documentation for more information.
            $pdf->Output(public_path('upload/reports/') . 'uib-report-' . time() . '.pdf', 'F');

            return array('class' => 'success', 'message' => 'Report Created Successfully');
        } catch (\Exception $exception) {
            return array('class' => 'error', 'message' => $exception->getMessage());
        }
    }

    private function getRequestedData($request)
    {
        $gift = $this->gift;
        $gift->where('accepted');

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

        return $gift->with(['sender', 'receiver', 'board'])->get();
    }

    public function allReports(){
        $files = File::allFiles(public_path('upload/reports'));
        $reports = array();

        foreach ($files as $file){
            $reports[] = array('filename' => $file->getRelativePathname());
        }

        return view('admin.reports.all-reports', compact('reports'));
    }
}
