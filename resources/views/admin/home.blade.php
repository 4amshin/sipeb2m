@extends('layout.app')

@section('title', 'Beranda')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Beranda</h1>
        </div>

        <div class="section-body">
            <!--Card Welcome User-->
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="hero bg-primary text-white">
                        <div class="hero-inner">
                            {{-- Menampilkan pesan selamat datang sesuai dengan peran pengguna --}}
                            @php
                                $user = auth()->user();
                                $name = $user->name;
                                if ($user->role === 'admin') {
                                    $role = 'Admin';
                                } else {
                                    $role = 'Pengguna';
                                }
                            @endphp
                            <h2>Halo, {{ $name }}</h2>
                            <p class="lead">Selamat datang di halaman {{ $role }}!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
