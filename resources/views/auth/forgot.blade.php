@extends('layout.auth')

@section('title', 'Lupa Password')

@section('content')
    <h4 class="mb-2">Lupa Password? 🔒</h4>
    <p class="mb-4">Masukkan alamat email Anda dan kami akan mengirimkan instruksi untuk mengatur ulang kata sandi Anda.
    </p>
    <form id="formAuthentication" class="mb-3" action="index.html" method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Masukkan Email Anda"
                autofocus />
        </div>
        <button class="btn btn-primary d-grid w-100">Kirim Link</button>
    </form>
    <div class="text-center">
        <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
            <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
            Halaman Login
        </a>
    </div>
@endsection
