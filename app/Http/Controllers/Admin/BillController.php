<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BillsExport;
use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Client;
use App\Models\Usage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = [
            'monthNow' => Carbon::now()->isoFormat('MMMM'),
            'yearNow' => Carbon::now()->isoFormat('Y'),
            'months' => collect(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'])
        ];

        return view('bill.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $month, $year)
    {
        if ($request->keyword) {
            $client = Client::where('client_id', 'like', '%' . $request->keyword . '%')->orWhere('name', 'like', '%' . $request->keyword . '%')->pluck('id');
            $data = [
                'month' => $month,
                'year' => $year,
                'usages' => Usage::where('month', $month)->where('year', $year)->whereIn('client_id', $client)->with(['client', 'bill'])->orderBy('client_id', 'asc')->paginate(10)
            ];
        } else {
            $data = [
                'month' => $month,
                'year' => $year,
                'usages' => Usage::where('month', $month)->where('year', $year)->with(['client', 'bill'])->orderBy('client_id', 'asc')->paginate(10)
            ];
        }

        return view('bill.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function edit(Bill $bill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bill $bill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bill $bill)
    {
        //
    }

    public function showAll()
    {
        $data = [
            'bills' => Bill::orderBy('created_at', 'desc')->with('usage.client')->get()
        ];

        return view('bill.all', $data);
    }

    public function acceptLate(Request $request, Bill $bill)
    {
        $bill->fine = config('custom.fine');
        $bill->total = $bill->total + config('custom.fine');
        $bill->status = 'late';
        $bill->save();

        activity()
            ->causedBy(Auth::user())
            ->log('Berhasil update tagihan');

        session()->flash('success', 'Berhasil update tagihan');

        return back();
    }

    public function declineLate(Request $request, Bill $bill)
    {
        $bill->fine = null;
        $bill->total = $bill->total - config('custom.fine');
        $bill->status = 'unpaid';
        $bill->save();

        activity()
            ->causedBy(Auth::user())
            ->log('Berhasil update tagihan');

        session()->flash('success', 'Berhasil update tagihan');

        return back();
    }

    public function export($month, $year)
    {
        return Excel::download(new BillsExport($month, $year), 'tagihan ' . $month . ' ' . $year . '.xlsx');
    }
}
