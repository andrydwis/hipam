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
        @font-face {
            font-family: dot;
            src: url("{{asset('fonts/dot.ttf')}}");
        }

        @media print {

            .no-print,
            .no-print * {
                display: none !important;
            }

            .col-small {
                max-width: 6.6cm;
            }

            html,
            body {
                display: block;
                margin: 0;
                color: black;
            }

            @page {
                size: 21.6cm 7.1cm;
            }
        }

        .print {
            font-size: 10px !important;
            font-family: sans-serif !important;
        }

        .tab {
            padding-left: 20px;
        }

        .box {
            border: 3px solid #000000;
            padding: 10px;
        }

        li {
            font-size: 10px !important;
            font-family: sans-serif !important;
        }
    </style>

    @yield('customCSS')
</head>

<body>
    <div class="container-fluid">
        <div class="row print">
            <div class="col col-small">
                <div class="text-center">HIPAM SWADAYA RW 2</div>
                <div class="text-center">Bukti Pembayaran Iuran Air</div>
                <div class="text-center">{{$day}} {{$month}} {{$year}}</div>
                <br>
                <div class="text-start">DATA PELANGGAN</div>
                <div class="text-start">No/Nama/RT <span class="tab"> : {{$client->client_id}}/{{$client->name}}/RT.{{$client->rt}}/RW.{{$client->rw}}</div>
                <div class="text-start">Penggunaan <span class="tab"> : {{$bills->where('status', 'unpaid')->first()->meter_cubic}} m<sup>3</sup></div>
                <br>
                <div class="text-start">RINCIAN</div>
                <div class="text-start">Tagihan ({{$bills->where('status', 'unpaid')->first()->meter_cubic}} m<sup>3</sup> x {{config('custom.cost')}}) = RP. {{number_format(($bills->where('status', 'unpaid')->first()->meter_cubic * config('custom.cost')),2,',','.')}}</div>
                <div class="text-start">Abonemen <span class="tab"><span class="tab"><span class="tab"> = RP. {{number_format(config('custom.subscription'),2,',','.')}}</div>
                <div class="text-start">Tunggakan <span class="tab"><span class="tab"><span class="tab"> = {{$bills->where('status', 'late')->count()}} kali</div>
                @if($bills->where('status', 'late')->first())
                <div class="text-start">Denda</div>
                <ul>
                    <li>
                        <div class="text-start">{{$bills->where('status', 'late')->first()->usage->month}} : RP. {{number_format($bills->where('status', 'late')->first()->cost + config('custom.subscription'),2,',','.')}} + {{number_format(config('custom.fine'),2,',','.')}}</div>
                    </li>
                    @endif
                    @if($bills->where('status', 'late')->skip(1)->first())
                    <li>
                        <div class="text-start">{{$bills->where('status', 'late')->skip(1)->first()->usage->month}} : RP. {{number_format($bills->where('status', 'late')->skip(1)->first()->cost + config('custom.subscription'),2,',','.')}} + {{number_format(config('custom.fine'),2,',','.')}}</div>
                    </li>
                    @endif
                    @if($bills->where('status', 'late')->skip(2)->first())
                    <li>
                        <div class="text-start">{{$bills->where('status', 'late')->skip(2)->first()->usage->month}} : RP. {{number_format($bills->where('status', 'late')->skip(2)->first()->cost + config('custom.subscription'),2,',','.')}} + {{number_format(config('custom.fine'),2,',','.')}}</div>
                    </li>
                    @endif
                </ul>
                <br>
                @php
                $sumTotal = $bills->sum('total');
                @endphp
                <div class="text-start">TOTAL <span class="tab"><span class="tab"><span class="tab"><span class="tab"> RP. {{number_format($sumTotal,2,',','.')}}</div>
            </div>
            <div class="col">
                <div class="text-center">HIPAM SWADAYA RW 2</div>
                <div class="text-center">Bukti Pembayaran Iuran Air</div>
                <div class="text-center">{{$day}} {{$month}} {{$year}}</div>
                <br>
                <div class="text-start">DATA PELANGGAN</div>
                <div class="text-start">No/Nama/RT <span class="tab"> : {{$client->client_id}}/{{$client->name}}/RT.{{$client->rt}}/RW.{{$client->rw}}</div>
                <div class="text-start">Penggunaan <span class="tab"> : {{$bills->where('status', 'unpaid')->first()->meter_cubic}} m<sup>3</sup></div>
                <br>
                <div class="text-start">RINCIAN</div>
                <div class="text-start">Tagihan ({{$bills->where('status', 'unpaid')->first()->meter_cubic}} m<sup>3</sup> x {{config('custom.cost')}}) = RP. {{number_format(($bills->where('status', 'unpaid')->first()->meter_cubic * config('custom.cost')),2,',','.')}}</div>
                <div class="text-start">Abonemen <span class="tab"><span class="tab"><span class="tab"> = RP. {{number_format(config('custom.subscription'),2,',','.')}}</div>
                <div class="text-start">Tunggakan <span class="tab"><span class="tab"><span class="tab"> = {{$bills->where('status', 'late')->count()}} kali</div>
                @if($bills->where('status', 'late')->first())
                <div class="text-start">Denda</div>
                <ul >
                    <li>
                        <div class="text-start">{{$bills->where('status', 'late')->first()->usage->month}} : RP. {{number_format($bills->where('status', 'late')->first()->cost + config('custom.subscription'),2,',','.')}} + {{number_format(config('custom.fine'),2,',','.')}}</div>
                    </li>
                    @endif
                    @if($bills->where('status', 'late')->skip(1)->first())
                    <li>
                        <div class="text-start">{{$bills->where('status', 'late')->skip(1)->first()->usage->month}} : RP. {{number_format($bills->where('status', 'late')->skip(1)->first()->cost + config('custom.subscription'),2,',','.')}} + {{number_format(config('custom.fine'),2,',','.')}}</div>
                    </li>
                    @endif
                    @if($bills->where('status', 'late')->skip(2)->first())
                    <li>
                        <div class="text-start">{{$bills->where('status', 'late')->skip(2)->first()->usage->month}} : RP. {{number_format($bills->where('status', 'late')->skip(2)->first()->cost + config('custom.subscription'),2,',','.')}} + {{number_format(config('custom.fine'),2,',','.')}}</div>
                    </li>
                    @endif
                </ul>
                <br>
                @php
                $sumTotal = $bills->sum('total');
                @endphp
                <div class="text-start">TOTAL <span class="tab"><span class="tab"><span class="tab"><span class="tab"> RP. {{number_format($sumTotal,2,',','.')}}</div>
            </div>
        </div>

        <a href="{{session('previousUrl')}}" class="btn btn-primary mt-5 no-print">Kembali</a>
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