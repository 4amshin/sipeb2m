<?php

namespace App\Console\Commands;

use App\Models\Pengembalian;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdatePengembalianTerlambat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-pengembalian-terlambat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status pengembalian menjadi terlambat ketika tanggal kembali telah terlewati';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //Tanggal hari ini
        $currentDate = Carbon::now();

        //query semua pengembalian dengan status "belum_dikembalikan"
        $pengembalians = Pengembalian::with('transaksi')
            ->whereHas('transaksi', function ($query) use ($currentDate) {
                $query->where('tanggal_kembali', '<', $currentDate);
            })
            ->where('status', '!=', 'diKembalikan')
            ->get();

        foreach ($pengembalians as $pengembalian) {
            //update status
            $pengembalian->status = 'terlambat';
            $pengembalian->save();
        }

        $this->info('Status Pengembalian telah diubah menjadi terlambat');

        return 0;
    }
}

