<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Total produk
        $totalProduk = Produk::count();

        // Total pesanan
        $totalPesanan = Order::count();

        // Total pelanggan (user)
        $totalPelanggan = User::count();

        // Pesanan baru (status pending atau paid_pending)
        $pesananBaru = Order::whereIn('status', ['pending', 'paid_pending'])->count();

        // Pesanan selesai / confirmed
        $pesananSelesai = Order::where('status', 'confirmed')->count();

        // Produk terbaru (5 terakhir)
        $produk = Produk::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProduk',
            'totalPesanan',
            'totalPelanggan',
            'pesananBaru',
            'pesananSelesai',
            'produk'
        ));
    }
}
