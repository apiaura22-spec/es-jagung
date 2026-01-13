<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentProof extends Model
{
    protected $fillable = ['order_id', 'file'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

