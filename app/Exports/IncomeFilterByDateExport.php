<?php

namespace App\Exports;

use App\Models\Bill;
use Carbon\Carbon;
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
            'date' => Carbon::parse($this->startDate)->isoFormat('DD MMMM YYYY') . ' sampai ' . Carbon::parse($this->endDate)->isoFormat('DD MMMM YYYY'),
            'now' => Carbon::now()->isoFormat('dddd, DD MMMM YYYY, h:mm:ss A'),
        ];

        return view('report.export.income', $data);
    }
}
