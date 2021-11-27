<?php

namespace App\Exports;

use App\Models\Bill;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class IncomeFilterByMonthExport implements FromView, ShouldAutoSize
{
    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function view(): View
    {
        $bills = Bill::where('status', 'paid')->whereMonth('paid_at', $this->month)->whereYear('paid_at', $this->year)->orderBy('paid_at', 'desc')->with('usage.client')->get();
        $total = Bill::where('status', 'paid')->whereMonth('paid_at', $this->month)->whereYear('paid_at', $this->year)->orderBy('paid_at', 'desc')->sum('total');

        $data = [
            'bills' => $bills,
            'total' => $total,
        ];

        return view('report.export.income-filter-by-month', $data);
    }
}
