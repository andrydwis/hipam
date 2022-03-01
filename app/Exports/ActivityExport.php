<?php

namespace App\Exports;

use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ActivityExport implements FromView, ShouldAutoSize
{
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $monthNow = Carbon::now()->isoFormat('MMMM');
        $yearNow = Carbon::now()->isoFormat('Y');

        if ($this->request['month'] && $this->request['year']) {
            $activities = Activity::with('technician')->where('month', $this->request['month'])->where('year', $this->request['year'])->orderBy('created_at', 'desc')->get();
        } else {
            $activities = Activity::with('technician')->where('month', $monthNow)->where('year', $yearNow)->orderBy('created_at', 'desc')->get();
        }

        $data = [
            'activities' => $activities,
        ];

        return view('activity.export', $data);
    }
}
