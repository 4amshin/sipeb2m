<div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
        <i class="bx bx-menu bx-sm"></i>
    </a>
</div>

<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

    <!-- Page Title  & Search -->
    <div class="navbar-nav align-items-center">
        @hasSection('page-title')
            <h4 class="fw-bold mt-3">@yield('page-title')</h4>
        @endif

        @hasSection('search')
            <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                    <i class="bx bx-search fs-4 lh-0"></i>
                    @yield('search')
                </div>
            </div>
        @endif
    </div>

    <!-- User -->
    <ul class="navbar-nav flex-row align-items-center ms-auto">
        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">

            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                <div class="avatar avatar-online">
                    <img src="{{ asset('assets/img/avatars/6.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                </div>
            </a>

            <ul class="dropdown-menu dropdown-menu-end">
                <!--Nama & Role-->
                <li>
                    <a class="dropdown-item" href="#">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-online">
                                    <img src="{{ asset('assets/img/avatars/6.png') }}" alt
                                        class="w-px-40 h-auto rounded-circle" />
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <span class="fw-semibold d-block">{{ auth()->user()->name }}</span>
                                <small class="text-muted">{{ auth()->user()->role }}</small>
                            </div>
                        </div>
                    </a>
                </li>

                <!--Divider-->
                <li>
                    <div class="dropdown-divider"></div>
                </li>

                <!--Profil-->
                <li>
                    <a class="dropdown-item" href="{{ route('pengguna.profile') }}">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">Profil</span>
                    </a>
                </li>

                <!--Keranjang-->
                @can('pengguna-only')
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class='bx bx-cart-alt me-2'></i>
                            {{-- <i class="bx bx-user me-2"></i> --}}
                            <span class="align-middle">Keranjang Saya</span>
                        </a>
                    </li>
                @endcan

                <!--Logout-->
                <li>
                    <a class="dropdown-item" href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bx
                        bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="post">
                        @csrf
                    </form>
                </li>

            </ul>
        </li>
    </ul>
</div>
