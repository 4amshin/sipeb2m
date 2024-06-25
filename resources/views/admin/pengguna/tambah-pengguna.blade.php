@extends('layout.app')

@section('page-title', 'Tambah Pengguna')

@section('content')
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-body">
                    <form method="POST" action="{{ route('pengguna.store') }}">
                        @csrf
                        <!--Role-->
                        <input type="hidden" name="role" id="role" value="pengguna">

                        <!--Nama & Nomor Telepon-->
                        <div class="row">
                            <!--Nama-->
                            <div class="col-6 mb-3">
                                <label class="form-label" for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" autofocus required>
                            </div>

                            <!--Jenis Kelamin-->
                            <div class="col-md">
                                <small class="text-light fw-semibold d-block">Jenis Kelamin</small>
                                <div class="form-check form-check-inline mt-3">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki-laki" value="laki-laki">
                                    <label class="form-check-label" for="laki-laki">Laki-Laki</label>
                                </div>
                                <div class="form-check form-check-inline mt-3">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="perempuan">
                                    <label class="form-check-label" for="perempuan">Perempuan</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!--Nomor Telepon-->
                            <div class="col-6 mb-3">
                                <label class="form-label" for="nomor_telepon">Nomor Telepon (Whatsapp)</label>
                                <input type="text" id="nomor_telepon" name="nomor_telepon"
                                    class="form-control phone-mask">
                            </div>
                            <!--Alamat-->
                            <div class="col-6 mb-3">
                                <label class="form-label" for="alamat">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat">
                            </div>
                        </div>

                        <div class="row">
                            <!--Email-->
                            <div class="col-6 mb-3">
                                <label for="email" class="form-label">Email </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="Masukkan Email Anda" autofocus />

                                <!--Pesan Eror-->
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!--Password-->
                            <div class="col-6 mb-3 form-password-toggle">
                                <!--Label & Link Lupa Password-->
                                <div class="d-flex justify-content-between">
                                    <!--Label-->
                                    <label class="form-label" for="password">Password</label>
                                </div>

                                <div class="input-group input-group-merge">
                                    <input type="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                        </div>


                        <!--Tombol Submit-->
                        <div class="row p-2">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
