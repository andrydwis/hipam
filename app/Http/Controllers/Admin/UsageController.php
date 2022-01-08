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
        if ($month == 'Januari') {
            $last = Usage::where('month', 'Desember')->where('year', $year - 1)->where('client_id', $client->id)->first();
        } elseif ($month == 'Februari') {
            $last = Usage::where('month', 'Januari')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'Maret') {
            $last = Usage::where('month', 'Februari')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'April') {
            $last = Usage::where('month', 'Maret')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'Mei') {
            $last = Usage::where('month', 'April')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'Juni') {
            $last = Usage::where('month', 'Mei')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'Juli') {
            $last = Usage::where('month', 'Juni')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'Agustus') {
            $last = Usage::where('month', 'Juli')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'September') {
            $last = Usage::where('month', 'Agustus')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'Oktober') {
            $last = Usage::where('month', 'September')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'November') {
            $last = Usage::where('month', 'Oktober')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'Desember') {
            $last = Usage::where('month', 'November')->where('year', $year)->where('client_id', $client->id)->first();
        }

        $data = [
            'client' => $client,
            'month' => $month,
            'year' => $year,
            'last' => $last
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

        if ($month == 'Januari') {
            $last = Usage::where('month', 'Desember')->where('year', $year - 1)->where('client_id', $client->id)->first();
        } elseif ($month == 'Februari') {
            $last = Usage::where('month', 'Januari')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'Maret') {
            $last = Usage::where('month', 'Februari')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'April') {
            $last = Usage::where('month', 'Maret')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'Mei') {
            $last = Usage::where('month', 'April')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'Juni') {
            $last = Usage::where('month', 'Mei')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'Juli') {
            $last = Usage::where('month', 'Juni')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'Agustus') {
            $last = Usage::where('month', 'Juli')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'September') {
            $last = Usage::where('month', 'Agustus')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'Oktober') {
            $last = Usage::where('month', 'September')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'November') {
            $last = Usage::where('month', 'Oktober')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'Desember') {
            $last = Usage::where('month', 'November')->where('year', $year)->where('client_id', $client->id)->first();
        }

        if ($last) {
            if ($request->meter_kubik - $last->meter_cubic < 0) {
                return redirect()->back()->with('error', 'Inputan meteran air harus lebih banyak. Jika muncul peringatan ini berarti inputan Anda salah memasukkan
                atau meteran pada pelanggan rusak. Silahkan cek kembali.');
            }
        }

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
        if ($month == 'Januari') {
            $last = Usage::where('month', 'Desember')->where('year', $year - 1)->where('client_id', $client->id)->first();
        } elseif ($month == 'Februari') {
            $last = Usage::where('month', 'Januari')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'Maret') {
            $last = Usage::where('month', 'Februari')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'April') {
            $last = Usage::where('month', 'Maret')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'Mei') {
            $last = Usage::where('month', 'April')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'Juni') {
            $last = Usage::where('month', 'Mei')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'Juli') {
            $last = Usage::where('month', 'Juni')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'Agustus') {
            $last = Usage::where('month', 'Juli')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'September') {
            $last = Usage::where('month', 'Agustus')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'Oktober') {
            $last = Usage::where('month', 'September')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'November') {
            $last = Usage::where('month', 'Oktober')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'Desember') {
            $last = Usage::where('month', 'November')->where('year', $year)->where('client_id', $client->id)->first();
        }

        $data = [
            'client' => $client,
            'usage' => Usage::where('client_id', $client->id)->where('month', $month)->where('year', $year)->first(),
            'month' => $month,
            'year' => $year,
            'last' => $last
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

        if ($month == 'Januari') {
            $last = Usage::where('month', 'Desember')->where('year', $year - 1)->where('client_id', $client->id)->first();
        } elseif ($month == 'Februari') {
            $last = Usage::where('month', 'Januari')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'Maret') {
            $last = Usage::where('month', 'Februari')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'April') {
            $last = Usage::where('month', 'Maret')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'Mei') {
            $last = Usage::where('month', 'April')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'Juni') {
            $last = Usage::where('month', 'Mei')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'Juli') {
            $last = Usage::where('month', 'Juni')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'Agustus') {
            $last = Usage::where('month', 'Juli')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'September') {
            $last = Usage::where('month', 'Agustus')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'Oktober') {
            $last = Usage::where('month', 'September')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'November') {
            $last = Usage::where('month', 'Oktober')->where('year', $year)->where('client_id', $client->id)->first();
        } elseif ($month == 'Desember') {
            $last = Usage::where('month', 'November')->where('year', $year)->where('client_id', $client->id)->first();
        }

        if ($last) {
            if ($request->meter_kubik - $last->meter_cubic < 0) {
                return redirect()->back()->with('error', 'Inputan meteran air harus lebih banyak. Jika muncul peringatan ini berarti inputan Anda salah memasukkan
                atau meteran pada pelanggan rusak. Silahkan cek kembali.');
            }
        }

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

    public function reset(Usage $usage)
    {
        $usage->meter_cubic = 0;
        $usage->change_meter = true;
        $usage->save();

        session()->flash('success', 'Berhasil mereset pemakaian pelanggan');

        return back();
    }

    public function showAll(Request $request)
    {
        $months = collect(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']);
        $years = Usage::select('year')->groupBy('year')->pluck('year');
        $monthNow = Carbon::now()->isoFormat('MMMM');
        $yearNow = Carbon::now()->isoFormat('Y');

        if ($request->month && $request->year) {
            $usages = Usage::where('month', $request->month)->where('year', $request->year);
        } else {
            $usages = Usage::where('month', $monthNow)->where('year', $yearNow);
        }

        if ($request->keyword) {
            $usages = $usages->whereHas('client', function ($query) use ($request) {
                return $query->where('client_id', 'like', '%' . $request->keyword . '%')->orWhere('name', 'like', '%' . $request->keyword . '%');
            })->orderBy('created_at', 'desc')->paginate($request->page_size ?? 10)->withQueryString();
        } else {
            $usages = $usages->with('client')->orderBy('created_at', 'desc')->paginate($request->page_size ?? 10)->withQueryString();
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
