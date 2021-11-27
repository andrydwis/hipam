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
        $type = $request->type ?? 'date';
        
        if ($type == 'date') {
            if ($request->start_date) {
                $startDate = Carbon::createFromFormat('Y-m-d', $request->start_date);
            } else {
                $startDate = Carbon::now()->subMonth()->startOfMonth();
            }
            if ($request->end_date) {
                $endDate = Carbon::createFromFormat('Y-m-d', $request->end_date);
            } else {
                $endDate = Carbon::now();
            }
            $bills = Bill::where('status', 'paid')->whereDate('paid_at', '>=', $startDate)->whereDate('paid_at', '<=', $endDate)->orderBy('paid_at', 'desc')->with('usage.client')->paginate($request->page_size ?? 10)->withQueryString();
            $total = Bill::where('status', 'paid')->whereDate('paid_at', '>=', $startDate)->whereDate('paid_at', '<=', $endDate)->orderBy('paid_at', 'desc')->sum('total');

            $data = [
                'request' => $request,
                'type' => $type,
                'bills' => $bills,
                'total' => $total,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ];
        } elseif ($type == 'month') {
            if ($request->month) {
                $month = $request->month;
            } else {
                $month = Carbon::now()->format('m');
            }
            if ($request->year) {
                $year = $request->year;
            } else {
                $year = Carbon::now()->format('Y');
            }
            $months = collect(range(1, 12))->map(function ($month) use ($year) {
                return [
                    'name' => Carbon::createFromDate($year, $month)->isoFormat('MMMM'),
                    'month' => $month,
                    'year' => $year,
                ];
            });
            $years = Bill::selectRaw('EXTRACT(YEAR FROM TIMESTAMP paid_at) as year')
                ->where('status', 'paid')
                ->groupBy('year')
                ->orderBy('year', 'desc')
                ->pluck('year');
            $bills = Bill::where('status', 'paid')->whereMonth('paid_at', $month)->whereYear('paid_at', $year)->orderBy('paid_at', 'desc')->with('usage.client')->paginate($request->page_size ?? 10)->withQueryString();
            $total = Bill::where('status', 'paid')->whereMonth('paid_at', $month)->whereYear('paid_at', $year)->orderBy('paid_at', 'desc')->sum('total');

            $data = [
                'request' => $request,
                'type' => $type,
                'bills' => $bills,
                'total' => $total,
                'month' => $month,
                'months' => $months,
                'year' => $year,
                'years' => $years,
            ];
        }

        return view('report.income', $data);
    }

    public function incomeExport(Request $request)
    {
        if ($request->start_date) {
            $startDate = Carbon::createFromFormat('Y-m-d', $request->start_date);
        } else {
            $startDate = Carbon::now()->subMonth()->startOfMonth();
        }
        if ($request->end_date) {
            $endDate = Carbon::createFromFormat('Y-m-d', $request->end_date);
        } else {
            $endDate = Carbon::now();
        }
    }
}
