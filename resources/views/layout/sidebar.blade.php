<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ route('home') }}">Sipetik</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="index.html">Sk</a>
    </div>

    <ul class="sidebar-menu">
        @section('sidebar')
            <li class="menu-header">Menu</li>

            <!--Beranda-->
            <li class="nav-item {{ Request::is('home*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fa-solid fa-house"></i> <span>Beranda</span>
                </a>
            </li>

            <!--Panduan Memesan Tiket-->
            <li class="nav-item {{ Request::is('caraPesan*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('informasi.caraPesan') }}">
                    <i class="fa-solid fa-business-time"></i> <span>Panduan Memesan</span>
                </a>
            </li>

            @can('super-user')
                <!--Kelola Pengguna-->
                <li class="nav-item {{ Request::is('pengguna*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('pengguna.index') }}">
                        <i class="fa-solid fa-users-gear"></i></i> <span>Kelola Pengguna</span>
                    </a>
                </li>
            @endcan

            @can('super-user')
                <!--Bus-->
                <li class="nav-item {{ Request::is('bus*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('bus.index') }}">
                        <i class="fa-solid fa-bus"></i> <span>Bus</span>
                    </a>
                </li>

                <!--Jadwal Berangkat-->
                <li class="nav-item {{ Request::is('jadwalBerangkat*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('jadwalBerangkat.index') }}">
                        <i class="fa-solid fa-road"></i> <span>Jadwal Berangkat</span>
                    </a>
                </li>
            @endcan

            @can('pengguna-only')
                <!--Pesan Tiket-->
                <li class="nav-item {{ Request::is('pemesanan/create*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('pemesanan.create') }}">
                        <i class="fa-solid fa-ticket"></i> <span>Pesan Tiket</span>
                    </a>
                </li>
            @endcan

            <!--Daftar Pemesanan-->
            <li
                class="nav-item {{ Request::is('pemesanan') || (Request::is('pemesanan/*') && !Request::is('pemesanan/create')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('pemesanan.index') }}">
                    <i class="fa-solid fa-file-invoice-dollar"></i> <span>Daftar Pemesanan</span>
                </a>
            </li>

            <!--Daftar Tiket-->
            <li class="nav-item {{ Request::is('daftarTiket*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('daftarTiket') }}">
                    <i class="fa-solid fa-file-lines"></i> <span>Daftar Tiket</span>
                </a>
            </li>
        @show
    </ul>


</aside>
