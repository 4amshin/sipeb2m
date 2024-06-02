@extends('layout.app')

@section('page-title', 'Profil')

@section('content')
    <!-- Alert -->
    @include('layout.page-alert')

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Biodata Pengguna</h5>
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf

                    <!-- Foto Profil -->
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <!-- Foto -->
                            <img src="{{ asset('assets/img/avatars/6.png') }}" alt="user-avatar" class="d-block rounded"
                                height="100" width="100" id="uploadedAvatar" />

                            <!-- Tombol Upload & Reset -->
                            <div class="button-wrapper">
                                <!-- Upload -->
                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Upload Foto Baru</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input type="file" id="upload" class="account-file-input" hidden
                                        accept="image/png, image/jpeg" />
                                </label>

                                <!-- Reset -->
                                <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                    <i class="bx bx-reset d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Reset</span>
                                </button>

                                <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
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

                                <!-- Email -->
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input class="form-control" type="text" id="email" name="email"
                                        value="{{ $pengguna->email }}" />
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
                                <div class="mb-3 col-md-6">
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
            </div>
        </div>
    </div>
@endsection
