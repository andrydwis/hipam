@extends('layouts.app')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Statistik Pelanggan</h1>
            <p class="mb-0">Menampilkan pemakaian pengguna pada bulan dan tahun tersebut</p>
        </div>
    </div>
</div>
@include('layouts.alert')
<div class="card">
    <div class="card-header d-flex justify-content-end">

    </div>
    <div class="card-body">
        <form action="" method="get" class="d-flex flex-row">
            <input type="text" class="form-control me-1" name="keyword" placeholder="Masukkan nomor atau nama pelanggan">
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
        <div class="table-responsive py-4">
            <table class="table table-hover" id="datatable">
                <thead class="thead-light">
                    <tr>
                        <th>Nomor Pelanggan</th>
                        <th>Nama</th>
                        <th>RT</th>
                        <th>RW</th>
                        <th>Pemakaian Terakhir</th>
                        <th>Tagihan Terakhir</th>
                        <th>Menu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $client)
                    <tr>
                        <td>
                            {{$client->client_id}}
                        </td>
                        <td>
                            {{$client->name}}
                        </td>
                        <td>
                            {{$client->rt}}
                        </td>
                        <td>
                            {{$client->rw}}
                        </td>
                        <td>
                            @if($client->usages->last())
                            {{$client->usages->last()->bill->meter_cubic}} m <sup>3</sup>
                            @else
                            {{'-'}}
                            @endif
                        </td>
                        <td>
                            @if($client->usages->last())
                            Rp. {{number_format(($client->usages->last()->bill->total),2,',','.')}}
                            @else
                            {{'-'}}
                            @endif
                        </td>
                        <td>
                            <a href="{{route('user-statistic.show', $client->id)}}" class="btn btn-primary">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{$clients->onEachSide(1)->links('vendor.pagination.bootstrap-4')}}
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
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.22/i18n/Indonesian.json"
            },
            "searching": false,
            "paging": false,
            "lengthChange": false,
        });
    });
</script>
@endsection