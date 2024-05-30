@extends('layout.custom')

@section('title', 'Registrasi Akun')

@section('content')
    <div class="row">
        <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
            <div class="login-brand">
                <img src="../assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <h4>Registrasi</h4>
                </div>

                <div class="card-body">
                    <form method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" autofocus>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="form-group col-6">
                                <!--label-->
                                <label for="password" class="d-block control-label">Password</label>

                                <!--Input-->
                                <div class="input-group">
                                    <!--Input Field-->
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        tabindex="2">

                                    <!--Show/Hide Password-->
                                    <div class="input-group-append">
                                        <span class="input-group-text"
                                            onclick="togglePasswordVisibility('password', 'show_eye', 'hide_eye');">
                                            <i class="fas fa-eye" id="show_eye"></i>
                                            <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
                                        </span>
                                    </div>
                                </div>

                                <!--Penampil Pesan Error-->
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-6">
                                <!--label-->
                                <label for="password_confirmation" class="d-block control-label">Konfirmasi Password</label>
                                <!--Input-->
                                <div class="input-group">
                                    <!--Input Field-->
                                    <input id="password_confirmation" type="password" class="form-control"
                                        name="password_confirmation" tabindex="2">

                                    <!--Show/Hide Password-->
                                    <div class="input-group-append">
                                        <span class="input-group-text"
                                            onclick="togglePasswordVisibility('password_confirmation', 'show_eye_confirm', 'hide_eye_confirm');">
                                            <i class="fas fa-eye" id="show_eye_confirm"></i>
                                            <i class="fas fa-eye-slash d-none" id="hide_eye_confirm"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg btn-block">
                                Daftar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="simple-footer">
                Copyright &copy; SIPEB2M 2024
            </div>
        </div>
    </div>
@endsection
