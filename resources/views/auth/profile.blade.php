@extends('layout.app')

@section('page-title', 'Profil')

@section('content')
    <!-- Alert -->
    @include('layout.page-alert')

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Biodata Pengguna</h5>
                <!--FORM-->
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Foto Profil -->
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <!-- Foto -->
                            <img src="{{ $pengguna->gambar_profil ? asset('storage/profil/' . $pengguna->gambar_profil) : asset('assets/img/baju-kosong.png') }}"
                                alt="user-avatar" class="d-block rounded fill-box" height="100" width="100"
                                id="uploadedAvatar" />

                            <!-- Tombol Upload & Reset -->
                            <div class="button-wrapper">
                                <!-- Upload -->
                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Upload Foto Baru</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input type="file" id="upload" class="account-file-input" hidden
                                        accept="image/png, image/jpeg, image/jpg," name="gambar_profil" />
                                </label>

                                <!-- Reset -->
                                <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                    <i class="bx bx-reset d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Reset</span>
                                </button>

                                <p class="text-muted mb-0">Upload gambar denga ratio 1:1 (Kotak)</p>
                            </div>
                        </div>
                    </div>

                    <hr class="my-0" />

                    <!-- Data Pengguna -->
                    <div class="card-body">
                        <form id="formAccountSettings" method="POST" onsubmit="return false">
                            <div class="row">

                                <!-- Nama -->
                                <div class="mb-3 col-md-6">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input class="form-control" type="text" id="nama" name="nama"
                                        value="{{ $pengguna->nama }}" autofocus />
                                </div>

                                <!--Jenis Kelamin-->
                                <div class="mb-3 col-md-6">
                                    <small class="text-light fw-semibold d-block">Jenis Kelamin</small>
                                    <div class="form-check form-check-inline mt-3">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki-laki"
                                            value="laki-laki"
                                            {{ $pengguna->jenis_kelamin == 'laki-laki' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="laki-laki">Laki-Laki</label>
                                    </div>
                                    <div class="form-check form-check-inline mt-3">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan"
                                            value="perempuan"
                                            {{ $pengguna->jenis_kelamin == 'perempuan' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="perempuan">Perempuan</label>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input class="form-control" type="text" id="email"
                                        placeholder="Readonly input here..." value="{{ $pengguna->email }}" readonly="">
                                </div>

                                <!-- Nomor Telepon -->
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="nomor_telepon">Nomor Telepon</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">ID |</span>
                                        <input type="text" id="nomor_telepon" name="nomor_telepon" class="form-control"
                                            value="{{ $pengguna->nomor_telepon }}" />
                                    </div>
                                </div>

                                <!-- Aalamat -->
                                <div class="mb-3 col-md-12">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <input type="text" class="form-control" id="alamat" name="alamat"
                                        value="{{ $pengguna->alamat }}" />
                                </div>
                            </div>

                            <!-- Tombol Simpan Perubahan-->
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </form>
                <!--FORM-->
            </div>
        </div>
    </div>
@endsection

@push('customJs')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const uploadedAvatar = document.getElementById('uploadedAvatar');
            const uploadInput = document.getElementById('upload');
            const resetButton = document.querySelector('.account-image-reset');
            const defaultAvatarSrc =
                "{{ $pengguna->gambar_profil ? asset('storage/public/'.$pengguna->gambar_profil) : asset('assets/img/baju-kosong.png') }}";

            // Handle image upload
            uploadInput.addEventListener('change', function(event) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    uploadedAvatar.src = e.target.result;
                };
                if (event.target.files[0]) {
                    reader.readAsDataURL(event.target.files[0]);
                }
            });

            // Handle image reset
            resetButton.addEventListener('click', function() {
                uploadedAvatar.src = defaultAvatarSrc;
                uploadInput.value = '';
            });
        });
    </script>
@endpush
