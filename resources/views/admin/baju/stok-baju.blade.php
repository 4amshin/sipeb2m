@extends('layout.app')

@section('search')
    <input type="text" class="form-control border-0 shadow-none" placeholder="Search..." aria-label="Search...">
@endsection

@section('content')
    <div class="row">
        @forelse ($daftarBaju as $baju)
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100">
                    <!--Gambar Baju-->
                    <img class="card-img-top" src="{{ asset('assets/img/t-white.png') }}" alt="Card image cap">

                    <!--Nama, Harga, Tombol-->
                    <div class="card-body">
                        <h5 class="card-title"> Rp{{ number_format($baju->harga_sewa_perhari, 0, ',', '.') }}/Hari</h5>
                        <p class="card-text">
                            {{ $baju->nama_baju }}
                        </p>

                        <!--Tombol-->
                        <div class="demo-inline-spacing">
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                <!--Tombol Tambahkan Ke Keranjang-->
                                <a href="" class="btn btn-outline-primary">
                                    <i class="tf-icons bx bxs-cart-add"></i>
                                </a>

                                <!--Tombol Sewa Sekarang-->
                                <a href="" class="btn btn-outline-primary">
                                    Sewa Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <h3>Data Tidak ditemukan</h3>
        @endforelse

    </div>
@endsection
