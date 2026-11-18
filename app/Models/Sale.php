<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_transaksi',
        'user_id',
        'total_harga',
        'bayar',
        'kembalian',
    ];

    // Relasi ke User (Kasir)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Detail Transaksi
    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }
}