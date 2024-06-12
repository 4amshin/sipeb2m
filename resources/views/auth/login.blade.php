@extends('layout.auth')

@section('title', 'Login')

@section('content')
    <h4 class="mb-2">Selamat Datang 👋</h4>
    <p class="mb-4">Masuk ke akun anda untuk menyewa produk kami.</p>

    <form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST">
        @csrf

        <!--Email-->
        <div class="mb-3">
            <label for="email" class="form-label">Email </label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                placeholder="Masukkan Email Anda" autofocus />

            <!--Pesan Eror-->
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!--Password-->
        <div class="mb-3 form-password-toggle">
            <!--Label & Link Lupa Password-->
            <div class="d-flex justify-content-between">
                <!--Label-->
                <label class="form-label" for="password">Password</label>

                <!--Link Lupa Password-->
                <a href="{{ route('password.request') }}">
                    <small>Lupa Password?</small>
                </a>
            </div>

            <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                    name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div>
        </div>

        <!--Tombol Login-->
        <div class="mb-3">
            <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
        </div>
    </form>

    <p class="text-center">
        <span>Belum Punya Akun?</span>
        <a href="{{ route('register') }}">
            <span>Daftar Disini</span>
        </a>
    </p>
@endsection
