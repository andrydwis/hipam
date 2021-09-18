<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        return view('dashboard.admin');
    }

    public function client()
    {
        return view('dashboard.client');
    }
}
