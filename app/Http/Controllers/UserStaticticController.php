<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Client;
use App\Models\Usage;
use Illuminate\Http\Request;

class UserStaticticController extends Controller
{
    //
    public function index()
    {
        return view('user-statistic.index');
    }

    public function search(Request $request)
    {
        $request->validate([
            'nomor_pelanggan' => ['required'],
            'nama' => ['required'],
        ]);

        $client = Client::where('client_id', $request->nomor_pelanggan)->Where('name', $request->nama)->first();

        if($client){
            return redirect()->route('user-statistic.show', $client);
        }else{
            session()->flash('error', 'Data Pelanggan Tidak Ditemukan');
            return redirect()->back();
        }
    }

    public function show(Client $client)
    {
        $usages = Usage::where('client_id', $client->id)->with('bill')->orderBy('id', 'desc')->get();
        $bills = Bill::whereIn('usage_id', $usages->pluck('id'))->where('status', '!=', 'paid')->with('usage')->orderBy('id', 'desc')->get();

        $data = [
            'client' => $client,
            'usages' => $usages,
            'bills' => $bills,
            'sumTotal' => 0
        ];

        return view('user-statistic.show', $data);
    }
}
