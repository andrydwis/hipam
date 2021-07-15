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
    <title>Laravel Volt Template Starter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="title" content="Laravel Volt Template Starter">
    <meta name="author" content="Andry">
    <meta name="description" content="Laravel Volt Template Starter">
    <meta name="keywords" content="laravel, bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, themesberg, themesberg dashboard, themesberg admin dashboard" />
    <link rel="canonical" href="https://themesberg.com/product/admin-dashboard/volt-premium-bootstrap-5-dashboard">

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
                <div class="text-center"><b>Bukti Pembayaran HIPPAM : Swadaya Desa Klampok</b></div>
                <div class="row mx-5 my-5">
                    <div class="col-3">
                        <p>NO PELANGGAN</p>
                        <p>HARGA AIR</p>
                        <p>DENDA I</p>
                        <p>DENDA II</p>
                        <p>DENDA III</p>
                        <p>TOTAL BAYAR</p>
                    </div>
                    <div class="col-3">
                        <p>: {{$client->client_id}}</p>
                        <p>: RP. {{number_format($bills->where('status', 'unpaid')->first()->total,2,',','.')}}</p>
                        @if($bills->where('status', 'late')->first())
                        <p>: RP. {{number_format($bills->where('status', 'late')->first()->total,2,',','.')}}</p>
                        @else
                        <p>: RP. 0</p>
                        @endif
                        @if($bills->where('status', 'late')->skip(1)->first())
                        <p>: RP. {{number_format($bills->where('status', 'late')->skip(1)->first()->total,2,',','.')}}</p>
                        @else
                        <p>: RP. 0</p>
                        @endif
                        @if($bills->where('status', 'late')->skip(2)->first())
                        <p>: RP. {{number_format($bills->where('status', 'late')->skip(2)->first()->total,2,',','.')}}</p>
                        @else
                        <p>: RP. 0</p>
                        @endif
                        @php
                        $sumTotal = $bills->sum('total');
                        @endphp
                        <p>: RP. {{number_format($sumTotal,2,',','.')}}</p>
                    </div>
                    <div class="col-3">
                        <p>NAMA</p>
                        <p>RT</p>
                        <p>RW</p>
                        <p>BL/TH</p>
                        <p>PEMAKAIAN</p>
                    </div>
                    <div class="col-3">
                        <p>: {{$client->name}}</p>
                        <p>: {{$client->rt}}</p>
                        <p>: {{$client->rw}}</p>
                        <p>: {{$month}}/{{$year}}</p>
                        <p>: {{$bills->where('status', 'unpaid')->first()->meter_cubic}} m<sup>3</sup></p>
                    </div>
                </div>
                <div class="text-center"><b>Pastikan Meter Air Anda Dapat Dibaca Secara Rutin Oleh Petugas</b></div>
                <div class="text-center"><b>HIPPAM : SWADAYA DESA KLAMPOK MENYATAKAN STRUK INI SEBAGAI BUKTI PEMBAYARAN YANG SAH. MOHON DI SIMPAN (TERIMA KASIH)</b></div>
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