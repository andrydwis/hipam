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
            <div class="col" style="border-right: 0.5px dashed">
                <div class="text-center fw-bolder">STRUK BUKTI PEMBAYARAN IURAN AIR</div>
                <div class="text-center fw-bolder">HIPAM SWADAYA RW.02 DESA KLAMPOK</div>
                <div class="text-center fw-bolder text-uppercase mt-2" style="font-size: 15px;">{{$month}} - {{$year}}</div>
                <hr style="margin-top: 5px; margin-bottom: 5px;">
                <div class="text-left fw-bolder" style="font-size: 18px;">{{$client->client_id}} - {{$client->name}} - RT.{{$client->rt}}/RW.{{$client->rw}}</div>
                <div style="font-size: 15px;">Pemakaian <span class="fw-bolder">{{$bills->where('status', 'unpaid')->first()->meter_cubic}} m<sup>3</sup></span> ({{($bills->where('status', 'unpaid')->first()->usage->meter_cubic)-($bills->where('status', 'unpaid')->first()->meter_cubic)}}-{{$bills->where('status', 'unpaid')->first()->usage->meter_cubic}})</div>
                <div class="text-start fw-bolder mt-2">RINCIAN</div>
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
                <hr style="margin-top: 5px; margin-bottom: 5px;">
                <div class="row mt-1">
                    <div class="col-5">
                        <div class="text-start fw-bolder" style="font-size: 15px;">TOTAL</div>
                    </div>
                    <div class="col-7">
                        <div class="text-start fw-bolder" style="font-size: 15px;">= Rp. {{number_format($sumTotal,2,',','.')}}</div>
                    </div>
                </div>
                <div style="font-size: 7.5px;">
                    Kertas ini merupakan alat bukti sah pembayaran jika sudah ditempel tanda tangan petugas.
                    Mohon dicek ulang meter air, jika ada ketidak sesuaian hubungi <span class="fw-bolder">PENGURUS</span> (bukan loket)
                </div>
                <hr style="margin-top: 5px; margin-bottom: 5px;">
                <div>
                    <div class="text-center">Cek tagihan anda di</div>
                    <div class="text-center fw-bolder">https://hipamklampok.com</div>
                </div>
            </div>
            <div class="col">
                <div class="text-center fw-bolder">STRUK BUKTI PEMBAYARAN IURAN AIR</div>
                <div class="text-center fw-bolder">HIPAM SWADAYA RW.02 DESA KLAMPOK</div>
                <div class="text-center fw-bolder text-uppercase mt-2" style="font-size: 15px;">{{$month}} - {{$year}}</div>
                <hr style="margin-top: 5px; margin-bottom: 5px;">
                <div class="text-left fw-bolder" style="font-size: 18px;">{{$client->client_id}} - {{$client->name}} - RT.{{$client->rt}}/RW.{{$client->rw}}</div>
                <div style="font-size: 15px;">Pemakaian <span class="fw-bolder">{{$bills->where('status', 'unpaid')->first()->meter_cubic}} m<sup>3</sup></span> ({{($bills->where('status', 'unpaid')->first()->usage->meter_cubic)-($bills->where('status', 'unpaid')->first()->meter_cubic)}}-{{$bills->where('status', 'unpaid')->first()->usage->meter_cubic}})</div>
                <div class="text-start fw-bolder mt-2">RINCIAN</div>
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
                <hr style="margin-top: 5px; margin-bottom: 5px;">
                <div class="row mt-1">
                    <div class="col-5">
                        <div class="text-start fw-bolder" style="font-size: 15px;">TOTAL</div>
                    </div>
                    <div class="col-7">
                        <div class="text-start fw-bolder" style="font-size: 15px;">= Rp. {{number_format($sumTotal,2,',','.')}}</div>
                    </div>
                </div>
                <div style="font-size: 7.5px;">
                    Kertas ini merupakan alat bukti sah pembayaran jika sudah ditempel tanda tangan petugas.
                    Mohon dicek ulang meter air, jika ada ketidak sesuaian hubungi <span class="fw-bolder">PENGURUS</span> (bukan loket)
                </div>
                <hr style="margin-top: 5px; margin-bottom: 5px;">
                <div>
                    <div class="text-center">Cek tagihan anda di</div>
                    <div class="text-center fw-bolder">https://hipamklampok.com</div>
                </div>
            </div>
        </div>

        <button onclick="window.print()" class="btn btn-primary mt-5 no-print">Print</button>
        <a href="{{route('transaction.index')}}" class="btn btn-outline-primary mt-5 no-print">Kembali</a>
    </div>
    <!-- Core -->
    <script src="{{asset('vendor/@popperjs/core/dist/umd/popper.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>

    <!-- Vendor JS -->
    <script src="{{asset('vendor/onscreen/dist/on-screen.umd.min.js')}}"></script>

    <!-- FA Icon -->
    <script src="https://kit.fontawesome.com/8482c12eb4.js" crossorigin="anonymous"></script>


    <script>
        window.onload = window.print();
    </script>
    @yield('customJS')
</body>

</html>