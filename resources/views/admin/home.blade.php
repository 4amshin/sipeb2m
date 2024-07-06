@extends('layout.app')

@section('page-title', 'Beranda')

@section('content')
    <div class="row">
        <!--Card Welcome-->
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">

                    <!--Card Welcome-->
                    <div class="col-sm-7">
                        <div class="card-body">

                            {{-- Menampilkan pesan selamat datang sesuai dengan peran pengguna --}}
                            @php
                                $user = auth()->user();
                                $name = $user->name;
                                if ($user->role === 'admin') {
                                    $role = 'Admin';
                                } else {
                                    $role = 'Pengguna';
                                }
                            @endphp

                            <h5 class="card-title text-primary">Selamat Datang {{ $name }}! 🎉</h5>
                            <p class="mb-4">
                                Lengkapi Profil anda untuk melakukan penyewaan, klik tombol 'Lihat Profil' dibawah ini untuk
                                melengkapi profil.
                            </p>

                            <a href="{{ route('pengguna.profile') }}" class="btn btn-sm btn-outline-primary">Lihat Profil</a>
                        </div>
                    </div>

                    <!--Vector Image-->
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="../assets/img/illustrations/man-with-laptop-light.png" height="140"
                                alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png" />
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @can('super-user')
        <div class="row">
            <!-- Baju Terlaris -->
            <div class="col-md-6 col-lg-6 col-xl-6 order-0 mb-4">
                <div class="card h-100">
                    <!--Top Part-->
                    <div class="card-header d-flex align-items-center justify-content-between pb-0">
                        <!--Title-->
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">Baju Terlaris</h5>
                        </div>

                        <!--Dropdown-->
                        {{-- <div class="dropdown">
                            <button class="btn p-0" type="button" id="orederStatistics" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                                <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                                <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                <a class="dropdown-item" href="javascript:void(0);">Share</a>
                            </div>
                        </div> --}}
                    </div>

                    <!--Body-->
                    <div class="card-body mt-4">
                        <!--List-->
                        <ul class="p-0 m-0">
                            @foreach ($bajuTerlarisMerged as $item)
                                <!--Item-->
                                <li class="d-flex mb-3 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-success"><i
                                                class="bx bx-closet"></i></span>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">{{ $item->nama_baju }}</h5>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $item->total_penyewaan }}Pcs</small>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <!--/ Baju Terlaris -->

            <!-- Pendapatan Bulanan -->
            <div class="col-md-6 col-lg-6 order-2 mb-4">
                <div class="card h-100">
                    <!--Top Part-->
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <!--Title-->
                        <h5 class="card-title m-0 me-2">Pendapatan Bulanan</h5>

                        <!--Dropdown-->
                        {{-- <div class="dropdown">
                            <button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                                <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                            </div>
                        </div> --}}
                    </div>

                    <!--Body-->
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            @foreach ($pendapatanBulanan as $pendapatan)
                                <li class="d-flex mb-3 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <img src="../assets/img/icons/unicons/wallet.png" alt="User" class="rounded">
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">
                                                {{ \Carbon\Carbon::parse($pendapatan->bulan)->isoFormat('MMMM YYYY') }}
                                            </h6>
                                        </div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <span class="text-muted">Rp</span>
                                            <h6 class="mb-0">
                                                {{ number_format($pendapatan->total_pendapatan, 0, ',', '.') }}
                                            </h6>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <!--/ Pendapatan Bulanan -->
        </div>
    @endcan

@endsection
