<!--

=========================================================
* Volt Free - Bootstrap 5 Dashboard
=========================================================

* Product Page: https://themesberg.com/product/admin-dashboard/volt-bootstrap-5-dashboard
* Copyright 2021 Themesberg (https://www.themesberg.com)

* Designed and coded by https://themesberg.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. Please contact us to request a removal. Contact us if you want to remove it.

-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Primary Meta Tags -->
    <title>HIPPAM: Desa Klampok</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="title" content="HIPPAM: Desa Klampok">
    <meta name="author" content="Andry">
    <meta name="description" content="HIPPAM: Desa Klampok">
    <meta name="keywords" content="HIPPAM: Desa Klampok" />
    <link rel="canonical" href="HIPPAM: Desa Klampok">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('assets/img/favicon/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/img/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/img/favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('assets/img/favicon/site.webmanifest')}}">
    <link rel="mask-icon" href="{{asset('assets/img/favicon/safari-pinned-tab.svg')}}" color="#ffffff">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <!-- Volt CSS -->
    <link type="text/css" href="{{asset('css/volt.css')}}" rel="stylesheet">
    <style>
        @media print {

            .no-print,
            .no-print * {
                display: none !important;
            }
        }
    </style>

    @yield('customCSS')
</head>

<body>
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-body">
                <div class="text-center"><b>HIPAM SWADAYA RW 2</b></div>
                <div class="text-center"><b>Bukti Pembayaran Iuran Air</b></div>
                <div class="text-center"><b>{{$day}} {{$month}} {{$year}}</b></div>
                <br>
                <div class="text-start"><b>DATA PELANGGAN</b></div>
                <div class="text-start">No/Nama/RT : {{$client->client_id}}/{{$client->name}}/RT.{{$client->rt}}</div>
                <div class="text-start">Penggunaan : {{$bills->where('status', 'unpaid')->first()->meter_cubic}} m<sup>3</sup></div>
                <br>
                <div class="text-start"><b>RINCIAN</b></div>
                <div class="text-start">Tagihan : ({{$bills->where('status', 'unpaid')->first()->meter_cubic}} m<sup>3</sup> x {{config('custom.cost')}}) = RP. {{number_format(($bills->where('status', 'unpaid')->first()->meter_cubic * config('custom.cost')),2,',','.')}}</div>
                <div class="text-start">Abonemen : RP. {{number_format(config('custom.subscription'),2,',','.')}}</div>
                <div class="text-start">Tunggakan : {{$bills->where('status', 'late')->count()}} kali</div>
                @if($bills->where('status', 'late')->first())
                <div class="text-start">Denda : </div>
                <div class="text-start">{{$bills->where('status', 'late')->first()->usage->month}} : RP. {{number_format($bills->where('status', 'late')->first()->cost + config('custom.subscription'),2,',','.')}} + {{number_format(config('custom.fine'),2,',','.')}}</div>
                @endif
                @if($bills->where('status', 'late')->skip(1)->first())
                <div class="text-start">{{$bills->where('status', 'late')->skip(1)->first()->usage->month}} : RP. {{number_format($bills->where('status', 'late')->skip(1)->first()->cost + config('custom.subscription'),2,',','.')}} + {{number_format(config('custom.fine'),2,',','.')}}</div>
                @endif
                @if($bills->where('status', 'late')->skip(2)->first())
                <div class="text-start">{{$bills->where('status', 'late')->skip(2)->first()->usage->month}} : RP. {{number_format($bills->where('status', 'late')->skip(2)->first()->cost + config('custom.subscription'),2,',','.')}} + {{number_format(config('custom.fine'),2,',','.')}}</div>
                @endif
                <br>
                @php
                $sumTotal = $bills->sum('total');
                @endphp
                <div class="text-start"><b>TOTAL : RP. {{number_format($sumTotal,2,',','.')}}</b></div>
                <br>
                <div class="text-end">Petugas</div>
                <br>
                <br>
                <div class="text-end">{{auth()->user()->name}}</div>
            </div>
        </div>
        <a href="{{route('transaction.index')}}" class="btn btn-primary mt-5 no-print">Kembali</a>
        <button onclick="window.print()" class="btn btn-primary mt-5 no-print">Print</button>
    </div>
    <!-- Core -->
    <script src="{{asset('vendor/@popperjs/core/dist/umd/popper.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>

    <!-- Vendor JS -->
    <script src="{{asset('vendor/onscreen/dist/on-screen.umd.min.js')}}"></script>

    <!-- FA Icon -->
    <script src="https://kit.fontawesome.com/8482c12eb4.js" crossorigin="anonymous"></script>

    @yield('customJS')
</body>

</html>