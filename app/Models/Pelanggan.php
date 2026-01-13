<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    // Field yang boleh diisi massal
    protected $fillable = [
        'nama',
        'email',
        'no_hp',
    ];

    /**
     * Relasi ke pesanan yang dimiliki pelanggan
     */
    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'pelanggan_id');
    }
}
