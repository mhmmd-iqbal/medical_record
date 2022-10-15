<!-- HEADER MOBILE-->
<header class="header-mobile d-block d-lg-none">
    <div class="header-mobile__bar">
        <div class="container-fluid">
            <div class="header-mobile-inner">
                <a href="#">
                    <div class="d-flex justify-content-between">
                    </div>
                </a>
                <button class="hamburger hamburger--slider" type="button">
                    <span class="hamburger-box ">
                        <span class="hamburger-inner fa fa-align-justify text-success"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <nav class="navbar-mobile">
        <div class="container-fluid">
            <ul class="navbar-mobile__list list-unstyled">
                <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }} ">
                        <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                </li>
                @can('isAdmin')
                    <li class="has-sub {{ request()->is('master*') ? 'active' : '' }}">
                        <a class="js-arrow" href="#">
                            <i class="fas  fa-th-large"></i>Master Data</a>
                        <ul class="navbar-mobile-sub__list list-unstyled js-sub-list"
                            style="display:{{ request()->is('master*') ? 'block' : 'none' }}">
                            <li class="{{ request()->is('master/user*') ? 'active' : '' }}">
                                <a href="{{ route('master.user.index') }}">Data User</a>
                            </li>
                            <li class="{{ request()->is('master/category*') ? 'active' : '' }}">
                                <a href="">Data Kategori Produk</a>
                            </li>
                            <li class="{{ request()->is('master/product*') ? 'active' : '' }}">
                                <a href=" ">Data Produk</a>
                            </li>

                        </ul>
                    </li>
                @endcan
                @canany(['isAdmin', 'isCasheer'])
                    <li class="{{ request()->is('about') ? 'active' : '' }}">
                        <a href="" class="disabled">
                            <i class="fas fa-toggle-up"></i>Transaksi Penjualan</a>
                    </li>
                @endcanany
                @can('isAdmin')
                @endcan
                <li class="{{ request()->is('about') ? 'active' : '' }}">
                    <a href="#" onclick="logout()">
                        <i class="fas fa-power-off"></i>Log Out</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<!-- END HEADER MOBILE-->

<!-- MENU SIDEBAR-->
<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="#">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="text-light">{{ Auth::user()->name }}</h3>
            </div>
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }} ">
                        <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                </li>
                <li class="{{ request()->is('queue') ? 'active' : '' }}">
                    <a href="{{ route('queue.index') }} ">
                        <i class="fas fa-user"></i>List Antrian</a>
                </li>
                <li>
                    <a href="{{ route('dashboard') }} ">
                        <i class="fas fa-hospital-o"></i>Rekam Medis</a>
                </li>
                @can('isAdmin')
                    <li class="has-sub {{ request()->is('master') ? 'active' : '' }}">
                        <a class="js-arrow" href="#">
                            <i class="fas  fa-th-large"></i>Master Data</a>
                        <ul class="navbar-mobile-sub__list list-unstyled js-sub-list"
                            style="display:{{ request()->is('master*') ? 'block' : 'none' }}">
                            <li class="{{ request()->is('master/user*') ? 'active' : '' }}">
                                <a href="{{ route('master.user.index') }}">Data User</a>
                            </li>
                            <li class="{{ request()->is('master/poliklinik*') ? 'active' : '' }}">
                                <a href="{{ route('master.poliklinik.index') }}">Data Poliklinik</a>
                            </li>
                            <li class="{{ request()->is('master/patient*') ? 'active' : '' }}">
                                <a href="{{ route('master.patient.index') }}">Data Pasien</a>
                            </li>

                        </ul>
                    </li>

                    <li class="{{ request()->is('report*') ? 'active' : '' }}">
                        <a href="" class="">
                            <i class="fas fa-bar-chart-o"></i>laporan</a>
                    </li>
                @endcan


                @canany(['isApotek'])
                    <li class="{{ request()->is('stock*') ? 'active' : '' }}">
                        <a href="{{ route('stock.index') }}" class="">
                            <i class="fas fa-toggle-down"></i>Stock Barang</a>
                    </li>
                @endcanany

                <li class="{{ request()->is('about') ? 'active' : '' }}">
                    <a href="#" onclick="logout()">
                        <i class="fas fa-power-off"></i>Log Out</a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
<!-- END MENU SIDEBAR-->
