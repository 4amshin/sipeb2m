<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Http\Requests\StorePenggunaRequest;
use App\Http\Requests\UpdatePenggunaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        // Menggunakan Gate untuk memeriksa izin super user
        if (Gate::denies('super-user')) {
            abort(403, 'Anda tidak bisa mengakses halaman ini');
        }

        // Mengambil daftar pengguna dengan kemampuan pencarian
        $daftarPengguna = Pengguna::when($request->input('search'), function ($query, $search) {
            $query->where('nama', 'like', '%' . $search . '%')
                ->orWhere('nomor_telepon', 'like', '%' . $search . '%')
                ->orWhere('alamat', 'like', '%' . $search . '%')
                ->orWhere('role', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        })->orderBy('created_at', 'desc')->paginate(5);

        // Menampilkan halaman daftar pengguna dengan data yang sudah diproses
        return view('admin.pengguna.daftar-pengguna', compact('daftarPengguna'))->with('showNavbar', true);
    }

    public function profile()
    {
        // Mengambil informasi pengguna yang sedang login
        $user = auth()->user();

        // Mengambil data pengguna dari tabel Pengguna berdasarkan email pengguna yang sedang login
        $pengguna = Pengguna::where('email', $user->email)->first();

        // Menampilkan halaman profil dengan data pengguna
        return view('auth.profile', compact('pengguna'));
    }

    public function updateProfile(Request $request)
    {
        // Mengambil informasi pengguna yang sedang login
        $user = auth()->user();
        $pengguna = Pengguna::where('email', $user->email)->first();

        // Validasi data yang dikirimkan oleh pengguna
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|max:255',
            'nomor_telepon' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'gambar_profil' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        // Mengambil foto profil lama untuk kemungkinan penghapusan setelah pembaruan
        $oldFoto = $pengguna->gambar_profil;
        $gambarProfil = $request->file('gambar_profil');

        // Jika terdapat pengiriman file gambar baru
        if ($request->hasFile('gambar_profil')) {

            // Membuat direktori penyimpanan jika belum ada
            if (!Storage::exists('public/profil')) {
                Storage::makeDirectory('public/profil');
            }

            // Menyimpan gambar profil baru
            $gambarProfil->store('public/profil');


            // Memperbarui nama file gambar profil
            $validatedData['gambar_profil'] = $gambarProfil->hashName();

            // Menghapus gambar profil lama jika ada
            if ($oldFoto) {
                Storage::disk('public/profil')->delete($oldFoto);
            }
        }

        // Memperbarui informasi pengguna dengan data yang divalidasi
        $pengguna->update($validatedData);

        // Mengarahkan kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Profil Berhasil diperbarui');
    }

    public function create()
    {
        // Menyiapkan pilihan jenis kelamin untuk formulir tambah pengguna
        $jenisKelamin = ['laki-laki', 'perempuan'];

        // Mengembalikan view formulir tambah pengguna dengan data jenis kelamin
        return view('admin.pengguna.tambah-pengguna', compact('jenisKelamin'));
    }


    public function store(StorePenggunaRequest $request)
    {
        // Memeriksa izin super user sebelum proses menyimpan data
        if (Gate::denies('super-user')) {
            abort(403, 'Anda tidak bisa mengakses halaman ini');
        }

        // Memvalidasi data masukan berdasarkan aturan yang telah ditentukan
        $validatedData = $request->validated();

        // Menyimpan data pengguna baru ke dalam database
        Pengguna::create($validatedData);

        // Mengarahkan pengguna kembali ke halaman daftar pengguna dengan pesan sukses
        return redirect()->route('pengguna.index')->with('success', 'Pengguna baru berhasil ditambahkan');
    }


    public function show(Pengguna $pengguna)
    {
    }

    public function edit(Pengguna $pengguna)
    {
        // Mendapatkan daftar jenis kelamin untuk opsi pada form
        $jenisKelamin = ['laki-laki', 'perempuan'];

        // Mengirimkan data pengguna yang akan diupdate ke halaman update-pengguna
        return view('admin.pengguna.update-pengguna', compact('pengguna', 'jenisKelamin'));
    }


    public function update(UpdatePenggunaRequest $request, Pengguna $pengguna)
    {
        // Memvalidasi data yang dikirimkan dari form update
        $validatedData = $request->validated();

        // Memperbarui data pengguna berdasarkan data yang divalidasi
        $pengguna->update($validatedData);

        // Mengarahkan pengguna kembali ke halaman daftar-pengguna dengan pesan sukses
        return redirect()->route('pengguna.index')->with('success', 'Data Pengguna berhasil diperbarui');
    }


    public function destroy(Pengguna $pengguna)
    {
        // Menghapus akun pengguna dari database
        $pengguna->delete();

        // Mengarahkan pengguna kembali ke halaman daftar-pengguna dengan pesan info
        return redirect()->route('pengguna.index')->with('info', 'Akun Pengguna Berhasil Dihapus');
    }
}
