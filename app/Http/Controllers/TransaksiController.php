<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Http\Requests\StoreTransaksiRequest;
use App\Http\Requests\UpdateTransaksiRequest;
use App\Models\Baju;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $daftarTransaksi  = Transaksi::orderBy('created_at', 'desc')
            ->paginate(5);

        if ($user->role == 'pengguna') {
            $daftarTransaksi->where('pengguna_id', $user->id);
        }


        return view('admin.penyewaan.daftar-penyewaan', compact('daftarTransaksi'));
    }

    public function getUkuran($nama_baju)
    {
        // Mengambil semua data baju dengan nama_baju yang sesuai
        $bajus = Baju::where('nama_baju', $nama_baju)->get();

        // Inisialisasi array untuk menampung ukuran yang tersedia
        $listUkuran = [];

        // Loop melalui setiap baju dan cek stoknya
        foreach ($bajus as $baju) {
            if ($baju->stok > 0) {
                $listUkuran[] = $baju->ukuran;
            }
        }

        // Cek apakah ada ukuran yang tersedia
        if (count($listUkuran) > 0) {
            return response()->json($listUkuran);
        } else {
            return response()->json(['error' => 'Ukuran tidak tersedia untuk baju ini atau stok habis'], 404);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listUkuran = ['S', 'M', 'L', 'XL', 'XXL'];
        $listBaju = Baju::all();
        return view('admin.penyewaan.tambah-penyewaan', compact('listBaju', 'listUkuran'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransaksiRequest $request)
    {
        //
    }

    public function konfirmasi(Transaksi $transaksi)
    {
        $transaksi->update(['status' => 'terkonfirmasi']);
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dikonfirmasi.');
    }

    public function tandaiSelesai(Transaksi $transaksi)
    {
        $transaksi->update(['status' => 'selesai']);
        return redirect()->route('transaksi.index')->with('success', 'Transaksi ditandai selesai.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransaksiRequest $request, transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return redirect()->route('transaksi.index')->with('success', 'Transaksi Berhaisl Dihapus');
    }
}
