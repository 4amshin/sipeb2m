@extends('layout.app')

@section('page-title', 'Pembayaran')

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
                        <th>Total Harga</th>
                        {{-- <th>Metode Pembayaran</th> --}}
                        <th>Status</th>
                        <th>Tanggal</th>
                        @can('super-user')
                            <th>Aksi</th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($daftarPembayaran as $index => $pembayaran)
                        <tr>
                            <td>
                                {{ $index + $daftarPembayaran->firstItem() }}
                            </td>
                            @can('super-user')
                                <td>
                                    <strong>
                                        {{ $pembayaran->transaksi->nama_penyewa }}
                                    </strong>
                                </td>
                            @endcan
                            <td>
                                @foreach ($pembayaran->transaksi->detailTransaksi as $detail)
                                    {{ $detail->baju->nama_baju }} ({{ $detail->ukuran }}, {{ $detail->jumlah }}Pcs)<br>
                                @endforeach
                            </td>
                            <td>
                                Rp{{ number_format($pembayaran->transaksi->harga_total, 0, ',', '.') }}
                            </td>
                            <td>
                                @switch($pembayaran->status_pembayaran)
                                    @case('belum_bayar')
                                        <span class="badge bg-label-warning me-1">Belum DiBayar</span>
                                    @break

                                    @case('dibayar')
                                        <span class="badge bg-label-success me-1">Lunas</span>
                                    @break

                                    @default
                                        <span class="badge bg-label-info me-1">Status Tidak Dikenali</span>
                                @endswitch
                            </td>
                            <td>
                                @if ($pembayaran->tanggal_pembayaran != null)
                                    {{ formatDate($pembayaran->tanggal_pembayaran) }}
                                @else
                                    -
                                @endif
                            </td>
                            @can('super-user')
                                @if ($pembayaran->status_pembayaran == 'belum_bayar')
                                    <td>
                                        <a href="{{ route('pembayaran.tandaiLunas', $pembayaran->id) }}" class="btn btn-success">
                                            Tandai Lunas
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
                    {{ $daftarPembayaran->withQueryString()->links() }}
                </ul>
            </nav>
    </div>

    <!--Keterangan Status-->
    <div class="card p-3">
        <div class="row gx-3">
            <div class="col-md-6 d-flex align-items-start">
                <div class="content-right">
                    <span class="badge bg-label-warning me-1">Belum DiBayar</span>
                    <p class="mb-0 lh-1">Pembayaran belum diterima atau belum dikonfirmasi</p>
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-center">
                <div class="content-right">
                    <span class="badge bg-label-success me-1">Lunas</span>
                    <p class="mb-0 lh-1">Pembayaran telah diterima dan dikonfirmasi</p>
                </div>
            </div>
        </div>
    </div>

    @endsection
