<?php

namespace App\Models;

use Illuminate\Foundation\Auth\Users as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Users extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'id'; // 🔥 WAJIB
    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'no_telp',
        
    ];

        public function kurir()
    {
        return $this->hasOne(Kurir::class);
    }
}
