<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'user_id',
        'rating',
        'ulasan',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    /**
     * Review milik satu user
     */
    public function user()
    {
        return $this->belongsTo(User::class)
            ->withDefault([
                'name' => 'Pelanggan'
            ]);
    }

    /**
     * Review milik satu produk
     * withDefault = ANTI NULL (INI KUNCI GAMBAR MUNCUL)
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id')
            ->withDefault([
                'nama'   => 'Produk',
                'gambar' => 'default.png',
            ]);
    }
}
