@extends('layout.app')

@section('page-title', 'Orderan')

@section('content')
    <!-- Alert -->
    @include('layout.page-alert')

    <!--Keterangan Status-->
    <div class="card p-3">
        <div class="row gx-3">
            <div class="col-md-4 d-flex align-items-start">
                <div class="content-right">
                    <span class="badge bg-label-warning me-1">DiProses</span>
                    <p class="mb-0 lh-1">Pesanan sedang dalam tahap verifikasi dan penyiapan</p>
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center">
                <div class="content-right">
                    <span class="badge bg-label-success me-1">DiTerima</span>
                    <p class="mb-0 lh-1">Pesanan telah disetujui dan akan segera diproses lebih lanjut</p>
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center">
                <div class="content-right">
                    <span class="badge bg-label-danger me-1">DiTolak</span>
                    <p class="mb-0 lh-1">Pesanan tidak disetujui, kemungkinan karena alasan tertentu seperti stok habis atau informasi yang tidak valid</p>
                </div>
            </div>
        </div>
    </div>


    <!-- Tabel -->
    <div class="card mt-2">
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        @can('super-user')
                            <th>Pelanggan</th>
                            <th>Alamat</th>
                            <th>No.Telepon</th>
                        @endcan
                        <th>Baju DiOrder</th>
                        <th>Harga Total</th>
                        <th>Tanggal Sewa</th>
                        <th>Status</th>
                        @can('super-user')
                            <th>Aksi</th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($daftarOrderan as $index => $transaksi)
                        <tr>
                            <td>
                                {{ $index + $daftarOrderan->firstItem() }}
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
                                @switch($transaksi->status_order)
                                    @case('diproses')
                                        <span class="badge bg-label-warning me-1">DiProses</span>
                                    @break

                                    @case('diterima')
                                        <span class="badge bg-label-success me-1">DiTerima</span>
                                    @break

                                    @case('ditolak')
                                        <span class="badge bg-label-danger me-1">DiTolak</span>
                                    @break

                                    @default
                                        <span class="badge bg-label-info me-1">Status Tidak Dikenali</span>
                                @endswitch
                            </td>

                            @can('super-user')
                                @if ($transaksi->status_order == 'diproses')
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <!--Tombol Terima-->
                                                <a href="{{ route('transaksi.terimaOrderan', $transaksi->id) }}"
                                                    class="dropdown-item">
                                                    <i class='bx bx-check me-1'></i> Terima Order
                                                </a>

                                                <!--Tombol Tolak-->
                                                <a href="{{ route('transaksi.tolakOrderan', $transaksi->id) }}"
                                                    class="dropdown-item">
                                                    <i class='bx bx-x me-1'></i> Tolak Order
                                                </a>

                                                <!--Tombol Tolak/Hapus-->
                                                {{-- <form action="{{ route('transaksi.destroy', $transaksi->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item">
                                                    <i class='bx bx-x me-1'></i> Tolak
                                                </button>
                                            </form> --}}
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
                    {{ $daftarOrderan->withQueryString()->links() }}
                </ul>
            </nav>

        </div>
        <!--/ Basic Bootstrap Table -->

    @endsection
