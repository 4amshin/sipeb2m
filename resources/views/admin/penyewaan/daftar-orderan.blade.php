@extends('layout.app')

@section('page-title', 'Orderan')

@section('content')
    <!-- Alert -->
    @include('layout.page-alert')

    <!-- Tab Bar -->
    <div class="nav-align-top mb-4">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-top-diproses" aria-controls="navs-top-diproses" aria-selected="true">
                    DiProses
                </button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-top-diterima" aria-controls="navs-top-diterima" aria-selected="false">
                    DiTerima
                </button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-top-ditolak" aria-controls="navs-top-ditolak" aria-selected="false">
                    DiTolak
                </button>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="navs-top-diproses" role="tabpanel">
                @include('admin.penyewaan.tabel-orderan', [
                    'orderList' => $orderDiproses,
                    'status' => 'diproses',
                ])
            </div>
            <div class="tab-pane fade" id="navs-top-diterima" role="tabpanel">
                @include('admin.penyewaan.tabel-orderan', [
                    'orderList' => $orderDiterima,
                    'status' => 'diterima',
                ])
            </div>
            <div class="tab-pane fade" id="navs-top-ditolak" role="tabpanel">
                @include('admin.penyewaan.tabel-orderan', [
                    'orderList' => $orderDitolak,
                    'status' => 'ditolak',
                ])
            </div>
        </div>
    </div>

    <!--Keterangan Status-->
    <div class="card p-3">
        <div class="row gx-3">
            <div class="col-md-4 d-flex align-items-start">
                <div class="content-right">
                    <span class="badge bg-label-warning me-1">DiProses</span>
                    <p class="mb-0 lh-1">Pesanan sedang dalam tahap verifikasi dan penyiapan</p>
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center">
                <div class="content-right">
                    <span class="badge bg-label-success me-1">DiTerima</span>
                    <p class="mb-0 lh-1">Pesanan telah disetujui dan akan segera diproses lebih lanjut</p>
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center">
                <div class="content-right">
                    <span class="badge bg-label-danger me-1">DiTolak</span>
                    <p class="mb-0 lh-1">Pesanan tidak disetujui, kemungkinan karena alasan tertentu seperti stok habis atau
                        informasi yang tidak valid</p>
                </div>
            </div>
        </div>
    </div>

@endsection
