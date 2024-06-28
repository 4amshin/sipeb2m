@include('layout.logo')

<div class="menu-inner-shadow"></div>

<!--Sidebar-->
<ul class="menu-inner py-1">

    <!-- Beranda -->
    <li class="menu-item {{ Request::is('home*') ? 'active' : '' }}">
        <a href="{{ route('home') }}" class="menu-link">
            <i class='menu-icon tf-icons bx bxs-home'></i>
            <div data-i18n="Analytics">Beranda</div>
        </a>
    </li>

    @can('super-user')
        <!-- Pengguna -->
        <li class="menu-item {{ Request::is('pengguna*') ? 'active' : '' }}">
            <a href="{{ route('pengguna.index') }}" class="menu-link">
                <i class='menu-icon tf-icons bx bxs-user'></i>
                <div data-i18n="Analytics">Pengguna</div>
            </a>
        </li>
    @endcan

    <!-- Baju -->
    <li class="menu-item {{ Request::is('baju*') ? 'active' : '' }}">
        <a href="{{ route('baju.index') }}" class="menu-link">
            <i class='menu-icon tf-icons bx bxs-t-shirt'></i>
            <div data-i18n="Analytics">Baju</div>
        </a>
    </li>

    <li class="menu-header small text-uppercase"><span class="menu-header-text">Transaksi</span></li>

    <!-- Orderan -->
    <li class="menu-item {{ Request::is('daftarOrderan*') ? 'active' : '' }}">
        <a href="{{ route('daftarOrderan') }}" class="menu-link">
            <i class='menu-icon tf-icons bx bxs-receipt'></i>
            <div data-i18n="Analytics">Orderan</div>
        </a>
    </li>

    <!-- Pembayaran -->
    <li class="menu-item {{ Request::is('pembayaran*') ? 'active' : '' }}">
        <a href="{{ route('pembayaran.index') }}" class="menu-link">
            <i class='menu-icon tf-icons bx bx bxs-wallet'></i>
            <div data-i18n="Analytics">Pembayaran</div>
        </a>
    </li>

    <!-- Penyewaan -->
    <li class="menu-item {{ Request::is('transaksi*') ? 'active' : '' }}">
        <a href="{{ route('transaksi.index') }}" class="menu-link">
            <i class='menu-icon tf-icons bx bxs-shopping-bags'></i>
            <div data-i18n="Analytics">Penyewaan</div>
        </a>
    </li>

    <!-- Pengembalian -->
    <li class="menu-item {{ Request::is('pengembalian*') ? 'active' : '' }}">
        <a href="{{ route('pengembalian.index') }}" class="menu-link">
            <i class='menu-icon tf-icons bx bxs-package'></i>
            <div data-i18n="Analytics">Pengembalian</div>
        </a>
    </li>

    <!-- Riwayat Penyewaan -->
    <li class="menu-item {{ Request::is('riwayat-penyewaan*') ? 'active' : '' }}">
        <a href="{{ route('transaksi.riwayat') }}" class="menu-link">
            <i class='menu-icon tf-icons bx bx-history'></i>
            <div data-i18n="Analytics">Riwayat Penyewaan</div>
        </a>
    </li>




</ul>
