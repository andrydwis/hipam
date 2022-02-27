@extends('layouts.app')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">User</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Daftar User</h1>
            <p class="mb-0">Menampilkan daftar semua user pada sistem</p>
        </div>
    </div>
</div>
@include('layouts.alert')
<div class="card">
    @role('superadmin')
    <div class="card-header">
        <a href="{{route('user.create')}}" class="btn btn-primary">Tambah User</a>
    </div>
    @endrole
    <div class="card-body">
        <div class="table-responsive py-4">
            <table class="table table-hover" id="datatable">
                <thead class="thead-light">
                    <tr>
                        <th>Nama</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>Menu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        @if($user->getRoleNames()->first() == 'admin')
                        <td><span class="badge bg-primary">Kasir</span></td>
                        @elseif($user->getRoleNames()->first() == 'officer')
                        <td><span class="badge bg-primary">Petugas Kontrol Air</span></td>
                        @elseif($user->getRoleNames()->first() == 'technician')
                        <td><span class="badge bg-primary">Teknisi Air</span></td>
                        @else
                        <td><span class="badge bg-primary">{{$user->getRoleNames()->first()}}</span></td>
                        @endif
                        <td>{{$user->email}}</td>
                        <td>
                            @role('superadmin')
                            <form action="{{route('user.destroy', [$user])}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-primary">Hapus</button>
                                <a href="{{route('user.show', [$user])}}" class="btn btn-sm btn-primary">Detail</a>
                            </form>
                            @endrole
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('customCSS')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />
@endsection

@section('customJS')
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.22/i18n/Indonesian.json"
            }
        });
    });
</script>
@endsection