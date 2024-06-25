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
                    <img src="{{ $baju->gambar_baju ? asset($baju->gambar_baju) : asset('assets/img/baju-kosong.png') }}"
                        alt="Gambar Baju" class="fill-box" height="230">
                    <div class="item-details">
                        <h2>{{ $baju->nama_baju }} ({{ $baju->ukuran }})</h2>
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
            <button class="close">Tutup</button>
            <button class="checkOut" data-bs-toggle="modal" data-bs-target="#tanggalSewaModal">Sewa</button>
        </div>
    </div>

    <!-- Modal Tanggal Sewa -->
    <div class="modal fade" id="tanggalSewaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <!--Modal-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Durasi Penyewaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!--Form-->
                <form action="{{ route('checkout') }}" method="POST">
                    @csrf

                    <!--Form Input-->
                    <div class="modal-body">
                        <!--Tanggal Sewa-->
                        <div class="row">
                            <div class="col mb-3">
                                <label for="tanggalSewa" class="form-label">Tanggal Sewa</label>
                                <input type="date" id="tanggalSewa" name="tanggal_sewa" class="form-control" required>
                            </div>
                        </div>

                        <!--Tanggal Kembali-->
                        <div class="row">
                            <div class="col mb-3">
                                <label for="tanggalKembali" class="form-label">Tanggal Kembali</label>
                                <input type="date" id="tanggalKembali" name="tanggal_kembali" class="form-control"
                                    required>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Input for Cart Data -->
                    <input type="hidden" name="cart" id="cartData">

                    <!--Tombol-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Sewa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('customJs')
    <script>
        let products = @json($daftarBaju);

        document.querySelector('.checkOut').addEventListener('click', () => {
            document.getElementById('cartData').value = JSON.stringify(cart);
        });

        document.getElementById('sewaForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const tanggalSewa = document.getElementById('tanggalSewa').value;
            const tanggalKembali = document.getElementById('tanggalKembali').value;

            if (new Date(tanggalKembali) < new Date(tanggalSewa)) {
                alert('Tanggal kembali tidak boleh lebih awal dari tanggal sewa.');
                return;
            }

            // Submit form via AJAX
            const formData = new FormData(this);
            formData.append('cart', JSON.stringify(cart));

            fetch('{{ route('checkout') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Success:', data);
                    // Clear cart and local storage
                    cart = [];
                    localStorage.removeItem('cart');
                    addCartToHTML();
                    document.getElementById('sewaForm').reset();
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        });
    </script>
    <script src="{{ asset('assets/js/cart.js') }}"></script>
@endpush
