@extends('layout.app')

@section('search')
    <input type="text" class="form-control border-0 shadow-none" placeholder="Search..." aria-label="Search...">
@endsection


@section('content')
    <div class="row mb-5">

        @forelse ($itemKeranjang as $item)
            <div class="col-md">
                <div class="card mb-3">
                    <div class="row g-0">
                        <!--Gambar Baju-->
                        <div class="col-md-4">
                            <img class="card-img card-img-left" src="../assets/img/elements/12.jpg" alt="Card image">
                        </div>

                        <!--Harga, Jumalh Dll-->
                        <div class="col-md-8">
                            <div class="card-body">
                                <!--Nama dan Harga Item-->
                                <h5 class="card-title">{{ $item->baju->nama_baju }}</h5>
                                <p class="card-text">
                                    Rp{{ number_format($item->harga_sewa_perhari, 0, ',', '.') }}
                                </p>

                                <!--Tombol Tambah dan Kurangin Jumlah Item-->
                                <div class="btn-group" role="group" aria-label="First group">
                                    <button type="button" class="btn btn-outline-secondary">
                                        <i class="tf-icons bx bx-minus"></i>
                                    </button>
                                    <span class="btn btn-outline-secondary">5</span>
                                    <button type="button" class="btn btn-outline-secondary">
                                        <i class="tf-icons bx bx-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @empty
            Keranjang Kosong
        @endforelse
    </div>
@endsection
