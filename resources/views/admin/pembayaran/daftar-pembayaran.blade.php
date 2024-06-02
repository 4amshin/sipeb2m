@extends('layout.app')

@section('page-title', 'Daftar Pembayaran')

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
                        <th>Penyewa</th>
                        <th>Baju Disewa</th>
                        <th>Pembayaran Masuk</th>
                        <th>Metode Pembayaran</th>
                        <th>Status</th>
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
                            <td>
                                <strong>
                                    {{ $pembayaran->transaksi->nama_penyewa }}
                                </strong>
                            </td>
                            <td>
                                @foreach ($pembayaran->transaksi->detailTransaksi as $detail)
                                    {{ $detail->baju->nama_baju }} ({{ $detail->ukuran }}, {{ $detail->jumlah }}Pcs)<br>
                                @endforeach
                            </td>
                            <td>
                                Rp{{ number_format($pembayaran->pembayaran_masuk, 0, ',', '.') }} /
                                Rp{{ number_format($pembayaran->transaksi->harga_total, 0, ',', '.') }}
                            </td>
                            <td>
                                {{ $pembayaran->metode_pembayaran }}
                            </td>
                            <td>
                                @switch($pembayaran->status_pembayaran)
                                    @case('belum_lunas')
                                        <span class="badge bg-label-warning me-1">Belum Lunas</span>
                                    @break

                                    @case('lunas')
                                        <span class="badge bg-label-success me-1">Lunas</span>
                                    @break

                                    @default
                                        <span class="badge bg-label-info me-1">Status Tidak Dikenali</span>
                                @endswitch
                            </td>
                            @can('super-user')
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <!--Tombol Update-->
                                            <a href="{{ route('pembayaran.edit', $pembayaran->id) }}" class="dropdown-item">
                                                <i class="bx bx-edit-alt me-1"></i> Edit
                                            </a>

                                            <!--Tombol Hapus-->
                                            <form action="{{ route('pembayaran.destroy', $pembayaran->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item">
                                                    <i class="bx bx-trash me-1"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
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
        <!--/ Basic Bootstrap Table -->

    @endsection
