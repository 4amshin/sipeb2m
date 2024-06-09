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
                        <!-- Gambar Baju -->
                        <div class="col-md-4">
                            <img class="card-img card-img-left" src="../assets/img/elements/12.jpg" alt="Card image">
                        </div>

                        <!-- Harga, Jumlah Dll -->
                        <div class="col-md-8">
                            <div class="card-body">
                                <!-- Nama dan Harga Item -->
                                <h5 class="card-title">{{ $item->baju->nama_baju }}</h5>
                                <p class="card-text">
                                    Rp{{ number_format($item->harga_sewa_perhari * $item->jumlah, 0, ',', '.') }}
                                </p>

                                <!-- Tombol Tambah dan Kurangi Jumlah Item -->
                                <div class="btn-group" role="group" aria-label="First group">
                                    <!-- Tombol Kurangi -->
                                    <button type="button" class="btn btn-outline-secondary btn-kurangi"
                                        data-id="{{ $item->id }}">
                                        <i class="tf-icons bx bx-minus"></i>
                                    </button>

                                    <!-- Jumlah Barang -->
                                    <span id="jumlah-{{ $item->id }}"
                                        class="btn btn-outline-secondary">{{ $item->jumlah }}</span>

                                    <!-- Tombol Tambah -->
                                    <button type="button" class="btn btn-outline-secondary btn-tambah"
                                        data-id="{{ $item->id }}">
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

@push('customJs')
    <script>
        $(document).ready(function() {
            $('.btn-kurangi').on('click', function() {
                var id = $(this).data('id');
                updateJumlah(id, 'kurangi');
            });

            $('.btn-tambah').on('click', function() {
                var id = $(this).data('id');
                updateJumlah(id, 'tambah');
            });

            function updateJumlah(id, action) {
                $.ajax({
                    url: '/keranjang/' + id + '/' + action,
                    type: 'GET',
                    success: function(data) {
                        if (data.jumlah !== undefined) {
                            // Update span jumlah barang
                            $('#jumlah-' + id).text(data.jumlah);
                        } else {
                            // Jika item dihapus, reload halaman
                            location.reload();
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            }
        });
    </script>
@endpush
