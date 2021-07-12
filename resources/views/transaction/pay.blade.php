@extends('layouts.app')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('transaction.index')}}">Transaksi Pembayaran</a></li>
            <li class="breadcrumb-item active">Bayar</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Bayar</h1>
            <p class="mb-0">Proses pembayaran tagihan pelanggan</p>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 col-12">
                <h5 class="card-title">Detail Pelanggan</h5>
                <div class="mb-4">
                    <label for="nomor_pelanggan">Nomor Pelanggan</label>
                    <input type="number" name="nomor_pelanggan" class="form-control" placeholder="nomor pelanggan" value="{{$client->client_id}}" readonly>
                </div>
                <div class="mb-4">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" class="form-control" placeholder="nama pelanggan" value="{{$client->name}}" readonly>
                </div>
                <div class="mb-4">
                    <label for="rt">RT</label>
                    <input type="text" name="rt" class="form-control" placeholder="RT" value="{{$client->rt}}" readonly>
                </div>
                <div class="mb-4">
                    <label for="rw">RW</label>
                    <input type="text" name="rw" class="form-control" placeholder="RW" value="{{$client->rw}}" readonly>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <h5 class="card-title">Tagihan</h5>
                <p class="card-text">Rincian Pembayaran:</p>
                <hr>
                @forelse ($bills as $bill)
                <div class="d-flex align-items-center">
                    <div class="me-auto"><b>Tagihan {{$bill->usage->month}} {{$bill->usage->year}}</b></div>
                    <div class="d-flex align-items-center gap-2">
                        Rp. {{number_format($bill->total,2,',','.')}}
                        <a href="{{route('bill.show', [$bill->usage->month, $bill->usage->year])}}" target="_blank" class="btn btn-outline-primary btn-icon-only"><i class="fas fa-eye"></i></a>
                    </div>
                </div>
                <hr>
                @php
                $sumTotal += $bill->total;
                @endphp
                @empty
                <div class="alert alert-success" role="alert">
                    Pelanggan ini telah membayar semua tagihan
                </div>
                @endforelse
                @if($bills->isNotEmpty())
                <div class="d-flex">
                    <div class="me-auto"><b>Total:</b></div>
                    <div class="d-flex align-items-center">
                        <b>Rp. {{number_format($sumTotal,2,',','.')}}</b>
                    </div>
                </div>
                <div class="d-grid mt-5">
                    <button class="btn btn-primary">Bayar</button>
                </div>
                @else
                <div class="d-grid mt-5">
                    <a href="{{route('transaction.show', [$client])}}" target="_blank" class="btn btn-primary">Detail</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection