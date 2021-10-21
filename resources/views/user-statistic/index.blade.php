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
            <h1 class="h4">Cek Tagihan HIPAM: Desa Klampok</h1>
            <p class="mb-0">Dimohon untuk masukkan nomor pelanggan dan nama, jika ada ketidaksesuaian hubungi pengurus (bukan kasir)</p>
        </div>
    </div>
</div>
@include('layouts.alert')
<div class="card">
    <div class="card-body">
        <form action="{{route('user-statistic.search')}}" method="post">
            @csrf
            <div class="mb-4">
                <label for="nomor_pelanggan">Nomor Pelanggan</label>
                <input type="number" name="nomor_pelanggan" class="form-control @error('nomor_pelanggan') is-invalid @enderror" placeholder="nomor pelanggan" value="{{old('nomor_pelanggan')}}">
                @error('nomor_pelanggan')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="nama">Nama</label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="nama pelanggan" value="{{old('nama')}}">
                @error('nama')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-4">
                <button type="submit" class="btn btn-primary">Cari</button>
                <button type="reset" class="btn btn-outline-primary">Reset</button>
            </div>
        </form>
    </div>
</div>
@endsection