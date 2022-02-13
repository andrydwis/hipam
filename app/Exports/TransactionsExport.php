<?php

namespace App\Exports;

use App\Models\Usage;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TransactionsExport implements FromView, ShouldAutoSize
{
    public function __construct($id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        return view('transaction.export', [
            'usages' => Usage::where('client_id', $this->id)->with(['client', 'bill'])->orderBy('id', 'desc')->get()
        ]);
    }
}
