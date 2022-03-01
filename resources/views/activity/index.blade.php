@extends('layouts.app')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">Laporan Kegiatan Teknisi</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Laporan Kegiatan Teknisi</h1>
            <p class="mb-0">Melihat keseluruhan laporan data teknisi air susuai dengan surat perintah kerja dari atasan</p>
        </div>
    </div>
</div>
@include('layouts.alert')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div>
            <select class="form-select" id="page-size" onchange="changePageSize()">
                <option value="10" selected>10</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <a href="{{route('activity.export', $request->all())}}" class="btn btn-outline-primary">Export</a>
    </div>
    <div class="card-body">
        <div class="d-flex gap-3">
            <select class="form-select" id="month" onchange="changeDate()" style="width: 175px;">
                <option disabled>Pilih Bulan</option>
                @foreach($months as $month)
                <option value="{{$month}}" @if($month==$monthNow ||$month==$request->month){{'selected'}}@endif>{{$month}}</option>
                @endforeach
            </select>
            <select class="form-select" id="year" onchange="changeDate()" style="width: 175px;">
                <option disabled>Pilih Tahun</option>
                @if($years->isNotEmpty())
                @foreach($years as $year)
                <option value="{{$year}}" @if($year==$yearNow){{'selected'}}@endif>{{$year}}</option>
                @endforeach
                @else
                <option value="{{$yearNow}}" selected>{{$yearNow}}</option>
                @endif
            </select>
        </div>
        <div class="table-responsive py-4">
            <table class="table table-hover" id="datatable">
                <thead class="thead-light">
                    <tr>
                        <th>Tahun</th>
                        <th>Bulan</th>
                        <th>Tanggal</th>
                        <th>Nama Teknisi</th>
                        <th>Jenis Kegiatan</th>
                        <th>Jenis Pekerjaan</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activities as $activity)
                    <tr>
                        <td>
                            {{$activity->year}}
                        </td>
                        <td>
                            {{$activity->month}}
                        </td>
                        <td>
                            {{$activity->created_at->isoFormat('dddd, DD-MM-YYYY hh:mm A')}}
                        </td>
                        <td>
                            {{$activity->technician->name}}
                        </td>
                        <td>
                            {{$activity->activity_type}}
                        </td>
                        <td>{{$activity->job_type}}</td>
                        <td>
                            <form action="{{route('activity.destroy', $activity)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-primary">Hapus</button>
                                <a href="{{route('activity.show-admin', $activity)}}" class="btn btn-outline-primary">Detail</a>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{$activities->onEachSide(1)->links('vendor.pagination.bootstrap-4')}}
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
@endsection