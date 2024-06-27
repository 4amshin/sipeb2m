<?php

namespace App\Http\Controllers;

use App\Models\Baju;
use App\Http\Requests\StoreBajuRequest;
use App\Http\Requests\UpdateBajuRequest;
use App\Models\DetailTransaksi;
use App\Models\Pengguna;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BajuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->role == 'admin') {
            $daftarBaju = Baju::when($request->input('search'), function ($query, $search) {
                $query->where('nama_baju', 'like', '%' . $search . '%')
                    ->orWhere('ukuran', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $search . '%');
            })->orderBy('created_at', 'desc')->paginate(5);

            return view('admin.baju.daftar-baju', compact('daftarBaju'))->with('showNavbar', true);
        } else  if ($user->role == 'pengguna') {
            $daftarBaju = Baju::all();

            return view('admin.baju.keranjang', compact('daftarBaju'))->with('showNavbar', false);
        }
    }

    public function checkout(Request $request)
    {
        // Decode the cart data
        $cart = json_decode($request->input('cart'), true);

        // Get the authenticated user
        $user = Auth::user();
        $penyewa = Pengguna::where('email', $user->email)->first();

        // Generate transaction code
        $kodeTransaksi = Str::random(10);

        // Calculate total price from cart
        $totalPrice = array_reduce($cart, function ($sum, $item) {
            $baju = Baju::find($item['product_id']);
            return $sum + ($baju->harga_sewa_perhari * $item['quantity']);
        }, 0);

        // Create new transaction
        $transaksi = new Transaksi();
        $transaksi->kode_transaksi = $kodeTransaksi;
        $transaksi->nama_penyewa = $penyewa->nama;
        $transaksi->alamat_penyewa = $penyewa->alamat;
        $transaksi->noTelepon_penyewa = $penyewa->nomor_telepon;
        $transaksi->tanggal_sewa = $request->input('tanggal_sewa');
        $transaksi->tanggal_kembali = $request->input('tanggal_kembali');
        $transaksi->harga_total = $totalPrice;
        $transaksi->save();

        // Create detail transactions
        foreach ($cart as $item) {
            $baju = Baju::find($item['product_id']);
            $detailTransaksi = new DetailTransaksi();
            $detailTransaksi->transaksi_id = $transaksi->id;
            $detailTransaksi->baju_id = $item['product_id'];
            $detailTransaksi->ukuran = $baju->ukuran; // Assuming 'ukuran' is a property of Baju model
            $detailTransaksi->jumlah = $item['quantity'];
            $detailTransaksi->save();
        }

        return redirect()->route('transaksi.index')->with('success', 'Transaksi Berhasil');
        // Return JSON response
        // return response()->json(['message' => 'Transaction successful!'], 200);
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
        $gambarBaju = $request->file('gambar_baju');

        if ($request->hasFile('gambar_baju')) {
            $gambarBaju->store('public');

            $baju->gambar_baju = $gambarBaju->hashName();
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
        // $baju->fill($request->validated());
        $oldFoto = $baju->gambar_baju;
        $gambarBaju = $request->file('gambar_baju');

        if ($request->hasFile('gambar_baju')) {
            $gambarBaju->store('public');

            // $baju->gambar_baju = $gambarBaju->hashName();
            $baju->update([
                'nama_baju' => $request->nama_baju,
                'gambar_baju' => $gambarBaju->hashName(),
                'ukuran' => $request->ukuran,
                'stok' => $request->stok,
                'harga_sewa_perhari' => $request->harga_sewa_perhari,
            ]);

            //hapus foto lama
            Storage::disk('public')->delete($oldFoto);
        } else {
            $baju->update([
                'nama_baju' => $request->nama_baju,
                'ukuran' => $request->ukuran,
                'stok' => $request->stok,
                'harga_sewa_perhari' => $request->harga_sewa_perhari,
            ]);
        }

        // $baju->save();

        return redirect()->route('baju.index')->with('success', 'Baju berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Baju $baju)
    {
        //hapus foto
        Storage::disk('public')->delete($baju->gambar_baju);

        $baju->delete();
        return redirect()->route('baju.index')->with('info', 'Baju berhasil dihapus');
    }
}
