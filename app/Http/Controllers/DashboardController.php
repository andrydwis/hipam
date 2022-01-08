<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{
    //
    public function index()
    {
        return $this->admin();
    }

    public function admin()
    {
        $data = [
            'date' => Carbon::now()
        ];

        return view('dashboard.admin', $data);
    }

    public function client()
    {
        return view('dashboard.client');
    }

    public function test()
    {

        dd($response->getBody()->getContents());
    }
}
