<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'total_price', 'status', 'metode_pembayaran', 
        'snap_token', 'payment_proof', 'payment_url', 'bank_qr', 'uuid'
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function items() { return $this->hasMany(OrderItem::class, 'order_id'); }

    // Cek apakah metode pembayaran adalah Cash
    public function isCash()
    {
        return trim(strtolower($this->metode_pembayaran)) === 'cash';
    }

    // Label Otomatis untuk Metode Pembayaran (Warna Badge)
    public function getMetodeLabelAttribute()
    {
        $val = trim(strtolower($this->metode_pembayaran));
        
        return match($val) {
            'midtrans' => '<span class="badge bg-info bg-opacity-10 text-info border border-info px-2"><i class="fas fa-credit-card me-1"></i> MIDTRANS</span>',
            'cash'     => '<span class="badge bg-success bg-opacity-10 text-success border border-success px-2"><i class="fas fa-money-bill-wave me-1"></i> TUNAI</span>',
            default    => '<span class="badge bg-secondary text-white">BELUM DIPILIH</span>',
        };
    }

    // Label Otomatis untuk Status Pesanan
    public function getStatusLabelAttribute()
    {
        $status = trim(strtolower($this->status));
        
        return match($status) {
            'baru'             => '<span class="badge bg-danger text-white"><i class="fas fa-star me-1"></i> PESANAN BARU</span>',
            'pending'          => '<span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i> MENUNGGU BAYAR</span>',
            'confirmed'        => '<span class="badge bg-info text-white"><i class="fas fa-check-circle me-1"></i> DIKONFIRMASI</span>',
            'processing'       => '<span class="badge bg-dark text-white"><i class="fas fa-fire me-1"></i> SEDANG DIMASAK</span>',
            'ready_to_pickup'  => '<span class="badge bg-primary text-white"><i class="fas fa-shopping-bag me-1"></i> SIAP DIAMBIL</span>',
            'done'             => '<span class="badge bg-success text-white"><i class="fas fa-check-double me-1"></i> SELESAI</span>',
            'rejected'         => '<span class="badge bg-danger text-white"><i class="fas fa-times me-1"></i> DITOLAK</span>',
            default            => '<span class="badge bg-secondary">' . strtoupper($status) . '</span>',
        };
    }
}