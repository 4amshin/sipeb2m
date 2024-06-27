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
        $pembayaran->status_pembayaran = 'dibayar';
        $pembayaran->tanggal_pembayaran = now();

        $pembayaran->save();

        $transaksi = Transaksi::find($pembayaran->transaksi->id);
        $transaksi->status_sewa = 'sudah_lunas';
        $transaksi->save();

        return redirect()->back()->with('success', 'Pembayaran Lunas');
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
