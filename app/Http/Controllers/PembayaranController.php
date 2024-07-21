<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Http\Requests\StorePembayaranRequest;
use App\Http\Requests\UpdatePembayaranRequest;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    public function index()
    {
        // Mengambil informasi pengguna yang sedang login
        $user = auth()->user();

        // Memeriksa peran pengguna
        if ($user->role == 'pengguna') {
            // Jika pengguna adalah pengguna biasa, ambil daftar pembayaran yang terkait dengan transaksi mereka
            $daftarPembayaran = Pembayaran::whereHas('transaksi', function ($query) use ($user) {
                $query->where('nama_penyewa', $user->name);
            })->with('transaksi')->orderBy('created_at', 'desc')->paginate(5);
        } else {
            // Jika pengguna adalah admin, ambil semua daftar pembayaran dengan transaksi terkait
            $daftarPembayaran = Pembayaran::with('transaksi')->orderBy('created_at', 'desc')->paginate(5);
        }

        // Mengirimkan data daftar pembayaran ke view 'admin.pembayaran.daftar-pembayaran' dengan memasukkan variabel 'showNavbar' sebagai true
        return view('admin.pembayaran.daftar-pembayaran', compact('daftarPembayaran'))->with('showNavbar', true);
    }

    public function create()
    {
    }

    public function tandaiLunas(Pembayaran $pembayaran)
    {
        // Menandai pembayaran sebagai lunas dan mencatat tanggal pembayaran saat ini
        $pembayaran->status_pembayaran = 'dibayar';
        $pembayaran->tanggal_pembayaran = now();

        // Menyimpan perubahan pada model Pembayaran
        $pembayaran->save();

        // Mengambil transaksi terkait dan menandai status sewa sebagai sudah lunas
        $transaksi = Transaksi::find($pembayaran->transaksi->id);
        $transaksi->status_sewa = 'sudah_lunas';
        $transaksi->save();

        // Redirect kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Pembayaran Lunas');
    }

    public function buktiPembayaran(Request $request, Pembayaran $pembayaran)
    {
        // Validasi data yang diterima dari request
        $validatedData = $request->validate([
            'metode_pembayaran' => 'required|string',
            'bukti_pembayaran' => 'nullable|image|mimes:png,jpg,jpeg|max:2048', // Tambahkan validasi ukuran
        ]);

        // Simpan gambar lama untuk dihapus jika ada gambar baru
        $oldImage = $pembayaran->bukti_pembayaran;
        $buktiPembayaran = $request->file('bukti_pembayaran');

        // Periksa apakah ada file bukti pembayaran yang diunggah
        if ($buktiPembayaran) {
            // Buat direktori jika belum ada
            $this->createDirectoryIfNotExists('public/bukti-pembayaran');

            // Simpan file bukti pembayaran yang baru
            $buktiPembayaran->store('public/bukti-pembayaran');
            $validatedData['bukti_pembayaran'] = $buktiPembayaran->hashName();

            // Hapus gambar lama jika ada
            $this->deleteOldImage($oldImage);
        }

        // Update metode pembayaran pada tabel pembayaran
        $pembayaran->update($validatedData);

        // Kembalikan ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Bukti Pembayaran Telah di Submit');
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
            Storage::disk('public/bukti-pembayaran')->delete($oldImage);
        }
    }

    public function store(StorePembayaranRequest $request)
    {
    }

    public function show(Pembayaran $pembayaran)
    {
    }

    public function edit(Pembayaran $pembayaran)
    {
    }

    public function update(UpdatePembayaranRequest $request, Pembayaran $pembayaran)
    {
    }

    public function destroy(Pembayaran $pembayaran)
    {
    }
}
