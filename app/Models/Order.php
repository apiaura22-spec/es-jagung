<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'status', 'total_price', 'payment_proof'
    ];

    /**
     * Relasi ke user pemilik order
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke bukti pembayaran (opsional)
     */
    public function paymentProof()
    {
        return $this->hasOne(PaymentProof::class, 'order_id'); // pastikan foreign key benar
    }

    /**
     * Relasi ke order items
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relasi ke produk melalui order items
     */
    public function produk()
    {
        return $this->hasManyThrough(
            Produk::class,    // Model akhir
            OrderItem::class, // Model perantara
            'order_id',       // FK di order_items menuju orders
            'id',             // PK di produk
            'id',             // PK di orders
            'produk_id'       // FK di order_items menuju produk
        );
    }
}
