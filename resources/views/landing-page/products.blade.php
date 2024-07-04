@extends('landing-page.app')

@section('title', 'Product')

@section('content')
    <section class="section gallery">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h1 class="font-weight-bold">Koleksi Baju Bodo</h1>
                </div>

                @foreach ($koleksiBaju as $baju)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="block mb-5">
                            <div class="image-container">
                                <img class="koleksi-baju" src="{{ asset('storage/' . $baju->gambar_baju) }}" alt="{{ $baju->nama_baju }}">
                            </div>
                        </div>
                        <div class="product-info mt-2">
                            <h4 class="mb-1"><a href="product-details.html" class="link-title">{{ $baju->nama_baju }}</a>
                            </h4>
                            <p class="price">
                                Rp{{ number_format($baju->harga_sewa_perhari, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
