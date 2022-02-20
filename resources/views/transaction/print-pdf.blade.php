<!DOCTYPE html>
<html lang="en">
<head>
    <link type="text/css" href="css/volt.css" rel="stylesheet">
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
    </div>
</body>

</html>