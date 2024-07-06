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
                            <small class="text-muted">Bulan Ini</small>
                        </div>

                        <!--Dropdown-->
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="orederStatistics" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                                <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                                <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                <a class="dropdown-item" href="javascript:void(0);">Share</a>
                            </div>
                        </div>
                    </div>

                    <!--Body-->
                    <div class="card-body">
                        <!--Top Part-->
                        <div class="d-flex justify-content-between align-items-center mb-3" style="position: relative;">
                            <!--SubTitle-->
                            <div class="d-flex flex-column align-items-center gap-1">
                                <h2 class="mb-2">{{ $totalPenyewaan }}</h2>
                                <span>Total Penyewaan</span>
                            </div>

                            <!--Rounded Shape-->
                            <div id="orderStatisticsChart" style="min-height: 137.55px;">
                                <div id="apexchartsrmtx095b" class="apexcharts-canvas apexchartsrmtx095b apexcharts-theme-light"
                                    style="width: 130px; height: 137.55px;"><svg id="SvgjsSvg4644" width="130"
                                        height="137.55" xmlns="http://www.w3.org/2000/svg" version="1.1"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev"
                                        class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)"
                                        style="background: transparent;">
                                        <g id="SvgjsG4646" class="apexcharts-inner apexcharts-graphical"
                                            transform="translate(-7, 0)">
                                            <defs id="SvgjsDefs4645">
                                                <clipPath id="gridRectMaskrmtx095b">
                                                    <rect id="SvgjsRect4648" width="150" height="173" x="-4.5" y="-2.5"
                                                        rx="0" ry="0" opacity="1" stroke-width="0"
                                                        stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                                </clipPath>
                                                <clipPath id="forecastMaskrmtx095b"></clipPath>
                                                <clipPath id="nonForecastMaskrmtx095b"></clipPath>
                                                <clipPath id="gridRectMarkerMaskrmtx095b">
                                                    <rect id="SvgjsRect4649" width="145" height="172" x="-2" y="-2"
                                                        rx="0" ry="0" opacity="1" stroke-width="0"
                                                        stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                                </clipPath>
                                            </defs>
                                            <g id="SvgjsG4650" class="apexcharts-pie">
                                                <g id="SvgjsG4651" transform="translate(0, 0) scale(1)">
                                                    <circle id="SvgjsCircle4652" r="44.835365853658544" cx="70.5"
                                                        cy="70.5" fill="transparent"></circle>
                                                    <g id="SvgjsG4653" class="apexcharts-slices">
                                                        <g id="SvgjsG4654" class="apexcharts-series apexcharts-pie-series"
                                                            seriesName="Electronic" rel="1" data:realIndex="0">
                                                            <path id="SvgjsPath4655"
                                                                d="M 70.5 10.71951219512195 A 59.78048780487805 59.78048780487805 0 0 1 97.63977353321047 123.7648046533095 L 90.85483014990785 110.44860348998213 A 44.835365853658544 44.835365853658544 0 0 0 70.5 25.664634146341456 L 70.5 10.71951219512195 z"
                                                                fill="rgba(105,108,255,1)" fill-opacity="1"
                                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="5"
                                                                stroke-dasharray="0"
                                                                class="apexcharts-pie-area apexcharts-donut-slice-0"
                                                                index="0" j="0" data:angle="153" data:startAngle="0"
                                                                data:strokeWidth="5" data:value="85"
                                                                data:pathOrig="M 70.5 10.71951219512195 A 59.78048780487805 59.78048780487805 0 0 1 97.63977353321047 123.7648046533095 L 90.85483014990785 110.44860348998213 A 44.835365853658544 44.835365853658544 0 0 0 70.5 25.664634146341456 L 70.5 10.71951219512195 z"
                                                                stroke="#ffffff"></path>
                                                        </g>
                                                        <g id="SvgjsG4656" class="apexcharts-series apexcharts-pie-series"
                                                            seriesName="Sports" rel="2" data:realIndex="1">
                                                            <path id="SvgjsPath4657"
                                                                d="M 97.63977353321047 123.7648046533095 A 59.78048780487805 59.78048780487805 0 0 1 70.5 130.28048780487805 L 70.5 115.33536585365854 A 44.835365853658544 44.835365853658544 0 0 0 90.85483014990785 110.44860348998213 L 97.63977353321047 123.7648046533095 z"
                                                                fill="rgba(133,146,163,1)" fill-opacity="1"
                                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="5"
                                                                stroke-dasharray="0"
                                                                class="apexcharts-pie-area apexcharts-donut-slice-1"
                                                                index="0" j="1" data:angle="27" data:startAngle="153"
                                                                data:strokeWidth="5" data:value="15"
                                                                data:pathOrig="M 97.63977353321047 123.7648046533095 A 59.78048780487805 59.78048780487805 0 0 1 70.5 130.28048780487805 L 70.5 115.33536585365854 A 44.835365853658544 44.835365853658544 0 0 0 90.85483014990785 110.44860348998213 L 97.63977353321047 123.7648046533095 z"
                                                                stroke="#ffffff"></path>
                                                        </g>
                                                        <g id="SvgjsG4658" class="apexcharts-series apexcharts-pie-series"
                                                            seriesName="Decor" rel="3" data:realIndex="2">
                                                            <path id="SvgjsPath4659"
                                                                d="M 70.5 130.28048780487805 A 59.78048780487805 59.78048780487805 0 0 1 10.71951219512195 70.50000000000001 L 25.664634146341456 70.5 A 44.835365853658544 44.835365853658544 0 0 0 70.5 115.33536585365854 L 70.5 130.28048780487805 z"
                                                                fill="rgba(3,195,236,1)" fill-opacity="1" stroke-opacity="1"
                                                                stroke-linecap="butt" stroke-width="5" stroke-dasharray="0"
                                                                class="apexcharts-pie-area apexcharts-donut-slice-2"
                                                                index="0" j="2" data:angle="90" data:startAngle="180"
                                                                data:strokeWidth="5" data:value="50"
                                                                data:pathOrig="M 70.5 130.28048780487805 A 59.78048780487805 59.78048780487805 0 0 1 10.71951219512195 70.50000000000001 L 25.664634146341456 70.5 A 44.835365853658544 44.835365853658544 0 0 0 70.5 115.33536585365854 L 70.5 130.28048780487805 z"
                                                                stroke="#ffffff"></path>
                                                        </g>
                                                        <g id="SvgjsG4660" class="apexcharts-series apexcharts-pie-series"
                                                            seriesName="Fashion" rel="4" data:realIndex="3">
                                                            <path id="SvgjsPath4661"
                                                                d="M 10.71951219512195 70.50000000000001 A 59.78048780487805 59.78048780487805 0 0 1 70.48956633664653 10.719513105630845 L 70.4921747524849 25.664634829223125 A 44.835365853658544 44.835365853658544 0 0 0 25.664634146341456 70.5 L 10.71951219512195 70.50000000000001 z"
                                                                fill="rgba(113,221,55,1)" fill-opacity="1" stroke-opacity="1"
                                                                stroke-linecap="butt" stroke-width="5" stroke-dasharray="0"
                                                                class="apexcharts-pie-area apexcharts-donut-slice-3"
                                                                index="0" j="3" data:angle="90" data:startAngle="270"
                                                                data:strokeWidth="5" data:value="50"
                                                                data:pathOrig="M 10.71951219512195 70.50000000000001 A 59.78048780487805 59.78048780487805 0 0 1 70.48956633664653 10.719513105630845 L 70.4921747524849 25.664634829223125 A 44.835365853658544 44.835365853658544 0 0 0 25.664634146341456 70.5 L 10.71951219512195 70.50000000000001 z"
                                                                stroke="#ffffff"></path>
                                                        </g>
                                                    </g>
                                                </g>
                                                <g id="SvgjsG4662" class="apexcharts-datalabels-group"
                                                    transform="translate(0, 0) scale(1)"><text id="SvgjsText4663"
                                                        font-family="Helvetica, Arial, sans-serif" x="70.5" y="90.5"
                                                        text-anchor="middle" dominant-baseline="auto" font-size="0.8125rem"
                                                        font-weight="400" fill="#a1acb8"
                                                        class="apexcharts-text apexcharts-datalabel-label"
                                                        style="font-family: Helvetica, Arial, sans-serif;">Weekly</text><text
                                                        id="SvgjsText4664" font-family="Public Sans" x="70.5" y="71.5"
                                                        text-anchor="middle" dominant-baseline="auto" font-size="1.5rem"
                                                        font-weight="400" fill="#566a7f"
                                                        class="apexcharts-text apexcharts-datalabel-value"
                                                        style="font-family: &quot;Public Sans&quot;;">38%</text></g>
                                            </g>
                                            <line id="SvgjsLine4665" x1="0" y1="0" x2="141"
                                                y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1"
                                                stroke-linecap="butt" class="apexcharts-ycrosshairs"></line>
                                            <line id="SvgjsLine4666" x1="0" y1="0" x2="141"
                                                y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt"
                                                class="apexcharts-ycrosshairs-hidden"></line>
                                        </g>
                                        <g id="SvgjsG4647" class="apexcharts-annotations"></g>
                                    </svg>
                                    <div class="apexcharts-legend"></div>
                                    <div class="apexcharts-tooltip apexcharts-theme-dark">
                                        <div class="apexcharts-tooltip-series-group" style="order: 1;"><span
                                                class="apexcharts-tooltip-marker"
                                                style="background-color: rgb(105, 108, 255);"></span>
                                            <div class="apexcharts-tooltip-text"
                                                style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                <div class="apexcharts-tooltip-y-group"><span
                                                        class="apexcharts-tooltip-text-y-label"></span><span
                                                        class="apexcharts-tooltip-text-y-value"></span></div>
                                                <div class="apexcharts-tooltip-goals-group"><span
                                                        class="apexcharts-tooltip-text-goals-label"></span><span
                                                        class="apexcharts-tooltip-text-goals-value"></span></div>
                                                <div class="apexcharts-tooltip-z-group"><span
                                                        class="apexcharts-tooltip-text-z-label"></span><span
                                                        class="apexcharts-tooltip-text-z-value"></span></div>
                                            </div>
                                        </div>
                                        <div class="apexcharts-tooltip-series-group" style="order: 2;"><span
                                                class="apexcharts-tooltip-marker"
                                                style="background-color: rgb(133, 146, 163);"></span>
                                            <div class="apexcharts-tooltip-text"
                                                style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                <div class="apexcharts-tooltip-y-group"><span
                                                        class="apexcharts-tooltip-text-y-label"></span><span
                                                        class="apexcharts-tooltip-text-y-value"></span></div>
                                                <div class="apexcharts-tooltip-goals-group"><span
                                                        class="apexcharts-tooltip-text-goals-label"></span><span
                                                        class="apexcharts-tooltip-text-goals-value"></span></div>
                                                <div class="apexcharts-tooltip-z-group"><span
                                                        class="apexcharts-tooltip-text-z-label"></span><span
                                                        class="apexcharts-tooltip-text-z-value"></span></div>
                                            </div>
                                        </div>
                                        <div class="apexcharts-tooltip-series-group" style="order: 3;"><span
                                                class="apexcharts-tooltip-marker"
                                                style="background-color: rgb(3, 195, 236);"></span>
                                            <div class="apexcharts-tooltip-text"
                                                style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                <div class="apexcharts-tooltip-y-group"><span
                                                        class="apexcharts-tooltip-text-y-label"></span><span
                                                        class="apexcharts-tooltip-text-y-value"></span></div>
                                                <div class="apexcharts-tooltip-goals-group"><span
                                                        class="apexcharts-tooltip-text-goals-label"></span><span
                                                        class="apexcharts-tooltip-text-goals-value"></span></div>
                                                <div class="apexcharts-tooltip-z-group"><span
                                                        class="apexcharts-tooltip-text-z-label"></span><span
                                                        class="apexcharts-tooltip-text-z-value"></span></div>
                                            </div>
                                        </div>
                                        <div class="apexcharts-tooltip-series-group" style="order: 4;"><span
                                                class="apexcharts-tooltip-marker"
                                                style="background-color: rgb(113, 221, 55);"></span>
                                            <div class="apexcharts-tooltip-text"
                                                style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                <div class="apexcharts-tooltip-y-group"><span
                                                        class="apexcharts-tooltip-text-y-label"></span><span
                                                        class="apexcharts-tooltip-text-y-value"></span></div>
                                                <div class="apexcharts-tooltip-goals-group"><span
                                                        class="apexcharts-tooltip-text-goals-label"></span><span
                                                        class="apexcharts-tooltip-text-goals-value"></span></div>
                                                <div class="apexcharts-tooltip-z-group"><span
                                                        class="apexcharts-tooltip-text-z-label"></span><span
                                                        class="apexcharts-tooltip-text-z-value"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="resize-triggers">
                                <div class="expand-trigger">
                                    <div style="width: 308px; height: 139px;"></div>
                                </div>
                                <div class="contract-trigger"></div>
                            </div>
                        </div>

                        <!--List-->
                        <ul class="p-0 m-0">
                            @foreach ($bajuTerlarisMerged as $item)
                                <!--Item-->
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-success"><i
                                                class="bx bx-closet"></i></span>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h5 class="mb-0">{{ $item->nama_baju }}</h5>
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
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                                <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                            </div>
                        </div>
                    </div>

                    <!--Body-->
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            <li class="d-flex mb-4 pb-1">
                                <div class="avatar flex-shrink-0 me-3">
                                    <img src="../assets/img/icons/unicons/paypal.png" alt="User" class="rounded">
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <small class="text-muted d-block mb-1">Paypal</small>
                                        <h6 class="mb-0">Send money</h6>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0">+82.6</h6>
                                        <span class="text-muted">USD</span>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-4 pb-1">
                                <div class="avatar flex-shrink-0 me-3">
                                    <img src="../assets/img/icons/unicons/wallet.png" alt="User" class="rounded">
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <small class="text-muted d-block mb-1">Wallet</small>
                                        <h6 class="mb-0">Mac'D</h6>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0">+270.69</h6>
                                        <span class="text-muted">USD</span>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-4 pb-1">
                                <div class="avatar flex-shrink-0 me-3">
                                    <img src="../assets/img/icons/unicons/chart.png" alt="User" class="rounded">
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <small class="text-muted d-block mb-1">Transfer</small>
                                        <h6 class="mb-0">Refund</h6>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0">+637.91</h6>
                                        <span class="text-muted">USD</span>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-4 pb-1">
                                <div class="avatar flex-shrink-0 me-3">
                                    <img src="../assets/img/icons/unicons/cc-success.png" alt="User" class="rounded">
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <small class="text-muted d-block mb-1">Credit Card</small>
                                        <h6 class="mb-0">Ordered Food</h6>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0">-838.71</h6>
                                        <span class="text-muted">USD</span>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-4 pb-1">
                                <div class="avatar flex-shrink-0 me-3">
                                    <img src="../assets/img/icons/unicons/wallet.png" alt="User" class="rounded">
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <small class="text-muted d-block mb-1">Wallet</small>
                                        <h6 class="mb-0">Starbucks</h6>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0">+203.33</h6>
                                        <span class="text-muted">USD</span>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex">
                                <div class="avatar flex-shrink-0 me-3">
                                    <img src="../assets/img/icons/unicons/cc-warning.png" alt="User" class="rounded">
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <small class="text-muted d-block mb-1">Mastercard</small>
                                        <h6 class="mb-0">Ordered Food</h6>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0">-92.45</h6>
                                        <span class="text-muted">USD</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--/ Pendapatan Bulanan -->
        </div>
    @endcan

@endsection
