<?php

namespace App\Observers;

use App\Models\Pengguna;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PenggunaObserver
{
    /**
     * Handle the Pengguna "created" event.
     */
    public function created(Pengguna $pengguna): void
    {
        if (User::where('email', $pengguna->email)->orWhere('name', $pengguna->nama)->exists()) {
            return;
        } else {
            User::create([
                'name' => $pengguna->nama,
                'role' => $pengguna->role,
                'email' => $pengguna->email,
                'password' => Hash::make($pengguna->password),
                'unHashed_password' => $pengguna->password,
            ]);
        }
    }

    /**
     * Handle the Pengguna "updated" event.
     */
    public function updated(Pengguna $pengguna): void
    {
        $userData = [
            'name' => $pengguna->nama,
            'email' => $pengguna->email,
        ];

        //update password only when it submitted
        if (!empty($pengguna->password)) {
            $userData['password'] = Hash::make($pengguna->password);
        }

        // Update user data in the users table
        User::where('email', $pengguna->email)->update($userData);
    }

    /**
     * Handle the Pengguna "deleted" event.
     */
    public function deleted(Pengguna $pengguna): void
    {
        //delete user
        $user = User::find($pengguna->id);
        $user->delete();
    }

    /**
     * Handle the Pengguna "restored" event.
     */
    public function restored(Pengguna $pengguna): void
    {
        //
    }

    /**
     * Handle the Pengguna "force deleted" event.
     */
    public function forceDeleted(Pengguna $pengguna): void
    {
        //
    }
}
