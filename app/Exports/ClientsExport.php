<?php

namespace App\Exports;

use App\Models\Client;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ClientsExport implements FromView, ShouldAutoSize
{
    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }
    
    public function view(): View
    {
        return view('client.export', [
            'clients' => Client::orderBy('name', 'asc')->get()
        ]);
    }
}
