@extends('layout.app')

@section('page-title', 'Riwayat Penyewaan')

@section('content')
    <!-- Alert -->
    @include('layout.page-alert')

    <!-- Tabel -->
    <div class="card">

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
