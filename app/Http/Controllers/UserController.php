<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Memeriksa apakah pengguna tidak memiliki izin sebagai super-user
        if (Gate::denies('super-user')) {
            // Jika tidak memiliki izin, tampilkan halaman error 403
            abort(403, 'Anda tidak bisa mengakses halaman ini');
        }

        // Mengambil daftar pengguna dari database dengan opsi pencarian dan paginasi
        $daftarPengguna = User::when($request->input('search'), function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('nomor_telepon', 'like', '%' . $search . '%')
                ->orWhere('alamat', 'like', '%' . $search . '%')
                ->orWhere('role', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        })->orderBy('created_at', 'desc')->paginate(5);

        // Mengembalikan tampilan daftar pengguna dengan data pengguna
        return view('admin.pengguna.daftar-pengguna', compact('daftarPengguna'));
    }

    public function create()
    {
        // Mengembalikan tampilan untuk menambahkan pengguna baru
        return view('admin.pengguna.tambah-pengguna');
    }

    public function store(Request $request)
    {
        // Memeriksa apakah pengguna tidak memiliki izin 'super-user'
        if (Gate::denies('super-user')) {
            abort(403, 'Anda tidak bisa mengakses halaman ini');
        }

        // Memvalidasi data yang diinputkan
        $request->validate([
            'name' => 'required|string',
            'nomor_telepon' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Membuat pengguna baru dengan data yang telah divalidasi
        $user = User::create([
            'name' => $request->name,
            'nomor_telepon' => $request->nomor_telepon,
            'alamat' => $request->alamat,
            'role' => 'pengguna',
            'email' => $request->email,
            'unHashed_password' => $request->password,
            'password' => Hash::make($request->password),
        ]);

        dd($user);

        // Mengarahkan kembali ke daftar pengguna dengan pesan sukses
        return redirect()->route('user.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }


    public function show(User $user)
    {
    }

    public function edit(User $user)
    {
        // Mengembalikan tampilan untuk mengupdate data pengguna
        return view('admin.pengguna.update-pengguna', compact('user'));
    }

    public function update(Request $request, User $user)
    {
    }

    public function destroy(User $user)
    {
    }
}
