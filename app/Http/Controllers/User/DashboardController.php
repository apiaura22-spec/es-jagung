<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Order;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard user (Hanya untuk user yang sudah login)
     */
    public function index()
    {
        // ================= PRODUK =================
        // Mengambil semua data produk untuk ditampilkan di halaman
        $produks = Produk::with('reviews')->get();

        /** * PERBAIKAN LOGIKA STOK:
         * totalProduk: Menghitung hanya produk yang tersedia (stok > 0)
         * produkHabis: Menghitung produk yang stoknya kosong (stok <= 0)
         */
        $totalProduk = $produks->where('stok', '>', 0)->count();
        $produkHabis = $produks->where('stok', '<=', 0)->count();

        // ================= DATA USER =================
        $notifications = collect();
        $produkReviewed = collect();
        $produkBeli = collect();
        $orderStats = [
            'pending' => 0,
            'processed' => 0,
            'done' => 0
        ];

        if (Auth::check()) {
            $user = Auth::user();

            // Ambil notifikasi terbaru user
            $notifications = $user->notifications()->latest()->take(5)->get();

            // Produk yang sudah direview oleh user yang sedang login
            $produkReviewed = Produk::whereHas('reviews', function ($query) {
                $query->where('user_id', auth()->id());
            })->get();

            // Produk yang sudah dibeli & Statistik Pesanan
            $userOrders = Order::with('items.produk')
                ->where('user_id', $user->id)
                ->get();

            foreach ($userOrders as $order) {
                // Hitung statistik status pesanan
                if (isset($orderStats[$order->status])) {
                    $orderStats[$order->status]++;
                }

                // Ambil list produk unik yang pernah dibeli
                foreach ($order->items as $item) {
                    if ($item->produk) {
                        $produkBeli->push($item->produk);
                    }
                }
            }
            $produkBeli = $produkBeli->unique('id');
        }

        // ================= ULASAN TERBARU (Global) =================
        $reviews = Review::with(['user', 'produk'])
                    ->latest()
                    ->take(5)
                    ->get();

        // ================= LOGIKA HIDE NOTIF 1 JAM =================
        $showNotification = true;
        $notifHiddenUntil = session('notif_hidden_until');
        if ($notifHiddenUntil && Carbon::now()->lessThan($notifHiddenUntil)) {
            $showNotification = false;
        } else {
            // Set agar notifikasi popup muncul lagi setelah 1 jam
            session(['notif_hidden_until' => Carbon::now()->addHour()]);
        }

        return view('user.dashboard', compact(
            'produks',
            'totalProduk',
            'produkHabis',
            'notifications',
            'showNotification',
            'produkReviewed',
            'produkBeli',
            'reviews',
            'orderStats'
        ));
    }

    /**
     * Tampilkan detail produk tertentu
     */
    public function show($id)
    {
        // Ambil produk beserta ulasannya (terbaru di atas)
        $produk = Produk::with(['reviews.user' => function($q) {
            $q->latest();
        }])->findOrFail($id);

        // Cek apakah user yang login pernah membeli produk ini dan sudah selesai (untuk syarat review)
        $order = null;
        if (Auth::check()) {
            $order = Order::where('user_id', Auth::id())
                ->where('status', 'done')
                ->whereHas('items', function ($q) use ($id) {
                    $q->where('produk_id', $id);
                })
                ->latest()
                ->first();
        }

        // Mengarahkan ke file view detail produk
        return view('user.produk.detail', compact('produk', 'order'));
    }
}