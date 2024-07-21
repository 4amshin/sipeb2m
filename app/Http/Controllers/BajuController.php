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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BajuController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan pengguna yang sedang login
        $user = auth()->user();

        // Jika pengguna adalah admin
        if ($user->role == 'admin') {
            // Mengambil daftar baju dengan pencarian dan pengurutan
            $daftarBaju = Baju::when($request->input('search'), function ($query, $search) {
                $query->where('nama_baju', 'like', '%' . $search . '%')
                    ->orWhere('ukuran', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $search . '%');
            })->orderBy('created_at', 'desc')->paginate(5);

            // Mengirimkan data ke tampilan daftar baju admin
            return view('admin.baju.daftar-baju', compact('daftarBaju'))->with('showNavbar', true);
        }
        // Jika pengguna adalah pengguna biasa
        else if ($user->role == 'pengguna') {
            // Mengambil semua data baju dan menambahkan URL gambar baju
            $daftarBaju = Baju::all()->map(function ($baju) {
                $baju->gambar_baju_url = $baju->gambar_baju ? asset('storage/' . $baju->gambar_baju) : asset('assets/img/baju-kosong.png');
                return $baju;
            });

            // Mengirimkan data ke tampilan keranjang pengguna
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
        // Mengambil data keranjang dari permintaan dan mengonversinya menjadi array
        $cart = json_decode($request->input('cart'), true);

        // Mendapatkan data pengguna yang sedang login
        $user = Auth::user();
        $penyewa = Pengguna::where('email', $user->email)->first();

        // Membuat kode transaksi secara acak
        $kodeTransaksi = Str::random(10);

        // Mendapatkan tanggal sewa dan tanggal kembali dari permintaan
        $tanggalSewa = new \DateTime($request->input('tanggal_sewa'));
        $tanggalKembali = new \DateTime($request->input('tanggal_kembali'));

        // Menghitung jumlah hari sewa
        $jumlahHari = $tanggalKembali->diff($tanggalSewa)->days + 1;

        // Menghitung total harga sewa berdasarkan jumlah hari dan jumlah barang
        $totalPrice = array_reduce($cart, function ($sum, $item) use ($jumlahHari) {
            $baju = Baju::find($item['product_id']);
            return $sum + ($baju->harga_sewa_perhari * $item['quantity'] * $jumlahHari);
        }, 0);

        // Membuat transaksi baru dan menyimpannya ke database
        $transaksi = new Transaksi();
        $transaksi->kode_transaksi = $kodeTransaksi;
        $transaksi->nama_penyewa = $penyewa->nama;
        $transaksi->alamat_penyewa = $penyewa->alamat;
        $transaksi->noTelepon_penyewa = $penyewa->nomor_telepon;
        $transaksi->tanggal_sewa = $request->input('tanggal_sewa');
        $transaksi->tanggal_kembali = $request->input('tanggal_kembali');
        $transaksi->harga_total = $totalPrice;

        // Simpan Gambar KTP
        $fotoKtp = $request->file('foto_ktp');
        if($fotoKtp) {
            //buat directori jika belum ada
            $this->createDirectoryIfNotExists('public/foto-ktp');

            $fotoKtp->store('public/foto-ktp');
            $transaksi->foto_ktp = $fotoKtp->hashName();
        }

        $transaksi->save();

        // Menyimpan detail transaksi untuk setiap item di keranjang
        foreach ($cart as $item) {
            $baju = Baju::find($item['product_id']);
            $detailTransaksi = new DetailTransaksi();
            $detailTransaksi->transaksi_id = $transaksi->id;
            $detailTransaksi->baju_id = $item['product_id'];
            $detailTransaksi->ukuran = $baju->ukuran;
            $detailTransaksi->jumlah = $item['quantity'];
            $detailTransaksi->save();
        }

        // Mengarahkan pengguna ke halaman daftar orderan dengan pesan sukses
        return redirect()->route('daftarOrderan')->with('success', 'Transaksi diproses');
    }

    // Membuat direktori jika belum ada
    protected function createDirectoryIfNotExists($path)
    {
        if (!Storage::exists($path)) {
            Storage::makeDirectory($path);
        }
    }

    // Menghapus gambar lama jika ada
    protected function deleteOldImage($oldImage)
    {
        if ($oldImage) {
            Storage::disk('public')->delete($oldImage);
        }
    }

    public function checkStock(Baju $baju)
    {
        // Mengecek apakah baju tersedia
        if ($baju) {
            // Mengembalikan stok baju dalam format JSON
            return response()->json(['stok' => $baju->stok]);
        } else {
            // Jika baju tidak ditemukan, mengembalikan stok 0 dengan status 404
            return response()->json(['stok' => 0], 404);
        }
    }

    public function create()
    {
        // Mendefinisikan daftar ukuran baju yang tersedia
        $listUkuran = ['S', 'M', 'L', 'XL', 'XXL'];

        // Menampilkan halaman tambah baju dengan daftar ukuran
        return view('admin.baju.tambah-baju', compact('listUkuran'));
    }

    public function store(StoreBajuRequest $request)
    {
        // Membuat instance baru dari model Baju dengan data yang telah divalidasi
        $baju = new Baju($request->validated());

        // Mengambil file gambar baju dari request
        $gambarBaju = $request->file('gambar_baju');

        // Mengecek apakah ada file gambar baju yang diupload
        if ($request->hasFile('gambar_baju')) {
            // Menyimpan file gambar baju ke direktori 'public'
            $gambarBaju->store('public');

            // Menyimpan nama file gambar baju yang telah di-hash ke dalam atribut model Baju
            $baju->gambar_baju = $gambarBaju->hashName();
        }

        // Menyimpan data baju ke dalam database
        $baju->save();

        // Mengarahkan kembali ke halaman index baju dengan pesan sukses
        return redirect()->route('baju.index')->with('success', 'Baju berhasil ditambahkan');
    }

    public function show(Baju $baju)
    {
    }

    public function edit(Baju $baju)
    {
        // Menentukan daftar ukuran yang tersedia
        $listUkuran = ['S', 'M', 'L', 'XL', 'XXL'];

        // Menampilkan halaman untuk mengupdate data baju dengan data baju dan daftar ukuran yang tersedia
        return view('admin.baju.update-baju', compact('baju', 'listUkuran'));
    }

    public function update(UpdateBajuRequest $request, Baju $baju)
    {
        // Menyimpan nama file gambar baju lama
        $oldFoto = $baju->gambar_baju;

        // Mengambil file gambar baju dari request
        $gambarBaju = $request->file('gambar_baju');

        // Mengecek apakah ada file gambar baju yang diupload
        if ($request->hasFile('gambar_baju')) {
            // Menyimpan file gambar baju ke direktori 'public'
            $gambarBaju->store('public');

            // Mengupdate data baju dengan gambar baru
            $baju->update([
                'nama_baju' => $request->nama_baju,
                'gambar_baju' => $gambarBaju->hashName(),
                'ukuran' => $request->ukuran,
                'stok' => $request->stok,
                'harga_sewa_perhari' => $request->harga_sewa_perhari,
            ]);

            // Menghapus file gambar baju lama dari penyimpanan jika ada
            if ($oldFoto) {
                Storage::disk('public')->delete($oldFoto);
            }
        } else {
            // Mengupdate data baju tanpa mengubah gambar
            $baju->update([
                'nama_baju' => $request->nama_baju,
                'ukuran' => $request->ukuran,
                'stok' => $request->stok,
                'harga_sewa_perhari' => $request->harga_sewa_perhari,
            ]);
        }

        // Mengarahkan kembali ke halaman index baju dengan pesan sukses
        return redirect()->route('baju.index')->with('success', 'Baju berhasil diperbarui');
    }

    public function destroy(Baju $baju)
    {
        // Menghapus file gambar baju dari penyimpanan
        Storage::disk('public')->delete($baju->gambar_baju);

        // Menghapus data baju dari database
        $baju->delete();

        // Mengarahkan kembali ke halaman index baju dengan pesan informasi
        return redirect()->route('baju.index')->with('info', 'Baju berhasil dihapus');
    }
}
