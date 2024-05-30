@extends('layout.app')

@section('title', 'Daftar Pengguna')

@section('content')
    <section class="section">
        <!--Header-->
        <div class="section-header">
            <h1>Daftar Pengguna</h1>
        </div>

        <!--Body-->
        <div class="section-body">
            <!--Notifikasi Singkat-->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @elseif (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <!--Tombol-->
                            @can('super-user')
                                <!--Tombol Tambah Pengguna-->
                                <div class="float-left">
                                    <a href="{{ route('pengguna.create') }}" class="btn btn-primary btn-lg">Tambah Pengguna</a>
                                </div>
                            @endcan

                            <!--Pencarian-->
                            <div class="float-right">
                                <form method="GET">
                                    <div class="input-group">
                                        <input name="search" type="text" class="form-control" placeholder="Search">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!--Spacer-->
                            <div class="clearfix mb-3"></div>

                            <!--Tabel-->
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Nomor Telepon</th>
                                        <th>Alamat</th>
                                        <th>Email</th>
                                        <th>Password</th>
                                        @can('super-user')
                                            <th>Aksi</th>
                                        @endcan
                                    </tr>

                                    @forelse ($daftarPengguna as $index => $pengguna)
                                        <tr>
                                            <td>
                                                {{ $index + $daftarPengguna->firstItem() }}
                                            </td>
                                            <td>
                                                {{ $pengguna->nama }}
                                            <td>
                                                {{ $pengguna->nomor_telepon }}
                                            </td>
                                            <td>
                                                {{ $pengguna->alamat }}
                                            </td>
                                            <td>
                                                {{ $pengguna->email }}
                                            </td>
                                            <td>
                                                <div class="bg-secondary text-white">
                                                    <center>
                                                        {{ $pengguna->password }}
                                                    </center>

                                                </div>
                                            </td>
                                            @can('super-user')
                                                <td>
                                                    <div class="row">
                                                        <!--Tombol Update-->
                                                        <a href="{{ route('pengguna.edit', $pengguna->id) }}"
                                                            class="btn btn-primary">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>
                                                        <div style="width: 10px;"></div>

                                                        <!--Tombol Hapus-->
                                                        <form action="{{ route('pengguna.destroy', $pengguna->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger" id="delete-confirm">
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            @endcan
                                        </tr>
                                    @empty
                                        <tr>
                                            <td>Data Tidak Ditemukan</td>
                                        </tr>
                                    @endforelse

                                </table>
                            </div>

                            <!--Navigasi Halaman-->
                            <div class="float-right">
                                <nav>
                                    <ul class="pagination">
                                        {{ $daftarPengguna->withQueryString()->links() }}
                                    </ul>
                                </nav>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
