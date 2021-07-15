@extends('layouts.app')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('bill.index')}}">Tagihan</a></li>
            <li class="breadcrumb-item active">Semua Data</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Tagihan</h1>
            <p class="mb-0">Menampilkan semua tagihan pengguna</p>
        </div>
    </div>
</div>
@include('layouts.alert')
<div class="card">
    <div class="card-body">
        <div class="table-responsive py-4">
            <table class="table table-hover" id="datatable">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Nomor Pelanggan</th>
                        <th>Nama</th>
                        <th>Meter Kubik</th>
                        <th>Tarif</th>
                        <th>Abonemen</th>
                        <th>Denda</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Bulan</th>
                        <th>Tahun</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bills as $bill)
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td>{{$bill->usage->client->client_id}}</td>
                        <td>{{$bill->usage->client->name}}</td>
                        <td>{{$bill->usage->meter_cubic}}</td>
                        <td>{{$bill->cost ?? '-'}}</td>
                        <td>{{$bill->subscription ?? '-'}}</td>
                        <td>{{$bill->fine ?? '-'}}</td>
                        <td>{{$bill->total ?? '-'}}</td>
                        <td>
                            @if($bill->usage->bill)
                            @if($bill->usage->bill->status == 'unpaid')
                            <span class="badge bg-primary">belum membayar</span>
                            @elseif($usage->bill->status == 'late')
                            <span class="badge bg-danger">telat membayar</span>
                            @elseif($usage->bill->status == 'paid')
                            <span class="badge bg-success">sudah membayar</span>
                            @endif
                            @endif
                        </td>
                        <td>{{$bill->usage->month}}</td>
                        <td>{{$bill->usage->year}}</td>
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