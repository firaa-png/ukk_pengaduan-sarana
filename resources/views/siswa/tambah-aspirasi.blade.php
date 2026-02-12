@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @php $siswa = session('siswa_id') ? App\Models\Siswa::find(session('siswa_id')) : null; @endphp
    @if(!$siswa)
        <div class="card shadow mb-4">
            <div class="card-body">
                <h5>Login Siswa</h5>
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="form-group">
                        <label>Username</label>
                        <input name="identifier" class="form-control" value="{{ old('identifier') }}">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <button class="btn btn-primary">Masuk</button>
                </form>
                <small class="text-muted d-block mt-2">Masuk menggunakan username/NIS dan password yang diberikan. Jika lupa, hubungi admin.</small>
            </div>
        </div>
    @else
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h1 class="h3 mb-0 text-gray-800">Tambah Aspirasi</h1>
        <a href="{{ route('siswa.create-aspirasi') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('siswa.store-aspirasi') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="kategori_id">Kategori</label>
                    <select name="kategori_id" id="kategori_id" class="form-control">
                        @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="lokasi">Lokasi</label>
                        <input type="text" name="lokasi" id="lokasi" class="form-control" value="{{ old('lokasi') }}" placeholder="Contoh: Ruang Kelas">
                </div>
                <div class="form-group">
                    <label for="deskripsi">Isi Pengaduan</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="5">{{ old('deskripsi') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="gambar">Lampiran Gambar </label>
                        <input type="file" name="gambar" id="gambar" class="form-control-file">
                        <div id="preview" class="mt-2" style="display:none;">
                            <img id="previewImg" src="#" alt="Preview" style="max-width:200px; max-height:200px; object-fit:cover;" />
                        </div>
                </div>
                <button class="btn btn-primary">Kirim Aspirasi</button>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    var input = document.getElementById('gambar');
    var preview = document.getElementById('preview');
    var previewImg = document.getElementById('previewImg');
    if (input) {
        input.addEventListener('change', function(){
            var file = this.files && this.files[0];
            if (!file) {
                preview.style.display = 'none';
                previewImg.src = '#';
                return;
            }
            var reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        });
    }
});
</script>
@endpush
