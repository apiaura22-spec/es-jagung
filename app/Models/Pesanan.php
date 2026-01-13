<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    // Field yang boleh diisi massal
    protected $fillable = [
        'pelanggan_id',
        'produk_id',
        'jumlah',
        'total_harga',
        'status', // pending, diproses, selesai, batal
    ];

    /**
     * Relasi ke pelanggan (user yang memesan)
     */
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    /**
     * Relasi ke produk melalui tabel pivot pesanan_produk
     */
    public function produk()
    {
        return $this->belongsToMany(Produk::class, 'pesanan_produk')
                    ->withPivot('jumlah', 'harga')
                    ->withTimestamps();
    }

    /**
     * Helper: total harga pesanan dihitung dari pivot table
     */
    public function hitungTotalHarga()
    {
        return $this->produk->sum(function($item) {
            return $item->pivot->jumlah * $item->pivot->harga;
        });
    }
}
