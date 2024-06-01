@extends('layout.auth')

@section('title', 'Register')

@section('content')
    <h4 class="mb-2">Daftarkan Akunmu Sekarang 🚀</h4>
    <p class="mb-4">Gabunglah Bersama Kami dan Mulailah Petualangan Berbusana Tradisionalmu!</p>

    <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('register') }}">
        @csrf
        <!--Nama-->
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Masukkkan Nama Lengkap"
                autofocus />
        </div>

        <!--Email-->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                placeholder="Masukkkan Email Anda" />

            <!--Pesan Error-->
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!--Password-->
        <div class="mb-3 form-password-toggle">
            <label class="form-label" for="password">Password</label>
            <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div>

            <!--Pesan Error-->
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!--Password Confirmation-->
        <div class="mb-3 form-password-toggle">
            <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
            <div class="input-group input-group-merge">
                <input type="password" id="password_confirmation"
                    class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div>

            <!--Pesan Error-->
            @error('password_confirmation')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!--Tombol Daftar-->
        <button type="submit" class="btn btn-primary d-grid w-100">Daftar</button>
    </form>

    <!--Link Login-->
    <p class="text-center">
        <span>Sudah Punya Akun?</span>
        <a href="{{ route('login') }}">
            <span>Login Disini</span>
        </a>
    </p>
@endsection
