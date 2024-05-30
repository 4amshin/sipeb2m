@extends('layout.app')

@section('title', 'Update Pengguna')

@section('content')
    <!--Header-->
    <section class="section">
        <div class="section-header">
            <h1>Edit Data Pengguna</h1>
        </div>
    </section>

    <!--Body-->
    <section class="section-body">
        <div class="card card-primary">
            <div class="card-body">
                <form method="POST" action="{{ route('pengguna.update', $pengguna->id) }}">
                    @csrf
                    @method('PUT')

                    <!--Nama & Nomor Telepon-->
                    <div class="row">
                        <!--Nama-->
                        <div class="form-group col-6">
                            <label for="nama">Nama Lengkap</label>
                            <input id="nama" type="text" class="form-control" name="nama"
                                value="{{ $pengguna->nama }}" autofocus required>
                        </div>

                        <!--Nomor Telepon-->
                        <div class="form-group col-6">
                            <label for="nomor_telepon">Nomor Telepon (Whatsapp)</label>
                            <input id="nomor_telepon" type="text" class="form-control" name="nomor_telepon"
                                value="{{ $pengguna->nomor_telepon }}" autofocus required>
                        </div>
                    </div>

                    <!--Email & Password-->
                    <div class="row">
                        <!--Email-->
                        <div class="form-group col-6">
                            <label for="email">Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ $pengguna->email }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!--Password-->
                        <div class="form-group col-6">
                            <label for="password" class="d-block">Password</label>
                            <div class="input-group">
                                <!--Input Field-->
                                <input id="password" type="password" class="form-control" name="password"
                                    value="{{ $pengguna->password }}">

                                <!--Show/Hide Password-->
                                <div class="input-group-append">
                                    <span class="input-group-text"
                                        onclick="togglePasswordVisibility('password', 'show_eye', 'hide_eye');">
                                        <i class="fas fa-eye" id="show_eye"></i>
                                        <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Tombol Simpan-->
                    <div class="form-group ">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
