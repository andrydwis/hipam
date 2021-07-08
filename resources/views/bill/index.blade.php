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
        </div>
    </div>
</div>
<div class="row">
    @foreach($months as $month)
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
    @endforeach
</div>
@endsection