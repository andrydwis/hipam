<?php

namespace App\Exports;

use App\Models\Usage;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BillsExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        return view('bill.export', [
            'usages' => Usage::with(['client', 'bill'])->get()
        ]);
    }
}
