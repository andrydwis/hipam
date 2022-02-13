@extends('layouts.app')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">Tagihan</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Tagihan</h1>
            <p class="mb-0">Menampilkan daftar tagihan pelanggan perbulan tiap tahun</p>
            <div class="mt-2">
                <select name="year" id="year" class="form-control" style="width: 100px;" onchange="changeYear()">
                    <option disabled>Pilih Tahun</Option>
                    @foreach($yearUsages as $year)
                    <option value="{{$year}}" @if($request->year == $year) selected @endif>{{$year}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row">
    @foreach($months as $month)
    @if(!$request->year || $request->year == $yearNow)
    @if($monthNow == $month)
    <div class="col-md-4 col-sm-6 col-12 mb-1">
        <a href="{{route('bill.show', [$month, $yearNow])}}">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <p class="card-text text-center">{{$month}}</p>
                </div>
            </div>
        </a>
    </div>
    @else
    <div class="col-md-4 col-sm-6 col-12 mb-1">
        <a href="{{route('bill.show', [$month, $yearNow])}}">
            <div class="card">
                <div class="card-body">
                    <p class="card-text text-center">{{$month}}</p>
                </div>
            </div>
        </a>
    </div>
    @endif
    @else
    <div class="col-md-4 col-sm-6 col-12 mb-1">
        <a href="{{route('bill.show', [$month, $request->year])}}">
            <div class="card">
                <div class="card-body">
                    <p class="card-text text-center">{{$month}}</p>
                </div>
            </div>
        </a>
    </div>
    @endif
    @endforeach
</div>
<div class="row">
    <div class="col">
        <a href="{{route('bill.show-all')}}">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <p class="card-text text-center">Lihat Semua Data</p>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection

@section('customJS')
<script>
    changeYear = () => {
        let year = document.getElementById("year").value
        let url = new URL(window.location.href);
        url.searchParams.set('year', year);
        window.location.href = url;
    }
    setSelectedYear = () => {
        let url = new URL(window.location.href);
        let year = url.searchParams.get('year');
    }
    window.onload = setSelectedYear;
</script>
@endsection