<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto">
                <a class="navbar-brand" href="{{ asset('home') }}">
                    <span class="brand-logo">
                        <img src="{{ asset('app-assets/images/logo/logo.png') }}" alt="png" height="32">
                    </span>
                    <h2 class="brand-text">Aset</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content mt-2">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item {{ Request::is('home') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('home') }}"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Dashboards</span></a>
            </li>

            <li class=" navigation-header"><span data-i18n="Data Inventarisasi Aset">Data Inventarisasi Aset</span><i data-feather="more-horizontal"></i>
            </li>

            <li class="nav-item {{ Request::is('aset') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('aset') }}">
                <i data-feather="database"></i><span class="menu-title text-truncate" data-i18n="Data Aset">Data Aset</span></a>
            </li>
            <li class=" nav-item {{ Request::is('history-penghapusan') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('history-penghapusan') }}">
                <i data-feather="trash-2"></i><span class="menu-title text-truncate" data-i18n="History Penghapusan Aset">History Penghapusan</span></a>
            </li>
            <li class="nav-item {{ Request::is('pengadaan-aset') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('pengadaan-aset') }}">
                <i data-feather="shopping-cart"></i><span class="menu-title text-truncate" data-i18n="Pengadaan Aset">Pengadaan Aset</span></a>
            </li>

            <li class=" navigation-header">
                <span data-i18n="Perhitungan TOPSIS">Perhitungan TOPSIS</span>
                <i data-feather="more-horizontal"></i>
            </li>

            <li class="nav-item {{ Request::is('kriteria') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('kriteria') }}">
                <i data-feather="database"></i><span class="menu-title text-truncate" data-i18n="Data Kriteria">Data Kriteria</span></a>
            </li>
            <li class="nav-item {{ Request::is('sub-kriteria') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('sub-kriteria') }}">
                <i data-feather="database"></i><span class="menu-title text-truncate" data-i18n="Data Sub Kriteria">Data Sub Kriteria</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('home') }}">
                <i data-feather="bar-chart-2"></i><span class="menu-title text-truncate" data-i18n="Data Perhitungan">Data Perhitungan</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('home') }}">
                <i data-feather="list"></i><span class="menu-title text-truncate" data-i18n="Hasil Perankingan">Hasil Perankingan</span></a>
            </li>


            @if(auth()->user()->role == 1)
                <li class=" navigation-header"><span data-i18n="Data User">Data User</span>
                    <i data-feather="more-horizontal"></i>
                </li>
                <li class="nav-item mb-4 {{ Request::is('users') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('users') }}">
                    <i data-feather="users"></i><span class="menu-title text-truncate" data-i18n="Data User">Data User</span></a>
                </li>
            @endif

            </li>
        </ul>
    </div>
</div>
