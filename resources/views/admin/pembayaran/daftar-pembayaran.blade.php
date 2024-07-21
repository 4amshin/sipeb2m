@extends('layout.app')

@section('page-title', 'Pembayaran')

@push('customCss')
    <link rel="stylesheet" href="{{ asset('assets/css/file-upload.css') }}">
@endpush

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
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Metode Pembayaran</th>
                        <th>Bukti Pembayaran</th>
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
                            <td>
                                {{ $pembayaran->metode_pembayaran }}
                            </td>
                            <td>
                                <img src="{{ $pembayaran->bukti_pembayaran ? asset('storage/bukti-pembayaran/' . $pembayaran->bukti_pembayaran) : asset('assets/img/baju-kosong.png') }}"
                                    alt="user-avatar" class="d-block rounded fill-box" height="75" width="100"
                                    id="uploadedAvatar" data-bs-toggle="modal"
                                    data-bs-target="#imageModal{{ $pembayaran->id }}" />
                            </td>
                            <!--Tombol Pembayaran (PENGGUNA)-->
                            @can('pengguna-only')
                                @if ($pembayaran->status_pembayaran == 'belum_bayar' && $pembayaran->metode_pembayaran == null)
                                    <!-- Tombol Bayar -->
                                    <td>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#updatePembayaranModal{{ $pembayaran->id }}">
                                            Bayar
                                        </button>
                                    </td>
                                @elseif ($pembayaran->status_pembayaran == 'belum_bayar' && $pembayaran->metode_pembayaran && $pembayaran->bukti_pembayaran)
                                    <!-- Tombol Update Pembayaran -->
                                    <td>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#updatePembayaranModal{{ $pembayaran->id }}">
                                            Update Pembayaran
                                        </button>
                                    </td>
                                @endif
                            @endcan
                            <!--Tombol Tandai Lunas (ADMIN)-->
                            @can('super-user')
                                @if ($pembayaran->status_pembayaran == 'belum_bayar')
                                    <td>
                                        <a href="{{ route('pembayaran.tandaiLunas', $pembayaran->id) }}"
                                            class="btn btn-success">
                                            Tandai Lunas
                                        </a>
                                    </td>
                                @endif
                            @endcan
                        </tr>

                        <!-- Modal Pembayaran -->
                        <div class="modal fade" id="updatePembayaranModal{{ $pembayaran->id }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel{{ $pembayaran->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                <!--Modal-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel{{ $pembayaran->id }}">
                                            Pembayaran
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('pembayaran.buktiPembayaran', $pembayaran->id) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <!--Form Input-->
                                        <div class="modal-body">
                                            <!--Metode Pembayran-->
                                            <div class="row">
                                                <div class="col mb-3">
                                                    <label for="metodePembayaran{{ $pembayaran->id }}"
                                                        class="form-label">Metode Pembayaran</label>
                                                    <input type="text" id="metodePembayaran{{ $pembayaran->id }}"
                                                        name="metode_pembayaran" class="form-control"
                                                        value="{{ $pembayaran->metode_pembayaran }}"
                                                        placeholder="Contoh: Tunai atau Transfer" required>
                                                </div>
                                            </div>
                                            <!--Bukti Pembayaran-->
                                            <div class="row">
                                                <div class="fl-container">
                                                    <input type="file" id="file" accept="image/*"
                                                        name="bukti_pembayaran" hidden>
                                                    <div class="img-area" data-img="">
                                                        <i class='bx bxs-cloud-upload icon'></i>
                                                        <h3>Upload Bukti Pembayaran</h3>
                                                        <p>Ukuran gambar maksimal <span>2MB</span></p>
                                                    </div>
                                                    <button type="button" class="fl-select-image">Pilih Gambar</button>
                                                </div>
                                            </div>
                                        </div>
                                        <!--Tombol-->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>


                        <!-- Modal Image View -->
                        <div class="modal fade" id="imageModal{{ $pembayaran->id }}" tabindex="-1"
                            aria-labelledby="imageModalLabel{{ $pembayaran->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="imageModalLabel{{ $pembayaran->id }}">Bukti Pembayaran
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="{{ $pembayaran->bukti_pembayaran ? asset('storage/bukti-pembayaran/' . $pembayaran->bukti_pembayaran) : asset('assets/img/baju-kosong.png') }}"
                                            alt="user-avatar" class="img-fluid rounded" />
                                    </div>
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

    @push('customJs')
        <script src="{{ asset('assets/js/file-upload.js') }}"></script>
    @endpush
