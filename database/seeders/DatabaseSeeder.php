<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::updateOrCreate(
        //     ['email' => 'admin@laundry.test'],
        //     [
        //         'nama'     => 'Admin Laundry',
        //         'password' => Hash::make('password'),
        //         'role'     => 'admin',
        //         'no_telp'  => '081234567890',
        //     ]);

        $this->call([
            AdminSeeder::class,
            CustomerSeeder::class,
            OutletSeeder::class,
            KasirSeeder::class,
            KurirSeeder::class,
        ]);
    }

}
