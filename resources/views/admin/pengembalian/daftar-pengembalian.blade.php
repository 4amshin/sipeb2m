@extends('layout.app')

@section('page-title', 'Pengembalian')

@section('content')
    <!-- Alert -->
    @include('layout.page-alert')



    <!-- Tabel -->
    <div class="card mb-3">
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        @can('super-user')
                            <th>Penyewa</th>
                        @endcan
                        <th>Baju Disewa</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        @can('super-user')
                            <th>Aksi</th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($daftarPengembalian as $index => $pengembalian)
                        <tr>
                            <td>
                                {{ $index + $daftarPengembalian->firstItem() }}
                            </td>
                            @can('super-user')
                                <td>
                                    <strong>
                                        {{ $pengembalian->transaksi->nama_penyewa }}
                                    </strong>
                                </td>
                            @endcan
                            <td>
                                @foreach ($pengembalian->transaksi->detailTransaksi as $detail)
                                    {{ $detail->baju->nama_baju }} ({{ $detail->ukuran }}, {{ $detail->jumlah }}Pcs)<br>
                                @endforeach
                            </td>
                            <td>
                                @switch($pengembalian->status)
                                    @case('belum_diKembalikan')
                                        <span class="badge bg-label-warning me-1">Belum DiKembalikan</span>
                                    @break

                                    @case('diKembalikan')
                                        <span class="badge bg-label-success me-1">DiKembalikan</span>
                                    @break

                                    @case('terlambat')
                                        <span class="badge bg-label-info me-1">Terlambat</span>
                                    @break

                                    @default
                                        <span class="badge bg-label-info me-1">Status Tidak Dikenali</span>
                                @endswitch
                            </td>
                            <td>
                                @if ($pengembalian->tanggal_kembali != null)
                                    {{ formatDate($pengembalian->tanggal_kembali) }}
                                @else
                                    -
                                @endif
                            </td>
                            @can('super-user')
                                @if ($pengembalian->status == 'belum_diKembalikan')
                                    <td>
                                        <!--Tombol Dikembalikan-->
                                        <a href="{{ route('pengembalian.tandaiKembali', $pengembalian->id) }}"
                                            class="btn btn-primary">
                                            <i class='bx bx-check-double'></i> Tandai Kembali
                                        </a>
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
                    {{ $daftarPengembalian->withQueryString()->links() }}
                </ul>
            </nav>

    </div>

     <!--Keterangan Status-->
     <div class="card p-3">
        <div class="row gx-3">
            <div class="col-md-4 d-flex align-items-start">
                <div class="content-right">
                    <span class="badge bg-label-warning me-1">Belum DiKembalikan</span>
                    <p class="mb-0 lh-1">Barang yang disewa telah dikembalikan ke toko</p>
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center">
                <div class="content-right">
                    <span class="badge bg-label-success me-1">DiKembalikan</span>
                    <p class="mb-0 lh-1">Barang yang disewa belum dikembalikan ke toko</p>
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center">
                <div class="content-right">
                    <span class="badge bg-label-info me-1">Terlambat</span>
                    <p class="mb-0 lh-1">Pengembalian barang melebihi batas waktu yang ditentukan</p>
                </div>
            </div>
        </div>
    </div>

    @endsection
