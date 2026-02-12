<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('sbadmin2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('sbadmin2/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <style>
        body, h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, Arial, sans-serif; }
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
                <div class="container-fluid" style="padding-top:10px;">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h1 class="h3 mb-0 text-gray-800">Halo, {{ auth()->user()->name ?? 'Admin' }}</h1>
                            <small class="text-muted">Ringkasan aktivitas dan statistik pengaduan</small>
                        </div>
                        <div class="d-flex">
                            <a href="{{ route('admin.data-siswa') }}" class="btn btn-outline-secondary mr-2">Data Siswa</a>
                            <a href="{{ route('admin.daftar-pengaduan') }}" class="btn btn-primary">Daftar Pengaduan</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Pengaduan Masuk</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pengaduanMasukCount ?? 0 }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-envelope-open-text fa-2x text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pengaduan Selesai</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pengaduanSelesaiCount ?? 0 }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-check-double fa-2x text-success"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Pengaduan</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPengaduanCount ?? 0 }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-layer-group fa-2x text-info"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Dalam Proses</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pengaduanDalamProsesCount ?? 0 }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-spinner fa-spin fa-2x text-warning"></i>
                                        </div>
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
            <x-footer />
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('sbadmin2/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('sbadmin2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('sbadmin2/js/sb-admin-2.min.js') }}"></script>

</body>

</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Halo, {{ auth()->user()->name ?? 'Admin' }}</title>

	<!-- Custom fonts for this template-->
	<link href="{{ asset('sbadmin2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

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
				<div class="container-fluid" style="padding-top: 10px;">

					<!-- Page Heading -->
					<div class="d-sm-flex align-items-center justify-content-between mb-3">
						<div>
							<h1 class="h3 mb-0 text-gray-800">Halo, <span class="user-name">{{ auth()->user()->name ?? 'Admin' }}</span></h1>
							<small class="text-muted">Ringkasan aktivitas dan statistik pengaduan</small>
						</div>
						<div class="d-flex">
							<a href="{{ route('admin.data-siswa') }}" class="btn btn-outline-secondary mr-2">Data Siswa</a>
							<a href="{{ route('admin.daftar-pengaduan') }}" class="btn btn-primary">Daftar Pengaduan</a>
						</div>
					</div>

					{{-- STYLE TAMBAHAN --}}
					<style>
						.card-hover:hover { transform: translateY(-6px); transition: 0.3s; }
						.user-name { font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; font-weight:600; }
						.stat-card { transition: transform .12s ease, box-shadow .12s ease; }
						.stat-card:hover { transform: translateY(-4px); box-shadow: 0 6px 18px rgba(0,0,0,0.08); }
						.stat-icon { width:56px; height:56px; display:flex; align-items:center; justify-content:center; border-radius:8px; }
						.stat-number { font-size:1.5rem; font-weight:700; }
						.stat-label { font-size:0.75rem; letter-spacing:0.6px; }
					</style>

                   
					<div class="row">

						{{-- PENGADUAN MASUK --}}
						<div class="col-xl-3 col-md-6 mb-4">
							<a href="{{ route('admin.daftar-pengaduan') . '?status=Dalam Proses' }}" class="text-decoration-none">
								<div class="card stat-card card-hover border-left-primary shadow h-100 py-2">
									<div class="card-body">
										<div class="row no-gutters align-items-center">
											<div class="col mr-2">
												<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
													Pengaduan Masuk
												</div>
												<div class="h4 font-weight-bold text-gray-800">
													<span class="stat-number">{{ $pengaduanMasukCount }}</span>
													<span class="badge badge-primary ml-2">Baru</span>
												</div>
												<div class="text-muted small">Jumlah pengaduan baru yang belum diproses</div>
											</div>
											<div class="col-auto">
												<i class="fas fa-envelope-open-text fa-3x text-primary"></i>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>

						{{-- PENGADUAN SELESAI --}}
						<div class="col-xl-3 col-md-6 mb-4">
							<a href="{{ route('admin.daftar-pengaduan') . '?status=Selesai' }}" class="text-decoration-none">
								<div class="card stat-card card-hover border-left-success shadow h-100 py-2">
									<div class="card-body">
										<div class="row no-gutters align-items-center">
											<div class="col mr-2">
												<div class="text-xs font-weight-bold text-success text-uppercase mb-1">
													Pengaduan Selesai
												</div>
												<div class="h4 font-weight-bold text-gray-800">
													<span class="stat-number">{{ $pengaduanSelesaiCount }}</span>
												</div>
												<div class="text-muted small">Pengaduan yang sudah selesai ditangani</div>
												<div class="progress mt-2">
													<div class="progress-bar bg-success" role="progressbar"
														style="width: {{ $persenSelesai }}%">
														{{ $persenSelesai }}%
													</div>
												</div>
											</div>
											<div class="col-auto">
												<i class="fas fa-check-double fa-3x text-success"></i>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>

						{{-- TOTAL PENGADUAN --}}
						<div class="col-xl-3 col-md-6 mb-4">
							<a href="{{ route('admin.daftar-pengaduan') }}" class="text-decoration-none">
								<div class="card stat-card card-hover border-left-info shadow h-100 py-2">
									<div class="card-body">
										<div class="row no-gutters align-items-center">
											<div class="col mr-2">
												<div class="text-xs font-weight-bold text-info text-uppercase mb-1">
													Total Pengaduan
												</div>
												<div class="h4 font-weight-bold text-gray-800">
													<span class="stat-number">{{ $totalPengaduanCount }}</span>
												</div>
												<div class="text-muted small">Total seluruh pengaduan di sistem</div>
											</div>
											<div class="col-auto">
												<i class="fas fa-layer-group fa-3x text-info"></i>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>

						{{-- DALAM PROSES --}}
						<div class="col-xl-3 col-md-6 mb-4">
							<a href="{{ route('admin.daftar-pengaduan') . '?status=Dalam Proses' }}" class="text-decoration-none">
								<div class="card stat-card card-hover border-left-warning shadow h-100 py-2">
									<div class="card-body">
										<div class="row no-gutters align-items-center">
											<div class="col mr-2">
												<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
													Dalam Proses
												</div>
												<div class="h4 font-weight-bold text-gray-800">
													<span class="stat-number">{{ $pengaduanDalamProsesCount }}</span>
												</div>
												<div class="text-muted small">Pengaduan yang sedang dalam proses penanganan</div>
											</div>
											<div class="col-auto">
												<i class="fas fa-spinner fa-spin fa-3x text-warning"></i>
											</div>
										</div>
									</div>
								</div>
							</a>
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
