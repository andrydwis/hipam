@extends('layouts.app')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">Detail Pelanggan</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Detail Pelanggan</h1>
            <p class="mb-0">Daftar rincian pembayaran dan penggunaan pelanggan</p>
        </div>
    </div>
</div>
@if($bills->isNotEmpty())
<div class="card">
    <div class="card-body">
        <div class="d-flex flex-column justify-content-center align-items-center">
            <p class="fw-bolder">BILLING IURAN AIR</p>
            <p class="fw-bolder">HIPAM SWADAYA RW.02 DESA KLAMPOK</p>
        </div>
        <br>
        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col-4">
                        <div class="text-start fw-bolder">No. Pelanggan </div>
                    </div>
                    <div class="col-8">
                        <div class="text-start fw-bolder">: {{$client->client_id}}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="text-start">Nama/RT/RW</div>
                    </div>
                    <div class="col-8">
                        <div class="text-start">: {{$client->name}}/RT.{{$client->rt}}/RW.{{$client->rw}}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="text-start">Penggunaan</div>
                    </div>
                    <div class="col-8">
                        <div class="text-start">: {{$bills->where('status', 'unpaid')->first()->meter_cubic}} m<sup>3</sup> ({{($bills->where('status', 'unpaid')->first()->usage->meter_cubic)-($bills->where('status', 'unpaid')->first()->meter_cubic)}}-{{$bills->where('status', 'unpaid')->first()->usage->meter_cubic}})</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="text-start fw-bolder">Bulan</div>
                    </div>
                    <div class="col-8">
                        <div class="text-start fw-bolder">: {{$bills->where('status', 'unpaid')->first()->usage->month}} {{$bills->where('status', 'unpaid')->first()->usage->year}}</div>
                    </div>
                </div>
                <br>
                <div class="text-start fw-bolder">RINCIAN</div>
                <div class="row">
                    <div class="col-4">
                        <div class="text-start">Tagihan ({{$bills->where('status', 'unpaid')->first()->meter_cubic}} m<sup>3</sup> x {{config('custom.cost')}})</div>
                    </div>
                    <div class="col-8">
                        <div class="text-start">= Rp. {{number_format(($bills->where('status', 'unpaid')->first()->meter_cubic * config('custom.cost')),2,',','.')}}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="text-start">Abonemen</div>
                    </div>
                    <div class="col-8">
                        <div class="text-start">= Rp. {{number_format(config('custom.subscription'),2,',','.')}}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="text-start">Tunggakan</div>
                    </div>
                    <div class="col-8">
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
                    <div class="col-4">
                        <div class="text-start">Denda</div>
                    </div>
                    <div class="col-8">
                        <div class="text-start">= Rp. {{number_format($late * config('custom.fine'),2,',','.')}}</div>
                    </div>
                </div>
                <ul class="list-unstyled m-0 p-0">
                    <li>
                        <div class="row">
                            <div class="col-4">
                                <div class="text-start">{{$bills->where('status', 'late')->first()->usage->month}}</div>
                            </div>
                            <div class="col-8">
                                <div class="text-start">= Rp. {{number_format($bills->where('status', 'late')->first()->cost + config('custom.subscription'),2,',','.')}}</div>
                            </div>
                        </div>
                    </li>
                    @endif
                    @if($bills->where('status', 'late')->skip(1)->first())
                    <li>
                        <div class="row">
                            <div class="col-4">
                                <div class="text-start">{{$bills->where('status', 'late')->skip(1)->first()->usage->month}}</div>
                            </div>
                            <div class="col-8">
                                <div class="text-start">= Rp. {{number_format($bills->where('status', 'late')->skip(1)->first()->cost + config('custom.subscription'),2,',','.')}}</div>
                            </div>
                        </div>
                    </li>
                    @endif
                    @if($bills->where('status', 'late')->skip(2)->first())
                    <li>
                        <div class="row">
                            <div class="col-4">
                                <div class="text-start">{{$bills->where('status', 'late')->skip(2)->first()->usage->month}}</div>
                            </div>
                            <div class="col-8">
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
                    <div class="col-4">
                        <div class="text-start fw-bolder">TOTAL</div>
                    </div>
                    <div class="col-8">
                        <div class="text-start fw-bolder">= Rp. {{number_format($sumTotal,2,',','.')}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="card">
    <div class="card-body d-flex flex-column justify-content-center align-items-center p-5">
        <img src="{{asset('assets/img/illustrations/done.svg')}}" alt="" height="200">
        <h1 class="h5">Tagihan pembayaran anda sudah lunas semua!</h1>
    </div>
</div>
@endif
<div class="card mt-5">
    <div class="card-body">
        <div class="table-responsive py-4">
            <table class="table table-hover" id="datatable">
                <thead class="thead-light">
                    <tr>
                        <th>Tahun</th>
                        <th>Bulan</th>
                        <th>Meter Kubik</th>
                        <th>Pemakaian</th>
                        <th>Tarif</th>
                        <th>Abonemen</th>
                        <th>Denda</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usages as $usage)
                    <tr>
                        <td>{{$usage->year}}</td>
                        <td>{{$usage->month}}</td>
                        <td>{{$usage->meter_cubic}} m <sup>3</sup></td>
                        <td>{{$usage->bill->meter_cubic}} m <sup>3</sup></td>
                        <td>Rp. {{number_format((config('custom.cost')),2,',','.')}}</td>
                        <td>Rp. {{number_format((config('custom.subscription')),2,',','.')}}</td>
                        <td>
                            @if($usage->bill->fine)
                            Rp. {{number_format(($usage->bill->fine),2,',','.')}}
                            @else
                            {{'-'}}
                            @endif
                        </td>
                        <td>Rp. {{number_format(($usage->bill->total),2,',','.')}}</td>
                        <td>
                            @if($usage->bill->status == 'unpaid')
                            <span class="badge rounded-pill bg-primary">Belum Lunas</span>
                            @elseif($usage->bill->status == 'late')
                            <span class="badge rounded-pill bg-danger">Terlambat</span>
                            @else
                            <span class="badge rounded-pill bg-success">Lunas</span>
                            @endif
                        </td>
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
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.22/i18n/Indonesian.json"
            }
        });
    });
</script>
@endsection