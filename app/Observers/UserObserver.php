<?php

namespace App\Observers;

use App\Models\Pengguna;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {

        if (Pengguna::where('email', $user->email)->orWhere('nama', $user->name)->exists()) {
            return;
        } else {
            //Buat data pengguna baru berdasarkan tabel user yang baru dibuat
            Pengguna::create([
                'nama' => $user->name,
                'nomor_telepon' => '-',
                'alamat' => '-',
                'role' => 'pengguna',
                'email' => $user->email,
                'password' => $user->unHashed_password,
            ]);
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
