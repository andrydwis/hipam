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
        $role = Auth::user()->getRoleNames()->first();
        if ($role == 'superadmin') {
            return $this->admin();
        } elseif ($role == 'admin') {
            return $this->admin();
        }
    }

    public function admin()
    {
        $data = [
            'users' => User::get()->count(),
            'logs' => Activity::get()->count()
        ];

        return view('dashboard.admin', $data);
    }

    public function client()
    {
        return view('dashboard.client');
    }
}
