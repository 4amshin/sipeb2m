<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Http\Requests\StorePengembalianRequest;
use App\Http\Requests\UpdatePengembalianRequest;

class PengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role == 'pengguna') {
            $daftarPengembalian = Pengembalian::whereHas('transaksi', function ($query) use ($user) {
                $query->where('nama_penyewa', $user->name);
            })->with('transaksi')->orderBy('created_at', 'desc')->paginate(5);
        } else {
            $daftarPengembalian = Pengembalian::with('transaksi')->orderBy('created_at', 'desc')->paginate(5);
        }

        return view('admin.pengembalian.daftar-pengembalian', compact('daftarPengembalian'))->with('showNavbar', true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function tandaiKembali(Pengembalian $pengembalian)
    {
        $pengembalian->status = 'diKembalikan';
        $pengembalian->save();

        return redirect()->route('pengembalian.index')->with('success', 'Baju telah dikembalikan');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePengembalianRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengembalian $pengembalian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengembalian $pengembalian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePengembalianRequest $request, Pengembalian $pengembalian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengembalian $pengembalian)
    {
        //
    }
}
