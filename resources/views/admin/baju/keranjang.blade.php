@extends('layout.app')

@push('customCss')
    <link rel="stylesheet" href="{{ asset('assets/css/cart.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/file-upload.css') }}">
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
            @php
                $groupedBaju = $daftarBaju->groupBy('nama_baju');
            @endphp
            @forelse ($groupedBaju as $namaBaju => $bajuGroup)
                <div data-nama="{{ $namaBaju }}" class="item">
                    <img src="{{ $bajuGroup->first()->gambar_baju ? asset('storage/' . $bajuGroup->first()->gambar_baju) : asset('assets/img/baju-kosong.png') }}"
                        alt="Gambar Baju" class="fill-box" height="230">
                    <div class="item-details">
                        <h2>{{ $namaBaju }}</h2>
                        <div class="price">
                            Mulai dari Rp{{ number_format($bajuGroup->min('harga_sewa_perhari'), 0, ',', '.') }}/Hari
                        </div>
                        <button class="addCart" data-bs-toggle="modal" data-bs-target="#pilihUkuranModal">
                            <i class="tf-icons bx bxs-cart-add"></i> Tambahkan
                        </button>
                    </div>
                </div>
            @empty
                Cart is Empty
            @endforelse
        </div>
    </div>

    <!--Side CartTab-->
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

    <!-- Modal Pilih Ukuran -->
    <div class="modal fade" id="pilihUkuranModal" tabindex="-1" aria-labelledby="pilihUkuranLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pilihUkuranLabel">Pilih Ukuran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <small class="text-light fw-semibold d-block">Ukuran Baju</small>
                        <div id="ukuranBajuContainer"></div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="hargaBaju" class="form-label">Harga:</label>
                        <div id="hargaBaju" class="form-control-plaintext">Rp0</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="konfirmasiUkuran">Tambahkan ke Keranjang</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tanggal Sewa -->
    <div class="modal fade" id="tanggalSewaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Durasi Penyewaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('checkout') }}" method="POST" enctype="multipart/form-data">
                    @csrf
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

                        <!--Foto KTP-->
                        <div class="row">
                            <label for="tanggalKembali" class="form-label">Jaminan (Foto KTP/Tanda Pengenal Lainnya)</label>
                            <div class="fl-container">
                                <input type="file" id="file" accept="image/*" name="foto_ktp" hidden>
                                <div class="img-area" data-img="">
                                    <i class='bx bxs-cloud-upload icon'></i>
                                    <h3>Upload Gambar</h3>
                                    <p>Ukuran gambar maksimal <span>2MB</span></p>
                                </div>
                                <button type="button" class="fl-select-image">Pilih Gambar</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="cart" id="cartData">
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
        document.querySelectorAll(".addCart").forEach(button => {
            button.addEventListener("click", (e) => {
                e.preventDefault();
                button.classList.add("animate");
                setTimeout(() => {
                    button.classList.remove("animate");
                }, 600);

                const item = e.target.closest('.item');
                const namaBaju = item.dataset.nama;
                const bajuGroup = @json($daftarBaju->groupBy('nama_baju'));
                const bajuOptions = bajuGroup[namaBaju];

                const ukuranContainer = document.getElementById('ukuranBajuContainer');
                ukuranContainer.innerHTML = '';
                bajuOptions.forEach(baju => {
                    const div = document.createElement('div');
                    div.classList.add('form-check', 'form-check-inline', 'mt-3');

                    const input = document.createElement('input');
                    input.classList.add('form-check-input');
                    input.type = 'radio';
                    input.name = 'ukuran';
                    input.id = `ukuran_${baju.id}`;
                    input.value = baju.id;
                    input.dataset.harga = baju.harga_sewa_perhari;

                    const label = document.createElement('label');
                    label.classList.add('form-check-label');
                    label.htmlFor = `ukuran_${baju.id}`;
                    label.textContent = baju.ukuran;

                    div.appendChild(input);
                    div.appendChild(label);
                    ukuranContainer.appendChild(div);
                });

                // Simpan nama baju yang dipilih
                document.getElementById('konfirmasiUkuran').dataset.namaBaju = namaBaju;
            });
        });

        document.getElementById('konfirmasiUkuran').addEventListener('click', () => {
            const selectedUkuran = document.querySelector('input[name="ukuran"]:checked');
            if (selectedUkuran) {
                const ukuranBaju = selectedUkuran.value;
                const namaBaju = document.getElementById('konfirmasiUkuran').dataset.namaBaju;
                const selectedProduct = products.find(baju => baju.id == ukuranBaju);

                addToCart(selectedProduct.id, selectedProduct.nama_baju, selectedProduct.ukuran, selectedProduct
                    .harga_sewa_perhari);

                // Tutup modal setelah menambahkan ke keranjang
                const modal = bootstrap.Modal.getInstance(document.getElementById('pilihUkuranModal'));
                modal.hide();
            } else {
                alert('Silakan pilih ukuran baju.');
            }
        });

        let products = @json($daftarBaju);

        document.getElementById('ukuranBajuContainer').addEventListener('change', (e) => {
            if (e.target.name === 'ukuran') {
                const harga = e.target.dataset.harga;
                document.getElementById('hargaBaju').textContent = `Rp${parseInt(harga).toLocaleString('id-ID')}`;
            }
        });

        document.querySelector('.checkOut').addEventListener('click', () => {
            document.getElementById('cartData').value = JSON.stringify(cart);
        });
    </script>

    <script src="{{ asset('assets/js/file-upload.js') }}"></script>

    <script src="{{ asset('assets/js/cart.js') }}"></script>
@endpush
