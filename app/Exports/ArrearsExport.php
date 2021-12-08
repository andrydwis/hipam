<?php

namespace App\Exports;


use App\Models\Bill;
use Carbon\Carbon;
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
        $bills = Bill::where('fine', '!=', null)->where('status', 'late')->whereMonth('created_at', $this->month)->whereYear('created_at', $this->year)->orderBy('created_at', 'desc')->with('usage.client')->get();
        $total = Bill::where('fine', '!=', null)->where('status', 'late')->whereMonth('created_at', $this->month)->whereYear('created_at', $this->year)->orderBy('created_at', 'desc')->sum('total');

        $data = [
            'bills' => $bills,
            'total' => $total,
            'date' => Carbon::createFromFormat('m Y', $this->month . ' ' . $this->year)->isoFormat('MMMM YYYY'),
            'now' => Carbon::now()->isoFormat('dddd, DD MMMM YYYY, h:mm:ss A'),
        ];

        return view('report.export.arrears', $data);
    }
}
