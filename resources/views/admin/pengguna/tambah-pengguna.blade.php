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
                                <label class="form-label" for="nama_penyewa">Nama</label>
                                <input type="text" class="form-control" id="nama_penyewa" name="nama_penyewa" autofocus
                                    required>
                            </div>

                            <!--Nomor Telepon-->
                            <div class="col-6 mb-3">
                                <label class="form-label" for="noTelepon_penyewa">Nomor Telepon (Whatsapp)</label>
                                <input type="text" id="noTelepon_penyewa" name="noTelepon_penyewa"
                                    class="form-control phone-mask">
                            </div>
                        </div>

                        <!--Alamat-->
                        <div class="mb-3">
                            <label class="form-label" for="alamat_penyewa">Alamat</label>
                            <input type="text" class="form-control" id="alamat_penyewa" name="alamat_penyewa">
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
