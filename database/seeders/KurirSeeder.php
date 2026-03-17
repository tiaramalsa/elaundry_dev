<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class KurirSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama'     => 'Kurir 1',
            'email'    => 'kurir1@laundry.test',
            'no_telp'  => '0811111111',
            'role'     => 'kurir',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'nama'     => 'Kurir 2',
            'email'    => 'kurir2@laundry.test',
            'no_telp'  => '0822222222',
            'role'     => 'kurir',
            'password' => Hash::make('password'),
        ]);
    }
}