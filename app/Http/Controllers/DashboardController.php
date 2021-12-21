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
        $siakad = new Client();
        $response = $siakad->request('POST', 'https://cms.sevima.com/service/siakadcloud/statuspendaftaran', [
            'headers' => [
                'Secret-App' => 'hhLpcautbqbmSk9NWhsdLNKXqtg4x6jxCpFA72RLatYx8Z3Hkfh789xdZK2JQQyF',
                'Token-Authorization' => 'M7JMSTFMNTJOMrM0S0wyTU1KtUxKMzA1SzVLTjIzTzMCAA==',
                'Accept' => 'application/json'
            ],
        ]);

        dd($response->getBody()->getContents());
    }
}
