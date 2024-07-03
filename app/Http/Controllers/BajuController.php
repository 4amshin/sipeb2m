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
            // $daftarBaju = Baju::all();
            $daftarBaju = Baju::all()->map(function ($baju) {
                $baju->gambar_baju_url = $baju->gambar_baju ? asset('storage/' . $baju->gambar_baju) : asset('assets/img/baju-kosong.png');
                return $baju;
            });

            return view('admin.baju.keranjang', compact('daftarBaju'))->with('showNavbar', false);
        }
    }

    public function koleksiBaju()
    {
        // Mendapatkan daftar nama baju yang unik
        $distinctNames = Baju::select('nama_baju')->distinct()->get();

        // Membuat koleksi kosong untuk menyimpan hasil akhir
        $koleksiBaju = collect();

        // Iterasi melalui setiap nama baju yang unik
        foreach ($distinctNames as $name) {
            // Mengambil baris pertama yang cocok dengan nama baju
            $baju = Baju::where('nama_baju', $name->nama_baju)->first();
            // Menambahkan hasil ke dalam koleksi jika ditemukan
            if ($baju) {
                $koleksiBaju->push($baju);
            }
        }

        // Mengirimkan hasil ke tampilan
        return view('landing-page.products', compact('koleksiBaju'));
    }


    public function checkout(Request $request)
    {
        // Menguraikan data keranjang
        $cart = json_decode($request->input('cart'), true);

        // Mendapatkan pengguna yang terautentikasi
        $user = Auth::user();
        $penyewa = Pengguna::where('email', $user->email)->first();

        // Menghasilkan kode transaksi
        $kodeTransaksi = Str::random(10);


        // Mendapatkan tanggal sewa dan tanggal kembali
        $tanggalSewa = new \DateTime($request->input('tanggal_sewa'));
        $tanggalKembali = new \DateTime($request->input('tanggal_kembali'));

        // Menghitung jumlah hari sewa
        $jumlahHari = $tanggalKembali->diff($tanggalSewa)->days + 1;

        // Menghitung total harga dari keranjang
        $totalPrice = array_reduce($cart, function ($sum, $item) use ($jumlahHari) {
            $baju = Baju::find($item['product_id']);
            return $sum + ($baju->harga_sewa_perhari * $item['quantity'] * $jumlahHari);
        }, 0);

        // Membuat transaksi baru
        $transaksi = new Transaksi();
        $transaksi->kode_transaksi = $kodeTransaksi;
        $transaksi->nama_penyewa = $penyewa->nama;
        $transaksi->alamat_penyewa = $penyewa->alamat;
        $transaksi->noTelepon_penyewa = $penyewa->nomor_telepon;
        $transaksi->tanggal_sewa = $request->input('tanggal_sewa');
        $transaksi->tanggal_kembali = $request->input('tanggal_kembali');
        $transaksi->harga_total = $totalPrice;
        $transaksi->save();

        // Membuat detail transaksi
        foreach ($cart as $item) {
            $baju = Baju::find($item['product_id']);
            $detailTransaksi = new DetailTransaksi();
            $detailTransaksi->transaksi_id = $transaksi->id;
            $detailTransaksi->baju_id = $item['product_id'];
            $detailTransaksi->ukuran = $baju->ukuran; // Menganggap 'ukuran' adalah properti dari model Baju
            $detailTransaksi->jumlah = $item['quantity'];
            $detailTransaksi->save();
        }

        return redirect()->route('daftarOrderan')->with('success', 'Transaksi diproses');
    }

    public function checkStock(Baju $baju)
    {
        if ($baju) {
            return response()->json(['stok' => $baju->stok]);
        } else {
            return response()->json(['stok' => 0], 404);
        }
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
            if ($oldFoto) {
                Storage::disk('public')->delete($oldFoto);
            }
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
