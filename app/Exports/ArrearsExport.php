<?php

namespace App\Exports;


use App\Models\Bill;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ArrearsExport implements FromView, ShouldAutoSize
{
    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function view(): View
    {
        $bills = Bill::where('fine', '!=', null)->whereMonth('created_at', $this->month)->whereYear('created_at', $this->year)->orderBy('created_at', 'desc')->with('usage.client')->get();
        $total = Bill::where('fine', '!=', null)->where('status', 'late')->whereMonth('created_at', $this->month)->whereYear('created_at', $this->year)->orderBy('created_at', 'desc')->sum('total');

        $data = [
            'bills' => $bills,
            'total' => $total,
        ];

        return view('report.export.arrears', $data);
    }
}
