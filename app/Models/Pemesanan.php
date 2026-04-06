<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan';
    protected $primaryKey = 'id_pemesanan';
    protected $fillable = [
        'id_track',
        'id_cust',
        'id_outlet',
        'id_promo',
        'jenis_layanan',
        'tipe_pemesanan',
        'no_order',
        'tanggal_masuk',
        'tanggal_selesai',
        'berat_cucian',
        'jumlah_item',
        'total_harga',
        'catatan_khusus',
        'detail_layanan',
        'latitude',
        'longitude',
        'jarak_km',
        'ongkir',
        'diskon',
        'total_akhir',
        'status_proses',
        'status_bayar',
        'jenis_pengambilan'
        ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_cust', 'id_cust');
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'id_outlet', 'id_outlet');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_pemesanan', 'id_pemesanan');
    }

    public function historyPemesanan()
    {
        return $this->hasMany(HistoryPemesanan::class, 'id_pemesanan', 'id_pemesanan');
    }

    public function trackPemesanan()
    {
        return $this->hasOne(TrackPemesanan::class, 'id_pemesanan', 'id_pemesanan');
    }

    public function getTipeAttribute()
    {
        return 'pemesanan';
    }

    public function promo()
    {
        return $this->belongsTo(Promo::class, 'id_promo', 'id_promo');
    }

    public function getLayananAttribute()
    {
        return array_filter(array_map('trim', explode(',', $this->jenis_layanan)));
    }

    public function kurir()
    {
        return $this->belongsTo(User::class, 'id_kurir');
    }

}
