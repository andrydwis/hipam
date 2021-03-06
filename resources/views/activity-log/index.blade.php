@extends('layouts.app')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">Log Aktifitas</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Log Aktifitas</h1>
            <p class="mb-0">Tampilkan catatan terbaru dari semua aktivitas pengguna di sistem</p>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive py-4">
            <table class="table table-hover" id="datatable">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Deskripsi</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td>{{$log->causer->name}}</td>
                        <td><span class="badge bg-primary">{{$log->causer->getRoleNames()->first()}}</span></td>
                        <td>{{$log->description}}</td>
                        <td>{{$log->created_at->isoFormat('dddd, DD-MM-YYYY hh:mm A')}} <span class="badge bg-primary">{{$log->created_at->diffForHumans()}}</span></td>
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