<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ActivityExport;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $months = collect(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']);
        $years = Activity::select('year')->groupBy('year')->pluck('year');
        $monthNow = Carbon::now()->isoFormat('MMMM');
        $yearNow = Carbon::now()->isoFormat('Y');

        if ($request->month && $request->year) {
            $activities = Activity::with('technician')->where('technician_id', Auth::user()->id)->where('month', $request->month)->where('year', $request->year)->orderBy('created_at', 'desc')->paginate($request->page_size ?? 10)->withQueryString();
        } else {
            $activities = Activity::with('technician')->where('technician_id', Auth::user()->id)->where('month', $monthNow)->where('year', $yearNow)->orderBy('created_at', 'desc')->paginate($request->page_size ?? 10)->withQueryString();
        }

        $data = [
            'months' => $months,
            'years' => $years,
            'monthNow' => $monthNow,
            'yearNow' => $yearNow,
            'activities' => $activities,
        ];

        return view('my-activity.index', $data);
    }

    public function list(Request $request)
    {
        $months = collect(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']);
        $years = Activity::select('year')->groupBy('year')->pluck('year');
        $monthNow = Carbon::now()->isoFormat('MMMM');
        $yearNow = Carbon::now()->isoFormat('Y');

        if ($request->month && $request->year) {
            $activities = Activity::with('technician')->where('month', $request->month)->where('year', $request->year)->orderBy('created_at', 'desc')->paginate($request->page_size ?? 10)->withQueryString();
        } else {
            $activities = Activity::with('technician')->where('month', $monthNow)->where('year', $yearNow)->orderBy('created_at', 'desc')->paginate($request->page_size ?? 10)->withQueryString();
        }

        $data = [
            'request' => $request,
            'months' => $months,
            'years' => $years,
            'monthNow' => $monthNow,
            'yearNow' => $yearNow,
            'activities' => $activities,
        ];

        return view('activity.index', $data);
    }

    public function showAdmin(Activity $activity)
    {
        $data = [
            'activity' => $activity
        ];

        return view('activity.show', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $data = [
            'now' => Carbon::now(),
            'request' => $request
        ];

        return view('my-activity.create', $data);
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
        if ($request->jenis_kegiatan && $request->jenis_kegiatan != 'Pasang baru' && $request->jenis_kegiatan != 'Perbaikan saluran pengguna') {
            $request->validate([
                'tanggal_kegiatan' => ['required', 'date'],
                'jenis_kegiatan' => ['required'],
                'jenis_pekerjaan' => ['required']
            ]);
        } elseif ($request->jenis_kegiatan && ($request->jenis_kegiatan == 'Pasang baru' || $request->jenis_kegiatan == 'Perbaikan saluran pengguna')) {
            $request->validate([
                'tanggal_kegiatan' => ['required', 'date'],
                'jenis_kegiatan' => ['required'],
                'jenis_pekerjaan' => ['required'],
                'no_surat_tugas' => ['required', 'integer'],
                'nama_pelanggan' => ['required'],
                'rt_rw' => ['required']
            ]);
        }

        //upload foto
        $photo = null;
        if ($request->foto) {
            foreach ($request->foto as $foto) {
                $paths[] = $foto->store('public/activity');
            }
            $photo = json_encode($paths);
        }

        $activity = new Activity();
        $activity->activity_type = $request->jenis_kegiatan;
        $activity->job_type = $request->jenis_pekerjaan;
        $activity->assignment_letter_number = $request->no_surat_tugas;
        $activity->name = $request->nama_pelanggan;
        $activity->rt_rw = $request->rt_rw;
        $activity->photo = $photo;
        $activity->description = $request->catatan;
        $activity->month = Carbon::now()->isoFormat('MMMM');
        $activity->year = Carbon::now()->isoFormat('YYYY');
        $activity->technician_id = Auth::user()->id;
        $activity->save();

        session()->flash('success', 'Berhasil menambahkan kegiatan teknisi');

        return redirect()->route('my-activity.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        //
        $data = [
            'activity' => $activity
        ];

        return view('my-activity.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity, Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        //
        if ($activity->photo) {
            $photos = json_decode($activity->photo);
            foreach ($photos as $photo) {
                $path = storage_path('app/' . $photo);
                if (file_exists($path)) {
                    unlink($path);
                }
            }
        }

        $activity->delete();

        session()->flash('success', 'Berhasil menghapus kegiatan teknisi');

        return redirect()->route('activity.list');
    }

    public function export(Request $request)
    {
        return Excel::download(new ActivityExport($request->all()), 'laporan kegiatan teknisi.xlsx');
    }
}
