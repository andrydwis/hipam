<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ArrearsExport;
use App\Exports\IncomeFilterByDateExport;
use App\Exports\IncomeFilterByMonthExport;
use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Client;
use App\Models\Usage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
            $years = Bill::selectRaw('EXTRACT(YEAR FROM created_at) AS year')
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

    public function arrears(Request $request)
    {
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
        $years = Bill::selectRaw('EXTRACT(YEAR FROM created_at) AS year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');
        $bills = Bill::where('fine', '!=', null)->whereMonth('created_at', $month)->whereYear('created_at', $year)->orderBy('created_at', 'desc')->with('usage.client')->paginate($request->page_size ?? 10)->withQueryString();
        $total = Bill::where('fine', '!=', null)->where('status', 'late')->whereMonth('created_at', $month)->whereYear('created_at', $year)->orderBy('created_at', 'desc')->sum('total');

        $data = [
            'request' => $request,
            'bills' => $bills,
            'total' => $total,
            'month' => $month,
            'months' => $months,
            'year' => $year,
            'years' => $years,
        ];

        return view('report.arrears', $data);
    }

    public function disconnection(Request $request)
    {
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
        $years = Bill::selectRaw('EXTRACT(YEAR FROM created_at) AS year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');
        $bills = Bill::where('fine', '!=', null)->where('status', 'late')->whereMonth('created_at', $month)->whereYear('created_at', $year)->orderBy('created_at', 'desc')->with('usage.client')->paginate($request->page_size ?? 10)->withQueryString();
        $total = Bill::where('fine', '!=', null)->where('status', 'late')->whereMonth('created_at', $month)->whereYear('created_at', $year)->orderBy('created_at', 'desc')->sum('total');

        $data = [
            'request' => $request,
            'bills' => $bills,
            'total' => $total,
            'month' => $month,
            'months' => $months,
            'year' => $year,
            'years' => $years,
        ];

        return view('report.disconnection', $data);
    }

    public function printWarning(Request $request, Client $client)
    {
        $usages = Usage::where('client_id', $client->id)->get()->pluck('id');
        $bills = Bill::whereIn('usage_id', $usages)->where('status', '!=', 'paid')->orderBy('id', 'desc')->get();

        $data = [
            'client' => $client,
            'bills' => $bills,
        ];

        return view('report.print.warning', $data);
    }

    public function incomeExport(Request $request)
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

            return Excel::download(new IncomeFilterByDateExport($startDate, $endDate), 'laporan-pendapatan-' . $startDate->format('Y-m-d') . '_' . $endDate->format('Y-m-d') . '.xlsx');
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

            return Excel::download(new IncomeFilterByMonthExport($month, $year), 'laporan-pendapatan-' . $month . '-' . $year . '.xlsx');
        }
    }

    public function arrearsExport(Request $request)
    {
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

        return Excel::download(new ArrearsExport($month, $year), 'laporan-tunggakan-' . $month . '-' . $year . '.xlsx');
    }
}
