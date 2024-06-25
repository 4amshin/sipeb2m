@extends('layout.app')

@section('page-title', 'Update Baju')

@section('content')
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-body">
                    <form method="POST" action="{{ route('baju.update', $baju->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!--Baju & Ukuran-->
                        <div class="row">
                            <!--Baju-->
                            <div class="col-6 mb-3">
                                <label class="form-label" for="nama_baju">Nama Baju</label>
                                <input type="text" class="form-control" id="nama_baju" name="nama_baju"
                                    value="{{ $baju->nama_baju }}" autofocus required>
                            </div>

                             <!--Jenis Kelamin-->
                             <div class="col-md">
                                <small class="text-light fw-semibold d-block">Jenis Kelamin</small>
                                @foreach ($jenisKelamin as $kelamin)
                                    <div class="form-check form-check-inline mt-3">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin"
                                            id="{{ $kelamin }}"
                                            value="{{ $kelamin }}">
                                        <label class="form-check-label"
                                            for="{{ $kelamin }}">{{ $kelamin == 'laki-laki' ? 'Laki Laki' : 'Perempuan' }}</label>
                                    </div>
                                @endforeach
                            </div>

                            <!--Ukuran-->
                            <div class="col-md">
                                <small class="text-light fw-semibold d-block">Ukuran Baju</small>
                                @foreach ($listUkuran as $ukuran)
                                    <div class="form-check form-check-inline mt-3">
                                        <input class="form-check-input" type="radio" name="ukuran"
                                            id="ukuran_{{ $ukuran }}" value="{{ $ukuran }}"
                                            {{ $baju->ukuran == $ukuran ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="ukuran_{{ $ukuran }}">{{ $ukuran }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!--Stok & Harga Sewa-->
                        <div class="row">
                            <!--Stok-->
                            <div class="col-6 mb-3">
                                <label class="form-label" for="stok">Stok</label>
                                <input type="number" class="form-control" id="stok" name="stok"
                                    value="{{ $baju->stok }}" autofocus required>
                            </div>

                            <!--Harga Sewa-->
                            <div class="col-6 mb-3">
                                <label class="form-label" for="harga_sewa_perhari">Harga Sewa/Hari</label>
                                <input type="number" id="harga_sewa_perhari" name="harga_sewa_perhari"
                                    value="{{ $baju->harga_sewa_perhari }}" class="form-control">
                            </div>
                        </div>

                        <!--Gambar-->
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Input Gambar Baju</label>
                            <div class="d-flex align-items-center">
                                <img src="{{ $baju->gambar_baju ? asset($baju->gambar_baju) : asset('assets/img/baju-kosong.png') }}"
                                    alt="Gambar Baju" class="d-block rounded me-3" style="width: 100px;" id="uploadedBaju">
                                <input class="form-control" type="file" id="formFile" name="gambar_baju">
                                <button type="button" class="btn btn-outline-secondary ms-2"
                                    id="resetButton">Reset</button>
                            </div>
                        </div>

                        <!--Tombol Submit-->
                        <div class="row p-2">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('customJs')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const uploadedBaju = document.getElementById('uploadedBaju');
            const uploadInput = document.getElementById('formFile');
            const resetButton = document.getElementById('resetButton');
            const defaultBajuSrc =
                "{{ $baju->gambar_baju ? asset($baju->gambar_baju) : asset('assets/img/baju-kosong.png') }}";

            // Handle image upload
            uploadInput.addEventListener('change', function(event) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    uploadedBaju.src = e.target.result;
                };
                if (event.target.files[0]) {
                    reader.readAsDataURL(event.target.files[0]);
                }
            });

            // Handle image reset
            resetButton.addEventListener('click', function() {
                uploadedBaju.src = defaultBajuSrc;
                uploadInput.value = '';
            });
        });
    </script>
@endpush
