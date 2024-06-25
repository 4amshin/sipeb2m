<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Http\Requests\StorePembayaranRequest;
use App\Http\Requests\UpdatePembayaranRequest;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role == 'pengguna') {
            $daftarPembayaran = Pembayaran::whereHas('transaksi', function ($query) use ($user) {
                $query->where('nama_penyewa', $user->name);
            })->with('transaksi')->orderBy('created_at', 'desc')->paginate(5);
        } else {
            $daftarPembayaran = Pembayaran::with('transaksi')->orderBy('created_at', 'desc')->paginate(5);
        }

        return view('admin.pembayaran.daftar-pembayaran', compact('daftarPembayaran'))->with('showNavbar', true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function tandaiLunas(Pembayaran $pembayaran)
    {
        $pembayaran->status_pembayaran = 'lunas';
        $pembayaran->pembayaran_masuk = $pembayaran->transaksi->harga_total;
        $pembayaran->tanggal_pembayaran = now();

        $pembayaran->save();

        $transaksi = Transaksi::find($pembayaran->transaksi->id);
        $transaksi->status = 'selesai';
        $transaksi->save();

        return redirect()->back()->with('success', 'Pembayaran Lunas');
    }

    public function updatePembayaran(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'pembayaran_masuk' => 'required|numeric',
            'metode_pembayaran' => 'required|string|max:255',
        ]);

        $pembayaran->pembayaran_masuk = $request->input('pembayaran_masuk');
        $pembayaran->metode_pembayaran = $request->input('metode_pembayaran');

        if ($pembayaran->pembayaran_masuk >= $pembayaran->transaksi->harga_total) {
            $pembayaran->status_pembayaran = 'lunas';

            $transaksi = Transaksi::find($pembayaran->transaksi->id);
            $transaksi->status = 'selesai';
            $transaksi->save();
        }

        $pembayaran->save();

        return redirect()->back()->with('success', 'Pembayaran berhasil diperbarui');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePembayaranRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePembayaranRequest $request, Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembayaran $pembayaran)
    {
        //
    }
}
