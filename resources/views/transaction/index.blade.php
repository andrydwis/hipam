@extends('layouts.app')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">Transaksi Pembayaran</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Transaksi Pembayaran</h1>
            <p class="mb-0">Menampilkan daftar transaksi pembayaran pelanggan</p>
        </div>
    </div>
</div>
@include('layouts.alert')
<div class="card">
    <div class="card-body">
        <form action="" method="get" class="d-flex flex-row">
            <input type="text" class="form-control me-1" name="keyword" placeholder="Masukkan nomor atau nama pelanggan">
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
        @if($client)
        <div class="row mt-5">
            <div class="col">
                <h3 class="text-center fw-bolder text-uppercase">{{$month}} - {{$year}}</h3>
                <h3 class="text-left fw-bolder">{{$client->client_id}} - {{$client->name}} RT.{{$client->rt}}/RW.{{$client->rw}}</h3>
                <p>Pemakaian <span class="fw-bolder">{{$bills->where('status', 'unpaid')->first()->meter_cubic}} m<sup>3</sup></span> ({{($bills->where('status', 'unpaid')->first()->usage->meter_cubic)-($bills->where('status', 'unpaid')->first()->meter_cubic)}}-{{$bills->where('status', 'unpaid')->first()->usage->meter_cubic}})</p>
                <div class="text-start fw-bolder">RINCIAN</div>
                <div class="row">
                    <div class="col-5">
                        <div class="text-start">Tagihan ({{$bills->where('status', 'unpaid')->first()->meter_cubic}} m<sup>3</sup> x {{config('custom.cost')}})</div>
                    </div>
                    <div class="col-7">
                        <div class="text-start">= Rp. {{number_format(($bills->where('status', 'unpaid')->first()->meter_cubic * config('custom.cost')),2,',','.')}}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-5">
                        <div class="text-start">Abonemen</div>
                    </div>
                    <div class="col-7">
                        <div class="text-start">= Rp. {{number_format(config('custom.subscription'),2,',','.')}}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-5">
                        <div class="text-start">Tunggakan</div>
                    </div>
                    <div class="col-7">
                        <div class="text-start">= {{$bills->where('status', 'late')->count()}} kali</div>
                    </div>
                </div>
                @if($bills->where('status', 'late')->first())
                @php
                $late = 0;
                foreach($bills->where('status', 'late') as $bill) {
                $late++;
                }
                @endphp
                <div class="row">
                    <div class="col-5">
                        <div class="text-start">Denda</div>
                    </div>
                    <div class="col-7">
                        <div class="text-start">= Rp. {{number_format($late * config('custom.fine'),2,',','.')}}</div>
                    </div>
                </div>
                <ul class="list-unstyled m-0 p-0">
                    <li>
                        <div class="row">
                            <div class="col-5">
                                <div class="text-start">{{$bills->where('status', 'late')->first()->usage->month}}</div>
                            </div>
                            <div class="col-7">
                                <div class="text-start">= Rp. {{number_format($bills->where('status', 'late')->first()->cost + config('custom.subscription'),2,',','.')}}</div>
                            </div>
                        </div>
                    </li>
                    @endif
                    @if($bills->where('status', 'late')->skip(1)->first())
                    <li>
                        <div class="row">
                            <div class="col-5">
                                <div class="text-start">{{$bills->where('status', 'late')->skip(1)->first()->usage->month}}</div>
                            </div>
                            <div class="col-7">
                                <div class="text-start">= Rp. {{number_format($bills->where('status', 'late')->skip(1)->first()->cost + config('custom.subscription'),2,',','.')}}</div>
                            </div>
                        </div>
                    </li>
                    @endif
                    @if($bills->where('status', 'late')->skip(2)->first())
                    <li>
                        <div class="row">
                            <div class="col-5">
                                <div class="text-start">{{$bills->where('status', 'late')->skip(2)->first()->usage->month}}</div>
                            </div>
                            <div class="col-7">
                                <div class="text-start">= Rp. {{number_format($bills->where('status', 'late')->skip(2)->first()->cost + config('custom.subscription'),2,',','.')}}</div>
                            </div>
                        </div>
                    </li>
                    @endif
                </ul>
                @php
                $sumTotal = $bills->sum('total');
                @endphp
                <hr>
                <div class="row">
                    <div class="col-5">
                        <h4 class="text-start fw-bolder">TOTAL</h4>
                    </div>
                    <div class="col-7">
                        <h4 class="text-start fw-bolder">= Rp. {{number_format($sumTotal,2,',','.')}}</h4>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-end gap-1">
                    <form action="{{route('transaction.pay-process', [$client])}}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary">Bayar</button>
                    </form>
                    <a href="{{route('transaction.show', [$client])}}" class="btn btn-outline-primary">Detail</a>
                    <button class="btn btn-outline-primary" disabled>Keringanan</button>
                </div>
            </div>
        </div>
        @endif
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