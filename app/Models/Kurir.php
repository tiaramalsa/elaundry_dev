<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kurir extends Model
{
    protected $fillable = [
        'user_id',
        'id_kurir',
        'status',
        'bergabung_sejak',
        'plat_nomor',
        'jenis_kendaraan',
        'foto'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
