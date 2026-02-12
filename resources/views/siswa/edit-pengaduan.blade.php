@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Pengaduan</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('siswa.pengaduan.update', $pengaduan) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="kategori_id">Kategori</label>
                    <select class="form-control" id="kategori_id" name="kategori_id" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ $pengaduan->kategori_id == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required>{{ $pengaduan->deskripsi }}</textarea>
                </div>
                <div class="form-group">
                    <label for="lokasi">Lokasi (opsional)</label>
                    <input type="text" class="form-control" id="lokasi" name="lokasi" value="{{ $pengaduan->lokasi }}">
                </div>
                <div class="form-group">
                    <label for="gambar">Gambar (opsional)</label>
                    <input type="file" class="form-control" id="gambar" name="gambar">
                    @if($pengaduan->gambar)
                        @php $imgPath = public_path($pengaduan->gambar); @endphp
                        @if(file_exists($imgPath))
                            <div class="mt-2"><img src="{{ asset($pengaduan->gambar) }}" style="max-height:200px; object-fit:contain;" /></div>
                        @else
                            <div class="mt-2 alert alert-warning">Gambar tidak ditemukan di server.</div>
                        @endif
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('siswa.create-aspirasi') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
