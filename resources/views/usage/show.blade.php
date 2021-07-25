@extends('layouts.app')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('usage.index')}}">Pemakaian</a></li>
            <li class="breadcrumb-item active">{{$month}} {{$year}}</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Pemakaian {{$month}} {{$year}}</h1>
            <p class="mb-0">Menampilkan pemakaian pengguna pada bulan dan tahun tersebut</p>
        </div>
    </div>
</div>
@include('layouts.alert')
<div class="card">
    <div class="card-header d-flex justify-content-end">
        <div>
            <a href="{{route('usage.import', [$month, $year])}}" class="btn btn-outline-primary">Import Pemakaian</a>
            <a href="{{route('usage.export', [$month, $year])}}" class="btn btn-outline-primary">Export Pemakaian</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive py-4">
            <table class="table table-hover" id="datatable">
                <thead class="thead-light">
                    <tr>
                        <th>Nomor Pelanggan</th>
                        <th>Nama</th>
                        <th>Meter Kubik</th>
                        <th>Menu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $client)
                    <tr>
                        <td>{{$client->client_id}}</td>
                        <td>{{$client->name}}</td>
                        <td>{{$client->usages->first()->meter_cubic ?? 'belum diisi'}}</td>
                        <td>
                            @if($client->usages->first())
                            <a href="{{route('usage.edit', [$client, $month, $year])}}" class="btn btn-outline-primary">Edit</a>
                            @else
                            <a href="{{route('usage.create', [$client, $month, $year])}}" class="btn btn-primary">Tambah</a>
                            @endif
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