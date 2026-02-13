@extends('layouts.app')

@section('content')
<div class="container-fluid" style="padding-top: 10px;">
    @if(!$siswa)
        <div class="card shadow mb-4">
            <div class="card-body">
                <h5>Login Siswa</h5>
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="form-group">
                        <label>Nama Pengguna atau NIS</label>
                        <input name="identifier" class="form-control" value="{{ old('nis') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button class="btn btn-primary">Masuk</button>
                </form>
                <small class="text-muted d-block mt-2">Gunakan username/NIS dan password yang diberikan. Jika lupa, hubungi admin.</small>
            </div>
        </div>
    @else
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Halo, {{ $siswa->nama }}</h1>
            <small class="text-muted">Selamat datang di dashboard aspirasi Anda</small>
        </div>
        <div class="d-flex">
            <a href="{{ route('siswa.create-aspirasi') }}" class="btn btn-primary mr-2">Input Aspirasi</a>
            <a href="{{ route('siswa.history') }}" class="btn btn-outline-secondary">Riwayat Pengaduan</a>
        </div>
    </div>

    <style>
        /* Local styles for nicer stat cards */
        .stat-card { transition: transform .12s ease, box-shadow .12s ease; }
        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 6px 18px rgba(0,0,0,0.08); }
        .stat-icon { width:56px; height:56px; display:flex; align-items:center; justify-content:center; border-radius:8px; }
        .stat-number { font-size:1.5rem; font-weight:700; }
        .stat-label { font-size:0.75rem; letter-spacing:0.6px; }
    </style>

    <div class="row">
        <div class="col-md-4 mb-4">
            <a href="{{ route('siswa.history') }}" class="text-decoration-none">
                <div class="card stat-card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="mr-3">
                            <div class="stat-icon bg-primary text-white">
                                <i class="fas fa-comments fa-lg"></i>
                            </div>
                        </div>
                        <div>
                            <div class="stat-label text-uppercase text-primary">Pengaduan Masuk</div>
                            <div class="stat-number text-gray-800">{{ number_format($total) }}</div>
                            <div class="text-muted small">Total aspirasi yang Anda kirim</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-4">
            <a href="{{ route('siswa.history') . '?status=Dalam Proses' }}" class="text-decoration-none">
                <div class="card stat-card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="mr-3">
                            <div class="stat-icon bg-warning text-white">
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                        </div>
                        <div>
                            <div class="stat-label text-uppercase text-warning">Dalam Proses</div>
                            <div class="stat-number text-gray-800">{{ number_format($proses) }}</div>
                            <div class="text-muted small">Pengaduan yang sedang ditindaklanjuti</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-4">
            <a href="{{ route('siswa.history') . '?status=Selesai' }}" class="text-decoration-none">
                <div class="card stat-card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="mr-3">
                            <div class="stat-icon bg-success text-white">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                        <div>
                            <div class="stat-label text-uppercase text-success">Selesai</div>
                            <div class="stat-number text-gray-800">{{ number_format($selesai) }}</div>
                            <div class="text-muted small">Pengaduan yang telah selesai</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    @endif

    {{-- Recent reports removed as requested --}}

</div>
@endsection
