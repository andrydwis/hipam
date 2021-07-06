@extends('layouts.app')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('client.index')}}">Pelanggan</a></li>
            <li class="breadcrumb-item active">Import Pelanggan</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Import Pelanggan</h1>
            <p class="mb-0">Menambah pelanggan baru ke dalam sistem dari file anda</p>
        </div>
    </div>
</div>
@if(session('failures'))
<div class="card bg-danger mb-3">
    <div class="card-body text-white">
        @foreach(session('failures') as $failure)
        <p> pada baris {{$failure->row()}}, terjadi kesalahan :</p>
        <ul>
            @foreach($failure->errors() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
        @endforeach
    </div>
</div>
@endif
<div class="card mb-5">
    <div class="card-body">
        <h5 class="h5 mb-4">Import</h5>
        <form action="{{route('client.import-process')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="file">File</label>
                <input type="file" name="file" class="form-control @error('file') is-invalid @enderror">
                @error('file')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-4">
                <button type="submit" class="btn btn-primary">Import</button>
                <button type="reset" class="btn btn-outline-primary">Reset</button>
            </div>
        </form>
    </div>
</div>
@endsection