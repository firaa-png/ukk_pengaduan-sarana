<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-tools"></i>
        </div>
        <div class="sidebar-brand-text mx-3">PENGADUAN SARANA<sup></sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'text-white' : '' }}" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu Utama
    </div>

    <!-- Nav Item - Data Siswa -->
    <li class="nav-item {{ request()->routeIs('admin.data-siswa') || request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->routeIs('admin.data-siswa') || request()->routeIs('admin.siswa.*') ? 'text-white' : '' }}" href="{{ route('admin.data-siswa') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Siswa</span></a>
    </li>

    <!-- Nav Item - Data Kategori -->
    <li class="nav-item {{ request()->routeIs('admin.data-kategori') || request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->routeIs('admin.data-kategori') || request()->routeIs('admin.kategori.*') ? 'text-white' : '' }}" href="{{ route('admin.data-kategori') }}">
            <i class="fas fa-fw fa-tags"></i>
            <span>Data Kategori</span></a>
    </li>

    <div class="sidebar-heading">
        Laporan
    </div>

    <!-- Nav Item - Daftar Pengaduan -->
    <li class="nav-item {{ request()->routeIs('admin.daftar-pengaduan') || request()->routeIs('admin.pengaduan.*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->routeIs('admin.daftar-pengaduan') || request()->routeIs('admin.pengaduan.*') ? 'text-white' : '' }}" href="{{ route('admin.daftar-pengaduan') }}">
            <i class="fas fa-fw fa-list"></i>
            <span>Data Pengaduan</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Akun
    </div>

    <!-- Nav Item - Logout -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Keluar</span></a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
