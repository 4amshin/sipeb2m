@extends('layout.app')

@section('page-title', 'Penyewaan')

@section('content')
    <!-- Alert -->
    @include('layout.page-alert')

    <!-- Tabel -->
    <div class="card">
        @can('super-user')
            <div class="float-left p-3">
                <a href="{{ route('transaksi.create') }}" class="btn btn-primary"> Tambah Penyewaan</a>
            </div>
        @endcan


        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        @can('super-user')
                            <th>Penyewa</th>
                            <th>Alamat</th>
                            <th>No.Telepon</th>
                        @endcan
                        <th>Baju Disewa</th>
                        <th>Harga Total</th>
                        <th>Tanggal Sewa</th>
                        <th>Status</th>
                        @can('super-user')
                            <th>Aksi</th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($daftarTransaksi as $index => $transaksi)
                        <tr>
                            <td>
                                {{ $index + $daftarTransaksi->firstItem() }}
                            </td>
                            @can('super-user')
                                <td>
                                    <strong>
                                        {{ $transaksi->nama_penyewa }}
                                    </strong>
                                </td>
                                <td>
                                    {{ $transaksi->alamat_penyewa }}
                                </td>
                                <td>
                                    <span class="badge bg-label-info me-1">{{ $transaksi->noTelepon_penyewa }}</span>

                                </td>
                            @endcan
                            <td>
                                @foreach ($transaksi->detailTransaksi as $detail)
                                    {{ $detail->baju->nama_baju }} ({{ $detail->ukuran }}, {{ $detail->jumlah }}Pcs)<br>
                                @endforeach
                            </td>
                            <td>
                                Rp{{ number_format($transaksi->harga_total, 0, ',', '.') }}
                            </td>
                            <td>
                                @php
                                    $tanggalSewa = \Carbon\Carbon::parse($transaksi->tanggal_sewa)->locale('id');
                                    $tanggalKembali = \Carbon\Carbon::parse($transaksi->tanggal_kembali)->locale('id');
                                @endphp

                                @if ($tanggalSewa->isSameMonth($tanggalKembali))
                                    {{ $tanggalSewa->isoFormat('DD') }} - {{ $tanggalKembali->isoFormat('DD MMMM YYYY') }}
                                @else
                                    {{ $tanggalSewa->isoFormat('DD MMMM') }} -
                                    {{ $tanggalKembali->isoFormat('DD MMMM YYYY') }}
                                @endif
                            </td>
                            <td>
                                @switch($transaksi->status_sewa)
                                    @case('sudah_lunas')
                                        <span class="badge bg-label-success me-1">Sudah Lunas</span>
                                    @break

                                    @case('sudah_ambil')
                                        <span class="badge bg-label-primary me-1">Sudah Diambil</span>
                                    @break

                                    @case('dikirim')
                                        <span class="badge bg-label-info me-1">Sudah Dikirim</span>
                                    @break

                                    @default
                                        <span class="badge bg-label-info me-1">Status Tidak Dikenali</span>
                                @endswitch
                            </td>

                            @can('super-user')
                                @if ($transaksi->status_sewa == 'sudah_lunas')
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <!--Tombol Sudah Diambil-->
                                                <a href="{{ route('transaksi.diAmbil', $transaksi->id) }}"
                                                    class="dropdown-item">
                                                    <i class='bx bx-check-circle me-1'></i> Tandai Diambil
                                                </a>

                                                <!--Tombol Sudah Dikirim-->
                                                <a href="{{ route('transaksi.diKirim', $transaksi->id) }}"
                                                    class="dropdown-item">
                                                    <i class='bx bx-archive me-1'></i> Tandai Dikirim
                                                </a>


                                            </div>
                                        </div>
                                    </td>
                                @endif
                            @endcan
                        </tr>
                        @empty
                            <tr>
                                <td>Data Tidak Ditemukan</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            <!--Navigasi Halaman-->
            <nav class="p-3" aria-label="Page navigation">
                <ul class="pagination justify-content-end">
                    {{ $daftarTransaksi->withQueryString()->links() }}
                </ul>
            </nav>

        </div>
        <!--/ Basic Bootstrap Table -->

    @endsection
