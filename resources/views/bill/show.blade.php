@extends('layouts.app')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('bill.index')}}">Tagihan</a></li>
            <li class="breadcrumb-item active">{{$month}} {{$year}}</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Tagihan {{$month}} {{$year}}</h1>
            <p class="mb-0">Menampilkan tagihan pengguna pada bulan dan tahun tersebut</p>
        </div>
    </div>
</div>
@include('layouts.alert')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div>
            <select class="form-select" id="page-size" onChange="changePageSize()">
                <option value="10" selected>10</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <a href="{{route('bill.export', [$month, $year])}}" class="btn btn-outline-primary">Export Tagihan</a>
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
                        <th>Pemakaian</th>
                        <th>Tarif</th>
                        <th>Abonemen</th>
                        <th>Denda</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Dibayar Pada</th>
                        <th>Menu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usages as $usage)
                    <tr>
                        <td>{{$usage->client->client_id}}</td>
                        <td>{{$usage->client->name}}</td>
                        <td>{{$usage->bill->meter_cubic ?? '-'}}</td>
                        <td>Rp. {{number_format($usage->bill->cost,2,',','.') ?? '-'}}</td>
                        <td>Rp. {{number_format($usage->bill->subscription,2,',','.') ?? '-'}}</td>
                        <td>Rp. {{number_format($usage->bill->fine,2,',','.') ?? '-'}}</td>
                        <td>Rp. {{number_format($usage->bill->total,2,',','.') ?? '-'}}</td>
                        <td>
                            @if($usage->bill)
                            @if($usage->bill->status == 'unpaid')
                            <span class="badge bg-primary">belum membayar</span>
                            @elseif($usage->bill->status == 'late')
                            <span class="badge bg-danger">telat membayar</span>
                            @elseif($usage->bill->status == 'paid')
                            <span class="badge bg-success">sudah membayar</span>
                            @endif
                            @endif
                        </td>
                        <td>
                            @if($usage->bill->paid_at)
                            {{$usage->bill->paid_at->isoFormat('dddd, DD-MM-YYYY hh:mm A')}}
                            @else
                            {{'-'}}
                            @endif
                        </td>
                        <td>
                            @if($usage->bill)
                            @if($usage->bill->status == 'unpaid')
                            <form action="{{route('bill.accept-late', [$usage->bill])}}" method="post">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-primary">Tandai Telat</button>
                            </form>
                            @elseif($usage->bill->status == 'late')
                            <form action="{{route('bill.decline-late', [$usage->bill])}}" method="post">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-danger">Batal Telat</button>
                            </form>
                            @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{$usages->onEachSide(1)->links('vendor.pagination.bootstrap-4')}}
    </div>
</div>
@endsection

@section('customCSS')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />
@endsection

@section('customJS')
<script>
    changePageSize = () => {
        let pageSize = document.getElementById("page-size").value
        let url = new URL(window.location.href);
        url.searchParams.set('page_size', pageSize);
        window.location.href = url;
    }
    setSelectedPageSize = () => {
        let url = new URL(window.location.href);
        let pageSize = url.searchParams.get('page_size');
        if (pageSize) {
            document.getElementById("page-size").value = pageSize;
        } else {
            document.getElementById("page-size").value = 10;
        }
    }
    window.onload = setSelectedPageSize;
</script>
<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
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
</script> -->
@endsection