@extends('layouts.app')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('usage.index')}}">Pemakaian</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Edit Pemakaian</h1>
            <p class="mb-0">Mengedit pemakaian dari pelanggan yang dipilih</p>
        </div>
    </div>
</div>
<div class="card mb-5">
    <div class="card-body">
        <h5 class="h5 mb-4">Edit</h5>
        <form action="{{route('usage.update', [$client, $month, $year])}}" method="post">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label for="nomor_pelanggan">Nomor Pelanggan</label>
                <input type="number" name="nomor_pelanggan" class="form-control @error('nomor_pelanggan') is-invalid @enderror" placeholder="nomor pelanggan" value="{{old('nomor_pelanggan') ?? $client->client_id}}" readonly>
                @error('nomor_pelanggan')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="nama">Nama</label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="nama pelanggan" value="{{old('nama') ?? $client->name}}" readonly>
                @error('nama')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-4">
                <div class="row">
                    <div class="col">
                        <label for="bulan">Bulan</label>
                        <input type="text" name="bulan" class="form-control @error('bulan') is-invalid @enderror" placeholder="bulan" value="{{$month}}" readonly>
                        @error('bulan')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="col">
                        <label for="tahun">Tahun</label>
                        <input type="number" name="tahun" class="form-control @error('tahun') is-invalid @enderror" placeholder="tahun" value="{{$year}}" readonly>
                        @error('tahun')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <label for="meter_kubik">Meter Kubik</label>
                <input type="number" step=".01" name="meter_kubik" class="form-control @error('meter_kubik') is-invalid @enderror" placeholder="jumlah pemakaian" value="{{old('meter_kubik') ?? $client->usages->first()->meter_cubic}}">
                @error('meter_kubik')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <input type="hidden" name="usage_id" value="{{$client->usages->first()->id}}">
            <div class="mb-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-outline-primary">Reset</button>
            </div>
        </form>
    </div>
</div>
@endsection