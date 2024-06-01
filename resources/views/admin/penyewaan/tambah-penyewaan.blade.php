@extends('layout.app')

@section('page-title', 'Tambah Penyewaan')

@section('content')
    <div class="row">
        <div class="col-xl">
            <form method="POST" action="{{ route('transaksi.store') }}">
                @csrf

                <!--Data Pelanggan-->
                <div class="card mb-4">
                    <h5 class="card-header">Data Pelanggan</h5>
                    <div class="card-body">
                        <!--Nama & Nomor Telepon-->
                        <div class="row">
                            <!--Nama-->
                            <div class="col-6 mb-3">
                                <label class="form-label" for="nama_penyewa">Nama</label>
                                <input type="text" class="form-control" id="nama_penyewa" name="nama_penyewa" autofocus
                                    required>
                            </div>

                            <!--Nomor Telepon-->
                            <div class="col-6 mb-3">
                                <label class="form-label" for="noTelepon_penyewa">Nomor Telepon (Whatsapp)</label>
                                <input type="text" id="noTelepon_penyewa" name="noTelepon_penyewa"
                                    class="form-control phone-mask">
                            </div>
                        </div>

                        <!--Alamat-->
                        <div class="mb-3">
                            <label class="form-label" for="alamat_penyewa">Alamat</label>
                            <input type="text" class="form-control" id="alamat_penyewa" name="alamat_penyewa">
                        </div>

                        <!--Tanggal Sewa & Kembali-->
                        <div class="row">
                            <!--Tanggal Sewa-->
                            <div class="col-6 mb-3">
                                <label class="form-label" for="tanggal_sewa">Tanggal Sewa</label>
                                <input class="form-control" type="date" id="tanggal_sewa" name="tanggal_sewa">
                            </div>

                            <!--Tanggal Kembali-->
                            <div class="col-6 mb-3">
                                <label class="form-label" for="tanggal_kembali">Tanggal Kembali</label>
                                <input class="form-control" type="date" id="tanggal_kembali" name="tanggal_kembali">
                            </div>
                        </div>
                    </div>
                </div>

                <!--Data Baju-->
                <div class="card mb-4">
                    <h5 class="card-header">Data Baju</h5>
                    <div class="card-body">
                        <!--Pilih Baju-->
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="nama_baju" class="form-label">Baju</label>
                                <select id="nama_baju" class="form-select" name="nama_baju">
                                    <option value="">Pilih Baju</option>
                                    @foreach ($listBaju as $baju)
                                        <option value="{{ $baju->nama_baju }}">{{ $baju->nama_baju }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!--Ukuran-->
                            <div class="col-6">
                                <label class="d-block">Ukuran Baju</label>
                                <div id="ukuran-container">
                                    <p class="text-muted">Pilih baju terlebih dahulu untuk melihat ukuran yang tersedia.</p>
                                </div>
                            </div>
                        </div>

                        <!--Jumlah-->
                        <div class="col-12 mb-3">
                            <label class="form-label" for="jumlah">Jumlah</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" autofocus required>
                        </div>
                    </div>
                </div>

                <!--Tombol Submit-->
                <div class="card mb-4">
                    <div class="row p-4">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('customJs')
    <script>
        document.getElementById('nama_baju').addEventListener('change', function() {
            var namaBaju = this.value;
            var ukuranContainer = document.getElementById('ukuran-container');

            if (namaBaju) {
                fetch(`/transaksi/ukuran/${namaBaju}`)
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw new Error(err.error || 'Network response was not ok');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        ukuranContainer.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(ukuran => {
                                var radio = `<div class="form-check form-check-inline mt-3">
                                    <input class="form-check-input" type="radio" name="ukuran" id="ukuran_${ukuran}" value="${ukuran}">
                                    <label class="form-check-label" for="ukuran_${ukuran}">${ukuran}</label>
                                </div>`;
                                ukuranContainer.insertAdjacentHTML('beforeend', radio);
                            });
                        } else {
                            ukuranContainer.innerHTML =
                                '<p class="text-danger">Ukuran tidak tersedia untuk baju ini.</p>';
                        }
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                        ukuranContainer.innerHTML =
                            '<p class="text-danger">Terjadi kesalahan saat memuat ukuran: ' + error.message +
                            '</p>';
                    });
            } else {
                ukuranContainer.innerHTML =
                    '<p class="text-muted">Pilih baju terlebih dahulu untuk melihat ukuran yang tersedia.</p>';
            }
        });
    </script>
@endpush
