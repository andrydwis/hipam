<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Client;
use App\Models\Usage;
use Illuminate\Http\Request;

class UserStaticticController extends Controller
{
    //
    public function index(Request $request)
    {
        $clients = Client::where('name', 'ilike', '%' . $request->keyword . '%')->with('usages.bill')->paginate(10);

        $data = [
            'keyword' => $request->keyword,
            'clients' => $clients,
        ];

        return view('user-statistic.index', $data);
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
