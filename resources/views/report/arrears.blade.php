@extends('layouts.app')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Laporan Tunggakan</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Laporan Tunggakan</h1>
            <p class="mb-0">Menampilkan laporan tunggakan dari pelanggan sesuai bulan dari tahun tersebut</p>
        </div>
    </div>
</div>
@include('layouts.alert')
<div class="card">
    <div class="card-header d-flex flex-column justify-content-between">
        <div class="d-flex justify-content-between">
            <div class="d-flex align-items-center me-auto gap-3">
                <select class="form-select" id="page-size" onchange="changePageSize()">
                    <option value="10" selected>10</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <a href="{{route('report.arrears-export', ['month' => $month, 'year' => $year])}}" class="btn btn-outline-primary">Export Tunggakan</a>
        </div>
        <hr>
        <div class="d-flex align-items-center gap-3">
            <label for="month" class="form-label">Bulan</label>
            <select class="form-select" id="month" name="month" onchange="changeMonth()">
                <option disabled>Pilih Bulan</option>
                @foreach($months as $month_filter)
                <option value="{{$month_filter['month']}}" @if($month_filter['month']==$month){{'selected'}}@endif>{{$month_filter['name']}}</option>
                @endforeach
            </select>
            <label for="year" class="form-label">Tahun</label>
            <select class="form-select" id="year" name="year" onchange="changeYear()">
                <option disabled>Pilih Tahun</option>
                @foreach($years as $year_filter)
                <option value="{{$year_filter}}" @if($year_filter==$year){{'selected'}}@endif>{{$year_filter}}</option>
                @endforeach
            </select>
        </div>
        <hr>
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex gap-3">
                <p class="mb-0">Total Kesuluruhan Tunggakan</p>
                <p class="mb-0">Total Orang Menunggak</p>
            </div>
            <div class="d-flex gap-3">
                <h4 class="font-weight-bold mb-0">Rp. {{number_format($total,2,',','.')}}</h4>
                <h4 class="font-weight-bold mb-0">{{$bills->count()}} Orang</h4>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive py-4">
            <table class="table table-hover" id="datatable">
                <thead class="thead-light">
                    <tr>
                        <th>Nomor Pelanggan</i></th>
                        <th>Nama</th>
                        <th>RT</th>
                        <th>RW</th>
                        <th>Total Tunggakan</th>
                        <th>Total Tagihan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bills as $bill)
                    <tr>
                        <td>{{$bill->usage->client->client_id}}</td>
                        <td>{{$bill->usage->client->name}}</td>
                        <td>{{$bill->usage->client->rt}}</td>
                        <td>{{$bill->usage->client->rw}}</td>
                        <td>{{$bill->allArrears($bill->usage->client->id)}} Bulan</td>
                        @php
                        $last_bill = 0;
                        foreach($bill->usage->client->usages as $usage) {
                        if($usage->bill->status != 'paid') {
                        $last_bill += $usage->bill->total;
                        }
                        }
                        @endphp
                        <td>Rp. {{number_format($last_bill,2,',','.')}}</td>
                        <td>{{$bill->status == 'late' ? 'Belum Dibayar' : 'Sudah DIbayar'}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{$bills->onEachSide(1)->links('vendor.pagination.bootstrap-4')}}
    </div>
</div>
@endsection

@section('customCSS')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />
@endsection

@section('customJS')
<script>
    sortByClientId = (direction) => {
        let url = new URL(window.location.href);
        url.searchParams.set('sort_client_id', direction);
        window.location.href = url;
    }
    changePageSize = () => {
        let pageSize = document.getElementById("page-size").value
        let url = new URL(window.location.href);
        url.searchParams.set('page_size', pageSize);
        window.location.href = url;
    }
    changeMonth = () => {
        let month = document.getElementById("month").value
        let url = new URL(window.location.href);
        url.searchParams.set('month', month);
        window.location.href = url;
    }
    changeYear = () => {
        let year = document.getElementById("year").value
        let url = new URL(window.location.href);
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
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.22/i18n/Indonesian.json"
            },
            "searching": false,
            "lengthChange": false,
            "paging": false
        });
    });
</script>
@endsection