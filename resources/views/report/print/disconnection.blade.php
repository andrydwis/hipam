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

            /* @page {
                size: 21.6cm 7.1cm;
            } */
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
            <div class="col-6 p-3" style="border-right: 0.5px dashed">
                <div class="text-center fw-bolder">HIPAM SWADAYA RW.02 DESA KLAMPOK</div>
                <hr class="m-0">
                <div class="text-center fw-bolder mb-3">SURAT PEMUTUSAN</div>
                <div class="d-flex justify-content-between">
                    <div>No:</div>
                    <div>Klampok, {{$date}}</div>
                </div>
                <br>
                <div class="text-start">
                    Kepada YTH, <span class="fw-bolder">{{$client->client_id}} - {{$client->name}} - RT {{$client->rt}} RW {{$client->rw}}</span>
                </div>
                <br>
                <div class="text-start">
                    <span class="fw-bolder">Teguran keterlambatan 3 bulan</span> yang belum diselesaikan, maka dilakukan <span class="fw-bolder">PEMUTUSAN SEMENTARA oleh Petugas</span>.
                    Untuk penyambungan mohon menyelesaikan pembayaran serta membayar denda Rp. 100.000,00 (seratus ribu rupiah) dan membuat surat bermaterai.
                </div>
                <br>
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
                    <div class="row">
                        <div class="col-5">
                            <div class="text-start">Denda Terlambat</div>
                        </div>
                        <div class="col-7">
                            <div class="text-start">= Rp. {{number_format($fine,2,',','.')}}</div>
                        </div>
                    </div>
                </ul>
                @php
                $sumTotal = $bills->sum('total')+$fine;
                @endphp
                <hr>
                <div class="row">
                    <div class="col-5">
                        <div class="text-start fw-bolder">TOTAL</div>
                    </div>
                    <div class="col-7">
                        <div class="text-start fw-bolder">= Rp. {{number_format($sumTotal,2,',','.')}}</div>
                    </div>
                </div>
                <div class="text-start mt-2" style="font-size: 7.5px;">
                    Apabila terdapat <span class="fw-bolder">ketidaksesuaian mohon mengkonfirmasi langsung kepada ketua/sekretaris,</span>
                    mohon selesaikan <span class="fw-bolder">sebelum tanggal {{$expected_at}}</span> untuk menghindari pemutusan.
                </div>
                <br>
                <br>
                <div class="d-flex justify-content-between">
                    <div>
                        PENGGUNA
                        <br>
                        <br>
                        [materai]
                    </div>
                    <div>TTD KETUA</div>
                </div>
            </div>
            <div class="col-6 p-3">
                <div class="text-center fw-bolder">HIPAM SWADAYA RW.02 DESA KLAMPOK</div>
                <hr class="m-0">
                <div class="text-center fw-bolder mb-3">SURAT PEMUTUSAN</div>
                <div class="d-flex justify-content-between">
                    <div>No:</div>
                    <div>Klampok, {{$date}}</div>
                </div>
                <br>
                <div class="text-start">
                    Kepada YTH, <span class="fw-bolder">{{$client->client_id}} - {{$client->name}} - RT {{$client->rt}} RW {{$client->rw}}</span>
                </div>
                <br>
                <div class="text-start">
                    <span class="fw-bolder">Teguran keterlambatan 3 bulan</span> yang belum diselesaikan, maka dilakukan <span class="fw-bolder">PEMUTUSAN SEMENTARA oleh Petugas</span>.
                    Untuk penyambungan mohon menyelesaikan pembayaran serta membayar denda Rp. 100.000,00 (seratus ribu rupiah) dan membuat surat bermaterai.
                </div>
                <br>
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
                    <div class="row">
                        <div class="col-5">
                            <div class="text-start">Denda Terlambat</div>
                        </div>
                        <div class="col-7">
                            <div class="text-start">= Rp. {{number_format($fine,2,',','.')}}</div>
                        </div>
                    </div>
                </ul>
                @php
                $sumTotal = $bills->sum('total')+$fine;
                @endphp
                <hr>
                <div class="row">
                    <div class="col-5">
                        <div class="text-start fw-bolder">TOTAL</div>
                    </div>
                    <div class="col-7">
                        <div class="text-start fw-bolder">= Rp. {{number_format($sumTotal,2,',','.')}}</div>
                    </div>
                </div>
                <div class="text-start mt-2" style="font-size: 7.5px;">
                    Apabila terdapat <span class="fw-bolder">ketidaksesuaian mohon mengkonfirmasi langsung kepada ketua/sekretaris,</span>
                    mohon selesaikan <span class="fw-bolder">sebelum tanggal {{$expected_at}}</span> untuk menghindari pemutusan.
                </div>
                <br>
                <br>
                <div class="d-flex justify-content-between">
                    <div>
                        PENGGUNA
                        <br>
                        <br>
                        [materai]
                    </div>
                    <div>TTD KETUA</div>
                </div>
            </div>
        </div>

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