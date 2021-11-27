<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //
    public function income(Request $request)
    {
        if ($request->start_date) {
            $startDate = Carbon::createFromFormat('Y-m-d', $request->start_date);
        } else {
            $startDate = Carbon::now()->subDays(30);
        }
        if($request->end_date){
            $endDate = Carbon::createFromFormat('Y-m-d', $request->end_date);
        }else{
            $endDate = Carbon::now();
        }
        $bills = Bill::where('status', 'paid')->whereDate('paid_at', '>=', $startDate)->whereDate('paid_at', '<=', $endDate)->orderBy('paid_at', 'desc')->with('usage.client')->paginate($request->page_size ?? 10)->withQueryString();
        $total = Bill::where('status', 'paid')->whereDate('paid_at', '>=', $startDate)->whereDate('paid_at', '<=', $endDate)->orderBy('paid_at', 'desc')->sum('total');

        $data = [
            'request' => $request,
            'bills' => $bills,
            'total' => $total,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];

        return view('report.income', $data);
    }
}
