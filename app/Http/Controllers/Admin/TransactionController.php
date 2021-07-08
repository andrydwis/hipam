<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Client;
use App\Models\Usage;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    //
    public function show(Client $client)
    {
        $usages = Usage::where('client_id', $client->id)->get()->pluck('id');
        $bills = Bill::whereIn('usage_id', $usages)->where('status', '!=', 'paid')->get();
        $sumTotal = 0;

        echo ('pelanggan : ' . $client->client_id . ' - ' . $client->name . '<br>');

        foreach ($bills as $bill) {
            if ($bill->status == 'late') {
                echo ('bulan yang telat : ' . $bill->usage->month . ' ' . $bill->usage->year . ' = ' . $bill->total . '<br>');
            } elseif ($bill->status == 'unpaid') {
                echo ('bulan : ' . $bill->usage->month . ' ' . $bill->usage->year . ' = ' . $bill->total . '<br>');
            }
            $sumTotal += $bill->total;
        }
        echo ('total yang harus dibayar = ' . $sumTotal);
    }
}
