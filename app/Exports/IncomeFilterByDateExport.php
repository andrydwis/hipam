<?php

namespace App\Exports;

use App\Models\Bill;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class IncomeFilterByDateExport implements FromView, ShouldAutoSize
{
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        $bills = Bill::where('status', 'paid')->whereDate('paid_at', '>=', $this->startDate)->whereDate('paid_at', '<=', $this->endDate)->orderBy('paid_at', 'desc')->with('usage.client')->get();
        $total = Bill::where('status', 'paid')->whereDate('paid_at', '>=', $this->startDate)->whereDate('paid_at', '<=', $this->endDate)->orderBy('paid_at', 'desc')->sum('total');

        $data = [
            'bills' => $bills,
            'total' => $total,
        ];

        return view('report.export.income', $data);
    }
}
