<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>{{ config('app.name', 'Laravel') }} - Data Pengaduan</title>

	<!-- Custom fonts for this template-->
	<link href="{{ asset('sbadmin2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
	<link
		href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
		rel="stylesheet">

	<!-- Custom styles for this template-->
	<link href="{{ asset('sbadmin2/css/sb-admin-2.min.css') }}" rel="stylesheet">
    
	<style>
		/* Apply Poppins font to all elements */
		body, h1, h2, h3, h4, h5, h6, .navbar, .sidebar, .card, .table, .btn, input, select, textarea {
			font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
		}
        
		/* Page transition effects */
		.page-transition {
			opacity: 0;
			transition: opacity 0.3s ease-in-out;
		}
        
		.page-transition.fade-in {
			opacity: 1;
		}
        
		.page-transition.fade-out {
			opacity: 0;
		}
        
		/* Smooth scrolling */
		html {
			scroll-behavior: smooth;
		}
        
		/* Remove top spacing to eliminate gap */
		#content {
			margin-top: 0;
			padding-top: 0;
		}
	</style>

</head>

<body id="page-top">

	<!-- Page Wrapper -->
	<div id="wrapper">

		<!-- Sidebar -->
		<x-sidebar />
		<!-- End of Sidebar -->

		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">

			<!-- Main Content -->
			<div id="content">

				<!-- Topbar -->
				<x-topbar />
				<!-- End of Topbar -->

				<!-- Begin Page Content -->
				<div class="container-fluid">

					<!-- Page Heading -->
					<div class="d-sm-flex align-items-center justify-content-between mb-4">
						<h1 class="h3 mb-0 text-gray-800">Data Pengaduan</h1>
					</div>

					<!-- Content Row -->
					<div class="row">
						<div class="col-lg-12">
							<div class="card shadow mb-4">
								<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
									<h6 class="m-0 font-weight-bold text-primary">Data Pengaduan</h6>
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
									<!-- Filter Form -->
									@php $daftarRoute = auth()->check() ? route('admin.daftar-pengaduan') : route('daftar-pengaduan'); @endphp
									<form method="GET" action="{{ $daftarRoute }}" class="mb-4">
										<!-- Baris 1: Filter Tanggal dan Status -->
										<div class="row">
											<div class="col-md-3">
												<div class="form-group">
													<label for="tanggal">Tanggal</label>
													<input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ request('tanggal') }}">
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="status">Pilih Status</label>
													<select class="form-control" id="status" name="status">
														<option value="">Semua Status</option>
														<option value="Dalam Proses" {{ request('status') == 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
														<option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
													</select>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="siswa_id">Pilih Siswa</label>
													<select class="form-control" id="siswa_id" name="siswa_id">
														<option value="">Semua Siswa</option>
														@foreach($siswas as $siswa)
															<option value="{{ $siswa->id }}" {{ request('siswa_id') == $siswa->id ? 'selected' : '' }}>
																{{ $siswa->nama }} ({{ $siswa->nis }})
															</option>
														@endforeach
													</select>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="kategori_id">Pilih Kategori</label>
													<select class="form-control" id="kategori_id" name="kategori_id">
														<option value="">Semua Kategori</option>
														@foreach($kategoris as $kategori)
															<option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
																{{ $kategori->nama_kategori }}
															</option>
														@endforeach
													</select>
												</div>
											</div>
										</div>
										<!-- Baris 2: Tombol Aksi -->
										<div class="row">
											<div class="col-md-12">
												<div class="d-flex">
													<button type="submit" class="btn btn-primary mr-2">
														<i class="fas fa-filter"></i> Terapkan Filter
													</button>
													@if(request('tanggal') || request('status') || request('siswa_id') || request('kategori_id'))
														<a href="{{ $daftarRoute }}" class="btn btn-secondary">
															<i class="fas fa-times"></i> Reset Filter
														</a>
													@endif
												</div>
											</div>
										</div>
									</form>

									<!-- Info Filter Results -->
									<div class="mb-3">
										<small class="text-muted">
											Menampilkan {{ $pengaduans->count() }} pengaduan
											@if(request('tanggal') || request('status') || request('siswa_id') || request('kategori_id'))
												dengan filter:
												@if(request('tanggal')) <strong>Tanggal: {{ request('tanggal') }}</strong>@endif
												@if(request('status')) <strong>Status: {{ request('status') }}</strong>@endif
												@if(request('siswa_id'))
													@php $siswa = $siswas->find(request('siswa_id')) @endphp
													<strong>Siswa: {{ $siswa ? $siswa->nama : 'N/A' }}</strong>
												@endif
												@if(request('kategori_id'))
													@php $kategori = $kategoris->find(request('kategori_id')) @endphp
													<strong>Kategori: {{ $kategori ? $kategori->nama_kategori : 'N/A' }}</strong>
												@endif
											@endif
										</small>
									</div>

									@if(session('success'))
										<div class="alert alert-success alert-dismissible fade show" role="alert">
											{{ session('success') }}
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
									@endif
									@if(session('info'))
										<div class="alert alert-info alert-dismissible fade show" role="alert">
											{{ session('info') }}
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
									@endif


									<div class="table-responsive">
										<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
											<thead class="thead-light">
												<tr>
													<th class="text-gray-800">No</th>
													<th class="text-gray-800">Pelapor</th>
													<th class="text-gray-800">Kategori</th>
													<th class="text-gray-800">Deskripsi</th>
													<th class="text-center text-gray-800">Status</th>
													<th class="text-gray-800">
														<a href="{{ auth()->check() ? route('admin.daftar-pengaduan', array_merge(request()->query(), ['sort_by' => 'created_at', 'sort_direction' => (request('sort_by') == 'created_at' && request('sort_direction') == 'asc') ? 'desc' : 'asc'])) : route('daftar-pengaduan', array_merge(request()->query(), ['sort_by' => 'created_at', 'sort_direction' => (request('sort_by') == 'created_at' && request('sort_direction') == 'asc') ? 'desc' : 'asc'])) }}" class="text-decoration-none">
															Tanggal
															@if(request('sort_by') == 'created_at')
																<i class="fas fa-sort-{{ request('sort_direction') == 'asc' ? 'up' : 'down' }}"></i>
															@endif
														</a>
													</th>
													<th class="text-center text-gray-800">Aksi</th>
												</tr>
											</thead>
											<tbody>
												@foreach($pengaduans as $pengaduan)
												<tr>
													<td class="text-gray-900">{{ $loop->iteration }}</td>
													<td class="text-gray-900">{{ $pengaduan->pelapor }}</td>
													<td class="text-gray-900">{{ $pengaduan->kategori->nama_kategori }}</td>
													<td class="text-gray-900">{{ Str::limit($pengaduan->deskripsi, 50) }}</td>
													<td class="text-center">
														<span class="badge {{ $pengaduan->status == 'Selesai' ? 'badge-success' : ($pengaduan->status == 'Dalam Proses' ? 'badge-warning' : 'badge-info') }}">
															{{ $pengaduan->status }}
														</span>
													</td>
													<td class="text-gray-900">{{ $pengaduan->created_at->format('d/m/Y') }}</td>
													<td class="text-center">
														<div class="d-flex justify-content-center align-items-center">
															<a href="{{ auth()->check() ? route('admin.pengaduan.show', $pengaduan) : route('pengaduan.show', $pengaduan) }}" class="btn btn-sm btn-info mr-2" title="Lihat Detail">
																<i class="fas fa-eye"></i>
															</a>

															<div class="ml-2 d-flex align-items-center">
																{{-- Custom visual indicator: green rounded check when Selesai, empty rounded box when not --}}
																@if($pengaduan->status == 'Selesai')
																	<span class="d-inline-flex align-items-center justify-content-center" title="Selesai" style="width:30px;height:30px;background:#20c997;border-radius:8px;">
																		<i class="fas fa-check" style="color:#fff;font-size:14px;"></i>
																	</span>
																@else
																	<form action="{{ auth()->check() ? route('admin.pengaduan.selesai', $pengaduan) : route('pengaduan.selesai', $pengaduan) }}" method="POST" style="display:inline;">
																		@csrf
																		@method('POST')
																		<button type="submit" class="btn p-0" title="Tandai Selesai" onclick="return confirm('Apakah Anda yakin ingin menandai pengaduan dari {{ $pengaduan->pelapor }} sebagai selesai?')" style="width:30px;height:30px;border:2px solid #e1e3ea;border-radius:8px;background:transparent;">
																			{{-- empty rounded box as submit control --}}
																		</button>
																	</form>
																@endif
															</div>
														</div>
													</td>
												</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
				<!-- /.container-fluid -->

			</div>
			<!-- End of Main Content -->

			<!-- Footer -->
			<footer class="sticky-footer bg-white">
				<div class="container my-auto">
					<div class="copyright text-center my-auto">

					</div>
				</div>
			</footer>
			<!-- End of Footer -->

		</div>
		<!-- End of Content Wrapper -->

	</div>
	<!-- End of Page Wrapper -->

	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>

	<!-- Logout Modal-->
	<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
						<a class="btn btn-primary" href="{{ route('logout') }}"
						   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
							@csrf
						</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Bootstrap core JavaScript-->
	<script src="{{ asset('sbadmin2/vendor/jquery/jquery.min.js') }}"></script>
	<script src="{{ asset('sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

	<!-- Core plugin JavaScript-->
	<script src="{{ asset('sbadmin2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

	<!-- Custom scripts for all pages-->
	<script src="{{ asset('sbadmin2/js/sb-admin-2.min.js') }}"></script>

	<!-- Page level plugins -->
	<script src="{{ asset('sbadmin2/vendor/chart.js/Chart.min.js') }}"></script>

	<!-- Page level custom scripts -->
	<script src="{{ asset('sbadmin2/js/demo/chart-area-demo.js') }}"></script>
	<script src="{{ asset('sbadmin2/js/demo/chart-pie-demo.js') }}"></script>

	<!-- Page transition script -->
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const pageContent = document.querySelector('#content');

			// Check if we're transitioning from another page
			const isTransitioning = sessionStorage.getItem('pageTransition');

			if (isTransitioning) {
				// Coming from a transition - start invisible and fade in
				if (pageContent) {
					pageContent.style.opacity = '0';
					pageContent.style.transition = 'opacity 0.3s ease-in-out';
					sessionStorage.removeItem('pageTransition'); // Clean up

					// Trigger reflow and then fade in
					void pageContent.offsetWidth; // Trigger reflow
					setTimeout(() => {
						pageContent.style.opacity = '1';
					}, 10);
				}
			}
			// If not transitioning, the page shows normally without animation

			// Handle link clicks for smooth transitions
			document.addEventListener('click', function(e) {
				const link = e.target.closest('a');

				// Skip transition for logout links (they handle form submission)
				if (link && (link.getAttribute('onclick') && link.getAttribute('onclick').includes('logout-form') || link.href.includes('/logout'))) {
					return; // Allow normal logout behavior
				}

				if (link && !link.hasAttribute('target') && !link.href.startsWith('mailto:') && !link.href.startsWith('tel:')) {
					e.preventDefault();

					// Set transition flag
					sessionStorage.setItem('pageTransition', 'true');

					// Fade out current page
					if (pageContent) {
						pageContent.style.transition = 'opacity 0.3s ease-in-out';
						pageContent.style.opacity = '0';

						setTimeout(() => {
							window.location.href = link.href;
						}, 300); // Match the CSS transition duration
					} else {
						window.location.href = link.href;
					}
				}
			});

			// Handle form submissions for smooth transitions
			const forms = document.querySelectorAll('form');
			forms.forEach(form => {
				form.addEventListener('submit', function(e) {
					// Skip transition for logout forms
					if (form.id === 'logout-form' || form.action?.includes('/logout')) {
						return; // Allow normal logout behavior
					}
                    
					if (!form.hasAttribute('target')) {
						e.preventDefault();

						// Set transition flag
						sessionStorage.setItem('pageTransition', 'true');

						// Fade out current page
						if (pageContent) {
							pageContent.style.transition = 'opacity 0.3s ease-in-out';
							pageContent.style.opacity = '0';

							setTimeout(() => {
								form.submit();
							}, 300); // Match the CSS transition duration
						} else {
							form.submit();
						}
					}
				});
			});
		});
	</script>

</body>

</html>
