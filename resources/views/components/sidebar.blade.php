<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto">
                <a class="navbar-brand" href="{{ asset('home') }}">
                    <span class="brand-logo">
                        <img src="{{ asset('app-assets/images/logo/logo.jpeg') }}" alt="jpeg" height="32">
                    </span>
                    <h2 class="brand-text">Sewa Mobil</h2>
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

            <li class="nav-item {{ Request::is('car') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('car') }}">
                <i data-feather="truck"></i><span class="menu-title text-truncate" data-i18n="Data Mobil">Data Mobil</span></a>
            </li>

            <li class="nav-item {{ Request::is('asset') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('asset') }}">
                <i data-feather="database"></i><span class="menu-title text-truncate" data-i18n="Data Mobil">Data Aset</span></a>
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
