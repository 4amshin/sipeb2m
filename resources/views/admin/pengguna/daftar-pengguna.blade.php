@extends('layout.app')

@section('page-title', 'Daftar Pengguna')

@section('content')
    <!-- Alert -->
    @include('layout.page-alert')

    <!-- Tabel -->
    <div class="card">
        <div class="float-left p-3">
            <a href="{{ route('pengguna.create') }}" class="btn btn-primary"> Tambah Pengguna</a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th class="text-center">Foto Profil</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Nomor Telepon</th>
                        <th>Alamat</th>
                        <th>Email</th>
                        <th>Password</th>
                        @can('super-user')
                            <th>Aksi</th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($daftarPengguna as $index => $pengguna)
                        <tr>
                            <td>
                                {{ $index + $daftarPengguna->firstItem() }}
                            </td>
                            <td class="align-center">
                                <div class="avatar">
                                    <img src="{{ $pengguna->gambar_profil ? asset('storage/profil/' . $pengguna->gambar_profil) : asset('assets/img/baju-kosong.png') }}"
                                        alt class="w-px-40 rounded-circle fill-box w-p"/>
                                </div>
                                {{-- <img src="{{ $pengguna->gambar_profil ? asset('storage/profil/' . $pengguna->gambar_profil) : asset('assets/img/baju-kosong.png') }}"
                                    alt="Avatar" class="rounded-circle fill-box" width="50px"> --}}
                            </td>
                            <td>
                                <strong>
                                    {{ $pengguna->nama }}
                                </strong>
                            </td>
                            <td>
                                {{ $pengguna->jenis_kelamin == 'laki-laki' ? 'Laki Laki' : 'Perempuan' }}
                            </td>
                            <td>
                                <span class="badge bg-label-info me-1">
                                    {{ $pengguna->nomor_telepon }}
                                </span>
                            </td>
                            <td>
                                {{ $pengguna->alamat }}
                            </td>
                            <td>
                                {{ $pengguna->email }}
                            </td>
                            <td>
                                {{ $pengguna->password }}
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
                                            <a href="{{ route('pengguna.edit', $pengguna->id) }}" class="dropdown-item">
                                                <i class="bx bx-edit-alt me-1"></i> Edit
                                            </a>

                                            <!--Tombol Hapus-->
                                            <form action="{{ route('pengguna.destroy', $pengguna->id) }}" method="POST">
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
                {{ $daftarPengguna->withQueryString()->links() }}
            </ul>
        </nav>

    </div>
    <!--/ Basic Bootstrap Table -->

@endsection
