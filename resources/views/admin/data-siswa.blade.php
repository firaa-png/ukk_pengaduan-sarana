<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>{{ config('app.name', 'Laravel') }} - Data Siswa</title>

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
						<h1 class="h3 mb-0 text-gray-800">Data Siswa</h1>
			<a href="{{ route('admin.siswa.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
								class="fas fa-plus fa-sm text-white-50"></i> Tambah Siswa</a>
					</div>

					@if(session('success'))
						<div class="alert alert-success">{{ session('success') }}</div>
					@endif

					<!-- Content Row -->
					<div class="row">
						<div class="col-lg-12">
							<div class="card shadow mb-4">
								<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
									<h6 class="m-0 font-weight-bold text-primary">Daftar Siswa</h6>
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
													<th class="text-gray-800">NIS</th>
													<th class="text-gray-800">Nama</th>
													<th class="text-gray-800">Username</th>
													<th class="text-gray-800">Kelas</th>
													<th class="text-gray-800">Jurusan</th>
													<th class="text-center text-gray-800">Aksi</th>
												</tr>
											</thead>
											<tbody>
												@foreach($siswas as $siswa)
												<tr>
													<td class="text-gray-900">{{ $siswa->nis }}</td>
													<td class="text-gray-900">{{ $siswa->nama }}</td>
													<td class="text-gray-900">{{ $siswa->username ?? '-' }}</td>
													<td class="text-gray-900">{{ $siswa->kelas }}</td>
													<td class="text-gray-900">{{ $siswa->jurusan }}</td>
													<td class="text-center">
														<div class="d-flex justify-content-center">
															<a href="{{ route('admin.siswa.edit', $siswa) }}" class="btn btn-sm btn-primary mr-1" title="Edit Siswa">
																<i class="fas fa-pen"></i>
															</a>
															<form action="{{ route('admin.siswa.destroy', $siswa) }}" method="POST" style="display:inline;">
																@csrf
																@method('DELETE')
																<button type="submit" class="btn btn-sm btn-danger" title="Hapus Siswa" onclick="return confirm('Apakah Anda yakin ingin menghapus siswa {{ $siswa->nama }}?')">
																	<i class="fas fa-trash"></i>
																</button>
															</form>
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
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
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
