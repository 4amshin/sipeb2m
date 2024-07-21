<div class="table-responsive text-nowrap">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                @can('super-user')
                    <th>Pelanggan</th>
                    <th>Jaminan</th>
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
            @forelse ($orderList as $index => $transaksi)
                <tr>
                    <td>{{ $index + $orderList->firstItem() }}</td>
                    @can('super-user')
                        <td><strong>{{ $transaksi->nama_penyewa }}</strong></td>
                        <td>
                            <img src="{{ $transaksi->foto_ktp ? asset('storage/foto-ktp/' . $transaksi->foto_ktp) : asset('assets/img/baju-kosong.png') }}"
                                alt="user-avatar" class="d-block rounded fill-box" height="70" width="100"
                                id="uploadedAvatar" data-bs-toggle="modal" data-bs-target="#imageModal{{ $transaksi->id }}" />
                        </td>
                        <td>{{ $transaksi->alamat_penyewa }}</td>
                        <td><span class="badge bg-label-info me-1">{{ $transaksi->noTelepon_penyewa }}</span></td>
                    @endcan
                    <td>
                        @foreach ($transaksi->detailTransaksi as $detail)
                            {{ $detail->baju->nama_baju }} ({{ $detail->ukuran }}, {{ $detail->jumlah }}Pcs)<br>
                        @endforeach
                    </td>
                    <td>Rp{{ number_format($transaksi->harga_total, 0, ',', '.') }}</td>
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
                                    </div>
                                </div>
                            </td>
                        @endif
                    @endcan
                </tr>

                <!-- Modal Image View -->
                <div class="modal fade" id="imageModal{{ $transaksi->id }}" tabindex="-1"
                    aria-labelledby="imageModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="imageModalLabel">Foto KTP
                                    {{ $transaksi->nama_penyewa }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src="{{ $transaksi->foto_ktp ? asset('storage/foto-ktp/' . $transaksi->foto_ktp) : asset('assets/img/baju-kosong.png') }}"
                                    alt="Foto KTP" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>

                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">Belum ada orderan {{ $status }}.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3 mx-3">
            {{ $orderList->links('pagination::bootstrap-5') }}
        </div>
    </div>
