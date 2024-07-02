@extends('landing-page.app')

@section('title', 'Home')

@section('content')
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center mb-5 mb-md-0">
                    <img class="img-fluid" src="{{ asset('assets/img/lp-images/baju1.png') }}" width="300" alt="">
                </div>
                <div class="col-md-6 align-self-center text-center text-md-left">
                    <div class="block">
                        <h1 class="font-weight-bold mb-4 font-size-60">Temukan Gaya Anda dengan Baju Bodo Modern</h1>
                        <p class="mb-4">Koleksi terbaru kami menghadirkan pilihan baju modern yang tidak hanya nyaman,
                            tetapi juga menambah kepercayaan diri Anda.</p>
                        <a href="/product" class="btn btn-main">Jelajahi Koleksi</a>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-purple section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center mb-5 mb-lg-0">
                    <img class="img-fluid" src="{{ asset('assets/img/lp-images/baju2.png') }}" width="300"
                        alt="">
                </div>
                <div class="col-md-6 align-self-center text-center text-md-left">
                    <div class="content">
                        <h2 class="subheading text-white font-weight-bold mb-10">Tentang Kami</h2>
                        <p class="text-white">Baju Bodo Cica menghadirkan koleksi baju modern dengan sentuhan klasik yang
                            tidak akan pernah ketinggalan zaman. Setiap desainnya dibuat dengan teliti menggunakan bahan
                            berkualitas tinggi, sehingga tidak hanya membuat Anda tampil gaya tetapi juga merasa nyaman
                            sepanjang hari.<br><br> Semua produk Baju Bodo Cica dipilih dengan cermat untuk memenuhi berbagai
                            kebutuhan gaya hidup Anda, dari momen santai hingga acara formal. Temukan kenyamanan yang tak
                            tertandingi dan gaya yang memukau dengan koleksi kami.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
