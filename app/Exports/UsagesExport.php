<?php

namespace App\Exports;

use App\Models\Client;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UsagesExport implements FromView, ShouldAutoSize
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

        return view('usage.export', [
            'month' => $month,
            'year' => $year,
            'clients' => Client::with(['usages' => function ($query) use ($month, $year) {
                $query->where('month', $month)->where('year', $year);
            }])->orderBy('client_id', 'asc')->get()
        ]);
    }
}
