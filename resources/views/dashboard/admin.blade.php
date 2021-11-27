@extends('layouts.app')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Dashboard</h1>
            <p class="mb-0">Selamat datang {{auth()->user()->name}}!</p>
        </div>
    </div>
    <div class="d-flex flex-column align-items-center justify-content-center m-5">
        <h1 id="time" style="font-size: 10vw"></h1>
        <h1 style="font-size: 2vw;">{{$date->isoFormat('dddd, DD-MMMM-YYYY')}}</h1>
    </div>
</div>
@endsection

@section('customJS')
<script>
    startTime = () => {
        const today = new Date();
        let h = today.getHours();
        let m = today.getMinutes();
        let s = today.getSeconds();
        h = checkTime(h);
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('time').innerHTML = h + ":" + m + ":" + s;
        setTimeout(startTime, 1000);
    }
    checkTime = (i) => {
        if (i < 10) {
            i = "0" + i
        }; // add zero in front of numbers < 10
        return i;
    }
    window.onload = startTime;
</script>
@endsection