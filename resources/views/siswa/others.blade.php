@extends('layouts.app')

@section('content')
<div class="container-fluid" style="padding-top:10px;">
	<div class="d-flex align-items-center justify-content-between mb-3">
		<div>
			<h1 class="h3 mb-0 text-gray-800">Aspirasi dari Siswa Lain</h1>
			<small class="text-muted">Daftar lengkap aduan yang dikirim siswa lain.</small>
		</div>
		<div>
			<a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary">Kembali</a>
		</div>
	</div>

	<div class="card mb-3">
		<div class="card-header bg-white font-weight-bold text-primary">Filter Aspirasi</div>
		<div class="card-body">
			<form method="GET" action="{{ route('siswa.pengaduan.lain') }}" class="form-inline">
				<div class="form-group mr-3">
					<label class="mr-2">Kategori:</label>
					<select name="kategori" class="form-control">
						<option value="">Semua Kategori</option>
						@foreach($kategoris ?? [] as $kat)
							<option value="{{ $kat->id }}" {{ (string)($filterKategori ?? '') === (string)$kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group mr-3">
					<label class="mr-2">Status:</label>
					<select name="status" class="form-control">
						<option value="">Semua Status</option>
						<option value="Menunggu" {{ ($filterStatus ?? '') === 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
						<option value="Dalam Proses" {{ ($filterStatus ?? '') === 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
						<option value="Selesai" {{ ($filterStatus ?? '') === 'Selesai' ? 'selected' : '' }}>Selesai</option>
					</select>
				</div>
				<div class="form-group mr-3">
					<label class="mr-2">Bulan:</label>
					<select name="bulan" class="form-control">
						<option value="">Semua Bulan</option>
						@for($m=1;$m<=12;$m++)
							@php $val = str_pad($m,2,'0',STR_PAD_LEFT); @endphp
							<option value="{{ $val }}" {{ ($filterBulan ?? '') === $val ? 'selected' : '' }}>{{ date('F', mktime(0,0,0,$m,1)) }}</option>
						@endfor
					</select>
				</div>
				<div class="form-group">
					<button class="btn btn-primary mr-2">Filter</button>
					<a href="{{ route('siswa.pengaduan.lain') }}" class="btn btn-secondary">Reset</a>
				</div>
			</form>
		</div>
	</div>

	<div class="card shadow">
		<div class="card-header">
			<i class="fas fa-list mr-2"></i> Daftar Aspirasi dari Siswa Lain <small class="text-muted">(Total: {{ $total ?? $pengaduans->total() }})</small>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered table-hover mb-0">
					<thead class="thead-light">
						<tr>
							<th style="width:60px">No</th>
							<th>Pelapor</th>
							<th>Kategori</th>
							<th>Keterangan</th>
							<th>Lokasi</th>
							<th style="width:140px">Status</th>
							<th style="width:140px">Tanggal</th>
							<th style="width:90px">Aksi</th>
						</tr>
					</thead>
					<tbody>
						@forelse($pengaduans as $i => $p)
						<tr>
							<td>{{ $pengaduans->firstItem() + $i }}</td>
							<td>
								<strong>{{ $p->pelapor }}</strong>
							</td>
							<td>{{ $p->kategori?->nama_kategori ?? '-' }}</td>
							<td>{{ Str::limit(strip_tags($p->deskripsi), 80) }}</td>
							<td>{{ $p->lokasi ?? '-' }}</td>
							<td>
								@if($p->status === 'Selesai')
									<span class="badge badge-success">Selesai</span>
								@elseif($p->status === 'Dalam Proses')
									<span class="badge badge-warning">Dalam Proses</span>
								@else
									<span class="badge badge-warning">Menunggu</span>
								@endif
							</td>
							<td>
								<div>{{ $p->created_at ? $p->created_at->format('d/m/Y') : '-' }}</div>
								<div class="text-muted small">{{ $p->created_at ? $p->created_at->diffForHumans() : '' }}</div>
							</td>
							<td class="text-center">
								<a href="{{ route('pengaduan.show', $p) }}" class="btn btn-sm btn-info" title="Lihat Detail">
									<i class="fas fa-eye"></i>
								</a>
							</td>
						</tr>
						@empty
						<tr>
							<td colspan="8" class="text-center">Belum ada pengaduan oleh pengguna lain.</td>
						</tr>
						@endforelse
					</tbody>
				</table>
			</div>

			<div class="mt-3 d-flex justify-content-center">
				{{ $pengaduans->links() }}
			</div>
		</div>
	</div>

</div>
@endsection
