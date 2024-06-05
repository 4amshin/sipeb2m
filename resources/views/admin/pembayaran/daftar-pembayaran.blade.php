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
                        @can('super-user')
                            <th>Penyewa</th>
                        @endcan
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
                                @if ($pembayaran->status_pembayaran == 'belum_lunas')
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <!--Tombol Tandai Lunas-->
                                                <a href="{{ route('pembayaran.tandaiLunas', $pembayaran->id) }}"
                                                    class="dropdown-item">
                                                    <i class='bx bx-check-double me-1'></i></i> Tandai Lunas
                                                </a>

                                                <!-- Tombol Update Pembayaran -->
                                                <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#updatePembayaranModal{{ $pembayaran->id }}">
                                                    <i class="bx bx-edit-alt me-1"></i> Update Pembayaran
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                @endif
                            @endcan
                        </tr>

                        <!-- Modal Update Pembayaran -->
                        <div class="modal fade" id="updatePembayaranModal{{ $pembayaran->id }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel{{ $pembayaran->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                <!--Modal-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel{{ $pembayaran->id }}">Update
                                            Pembayaran</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('pembayaran.updatePembayaran', $pembayaran->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')

                                        <!--Form Input-->
                                        <div class="modal-body">
                                            <!--Pembayaran Masuk-->
                                            <div class="row">
                                                <div class="col mb-3">
                                                    <label for="pembayaranMasuk{{ $pembayaran->id }}"
                                                        class="form-label">Pembayaran Masuk</label>
                                                    <input type="number" id="pembayaranMasuk{{ $pembayaran->id }}"
                                                        name="pembayaran_masuk" class="form-control"
                                                        value="{{ $pembayaran->pembayaran_masuk }}" required>
                                                </div>
                                            </div>

                                            <!--Metode Pembayran-->
                                            <div class="row">
                                                <div class="col mb-3">
                                                    <label for="metodePembayaran{{ $pembayaran->id }}"
                                                        class="form-label">Metode Pembayaran</label>
                                                    <input type="text" id="metodePembayaran{{ $pembayaran->id }}"
                                                        name="metode_pembayaran" class="form-control"
                                                        value="{{ $pembayaran->metode_pembayaran }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <!--Tombol-->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

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
