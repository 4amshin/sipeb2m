@include('layout.logo')

<div class="menu-inner-shadow"></div>

<!--Sidebar-->
<ul class="menu-inner py-1">

    <!-- Beranda -->
    <li class="menu-item {{ Request::is('home*') ? 'active' : '' }}">
        <a href="{{ route('home') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">Beranda</div>
        </a>
    </li>

    @can('super-user')
        <!-- Pengguna -->
        <li class="menu-item {{ Request::is('pengguna*') ? 'active' : '' }}">
            <a href="{{ route('pengguna.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Analytics">Pengguna</div>
            </a>
        </li>

        <!-- Baju -->
        <li class="menu-item {{ Request::is('baju*') ? 'active' : '' }}">
            <a href="{{ route('baju.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Analytics">Baju</div>
            </a>
        </li>
    @endcan

</ul>
