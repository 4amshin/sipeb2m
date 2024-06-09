<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Http\Requests\StoreKeranjangRequest;
use App\Http\Requests\UpdateKeranjangRequest;
use App\Models\Baju;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $itemKeranjang = Keranjang::where('pengguna_id', $user->id)->get();

        return view('pengguna.keranjang.keranjang', compact('itemKeranjang'));
    }

    public function tambahKeKeranjang(Baju $baju)
    {
        $user = auth()->user();

        // Cek jika baju sudah ada di keranjang
        $itemKeranjang = Keranjang::where('pengguna_id', $user->id)
            ->where('baju_id', $baju->id)
            ->first();

        if ($itemKeranjang) {
            // Jika item sudah ada di keranjang, tambahkan jumlahnya
            $itemKeranjang->jumlah += 1;
            $itemKeranjang->save();
        } else {
            // Jika item belum ada di keranjang, buat baru
            Keranjang::create([
                'pengguna_id' => $user->id,
                'baju_id' => $baju->id,
                'jumlah' => 1,
                'harga_sewa_perhari' => $baju->harga_sewa_perhari,
            ]);
        }

        return redirect()->back()->with('success', $baju->nama_baju . ' berhasil ditambahkan ke keranjang!');
    }

    public function updateJumlah($id, $action)
    {
        $keranjang = Keranjang::find($id);

        if (!$keranjang) {
            return response()->json(['error' => 'Item tidak ditemukan'], 404);
        }

        if ($action == 'tambah') {
            $keranjang->jumlah += 1;
        } else if ($action == 'kurangi') {
            if ($keranjang->jumlah > 1) {
                $keranjang->jumlah -= 1;
            } else {
                // Jika jumlah terkini adalah 1, hapus dari keranjang
                $keranjang->delete();
                return response()->json(['success' => 'Item berhasil dihapus dari keranjang']);
            }
        }

        $keranjang->save();

        return response()->json(['jumlah' => $keranjang->jumlah]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKeranjangRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Keranjang $keranjang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Keranjang $keranjang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKeranjangRequest $request, Keranjang $keranjang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keranjang $keranjang)
    {
        //
    }
}
