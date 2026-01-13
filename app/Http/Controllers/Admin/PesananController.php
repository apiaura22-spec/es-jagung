<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Produk;
use App\Notifications\PesananSiapNotification;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    // ===================== LIST PESANAN =====================
    public function index()
    {
        $orders = Order::with(['user', 'paymentProof'])
            ->latest()
            ->get();

        return view('admin.pesanan.index', compact('orders'));
    }

    // ===================== DETAIL PESANAN =====================
    public function show(Order $order)
    {
        $order->load(['user', 'items.produk', 'paymentProof']);
        return view('admin.pesanan.show', compact('order'));
    }

    // ===================== KONFIRMASI PEMBAYARAN =====================
    public function confirm(Order $order)
    {
        DB::transaction(function () use ($order) {

            // Cegah double proses
            if ($order->status === 'done') {
                return;
            }

            // KURANGI STOK PRODUK
            foreach ($order->items as $item) {
                $produk = $item->produk;

                if ($produk->stok < $item->quantity) {
                    abort(400, 'Stok produk tidak mencukupi');
                }

                $produk->decrement('stok', $item->quantity);
            }

            // UPDATE STATUS
            $order->update([
                'status' => 'done'
            ]);
        });

        // NOTIFIKASI USER
        $order->user->notify(new PesananSiapNotification($order));

        return redirect()
            ->route('admin.pesanan.index')
            ->with('success', 'Pesanan berhasil dikonfirmasi & stok diperbarui.');
    }

    // ===================== TOLAK PESANAN =====================
    public function reject(Order $order)
    {
        $order->update([
            'status' => 'rejected'
        ]);

        return redirect()
            ->route('admin.pesanan.index')
            ->with('success', 'Pesanan berhasil ditolak.');
    }

    // ===================== PROSES PESANAN =====================
    public function process(Order $order)
    {
        $order->update([
            'status' => 'processing'
        ]);

        return redirect()
            ->route('admin.pesanan.index')
            ->with('success', 'Pesanan sedang diproses.');
    }
}
