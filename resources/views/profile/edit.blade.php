@extends('layouts.app')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('profile.show')}}">Profil</a></li>
            <li class="breadcrumb-item active">Edit Profil</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Edit Profil</h1>
            <p class="mb-0">Edit profil anda</p>
        </div>
    </div>
</div>
<div class="card mb-5">
    <div class="card-body">
        <h5 class="h5 mb-4">Informasi umum</h5>
        <form action="{{route('profile.update')}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label for="name">Nama</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="fullname" value="{{old('name') ?? $user->name}}">
                @error('name')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="example@gmail.com" value="{{old('email') ?? $user->email}}">
                @error('email')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="password">
                @error('password')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="password confirmation">
            </div>
            <div class="mb-4">
                <label for="photo">Foto</label>
                <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">
                @error('photo')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{route('profile.reset-photo')}}" class="btn btn-outline-primary">Reset Foto</a>
            </div>
        </form>
    </div>
</div>
@endsection