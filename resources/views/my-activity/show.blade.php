@extends('layouts.app')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('my-activity.index')}}">Kegiatan Teknisi</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Detail Kegiatan Teknisi</h1>
            <p class="mb-0">Detail data kegiatan teknisi</p>
        </div>
    </div>
</div>
@include('layouts.alert')
<div class="card">
    <div class="card-header">
        <div class="form-group row">
            <label for="tanggal_kegiatan" class="col-6 col-sm-2 col-form-label">Tanggal Kegiatan</label>
            <div class="col-6 col-sm-10 col-form-label">
                <p>{{$activity->created_at->format('Y-m-d')}}</p>
            </div>
        </div>
        <div class="form-group row mt-3">
            <label for="jenis_kegiatan" class="col-6 col-sm-2 col-form-label">Jenis Kegiatan</label>
            <div class="col-6 col-sm-10 col-form-label">
                <p>{{$activity->activity_type}}</p>
            </div>
        </div>
    </div>
    @if($activity->activity_type != 'Pasang baru' && $activity->activity_type != 'Perbaikan saluran pengguna')
    <div class="card-body">
        <div class="form-group row">
            <label for="jenis_pekerjaan" class="col-6 col-sm-2 col-form-label">Jenis Pekerjaan</label>
            <div class="col-6 col-sm-10 col-form-label">
                <p>{{$activity->job_type}}</p>
            </div>
        </div>
        @if($activity->photo)
        <div class="form-group row mt-3">
            <label for="foto[]" class="col-sm-2 col-form-label">Foto</label>
            @php
            $photos = json_decode($activity->photo);
            @endphp
            <div class="col-sm-10 d-flex flex-wrap gap-3">
                @foreach($photos as $photo)
                <img src="{{asset('storage/'.$photo)}}" alt="Foto" class="img-thumbnail" style="object-fit: cover;" width="250" height="250">
                @endforeach
            </div>
        </div>
        @endif
        <textarea name="catatan" class="form-control mt-3" rows="5" placeholder="Tambahkan catatan" readonly>{{$activity->description}}</textarea>
        <div class="d-flex mt-3 justify-content-end gap-3">
            <a href="{{route('my-activity.index')}}" class="btn btn-outline-primary">Kembali</a>
        </div>
    </div>
    @endif
    @if($activity->activity_type == 'Pasang baru' || $activity->activity_type == 'Perbaikan saluran pengguna')
    <div class="card-body">
        <div class="form-group row">
            <label for="jenis_pekerjaan" class="col-6 col-sm-2 col-form-label">Jenis Pekerjaan</label>
            <div class="col-6 col-sm-10 col-form-label">
                <p>{{$activity->job_type}}</p>
            </div>
        </div>
        <div class="form-group row mt-3">
            <label for="no_surat_tugas" class="col-6 col-sm-2 col-form-label">No Surat Tugas</label>
            <div class="col-6 col-sm-10 col-form-label">
                <p>{{$activity->assignment_letter_number}}</p>
            </div>
        </div>
        <div class="form-group row mt-3">
            <label for="nama_pelanggan" class="col-6 col-sm-2 col-form-label">Nama Pelanggan</label>
            <div class="col-6 col-sm-10 col-form-label">
                <p>{{$activity->name}}</p>
            </div>
        </div>
        <div class="form-group row mt-3">
            <label for="rt_rw" class="col-6 col-sm-2 col-form-label">RT / RW</label>
            <div class="col-6 col-sm-10 col-form-label">
                <p>{{$activity->rt_rw}}</p>
            </div>
        </div>
        @if($activity->photo)
        <div class="form-group row mt-3">
            <label for="foto[]" class="col-sm-2 col-form-label">Foto</label>
            @php
            $photos = json_decode($activity->photo);
            @endphp
            <div class="col-sm-10 d-flex flex-wrap gap-3">
                @foreach($photos as $photo)
                <img src="{{asset('storage/'.$photo)}}" alt="Foto" class="img-thumbnail" style="object-fit: cover;" width="250" height="250">
                @endforeach
            </div>
        </div>
        @endif
        <textarea name="catatan" class="form-control mt-3" rows="5" placeholder="Tambahkan catatan" readonly>{{$activity->description}}</textarea>
        <div class="d-flex mt-3 justify-content-end gap-3">
            <a href="{{route('my-activity.index')}}" class="btn btn-outline-primary">Kembali</a>
        </div>
    </div>
    @endif
</div>
</div>
@endsection