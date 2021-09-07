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
            /* font-family: sans-serif !important; */
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

        hr {
            border: 0.75px solid #000000;
        }
    </style>

    @yield('customCSS')
</head>

<body>
    <div class="container-fluid">
        <div class="row print">
            <div class="col col-small" style="border-right: 0.5px dashed">
                <div class="text-center">STRUK BUKTI PEMBAYARAN IURAN AIR</div>
                <div class="text-center">HIPAM SWADAYA RW.02 DESA KLAMPOK</div>
                <div class="text-center fw-bolder">{{$month}} {{$year}}</div>
                <br>
                <div class="text-start fw-bolder">No. Pelanggan <span class="tab"> : {{$client->client_id}}</div>
                <div class="text-start">Nama/RT/RW <span class="tab"> : {{$client->name}}/RT.{{$client->rt}}/RW.{{$client->rw}}</div>
                <div class="text-start">Penggunaan <span class="tab"> : {{$bills->where('status', 'unpaid')->first()->meter_cubic}} m<sup>3</sup> ({{($bills->where('status', 'unpaid')->first()->usage->meter_cubic)-($bills->where('status', 'unpaid')->first()->meter_cubic)}}-{{$bills->where('status', 'unpaid')->first()->usage->meter_cubic}})</div>
                <br>
                <div class="text-start fw-bolder">RINCIAN</div>
                <div class="text-start">Tagihan ({{$bills->where('status', 'unpaid')->first()->meter_cubic}} m<sup>3</sup> x {{config('custom.cost')}}) = RP. {{number_format(($bills->where('status', 'unpaid')->first()->meter_cubic * config('custom.cost')),2,',','.')}}</div>
                <div class="text-start">Abonemen <span class="tab"><span class="tab"><span class="tab"> = RP. {{number_format(config('custom.subscription'),2,',','.')}}</div>
                <div class="text-start">Tunggakan <span class="tab"><span class="tab"><span class="tab"> = {{$bills->where('status', 'late')->count()}} kali</div>
                @if($bills->where('status', 'late')->first())
                @php
                $late = 0;
                foreach($bills->where('status', 'late') as $bill) {
                $late++;
                }
                @endphp
                <div class="text-start">Denda <span class="tab"><span class="tab"><span class="tab"> = {{number_format($late * config('custom.fine'),2,',','.')}}</div>
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
                @php
                $sumTotal = $bills->sum('total');
                @endphp
                <hr>
                <div class="text-start fw-bolder">TOTAL <span class="tab"><span class="tab"><span class="tab"><span class="tab"> = RP. {{number_format($sumTotal,2,',','.')}}</div>
                <div class="d-flex justify-content-between mt-2">
                    <div>Tanggal Bayar {{$day}} {{$month}} {{$year}}</div>
                    <div>TTD Petugas</div>
                </div>
                <div class="mt-2" style="font-size: 7.5px;">
                    Kertas ini merupakan alat bukti sah pembayaran jika sudah ditempel tanda tangan petugas.
                    Mohon dicek ulang meter air, jika ada ketidak sesuaian hubungi <span class="fw-bolder">PENGURUS</span> (bukan loket)
                </div>
            </div>
            <div class="col">
                <div class="text-center">STRUK BUKTI PEMBAYARAN IURAN AIR</div>
                <div class="text-center">HIPAM SWADAYA RW.02 DESA KLAMPOK</div>
                <div class="text-center fw-bolder">{{$month}} {{$year}}</div>
                <br>
                <div class="text-start fw-bolder">No. Pelanggan <span class="tab"> : {{$client->client_id}}</div>
                <div class="text-start">Nama/RT/RW <span class="tab"> : {{$client->name}}/RT.{{$client->rt}}/RW.{{$client->rw}}</div>
                <div class="text-start">Penggunaan <span class="tab"> : {{$bills->where('status', 'unpaid')->first()->meter_cubic}} m<sup>3</sup> ({{($bills->where('status', 'unpaid')->first()->usage->meter_cubic)-($bills->where('status', 'unpaid')->first()->meter_cubic)}}-{{$bills->where('status', 'unpaid')->first()->usage->meter_cubic}})</div>
                <br>
                <div class="text-start fw-bolder">RINCIAN</div>
                <div class="text-start">Tagihan ({{$bills->where('status', 'unpaid')->first()->meter_cubic}} m<sup>3</sup> x {{config('custom.cost')}}) = RP. {{number_format(($bills->where('status', 'unpaid')->first()->meter_cubic * config('custom.cost')),2,',','.')}}</div>
                <div class="text-start">Abonemen <span class="tab"><span class="tab"><span class="tab"> = RP. {{number_format(config('custom.subscription'),2,',','.')}}</div>
                <div class="text-start">Tunggakan <span class="tab"><span class="tab"><span class="tab"> = {{$bills->where('status', 'late')->count()}} kali</div>
                @if($bills->where('status', 'late')->first())
                @php
                $late = 0;
                foreach($bills->where('status', 'late') as $bill) {
                $late++;
                }
                @endphp
                <div class="text-start">Denda <span class="tab"><span class="tab"><span class="tab"> = {{number_format($late * config('custom.fine'),2,',','.')}}</div>
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
                @php
                $sumTotal = $bills->sum('total');
                @endphp
                <hr>
                <div class="text-start fw-bolder">TOTAL <span class="tab"><span class="tab"><span class="tab"><span class="tab"> = RP. {{number_format($sumTotal,2,',','.')}}</div>
                <div class="d-flex justify-content-between mt-2">
                    <div>Tanggal Bayar {{$day}} {{$month}} {{$year}}</div>
                    <div>TTD Petugas</div>
                </div>
                <div class="mt-2" style="font-size: 7.5px;">
                    Kertas ini merupakan alat bukti sah pembayaran jika sudah ditempel tanda tangan petugas.
                    Mohon dicek ulang meter air, jika ada ketidak sesuaian hubungi <span class="fw-bolder">PENGURUS</span> (bukan loket)
                </div>
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