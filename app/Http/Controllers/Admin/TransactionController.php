<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Client;
use App\Models\Usage;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $data = [
            'clients' => Client::get()
        ];

        return view('transaction.index', $data);
    }

    public function show(Client $client)
    {
        $data = [
            'client' => $client,
            'usages' => Usage::where('client_id', $client->id)->with(['client', 'bill'])->orderBy('id', 'desc')->get()
        ];

        return view('transaction.show', $data);
    }

    public function pay(Client $client)
    {
        $usages = Usage::where('client_id', $client->id)->get()->pluck('id');
        $bills = Bill::whereIn('usage_id', $usages)->where('status', '!=', 'paid')->orderBy('id', 'desc')->get();

        $data = [
            'client' => $client,
            'bills' => $bills,
            'sumTotal' => 0
        ];

        return view('transaction.pay', $data);
    }

    public function payProcess(Client $client)
    {
        $usages = Usage::where('client_id', $client->id)->get()->pluck('id');
        $bills = Bill::whereIn('usage_id', $usages)->where('status', '!=', 'paid')->orderBy('id', 'desc')->get();

        $paid = Bill::WhereIn('id', $bills->pluck('id'))->update(['status' => 'paid']);

        $data = [
            'client' => $client,
            'bills' => $bills,
            'sumTotal' => 0,
            'month' => Carbon::now()->isoFormat('MMMM'),
            'year' => Carbon::now()->isoFormat('Y'),
        ];

        return view('transaction.print', $data);
    }
}
