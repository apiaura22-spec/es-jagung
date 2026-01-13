<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    // Tambahkan baris ini agar data bisa diinput lewat form
    protected $fillable = [
        'keterangan',
        'kategori',
        'jumlah',
        'tanggal'
    ];
}