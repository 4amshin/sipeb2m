<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ route('home') }}">SIPEB2M</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="index.html">SP</a>
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

            @can('super-user')
                <!--Kelola Pengguna-->
                <li class="nav-item {{ Request::is('user*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('user.index') }}">
                        <i class="fa-solid fa-users-gear"></i></i> <span>Kelola Pengguna</span>
                    </a>
                </li>
            @endcan
        @show
    </ul>
</aside>
