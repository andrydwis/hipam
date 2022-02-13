<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TransactionsExport;
use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Client;
use App\Models\Usage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->keyword) {
            $client = Client::where('client_id', $request->keyword)->orWhere('name', $request->keyword)->first();

            if ($client) {
                $usages = Usage::where('client_id', $client->id)->with('bill.admin')->orderBy('created_at', 'desc')->get();
                $bills = Bill::whereIn('usage_id', $usages->pluck('id'))->where('status', '!=', 'paid')->orderBy('id', 'desc')->get();

                // //if no bills then return back
                // if ($bills->isEmpty()) {
                //     return back()->with('error', 'Semua tagihan pelanggan sudah dibayar');
                // }
            } else {
                return redirect()->back()->with('error', 'Data tidak ditemukan');
            }

            $data = [
                'client' => $client,
                'usages' => $usages,
                'bills' => $bills,
                'month' => Carbon::now()->isoFormat('MMMM'),
                'year' => Carbon::now()->isoFormat('Y'),
            ];
        } else {
            $data = [
                'client' => null,
            ];
        }

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

    public function export(Client $client)
    {
        return Excel::download(new  TransactionsExport($client->id), 'detail tagihan ' . $client->name . '.xlsx');
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

        // if no bills then return back
        if ($bills->isEmpty()) {
            return back()->with('error', 'Semua tagihan pelanggan sudah dibayar');
        }

        $paid = Bill::WhereIn('id', $bills->pluck('id'))->update(['admin_id' => Auth::user()->id, 'status' => 'paid', 'paid_at' => Carbon::now()]);

        $data = [
            'client' => $client,
            'bills' => $bills,
            'sumTotal' => 0,
            'day' => Carbon::now()->isoFormat('D'),
            'month' => Carbon::now()->isoFormat('MMMM'),
            'year' => Carbon::now()->isoFormat('Y'),
        ];

        session()->flash('previousUrl', url()->previous());

        return view('transaction.print', $data);
    }
}
