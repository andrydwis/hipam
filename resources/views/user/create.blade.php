@extends('layouts.app')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('user.index')}}">User</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Tambah User</h1>
            <p class="mb-0">Menambah user ke dalam sistem</p>
        </div>
    </div>
</div>
<div class="card mb-5">
    <div class="card-body">
        <h5 class="h5 mb-4">Informasi umum</h5>
        <form action="{{route('user.store')}}" method="post">
            @csrf
            <div class="mb-4">
                <label for="name">Nama</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="nama lengkap" value="{{old('name')}}">
                @error('name')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="example@gmail.com" value="{{old('email')}}">
                @error('email')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="role">Role</label>
                <select name="role" class="form-control @error('role') is-invalid @enderror">
                    <option value="" @if(old('role') == null) selected @endif  disabled>Pilih Role</option>
                    <option value="superadmin" @if(old('role') == 'superadmin') selected @endif>Super Admin</option>
                    <option value="admin" @if(old('role') == 'admin') selected @endif>Admin</option>
                    <option value="officer" @if(old('role') == 'officer') selected @endif>Petugas</option>
                </select>
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
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection