<?php

namespace App\Exports;

use App\Models\Usage;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BillsExport implements FromView, ShouldAutoSize
{
    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function view(): View
    {
        $month = $this->month;
        $year = $this->year;

        return view('bill.export', [
            'usages' => Usage::with(['client', 'bill'])->where('month', $month)->where('year', $year)->get()->sortBy(function ($query) {
                return $query->client->client_id;
            })
        ]);
    }
}
