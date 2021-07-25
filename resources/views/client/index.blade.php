@extends('layouts.app')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">Pelanggan</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Daftar Pelanggan</h1>
            <p class="mb-0">Menampilkan daftar semua pelanggan pada sistem</p>
        </div>
    </div>
</div>
@include('layouts.alert')
<div class="card">
    @role('superadmin')
    <div class="card-header d-flex justify-content-between">
        <a href="{{route('client.create')}}" class="btn btn-primary">Tambah Pelanggan</a>
        <div>
            <a href="{{route('client.import')}}" class="btn btn-outline-primary">Import Pelanggan</a>
            <a href="{{route('client.export')}}" class="btn btn-outline-primary">Export Pelanggan</a>
        </div>
    </div>
    @endrole
    <div class="card-body">
        <div class="table-responsive py-4">
            <table class="table table-hover" id="datatable">
                <thead class="thead-light">
                    <tr>
                        <th>No Pelanggan</th>
                        <th>Nama</th>
                        <th>RT</th>
                        <th>RW</th>
                        <th>Menu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $client)
                    <tr>
                        <td>{{$client->client_id}}</td>
                        <td>{{$client->name}}</td>
                        <td>{{$client->rt}}</td>
                        <td>{{$client->rw}}</td>
                        <td class="d-flex gap-1">
                            @role('superadmin')
                            <a href="{{route('client.edit', [$client])}}" class="btn btn-primary">Edit</a>
                            <form action="{{route('client.destroy', [$client])}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-primary">Hapus</button>
                            </form>
                            @endrole
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('customCSS')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />
@endsection

@section('customJS')
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            responsive: true,
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.22/i18n/Indonesian.json"
            }
        });
    });
</script>
@endsection