<?php

namespace App\Http\Controllers;

use App\Models\Baju;
use App\Http\Requests\StoreBajuRequest;
use App\Http\Requests\UpdateBajuRequest;
use Illuminate\Http\Request;

class BajuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $daftarBaju = Baju::when($request->input('search'), function ($query, $search) {
            $query->where('nama_baju', 'like', '%' . $search . '%')
                ->orWhere('ukuran', 'like', '%' . $search . '%')
                ->orWhere('deskripsi', 'like', '%' . $search . '%');
        })->orderBy('created_at', 'desc')->paginate(5);

        return view('admin.baju.daftar-baju', compact('daftarBaju'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listUkuran = ['S', 'M', 'L', 'XL', 'XXL'];
        return view('admin.baju.tambah-baju', compact('listUkuran'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBajuRequest $request)
    {
        //$simpan data baju
        $baju = new Baju($request->validated());

        //jika ada gambar, simpan gambar
        if ($request->hasFile('gambar_baju')) {
            $filePath = $request->file('gambar_baju')->store('public/gambar_baju');
            $baju->gambar_baju = basename($filePath);
        }

        $baju->save();

        return redirect()->route('baju.index')->with('success', 'Baju berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Baju $baju)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Baju $baju)
    {
        $listUkuran = ['S', 'M', 'L', 'XL', 'XXL'];
        return view('admin.baju.update-baju', compact('baju', 'listUkuran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBajuRequest $request, Baju $baju)
    {
        $baju->fill($request->validated());

        //jika ada gambar baru, simpan gambar baru
        if ($request->hasFile('gambar_baju')) {
            $filePath = $request->file('gambar_baju')->store('public/gambar_baju');
            $baju->gambar_baju = basename($filePath);
        }

        $baju->save();

        return redirect()->route('baju.index')->with('success', 'Baju berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Baju $baju)
    {
        $baju->delete();
        return redirect()->route('baju.index')->with('success', 'Baju berhasil dihapus');
    }
}
