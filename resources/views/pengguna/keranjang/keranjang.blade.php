@extends('layout.app')


@push('customCss')
    <link rel="stylesheet" href="{{ asset('assets/css/cart.css') }}">
@endpush

@section('content')
    <div class="container">
        <header>
            <div class="title">BAJU BODO MODEREN</div>
            <div class="icon-cart">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 15a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0h8m-8 0-1-4m9 4a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-9-4h10l2-7H3m2 7L3 4m0 0-.792-3H1" />
                </svg>
                <span>0</span>
            </div>
        </header>
        <div class="listProduct">
            @forelse ($daftarBaju as $baju)
                <div data-id="{{ $baju->id }}" class="item">
                    <img src=" {{ asset('assets/img/t-white.png') }}">
                    <div class="item-details">
                        <h2>{{ $baju->nama_baju }}</h2>
                        <div class="price">
                            Rp{{ number_format($baju->harga_sewa_perhari, 0, ',', '.') }}/Hari
                        </div>
                        <button class="addCart"><i class="tf-icons bx bxs-cart-add"></i> Tambahkan</button>
                    </div>
                </div>
            @empty
                Cart is Empty
            @endforelse

        </div>
    </div>
    <div class="cartTab">
        <h1>Keranjang Saya</h1>
        <div class="listCart">

        </div>
        <div class="totalPriceContainer">
            <h2>Total Harga: <span class="totalPrice">Rp0</span></h2>
        </div>
        <div class="btn">
            <button class="close">CLOSE</button>
            <button class="checkOut">Check Out</button>
        </div>
    </div>
@endsection

@push('customJs')
    <script>
        let products = @json($daftarBaju);
    </script>
    <script src="{{ asset('assets/js/cart.js') }}"></script>
@endpush
