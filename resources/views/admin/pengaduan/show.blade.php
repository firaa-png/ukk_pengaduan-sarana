<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ config('app.name', 'Laravel') }} - Detail Pengaduan</title>

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
                        <h1 class="h1 mb-0 text-gray-800" style="font-size:34px;">Detail Aspirasi</h1>
                        <a href="{{ auth()->check() ? route('admin.daftar-pengaduan') : (session('siswa_id') ? route('siswa.create-aspirasi') : route('dashboard')) }}" class="btn btn-secondary rounded-pill">Kembali</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Detail Pengaduan</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                            <div class="col-lg-8">
                                                <div class="card mb-4" style="background:transparent; border:0; box-shadow:none;">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold text-primary">Informasi Aspirasi</h6>
                                                    </div>
                                                    <div class="card-body p-5">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <p><strong>Siswa:</strong> {{ $pengaduan->pelapor }}</p>
                                                                <p><strong>Kategori:</strong> {{ $pengaduan->kategori->nama_kategori }}</p>
                                                                <p><strong>Lokasi:</strong> {{ $pengaduan->lokasi }}</p>
                                                                <p><strong>Status:</strong>
                                                                    @php
                                                                        $status = $pengaduan->status;
                                                                        $badgeClass = 'badge-secondary';
                                                                        if ($status == 'Selesai') $badgeClass = 'badge-success';
                                                                        elseif ($status == 'Dalam Proses') $badgeClass = 'badge-warning';
                                                                        elseif ($status == 'Menunggu') $badgeClass = 'badge-info';
                                                                    @endphp
                                                                    <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                                                                </p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p><strong>Keterangan:</strong> {{ $pengaduan->deskripsi }}</p>
                                                                <p><strong>Tanggal Dibuat:</strong> {{ $pengaduan->created_at->format('d/m/Y') }}</p>
                                                                @if($pengaduan->feedback && (auth()->check() || (session('siswa_id') && $pengaduan->siswa_id == session('siswa_id'))))
                                                                    <p><strong>Feedback:</strong> {{ $pengaduan->feedback }}</p>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        @php
                                                            // Show gambar to anyone when it exists (previously limited to admin/owner)
                                                        @endphp
                                                        @if($pengaduan->gambar)
                                                            @php $imgPath = public_path($pengaduan->gambar); @endphp
                                                            <hr />
                                                            <h5>Gambar:</h5>
                                                            <div class="mb-2">
                                                                    @if(file_exists($imgPath))
                                                                        <img src="{{ asset($pengaduan->gambar) }}" alt="Gambar Pengaduan" class="img-fluid mx-auto d-block" style="max-height:360px; object-fit:contain; width:auto; max-width:100%;" />
                                                                    @else
                                                                        <div class="alert alert-warning">Gambar tidak ditemukan di server.</div>
                                                                    @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="card mb-4" style="background:transparent; border:0; box-shadow:none;">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold text-primary">Update Status</h6>
                                                    </div>
                                                    <div class="card-body p-4">
                                                        @if(auth()->check())
                                                            @if($pengaduan->status !== 'Selesai')
                                                                <form action="{{ route('admin.pengaduan.update_status', $pengaduan) }}" method="POST">
                                                                    @csrf
                                                                    <div class="form-group">
                                                                        <label>Status</label>
                                                                        <select name="status" class="form-control">
                                                                            <option value="Dalam Proses" {{ $pengaduan->status == 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
                                                                            <option value="Menunggu" {{ $pengaduan->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                                                            <option value="Selesai" {{ $pengaduan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Feedback (Opsional)</label>
                                                                        <textarea name="feedback" class="form-control" rows="5">{{ old('feedback', $pengaduan->feedback) }}</textarea>
                                                                    </div>
                                                                    <button class="btn btn-primary btn-block btn-sm">Update Status</button>
                                                                </form>
                                                            @else
                                                                <div class="alert alert-info">Pengaduan sudah selesai dan tidak bisa diubah lagi.</div>
                                                                @if($pengaduan->feedback)
                                                                    <div class="form-group">
                                                                        <label>Feedback</label>
                                                                        <textarea class="form-control" rows="5" readonly>{{ $pengaduan->feedback }}</textarea>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        @else
                                                            <p>Update status hanya tersedia untuk admin.</p>
                                                        @endif
                                                    </div>
                                                </div>
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
