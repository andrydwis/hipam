@extends('layouts.app')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">Kegiatan Teknisi</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Kegiatan Teknisi</h1>
            <p class="mb-0">Memasukkan data sesuai dengan surat perintah kerja dari atasan</p>
        </div>
    </div>
</div>
@include('layouts.alert')
<div class="card">
    <form action="{{route('my-activity.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card-header">
            <div class="form-group row">
                <label for="tanggal_kegiatan" class="col-sm-2 col-form-label">Tanggal Kegiatan</label>
                <div class="col-sm-10">
                    <input type="date" name="tanggal_kegiatan" class="form-control-plaintext px-3 @error('tanggal_kegiatan') is-invalid @enderror" placeholder="Tanggal Kegiatan" value="{{$now->format('Y-m-d') ?? old('tanggal_kegiatan')}}" readonly>
                    @error('tanggal_kegiatan')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="form-group row mt-3">
                <label for="jenis_kegiatan" class="col-sm-2 col-form-label">Jenis Kegiatan</label>
                <div class="col-sm-10">
                    <select class="form-control @error('jenis_kegiatan') is-invalid @enderror" id="jenis_kegiatan" name="jenis_kegiatan" onChange="changeJenisKegiatan()">
                        <option selected disabled>Pilih Jenis Kegiatan</option>
                        <option value="Pasang baru">Pasang baru</option>
                        <option value="Perbaikan saluran pengguna">Perbaikan saluran pengguna</option>
                        <option value="Pemeliharaan jalur induk utama">Pemeliharaan jalur induk utama</option>
                        <option value="Pemeliharaan jalur sub induk utama">Pemeliharaan jalur sub induk utama</option>
                        <option value="Perbaikan jalur induk utama">Perbaikan jalur induk utama</option>
                        <option value="Perbaikan jalur sub induk utama">Perbaikan jalur sub induk utama</option>
                    </select>
                    @error('jenis_kegiatan')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
        @if($request->jenis_kegiatan != 'Pasang baru' && $request->jenis_kegiatan != 'Perbaikan saluran pengguna' && $request->jenis_kegiatan != null)
        <div class="card-body">
            <div class="form-group row">
                <label for="jenis_pekerjaan" class="col-sm-2 col-form-label">Jenis Pekerjaan</label>
                <div class="col-sm-10">
                    <select class="form-control @error('jenis_pekerjaan') is-invalid @enderror" name="jenis_pekerjaan">
                        <option selected disabled>Pilih Jenis Pekerjaan</option>
                        <option value="ringan" @if(old('jenis_pekerjaan')=='ringan' ) selected @endif>Ringan</option>
                        <option value="sedang" @if(old('jenis_pekerjaan')=='sedang' ) selected @endif>Sedang</option>
                        <option value="berat" @if(old('jenis_pekerjaan')=='berat' ) selected @endif>Berat</option>
                    </select>
                    @error('jenis_pekerjaan')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="form-group row mt-3">
                <label for="foto[]" class="col-sm-2 col-form-label">Foto</label>
                <div class="col-sm-10">
                    <input type="file" multiple name="foto[]" class="form-control @error('foto[]') is-invalid @enderror">
                    @error('foto[]')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </div>
            <textarea name="catatan" class="form-control mt-3" rows="5" placeholder="Tambahkan catatan">{{old('catatan')}}</textarea>
            <div class="d-flex mt-3 justify-content-end gap-3">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{route('my-activity.index')}}" class="btn btn-outline-primary">Batal</a>
            </div>
        </div>
        @endif
        @if($request->jenis_kegiatan == 'Pasang baru' || $request->jenis_kegiatan == 'Perbaikan saluran pengguna')
        <div class="card-body">
            <div class="form-group row">
                <label for="jenis_pekerjaan" class="col-sm-2 col-form-label">Jenis Pekerjaan</label>
                <div class="col-sm-10">
                    <select class="form-control @error('jenis_pekerjaan') is-invalid @enderror" name="jenis_pekerjaan">
                        <option selected disabled>Pilih Jenis Pekerjaan</option>
                        <option value="ringan" @if(old('jenis_pekerjaan')=='ringan' ) selected @endif>Ringan</option>
                        <option value="sedang" @if(old('jenis_pekerjaan')=='sedang' ) selected @endif>Sedang</option>
                        <option value="berat" @if(old('jenis_pekerjaan')=='berat' ) selected @endif>Berat</option>
                    </select>
                    @error('jenis_pekerjaan')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="form-group row mt-3">
                <label for="no_surat_tugas" class="col-sm-2 col-form-label">No Surat Tugas</label>
                <div class="col-sm-10">
                    <input type="text" name="no_surat_tugas" class="form-control @error('no_surat_tugas') is-invalid @enderror" placeholder="No Surat Tugas" value="{{old('no_surat_tugas')}}">
                    @error('no_surat_tugas')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="form-group row mt-3">
                <label for="nama_pelanggan" class="col-sm-2 col-form-label">Nama Pelanggan</label>
                <div class="col-sm-10">
                    <input type="text" name="nama_pelanggan" class="form-control @error('nama_pelanggan') is-invalid @enderror" placeholder="Nama Pelanggan" value="{{old('nama_pelanggan')}}">
                    @error('nama_pelanggan')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="form-group row mt-3">
                <label for="rt_rw" class="col-sm-2 col-form-label">RT / RW</label>
                <div class="col-sm-10">
                    <input type="text" name="rt_rw" class="form-control @error('rt_rw') is-invalid @enderror" placeholder="RT / RW" value="{{old('rt_rw')}}">
                    @error('rt_rw')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="form-group row mt-3">
                <label for="foto[]" class="col-sm-2 col-form-label">Foto</label>
                <div class="col-sm-10">
                    <input type="file" multiple name="foto[]" class="form-control @error('foto[]') is-invalid @enderror">
                    @error('foto[]')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </div>
            <textarea name="catatan" class="form-control mt-3" rows="5" placeholder="Tambahkan catatan">{{old('catatan')}}</textarea>
            <div class="d-flex mt-3 justify-content-end gap-3">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{route('my-activity.index')}}" class="btn btn-outline-primary">Batal</a>
            </div>
        </div>
        @endif
    </form>
</div>
</div>
@endsection

@section('customJS')
<script>
    changeJenisKegiatan = () => {
        let jenisKegiatan = document.getElementById("jenis_kegiatan").value
        let url = new URL(window.location.href);
        url.searchParams.set('jenis_kegiatan', jenisKegiatan);
        window.location.href = url;
    }
    setSelectedJenisKegiatan = () => {
        let url = new URL(window.location.href);
        let jenisKegiatan = url.searchParams.get('jenis_kegiatan');
        if (jenisKegiatan) {
            document.getElementById("jenis_kegiatan").value = jenisKegiatan;
        }
    }
    window.onload = setSelectedJenisKegiatan;
</script>
@endsection