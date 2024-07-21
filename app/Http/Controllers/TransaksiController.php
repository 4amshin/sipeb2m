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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class TransaksiController extends Controller
{
    public function homePage()
    {
        /*------------------BAJU TERLARIS-------------------*/
        $bajuTerlaris = DetailTransaksi::select('baju_id', DB::raw('SUM(jumlah) as total_penyewaan'))
            ->whereHas('transaksi', function ($query) {
                $query->where('status_sewa', 'selesai');
            })
            ->groupBy('baju_id')
            ->orderBy('total_penyewaan', 'DESC')
            ->with('baju') // Assuming you have a relationship to get the baju details
            ->take(5) // Limit to top 5 items, adjust as necessary
            ->get();

        // Menggabungkan item berdasarkan nama baju
        $mergedItems = [];
        foreach ($bajuTerlaris as $item) {
            $namaBaju = $item->baju->nama_baju;
            if (isset($mergedItems[$namaBaju])) {
                $mergedItems[$namaBaju] += $item->total_penyewaan;
            } else {
                $mergedItems[$namaBaju] = $item->total_penyewaan;
            }
        }

        // Konversi array $mergedItems menjadi koleksi Laravel
        $bajuTerlarisMerged = collect();
        foreach ($mergedItems as $namaBaju => $totalPenyewaan) {
            $bajuTerlarisMerged->push((object) ['nama_baju' => $namaBaju, 'total_penyewaan' => $totalPenyewaan]);
        }
        /*------------------BAJU TERLARIS-------------------*/


        /*------------------PENDAPATAN BULANAN-------------------*/
        $pendapatanBulanan = Transaksi::select(
            DB::raw('SUM(harga_total) as total_pendapatan'),
            DB::raw('DATE_FORMAT(tanggal_sewa, "%Y-%m") as bulan')
        )
            ->where('status_sewa', 'selesai')
            ->groupBy(DB::raw('DATE_FORMAT(tanggal_sewa, "%Y-%m")'))
            ->orderBy(DB::raw('DATE_FORMAT(tanggal_sewa, "%Y-%m")'), 'DESC')
            ->get();
        /*------------------PENDAPATAN BULANAN-------------------*/

        return view('admin.home', compact('bajuTerlarisMerged', 'pendapatanBulanan'))->with('showNavbar', true);
    }

    public function index()
    {
        // Mendapatkan pengguna yang sedang login
        $user = auth()->user();

        // Memeriksa apakah pengguna memiliki peran 'pengguna'
        if ($user->role == 'pengguna') {
            // Mendapatkan daftar transaksi yang sesuai dengan pengguna
            $daftarTransaksi = Transaksi::where('nama_penyewa', $user->name)
                ->where('status_order', 'diterima')
                ->where(function ($query) {
                    $query->where('status_sewa', 'sudah_ambil')
                        ->orWhere('status_sewa', 'sudah_lunas')
                        ->orWhere('status_sewa', 'dikirim');
                })
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        } else {
            // Mendapatkan daftar transaksi untuk admin
            $daftarTransaksi = Transaksi::where('status_order', 'diterima')
                ->where(function ($query) {
                    $query->where('status_sewa', 'sudah_ambil')
                        ->orWhere('status_sewa', 'sudah_lunas')
                        ->orWhere('status_sewa', 'dikirim');
                })
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        }

        // Mengembalikan tampilan daftar penyewaan dengan daftar transaksi yang sesuai
        return view('admin.penyewaan.daftar-penyewaan', compact('daftarTransaksi'))->with('showNavbar', true);
    }

    public function daftarOrderan()
    {
        // Mendapatkan pengguna yang sedang login
        $user = auth()->user();

        if ($user->role == 'pengguna') {
            // Mendapatkan daftar orderan yang sesuai dengan pengguna dan pisahkan berdasarkan status
            $orderDiproses = Transaksi::where('nama_penyewa', $user->name)
                ->where('status_order', 'diproses')
                ->orderBy('created_at', 'desc')
                ->paginate(5, ['*'], 'diproses');

            $orderDiterima = Transaksi::where('nama_penyewa', $user->name)
                ->where('status_order', 'diterima')
                ->orderBy('created_at', 'desc')
                ->paginate(5, ['*'], 'diterima');

            $orderDitolak = Transaksi::where('nama_penyewa', $user->name)
                ->where('status_order', 'ditolak')
                ->orderBy('created_at', 'desc')
                ->paginate(5, ['*'], 'ditolak');
        } else {
            // Mendapatkan daftar orderan untuk admin dan pisahkan berdasarkan status
            $orderDiproses = Transaksi::where('status_order', 'diproses')
                ->orderBy('created_at', 'desc')
                ->paginate(5, ['*'], 'diproses');

            $orderDiterima = Transaksi::where('status_order', 'diterima')
                ->orderBy('created_at', 'desc')
                ->paginate(5, ['*'], 'diterima');

            $orderDitolak = Transaksi::where('status_order', 'ditolak')
                ->orderBy('created_at', 'desc')
                ->paginate(5, ['*'], 'ditolak');
        }

        // Mengembalikan tampilan daftar orderan dengan daftar orderan yang sesuai
        return view('admin.penyewaan.daftar-orderan', compact('orderDiproses', 'orderDiterima', 'orderDitolak'))->with('showNavbar', true);
    }


    public function riwayatPenyewaan()
    {
        // Mendapatkan pengguna yang sedang login
        $user = auth()->user();

        // Memeriksa apakah pengguna memiliki peran 'pengguna'
        if ($user->role == 'pengguna') {
            // Mendapatkan daftar transaksi yang telah selesai untuk pengguna
            $daftarTransaksi = Transaksi::where('status_sewa', 'selesai')
                ->where('nama_penyewa', $user->name)
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        } else {
            // Mendapatkan daftar transaksi yang telah selesai untuk admin
            $daftarTransaksi = Transaksi::where('status_sewa', 'selesai')
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        }

        // Mengembalikan tampilan riwayat penyewaan dengan daftar transaksi yang sesuai
        return view('admin.penyewaan.riwayat-penyewaan', compact('daftarTransaksi'))->with('showNavbar', true);
    }

    public function getUkuran($nama_baju)
    {
        // Mengambil data baju berdasarkan nama baju yang diberikan
        $bajus = Baju::where('nama_baju', $nama_baju)->get();

        // Membuat array untuk menyimpan ukuran baju yang tersedia
        $listUkuran = [];

        // Mengecek setiap baju yang ditemukan
        foreach ($bajus as $baju) {
            if ($baju->stok > 0) {
                // Menambahkan ukuran baju ke dalam array jika stok masih ada
                $listUkuran[] = $baju->ukuran;
            }
        }

        // Mengembalikan daftar ukuran jika tersedia, atau pesan error jika tidak ada ukuran atau stok habis
        if (count($listUkuran) > 0) {
            return response()->json($listUkuran);
        } else {
            return response()->json(['error' => 'Ukuran tidak tersedia untuk baju ini atau stok habis'], 404);
        }
    }

    public function create()
    {
        // Daftar ukuran yang tersedia
        $listUkuran = ['S', 'M', 'L', 'XL', 'XXL'];

        // Mengambil semua data baju dari database
        $listBaju = Baju::all();

        // Mengambil dan menghapus data baju dari session jika ada
        $listDataBaju = session()->get('listDataBaju', []);
        session()->forget('listDataBaju');

        // Mengirimkan data ke view untuk proses tambah penyewaan
        return view('admin.penyewaan.tambah-penyewaan', compact('listBaju', 'listUkuran', 'listDataBaju'));
    }

    public function tambahDataBaju(Request $request)
    {
        // Mendapatkan data baju yang ditambahkan dari request
        $dataBaju = $request->only(['nama_baju', 'ukuran', 'jumlah']);

        // Mengambil list data baju dari session, jika tidak ada maka array kosong
        $listDataBaju = session()->get('listDataBaju', []);

        // Menambahkan data baju baru ke dalam list
        $listDataBaju[] = $dataBaju;

        // Menyimpan kembali list data baju ke dalam session
        session()->put('listDataBaju', $listDataBaju);

        // Memberikan respons JSON untuk menandakan sukses
        return response()->json(['success' => true]);
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            'nama_penyewa' => 'required|string|max:255',
            'alamat_penyewa' => 'required|string|max:255',
            'noTelepon_penyewa' => 'required|string|max:15',
            'tanggal_sewa' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_sewa',
        ]);

        // Menghitung durasi sewa berdasarkan tanggal sewa dan tanggal kembali
        $tanggalSewa = \Carbon\Carbon::parse($request->tanggal_sewa);
        $tanggalKembali = \Carbon\Carbon::parse($request->tanggal_kembali);
        $durasiSewa = $tanggalKembali->diffInDays($tanggalSewa);

        // Menghitung harga total berdasarkan baju yang dipilih
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

        // Membuat transaksi baru
        $transaksi = Transaksi::create([
            'kode_transaksi' => Str::random(10),
            'nama_penyewa' => $request->nama_penyewa,
            'alamat_penyewa' => $request->alamat_penyewa,
            'noTelepon_penyewa' => $request->noTelepon_penyewa,
            'tanggal_sewa' => $request->tanggal_sewa,
            'tanggal_kembali' => $request->tanggal_kembali,
            'harga_total' => $hargaTotal,
            'status' => 'diproses',
        ]);

        // Menyimpan detail transaksi untuk setiap baju yang dipilih
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

        // Menghapus data baju dari session setelah transaksi selesai diproses
        session()->forget('listDataBaju');

        // Redirect ke halaman daftar orderan dengan pesan sukses
        return redirect()->route('daftarOrderan')->with('success', 'Transaksi diproses.');
    }

    public function terimaOrderan(Transaksi $transaksi)
    {
        // Memperbarui status order transaksi menjadi 'diterima'
        $transaksi->update(['status_order' => 'diterima']);

        // Membuat entri pembayaran baru untuk transaksi ini
        $pembayaran = Pembayaran::create([
            'transaksi_id' => $transaksi->id,
            'status_pembayaran' => 'belum_bayar',
            'metode_pembayaran' => null,
            'tanggal_pembayaran' => null,
        ]);

        // Membuat entri pengembalian baru untuk transaksi ini
        $pengembalian = Pengembalian::create([
            'transaksi_id' => $transaksi->id,
            'status' => 'belum_diKembalikan',
        ]);

        // Redirect kembali ke halaman daftar orderan dengan pesan sukses
        return redirect()->route('daftarOrderan')->with('success', 'Orderan Diterima.');
    }

    public function tolakOrderan(Transaksi $transaksi)
    {
        // Memperbarui status order transaksi menjadi 'ditolak'
        $transaksi->update(['status_order' => 'ditolak']);

        // Redirect kembali ke halaman daftar orderan dengan pesan info
        return redirect()->route('daftarOrderan')->with('info', 'Orderan Ditolak.');
    }

    public function diAmbil(Transaksi $transaksi)
    {
        // Memperbarui status sewa transaksi menjadi 'sudah_ambil'
        $transaksi->update(['status_sewa' => 'sudah_ambil']);

        // Redirect kembali ke halaman indeks transaksi dengan pesan info
        return redirect()->route('transaksi.index')->with('info', 'Barang Telah Diambil');
    }

    public function diKirim(Transaksi $transaksi)
    {
        // Memperbarui status sewa transaksi menjadi 'dikirim'
        $transaksi->update(['status_sewa' => 'dikirim']);

        // Redirect kembali ke halaman indeks transaksi dengan pesan info
        return redirect()->route('transaksi.index')->with('info', 'Barang Telah Dikirim');
    }

    public function tandaiSelesai(Transaksi $transaksi)
    {
        // Memperbarui status transaksi menjadi 'selesai'
        $transaksi->update(['status' => 'selesai']);

        // Redirect kembali ke halaman indeks transaksi dengan pesan sukses
        return redirect()->route('transaksi.index')->with('success', 'Transaksi ditandai selesai.');
    }


    public function show(Transaksi $transaksi)
    {
    }

    public function edit(Transaksi $transaksi)
    {
    }

    public function update(UpdateTransaksiRequest $request, transaksi $transaksi)
    {
    }

    public function destroy(Transaksi $transaksi)
    {
        // Menghapus transaksi dari database
        $transaksi->delete();

        // Redirect kembali ke halaman indeks transaksi dengan pesan informasi
        return redirect()->route('transaksi.index')->with('info', 'Transaksi Berhasil Dihapus');
    }
}
