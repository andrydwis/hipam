@extends('layouts.app')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('usage.index')}}">Pemakaian</a></li>
            <li class="breadcrumb-item active">Semua Data</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Pemakaian</h1>
            <p class="mb-0">Menampilkan semua data pemakaian pengguna</p>
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
        <div class="d-flex gap-3">
            <select class="form-select" id="month" onChange="changeDate()" style="width: 175px;">
                <option disabled>Pilih Bulan</option>
                @foreach($months as $month)
                <option value="{{$month}}" @if($month==$monthNow){{'selected'}}@endif>{{$month}}</option>
                @endforeach
            </select>
            <select class="form-select" id="year" onChange="changeDate()" style="width: 175px;">
                <option disabled>Pilih Tahun</option>
                @foreach($years as $year)
                <option value="{{$year}}" @if($year==$yearNow){{'selected'}}@endif>{{$year}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="card-body">
        <!-- <form action="" method="get" class="d-flex flex-row">
            <input type="text" class="form-control me-1" name="keyword" placeholder="Masukkan nomor atau nama pelanggan">
            <button type="submit" class="btn btn-primary">Cari</button>
        </form> -->
        <div class="table-responsive py-4">
            <table class="table table-hover" id="datatable">
                <thead class="thead-light">
                    <tr>
                        <th>Nomor Pelanggan</th>
                        <th>Nama</th>
                        <th>Meter Kubik</th>
                        <th>Bulan</th>
                        <th>Tahun</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usages as $usage)
                    <tr>
                        <td>{{$usage->client->client_id}}</td>
                        <td>{{$usage->client->name}}</td>
                        <td>{{$usage->meter_cubic}} m<sup>3</sup></td>
                        <td>{{$usage->month}}</td>
                        <td>{{$usage->year}}</td>
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
    changeDate = () => {
        let month = document.getElementById("month").value
        let year = document.getElementById("year").value
        let url = new URL(window.location.href);
        url.searchParams.set('month', month);
        url.searchParams.set('year', year);
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
            }
        });
    });
</script> -->
@endsection