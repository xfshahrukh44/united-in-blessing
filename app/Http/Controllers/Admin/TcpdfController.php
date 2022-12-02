<?php

namespace App\Http\Controllers\Admin;

use TCPDF;

Class TcpdfController extends TCPDF{
    //Page header
    public function Header() {
        // Logo
        $image_file = asset('assets/images/logo.png');
        $this->Image($image_file, 10, 2, 13, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // Set font
        $this->SetFont('helvetica', 'B', 20);

        // Title
        $this->Cell(0, 27, 'Report - United In Blessings', 0, false, 'C', 0, '', 0, false, 'M', 'B');

        // Add Line
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
        $this->Line(10, 23, 200, 23, $style);
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-10);

        // Set font
        $this->SetFont('helvetica', 'I', 10);

        // Add Line
        $this->writeHTML("<hr>", false, false, false, false, '');

        // Page number
        $this->Cell(0, 5, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, true, 'C', 0, '', 0, false, 'T', 'B');
    }

    // Load table data from file
    public function LoadData($gifts) {
        $data = array();
        foreach($gifts as $gift) {
//            dd($gift);
//            $data[] = explode(';', chop($gift));
            $data[] = $gift;
        }
        return $data;
    }

    // Load Range Data
    public function rangeData($gifts){
        $data = array();
        foreach($gifts as $gift) {
//            dd($gift);
//            $data[] = explode(';', chop($gift));
            $data[] = $gift;
        }
        return $data;
    }

    // Colored table
    public function ColoredTable($header,$data) {
        // Colors, line width and bold font
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');

        // Header
        $w = array(15, 38, 38, 36, 25, 38); // Total 190
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();

        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');

        // Data
        $fill = 0;
        foreach($data as $key => $row) {
            $this->Cell($w[0], 6, $key+1, 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row->sender->username, 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, $row->receiver->username, 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, $row->board->board_number, 'LR', 0, 'R', $fill);
            $this->Cell($w[4], 6, '$ ' . $row->amount, 'LR', 0, 'R', $fill);
            $this->Cell($w[5], 6, $row->updated_at->format('F d, Y'), 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
        $this->Ln();
    }

    public function ColoredRangeTable($header,$data) {
        // Colors, line width and bold font
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');

        // Header
        $w = array(15, 55, 60, 60); // Total 190
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();

        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');

        // Data
        $fill = 0;
        foreach($data as $key => $row) {
            $this->Cell($w[0], 6, $key+1, 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row->username, 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, '$ ' . $row->sentByGifts->sum('amount'), 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, '$ ' . $row->sentToGifts->sum('amount'), 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
        $this->Ln();
    }
}
