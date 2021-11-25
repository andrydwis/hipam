<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsagesExport;
use App\Http\Controllers\Controller;
use App\Imports\UsagesImport;
use App\Models\Client;
use App\Models\Usage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class UsageController extends Controller
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

        return view('usage.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Client $client, $month, $year)
    {
        //
        $data = [
            'client' => $client,
            'month' => $month,
            'year' => $year
        ];

        return view('usage.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Client $client, $month, $year)
    {
        //
        $request->validate([
            'meter_kubik' => ['required', 'numeric', 'min:0']
        ]);

        $usage =  new Usage();
        $usage->client_id = $client->id;
        $usage->meter_cubic = $request->meter_kubik;
        $usage->month = $month;
        $usage->year = $year;
        $usage->save();

        activity()
            ->causedBy(Auth::user())
            ->log('Berhasil menambah pemakaian pelanggan');

        session()->flash('success', 'Berhasil menambah pemakaian pelanggan');

        return redirect()->route('usage.show', [$month, $year]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Usage  $usage
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $month, $year)
    {
        //
        if ($request->keyword) {
            $data = [
                'month' => $month,
                'year' => $year,
                'clients' => Client::where('client_id', 'like', '%' . $request->keyword . '%')->orWhere('name', 'like', '%' . $request->keyword . '%')->with(['usages' => function ($query) use ($month, $year) {
                    $query->where('month', $month)->where('year', $year)->orderBy('client_id', 'asc');
                }])->paginate($request->page_size ?? 10)->withQueryString()
            ];
        } else {
            $data = [
                'month' => $month,
                'year' => $year,
                'clients' => Client::with(['usages' => function ($query) use ($month, $year) {
                    $query->where('month', $month)->where('year', $year)->orderBy('client_id', 'asc');
                }])->paginate($request->page_size ?? 10)->withQueryString()
            ];
        }

        return view('usage.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Usage  $usage
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client, $month, $year)
    {
        //
        $data = [
            'client' => $client,
            'usage' => Usage::where('client_id', $client->id)->where('month', $month)->where('year', $year)->first(),
            'month' => $month,
            'year' => $year
        ];

        session()->flash('previousUrl', url()->previous());

        return view('usage.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Usage  $usage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client, $month, $year)
    {
        //
        $request->validate([
            'meter_kubik' => ['required', 'numeric', 'min:0']
        ]);

        $usage = Usage::find($request->usage_id);
        $usage->client_id = $client->id;
        $usage->meter_cubic = $request->meter_kubik;
        $usage->save();

        activity()
            ->causedBy(Auth::user())
            ->log('Berhasil mengedit pemakaian pelanggan');

        session()->flash('success', 'Berhasil mengedit pemakaian pelanggan');

        return redirect(session()->get('previousUrl'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Usage  $usage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usage $usage)
    {
        //
        $usage->delete();

        activity()
            ->causedBy(Auth::user())
            ->log('Berhasil menghapus pemakaian pelanggan');

        session()->flash('success', 'Berhasil menghapus pemakaian pelanggan');

        return back();
    }

    public function showAll(Request $request)
    {
        $months = collect(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']);
        $years = collect(range(Carbon::now()->year - 2, Carbon::now()->year + 2));
        $monthNow = Carbon::now()->isoFormat('MMMM');
        $yearNow = Carbon::now()->isoFormat('Y');

        if ($request->month && $request->year) {
            $usages = Usage::where('month', $request->month)->where('year', $request->year)->orderBy('created_at', 'desc')->with('client')->paginate($request->page_size ?? 10)->withQueryString();
        } else {
            $usages = Usage::where('month', $monthNow)->where('year', $yearNow)->orderBy('created_at', 'desc')->with('client')->paginate($request->page_size ?? 10)->withQueryString();
        }

        $data = [
            'months' => $months,
            'years' => $years,
            'monthNow' => $request->month ?? $monthNow,
            'yearNow' => $request->year ?? $yearNow,
            'usages' => $usages,
        ];

        return view('usage.all', $data);
    }

    public function import($month, $year)
    {
        //
        $data = [
            'month' => $month,
            'year' => $year
        ];

        return view('usage.import', $data);
    }

    public function importProcess(Request $request, $month, $year)
    {
        $request->validate([
            'file' => ['required', 'mimes:xlsx']
        ]);

        try {
            Excel::import(new UsagesImport($month, $year), $request->file('file'));

            activity()
                ->causedBy(Auth::user())
                ->log('Berhasil import pemakaian');

            session()->flash('success', 'Berhasil import pemakaian');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            return redirect()->route('usage.import', [$month, $year])->with('failures', $failures);
        }

        return redirect()->route('usage.import', [$month, $year]);
    }

    public function export($month, $year)
    {
        return Excel::download(new UsagesExport($month, $year), 'pemakaian ' . $month . ' ' . $year . '.xlsx');
    }
}
