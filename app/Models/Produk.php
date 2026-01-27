<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produks';

    protected $fillable = [
    'nama',
    'description',
    'harga',
    'diskon',
    'stok',
    'gambar'
];

    protected $attributes = [
        'diskon' => 0,
    ];


    // Relasi: 1 Produk punya banyak Review
    public function reviews()
    {
        return $this->hasMany(Review::class, 'produk_id');
    }

    // Relasi: 1 Produk punya banyak OrderItem
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'produk_id');
    }

    // Hitung harga setelah diskon
    public function getHargaSetelahDiskonAttribute()
    {
        $diskon = $this->diskon ?? 0;
        if ($diskon > 0) {
            return $this->harga - ($this->harga * $diskon / 100);
        }
        return $this->harga;
    }

    // Cek apakah ada diskon
    public function hasDiskon()
    {
        return ($this->diskon ?? 0) > 0;
    }
}
