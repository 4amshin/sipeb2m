@extends('layout.app')

@section('page-title', 'Daftar Baju')

@section('content')
    <!-- Alert -->
    @include('layout.page-alert')

    <!-- Tabel -->
    <div class="card">
        <div class="float-left p-3">
            <a href="{{ route('baju.create') }}" class="btn btn-primary"> Tambah Baju</a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        {{-- <th>Gambar</th> --}}
                        <th>Baju</th>
                        <th>Ukuran</th>
                        <th>Stok</th>
                        <th>Harga Sewa/Hari</th>
                        @can('super-user')
                            <th>Aksi</th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($daftarBaju as $index => $baju)
                        <tr>
                            <td>
                                {{ $index + $daftarBaju->firstItem() }}
                            </td>
                            {{-- <td>
                                <img src="{{ asset('storage/gambar-baju/' . $baju->gambar_baju) }}"
                                    alt="{{ $baju->nama_baju }}" class="d-block rounded" height="50" width="50"
                                    id="uploadedAvatar">
                            </td> --}}
                            <td>
                                {{ $baju->nama_baju }}
                            </td>
                            <td>
                                <span class="badge bg-label-primary me-1">
                                    {{ $baju->ukuran }}
                                </span>
                            </td>
                            <td>
                                {{ $baju->stok }}pcs
                            </td>
                            <td>
                                Rp{{ number_format($baju->harga_sewa_perhari, 0, ',', '.') }}
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
                                            <a href="{{ route('baju.edit', $baju->id) }}" class="dropdown-item">
                                                <i class="bx bx-edit-alt me-1"></i> Edit
                                            </a>

                                            <!--Tombol Hapus-->
                                            <form action="{{ route('baju.destroy', $baju->id) }}" method="POST">
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
                {{ $daftarBaju->withQueryString()->links() }}
            </ul>
        </nav>

    </div>
    <!--/ Basic Bootstrap Table -->

@endsection
