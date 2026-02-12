@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="mb-0">Profil Siswa</h5>
                            <small class="text-muted">Informasi akun dan data diri</small>
                        </div>
                        <div class="text-right">
                            @if(Route::has('siswa.profile.edit'))
                                <a href="{{ route('siswa.profile.edit', $siswa?->id) }}" class="btn btn-sm btn-outline-primary mr-2">Edit Profil</a>
                            @endif
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-sm btn-danger">Keluar</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        </div>
                    </div>

                    @if($siswa)
                        @php
                            $initials = collect(explode(' ', $siswa->nama))->map(function($p){ return strtoupper(substr($p,0,1)); })->take(2)->implode('');
                        @endphp

                        <div class="row">
                            <div class="col-md-4 text-center">
                                @if($siswa->avatar)
                                    <img src="{{ asset($siswa->avatar) }}" alt="avatar" class="rounded-circle mx-auto mb-3" style="width:110px;height:110px;object-fit:cover;">
                                @else
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width:110px;height:110px;font-size:32px;">
                                        {{ $initials }}
                                    </div>
                                @endif
                                <h5 class="mb-0">{{ $siswa->nama }}</h5>
                                <div class="text-muted small">{{ $siswa->nis }} • {{ $siswa->kelas }}</div>
                            </div>
                            <div class="col-md-8">
                                <dl class="row">
                                    <dt class="col-sm-4 text-muted">NIS</dt>
                                    <dd class="col-sm-8">{{ $siswa->nis }}</dd>

                                    <dt class="col-sm-4 text-muted">Nama</dt>
                                    <dd class="col-sm-8">{{ $siswa->nama }}</dd>

                                    <dt class="col-sm-4 text-muted">Kelas</dt>
                                    <dd class="col-sm-8">{{ $siswa->kelas }}</dd>

                                    <dt class="col-sm-4 text-muted">Jurusan</dt>
                                    <dd class="col-sm-8">{{ $siswa->jurusan }}</dd>

                                    <dt class="col-sm-4 text-muted">Username</dt>
                                    <dd class="col-sm-8">{{ $siswa->username ?? '-' }}</dd>

                                    <dt class="col-sm-4 text-muted">Dibuat</dt>
                                    <dd class="col-sm-8">{{ $siswa->created_at ? $siswa->created_at->format('d M Y') : '-' }}</dd>
                                </dl>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">Data siswa tidak ditemukan.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
