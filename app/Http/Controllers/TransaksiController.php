<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Http\Requests\StoreTransaksiRequest;
use App\Http\Requests\UpdateTransaksiRequest;
use App\Models\Baju;
use App\Models\DetailTransaksi;
use App\Models\Pembayaran;
use App\Models\Pengembalian;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role == 'pengguna') {
            $daftarTransaksi = Transaksi::where('nama_penyewa', $user->name)
                ->where('status_order', 'diterima')
                ->where('status_sewa', 'sudah_ambil')
                ->orWhere('status_sewa', 'sudah_lunas')
                ->orWhere('status_sewa', 'dikirim')
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        } else {
            $daftarTransaksi = Transaksi::where('status_order', 'diterima')
                ->where('status_sewa', 'sudah_ambil')
                ->orWhere('status_sewa', 'sudah_lunas')
                ->orWhere('status_sewa', 'dikirim')
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        }

        return view('admin.penyewaan.daftar-penyewaan', compact('daftarTransaksi'))->with('showNavbar', true);
    }

    public function daftarOrderan()
    {
        $user = auth()->user();

        if ($user->role == 'pengguna') {
            $daftarOrderan = Transaksi::where('nama_penyewa', $user->name)
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        } else {
            $daftarOrderan = Transaksi::orderBy('created_at', 'desc')
                ->paginate(5);
        }

        return view('admin.penyewaan.daftar-orderan', compact('daftarOrderan'))->with('showNavbar', true);
    }


    public function riwayatPenyewaan()
    {
        $user = auth()->user();


        if ($user->role == 'pengguna') {
            $daftarTransaksi = Transaksi::where('status_sewa', 'selesai')
                ->where('nama_penyewa', $user->name)
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        } else {
            $daftarTransaksi  = Transaksi::where('status_sewa', 'selesai')
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        }


        return view('admin.penyewaan.riwayat-penyewaan', compact('daftarTransaksi'))->with('showNavbar', true);
    }

    public function getUkuran($nama_baju)
    {
        // Mengambil semua data baju dengan nama_baju yang sesuai
        $bajus = Baju::where('nama_baju', $nama_baju)->get();

        // Inisialisasi array untuk menampung ukuran yang tersedia
        $listUkuran = [];

        // Loop melalui setiap baju dan cek stoknya
        foreach ($bajus as $baju) {
            if ($baju->stok > 0) {
                $listUkuran[] = $baju->ukuran;
            }
        }

        // Cek apakah ada ukuran yang tersedia
        if (count($listUkuran) > 0) {
            return response()->json($listUkuran);
        } else {
            return response()->json(['error' => 'Ukuran tidak tersedia untuk baju ini atau stok habis'], 404);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listUkuran = ['S', 'M', 'L', 'XL', 'XXL'];
        $listBaju = Baju::all();
        $listDataBaju = session()->get('listDataBaju', []);
        session()->forget('listDataBaju');
        return view('admin.penyewaan.tambah-penyewaan', compact('listBaju', 'listUkuran', 'listDataBaju'));
    }

    public function tambahDataBaju(Request $request)
    {
        $dataBaju = $request->only(['nama_baju', 'ukuran', 'jumlah']);
        $listDataBaju = session()->get('listDataBaju', []);
        $listDataBaju[] = $dataBaju;
        session()->put('listDataBaju', $listDataBaju);

        return response()->json(['success' => true]);
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_penyewa' => 'required|string|max:255',
            'alamat_penyewa' => 'required|string|max:255',
            'noTelepon_penyewa' => 'required|string|max:15',
            'tanggal_sewa' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_sewa',
        ]);

        // Hitung durasi sewa dalam hari
        $tanggalSewa = \Carbon\Carbon::parse($request->tanggal_sewa);
        $tanggalKembali = \Carbon\Carbon::parse($request->tanggal_kembali);
        $durasiSewa = $tanggalKembali->diffInDays($tanggalSewa);

        // Hitung harga total
        $hargaTotal = 0;
        $listDataBaju = session()->get('listDataBaju', []);
        foreach ($listDataBaju as $dataBaju) {
            $baju = Baju::where('nama_baju', $dataBaju['nama_baju'])
                ->where('ukuran', $dataBaju['ukuran'])
                ->first();

            if ($baju) {
                $hargaSewaPerBaju = $baju->harga_sewa_perhari * $dataBaju['jumlah'];
                $hargaSewaTotal = $hargaSewaPerBaju * $durasiSewa;
                $hargaTotal += $hargaSewaTotal;
            }
        }

        // Simpan data transaksi
        $transaksi = Transaksi::create([
            'kode_transaksi' => Str::random(10), // Atau gunakan generator kode unik lainnya
            'nama_penyewa' => $request->nama_penyewa,
            'alamat_penyewa' => $request->alamat_penyewa,
            'noTelepon_penyewa' => $request->noTelepon_penyewa,
            'tanggal_sewa' => $request->tanggal_sewa,
            'tanggal_kembali' => $request->tanggal_kembali,
            'harga_total' => $hargaTotal,
            'status' => 'diproses',
        ]);

        // Simpan data detail transaksi
        foreach ($listDataBaju as $dataBaju) {
            $baju = Baju::where('nama_baju', $dataBaju['nama_baju'])->first();
            if ($baju) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'baju_id' => $baju->id,
                    'ukuran' => $dataBaju['ukuran'],
                    'jumlah' => $dataBaju['jumlah'],
                ]);
            }
        }

        // Reset session listDataBaju
        session()->forget('listDataBaju');

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan.');
    }



    public function terimaOrderan(Transaksi $transaksi)
    {
        // Update status transaksi menjadi diterima
        $transaksi->update(['status_order' => 'diterima']);

        // Buat entri pembayaran baru
        $pembayaran = Pembayaran::create([
            'transaksi_id' => $transaksi->id,
            'status_pembayaran' => 'belum_bayar',
            'metode_pembayaran' => null,
            'tanggal_pembayaran' => null,
        ]);

        // Buat entri pengembalian baru
        $pengembalian = Pengembalian::create([
            'transaksi_id' => $transaksi->id,
            'status' => 'belum_diKembalikan',
        ]);

        // Redirect ke halaman daftar transaksi dengan pesan sukses
        return redirect()->route('daftarOrderan')->with('success', 'Orderan Diterima.');
    }

    public function tolakOrderan(Transaksi $transaksi)
    {
        // Update status transaksi menjadi ditolak
        $transaksi->update(['status_order' => 'ditolak']);

        // Redirect ke halaman daftar transaksi dengan pesan sukses
        return redirect()->route('daftarOrderan')->with('info', 'Orderan Ditolak.');
    }

    public function diAmbil(Transaksi $transaksi)
    {
        // Update status transaksi menjadi sudah_ambil
        $transaksi->update(['status_sewa' => 'sudah_ambil']);

        // Redirect ke halaman daftar transaksi dengan pesan sukses
        return redirect()->route('transaksi.index')->with('info', 'Barang Telah Diambil');
    }

    public function diKirim(Transaksi $transaksi)
    {
        // Update status transaksi menjadi dikirim
        $transaksi->update(['status_sewa' => 'dikirim']);

        // Redirect ke halaman daftar transaksi dengan pesan sukses
        return redirect()->route('transaksi.index')->with('info', 'Barang Telah Dikirim');
    }


    public function tandaiSelesai(Transaksi $transaksi)
    {
        $transaksi->update(['status' => 'selesai']);
        return redirect()->route('transaksi.index')->with('success', 'Transaksi ditandai selesai.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransaksiRequest $request, transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return redirect()->route('transaksi.index')->with('info', 'Transaksi Berhasil Dihapus');
    }
}
