@extends('layout.app')

@section('title', 'Profile')

@section('content')
    <section class="section">
        <!--Header-->
        <div class="section-header">
            <h1>Profile</h1>
        </div>


        <?php
        $user = auth()->user();
        $profile = App\Models\Pengguna::where('email', $user->email)->first();
        ?>
        <!--Body-->
        <section class="section-body">
            <div class="row">
                <!--Left Card-->
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <!--Foto Profil-->
                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp"
                                alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">

                            <!--Nama-->
                            <h5 class="my-3">{{ $profile->nama }}</h5>
                            <p>{{ $user->email }}</p>

                            <!--Tombol Edit Profil-->
                            @can('super-user')
                                <a href="#" class="btn btn-primary">Edit Profil</a>
                            @endcan
                        </div>
                    </div>
                </div>

                <!--Right Card-->
                <div class="col-lg-8 card mb-4 ">
                    <div class="card-body">
                        <!--Nama-->
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Name Lengkap</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $profile->nama }}</p>
                            </div>
                        </div>
                        <hr>

                        <!--Nomor Telepon-->
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Nomor Telepon</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $profile->nomor_telepon }}</p>
                            </div>
                        </div>
                        <hr>

                        <!--Email-->
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Email</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $profile->email }}</p>
                            </div>
                        </div>
                        <hr>

                        <!--Password-->
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Password</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $profile->password }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
