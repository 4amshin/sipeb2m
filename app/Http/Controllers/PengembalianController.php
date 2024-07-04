<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Http\Requests\StorePengembalianRequest;
use App\Http\Requests\UpdatePengembalianRequest;
use App\Models\Transaksi;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    public function index()
    {
        // Mengambil informasi pengguna yang sedang terautentikasi
        $user = auth()->user();

        // Inisialisasi daftar pengembalian yang akan ditampilkan
        $daftarPengembalian = null;

        // Jika pengguna memiliki peran sebagai 'pengguna', hanya menampilkan pengembalian yang terkait dengan nama pengguna tersebut
        if ($user->role == 'pengguna') {
            $daftarPengembalian = Pengembalian::whereHas('transaksi', function ($query) use ($user) {
                $query->where('nama_penyewa', $user->name);
            })->with('transaksi')->orderBy('created_at', 'desc')->paginate(5);
        } else {
            // Jika pengguna memiliki peran lain atau tidak ditentukan, menampilkan semua pengembalian
            $daftarPengembalian = Pengembalian::with('transaksi')->orderBy('created_at', 'desc')->paginate(5);
        }

        // Mengembalikan tampilan daftar pengembalian dengan variabel yang diperlukan
        return view('admin.pengembalian.daftar-pengembalian', compact('daftarPengembalian'))->with('showNavbar', true);
    }


    public function create()
    {
        //
    }

    public function tandaiKembali(Pengembalian $pengembalian)
    {
        // Menandai status pengembalian sebagai 'diKembalikan' dan mencatat tanggal kembali saat ini
        $pengembalian->status = 'diKembalikan';
        $pengembalian->tanggal_kembali = Carbon::now();
        $pengembalian->save();

        // Memperbarui status transaksi terkait menjadi 'selesai'
        $transaksi = Transaksi::find($pengembalian->transaksi->id);
        $transaksi->status_sewa = 'selesai';
        $transaksi->save();

        // Redirect kembali ke halaman daftar pengembalian dengan pesan sukses
        return redirect()->route('pengembalian.index')->with('success', 'Baju telah dikembalikan');
    }


    public function store(StorePengembalianRequest $request)
    {
        //
    }

    public function show(Pengembalian $pengembalian)
    {
        //
    }

    public function edit(Pengembalian $pengembalian)
    {
        //
    }

    public function update(UpdatePengembalianRequest $request, Pengembalian $pengembalian)
    {
        //
    }

    public function destroy(Pengembalian $pengembalian)
    {
        //
    }
}
