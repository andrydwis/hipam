<?php

namespace App\Exports;

use App\Models\Client;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ClientsExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        return view('client.export', [
            'clients' => Client::orderBy('client_id', 'asc')->get()
        ]);
    }
}
