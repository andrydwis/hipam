@extends('layouts.app')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('client.index')}}">Pelanggan</a></li>
            <li class="breadcrumb-item active">Tambah Pelanggan</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Tambah Pelanggan</h1>
            <p class="mb-0">Menambah pelanggan baru ke dalam sistem</p>
        </div>
    </div>
</div>
<div class="card mb-5">
    <div class="card-body">
        <h5 class="h5 mb-4">Tambah</h5>
        <form action="{{route('client.store')}}" method="post">
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
                <label for="rt">RT</label>
                <input type="text" name="rt" class="form-control @error('rt') is-invalid @enderror" placeholder="RT" value="{{old('rt')}}">
                @error('rt')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="rw">RW</label>
                <input type="text" name="rw" class="form-control @error('rw') is-invalid @enderror" placeholder="RW" value="{{old('rw')}}">
                @error('rw')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-outline-primary">Reset</button>
            </div>
        </form>
    </div>
</div>
@endsection