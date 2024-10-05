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

            <li class=" navigation-header"><span data-i18n="Data Sewa Mobil">Data Sewa Mobil</span><i data-feather="more-horizontal"></i>
            </li>

            <li class="nav-item {{ Request::is('asset') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('asset') }}">
                <i data-feather="database"></i><span class="menu-title text-truncate" data-i18n="Data Aset">Data Aset</span></a>
            </li>
            <li class=" nav-item {{ Request::is('deletion-history') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('deletion-history') }}">
                <i data-feather="trash-2"></i><span class="menu-title text-truncate" data-i18n="History Penghapusan Aset">History Penghapusan</span></a>
            </li>
            <li class="nav-item {{ Request::is('maintenance') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('maintenance') }}">
                <i data-feather="tool"></i><span class="menu-title text-truncate" data-i18n="Pemeliharaan Aset">Pemeliharaan Aset</span></a>
            </li>            
            
            <li class=" navigation-header">
                <span data-i18n="Perhitungan TOPSIS">Perhitungan TOPSIS</span>
                <i data-feather="more-horizontal"></i>
            </li>
            
            <li class="nav-item {{ Request::is('criteria') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('criteria') }}">
                <i data-feather="database"></i><span class="menu-title text-truncate" data-i18n="Data Kriteria">Data Kriteria</span></a>
            </li>
            <li class="nav-item {{ Request::is('subcriteria') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('subcriteria') }}">
                <i data-feather="database"></i><span class="menu-title text-truncate" data-i18n="Data Sub Kriteria">Data Sub Kriteria</span></a>
            </li>
            <li class="nav-item {{ Request::is('evaluation') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('evaluation') }}">
                <i data-feather="edit"></i><span class="menu-title text-truncate" data-i18n="Data Perhitungan">Data Penilaian</span></a>
            </li>
            <li class="nav-item {{ Request::is('process') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('process') }}">
                <i data-feather="bar-chart-2"></i><span class="menu-title text-truncate" data-i18n="Data Perhitungan">Data Perhitungan</span></a>
            </li>
            <li class="nav-item {{ Request::is('ranking') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('ranking') }}">
                <i data-feather="bar-chart"></i><span class="menu-title text-truncate" data-i18n="Pengadaan Aset">Hasil Perankingan</span></a>
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