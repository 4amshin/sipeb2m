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
            @php
                // Query untuk mendapatkan gambar profil dari tabel 'pengguna' berdasarkan email pengguna yang sedang login
                $email = auth()->user()->email;
                $pengguna = \App\Models\Pengguna::where('email', $email)->first();
                $gambarProfil = $pengguna->gambar_profil
                    ? asset('storage/profil/'.$pengguna->gambar_profil)
                    : asset('assets/img/baju-kosong.png');
            @endphp
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                <div class="avatar avatar-online">
                    <img src="{{ $gambarProfil }}" alt class="w-px-40 rounded-circle fill-box" />
                </div>
            </a>

            <ul class="dropdown-menu dropdown-menu-end">
                <!--Nama & Role-->
                <li>
                    <a class="dropdown-item" href="{{ route('pengguna.profile') }}">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-online">
                                    <img src="{{ $gambarProfil }}" alt class="w-px-40 rounded-circle fill-box" />
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
