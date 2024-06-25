<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Http\Requests\StorePenggunaRequest;
use App\Http\Requests\UpdatePenggunaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //Cek Access
        if (Gate::denies('super-user')) {
            abort(403, 'Anda tidak bisa mengakses halaman ini');
        }

        $daftarPengguna = Pengguna::when($request->input('search'), function ($query, $search) {
            $query->where('nama', 'like', '%' . $search . '%')
                ->orWhere('nomor_telepon', 'like', '%' . $search . '%')
                ->orWhere('alamat', 'like', '%' . $search . '%')
                ->orWhere('role', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        })->orderBy('created_at', 'desc')->paginate(5);

        return view('admin.pengguna.daftar-pengguna', compact('daftarPengguna'))->with('showNavbar', true);
    }

    public function profile()
    {
        $user = auth()->user();
        $pengguna = Pengguna::where('email', $user->email)->first();

        return view('auth.profile', compact('pengguna'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $pengguna = Pengguna::where('email', $user->email)->first();

        // Validasi data
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_telepon' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'gambar_baju' => 'nullable|image|mimes:jpeg,png,jpg,webp',
        ]);

        // Periksa apakah ada gambar baru yang diunggah
        if ($request->hasFile('gambar_profil')) {
            // Hapus gambar lama jika ada
            if ($pengguna->gambar_profil && File::exists(public_path($pengguna->gambar_profil))) {
                File::delete(public_path($pengguna->gambar_profil));
            }

            // Simpan gambar baru
            $file = $request->file('gambar_profil');
            $path = 'uploads/profil/' . time() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/profil', $path);
            $pengguna->gambar_profil = $path;
        }

        // Perbarui data profil pengguna
        $pengguna->update($validatedData);

        return redirect()->back()->with('success', 'Profil Berhasil diPerbarui');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenisKelamin = ['laki-laki', 'perempuan'];
        return view('admin.pengguna.tambah-pengguna', compact('jenisKelamin'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePenggunaRequest $request)
    {
        //Cek Akses
        if (Gate::denies('super-user')) {
            abort(403, 'Anda tidak bisa mengakses halaman ini');
        }

        // Validasi
        $validatedData = $request->validated();

        //Simpan Pengguna
        Pengguna::create($validatedData);

        //Kembali
        return redirect()->route('pengguna.index')->with('success', 'Pengguna baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengguna $pengguna)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengguna $pengguna)
    {
        return view('admin.pengguna.update-pengguna', compact('pengguna'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePenggunaRequest $request, Pengguna $pengguna)
    {
        // Validasi
        $validatedData = $request->validated();

        // Simpan Perubahan
        $pengguna->update($validatedData);

        // Kembali
        return redirect()->route('pengguna.index')->with('success', 'Data Pengguna berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengguna $pengguna)
    {
        $pengguna->delete();
        return redirect()->route('pengguna.index')->with('info', 'Akun Pengguna Berhasil Dihapus');
    }
}
