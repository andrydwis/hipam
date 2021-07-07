<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ClientsExport;
use App\Http\Controllers\Controller;
use App\Imports\ClientsImport;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class ClientController extends Controller
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
            'clients' => Client::orderBy('name', 'asc')->get()
        ];

        return view('client.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('client.create');
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
        $request->validate([
            'nomor_pelanggan' => ['required', Rule::unique('clients', 'client_id')],
            'nama' => ['required'],
            'rt' => ['required'],
            'rw' => ['required']
        ]);

        $client = new Client();
        $client->client_id = $request->nomor_pelanggan;
        $client->name = $request->nama;
        $client->rt = $request->rt;
        $client->rw = $request->rw;
        $client->save();

        activity()
            ->causedBy(Auth::user())
            ->log('Berhasil menambahkan pelanggan');

        session()->flash('success', 'Berhasil menambahkan pelanggan');

        return redirect()->route('client.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
        $data = [
            'client' => $client
        ];

        return view('client.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
        $request->validate([
            'nomor_pelanggan' => ['required', Rule::unique('clients', 'client_id')->ignore($client)],
            'nama' => ['required'],
            'rt' => ['required'],
            'rw' => ['required']
        ]);

        $client->client_id = $request->nomor_pelanggan;
        $client->name = $request->nama;
        $client->rt = $request->rt;
        $client->rw = $request->rw;
        $client->save();

        activity()
            ->causedBy(Auth::user())
            ->log('Berhasil mengedit pelanggan');

        session()->flash('success', 'Berhasil mengedit pelanggan');

        return redirect()->route('client.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
        $client->delete();

        activity()
            ->causedBy(Auth::user())
            ->log('Berhasil menghapus pelanggan');

        session()->flash('success', 'Berhasil menghapus pelanggan');

        return redirect()->route('client.index');
    }

    public function import()
    {
        //
        return view('client.import');
    }

    public function importProcess(Request $request)
    {
        $request->validate([
            'file' => ['required', 'mimes:xlsx']
        ]);

        try {
            Excel::import(new ClientsImport, $request->file('file'));

            activity()
                ->causedBy(Auth::user())
                ->log('Berhasil menghapus pelanggan');

            session()->flash('success', 'Berhasil menghapus pelanggan');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            return redirect()->route('client.import')->with('failures', $failures);
        }

        return redirect()->route('client.index');
    }

    public function export(Request $request)
    {
        activity()
            ->causedBy(Auth::user())
            ->log('Berhasil export data pelanggan');

        session()->flash('success', 'Berhasil export data pelanggan');

        return Excel::download(new ClientsExport, 'daftar pelanggan.xlsx');
    }
}
