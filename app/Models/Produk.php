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
    'stok',
    'gambar'
];


    // Relasi: 1 Produk punya banyak Review
    public function reviews()
    {
        return $this->hasMany(Review::class, 'produk_id');
    }
}
