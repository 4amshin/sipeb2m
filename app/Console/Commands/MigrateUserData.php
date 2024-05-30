<?php

namespace App\Console\Commands;

use App\Models\Pengguna;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class MigrateUserData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:user-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate data from penggunas tables to users table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //migrate data from penggunas table
        $penggunas = Pengguna::all();
        foreach ($penggunas as $pengguna) {
            User::create([
                'name' => $pengguna->nama,
                'role' => $pengguna->role,
                'email' => $pengguna->email,
                'password' => Hash::make($pengguna->password),
            ]);
        }

        $this->info('Data migration completed successfully');
    }
}
