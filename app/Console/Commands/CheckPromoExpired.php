<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Promo;
use Carbon\Carbon;

class CheckPromoExpired extends Command
{
    protected $signature = 'promo:check-expired';

    protected $description = 'Nonaktifkan promo yang sudah melewati tanggal selesai';

    public function handle()
    {
        $today = Carbon::today();

        $expired = Promo::where('status', 'aktif')
            ->whereDate('tanggal_selesai', '<', $today)
            ->update([
                'status' => 'nonaktif'
            ]);

        $this->info("Promo expired dinonaktifkan: ".$expired);
    }
}