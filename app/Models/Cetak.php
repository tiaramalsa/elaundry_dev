<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // 🔥 INI WAJIB

class Cetak extends Model
{
use HasFactory; 

protected $table = 'cetak';

protected $fillable = [
    'nama_toko',
    'alamat',
    'telepon',
    'footer',
    'jam_buka',
    'tipe_kertas',
    'custom_width',
    'show_logo',
    'show_maps',
    'status',
];
}
