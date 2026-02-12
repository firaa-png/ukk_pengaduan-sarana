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
    <h1 class="h3 mb-4 text-gray-800">Riwayat Pengaduan</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Pengaduan Selesai</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Opsi Tabel:</div>
                    <a class="dropdown-item" href="#" onclick="$('#dataTable').DataTable().search('').draw();">Clear Filter</a>
                    <a class="dropdown-item" href="#" onclick="$('#dataTable').DataTable().page.len(25).draw();">Tampilkan 25</a>
                    <a class="dropdown-item" href="#" onclick="$('#dataTable').DataTable().page.len(50).draw();">Tampilkan 50</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center text-gray-800">No</th>
                            <th class="text-center text-gray-800">Kategori</th>
                            <th class="text-center text-gray-800">Isi Pengaduan</th>
                            <th class="text-center text-gray-800">Tanggal</th>
                            <th class="text-center text-gray-800">Status</th>
                            <th class="text-center text-gray-800">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengaduans->where('status','Selesai') as $p)
                        <tr>
                            <td class="text-center text-gray-900">{{ $loop->iteration }}</td>
                            <td class="text-gray-900">{{ $p->kategori->nama_kategori }}</td>
                            <td class="text-gray-900">{{ Str::limit($p->deskripsi, 100) }}</td>
                            <td class="text-center text-gray-900">{{ $p->created_at->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <span class="badge {{ $p->status == 'Selesai' ? 'badge-success' : ($p->status == 'Dalam Proses' ? 'badge-warning' : 'badge-info') }}">
                                    {{ $p->status }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('pengaduan.show', $p) }}" class="btn btn-sm btn-info mr-1" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    @if(session('siswa_id') && $p->siswa_id == session('siswa_id'))
                                        {{-- Allow edit & delete only for the owner and only when not finished --}}
                                        @if($p->status !== 'Selesai')
                                            <a href="{{ route('siswa.pengaduan.edit', $p) }}" class="btn btn-sm btn-primary mr-1" title="Edit Pengaduan">
                                                <i class="fas fa-pen"></i>
                                            </a>

                                            <form action="{{ route('siswa.pengaduan.destroy', $p) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus Pengaduan" onclick="return confirm('Yakin ingin menghapus pengaduan ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            {{-- finished items cannot be deleted -- show disabled delete button (kept red per request) --}}
                                            <button class="btn btn-sm btn-danger" disabled title="Pengaduan selesai, tidak dapat dihapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection