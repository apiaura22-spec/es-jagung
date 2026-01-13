<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminOrderController extends Controller
{
    /**
     * List semua pesanan
     */
    public function index()
    {
        $orders = Order::latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Detail pesanan
     */
    public function detail($id)
    {
        $order = Order::with('paymentProof', 'items.product', 'user')
                      ->findOrFail($id);

        return view('admin.orders.detail', compact('order'));
    }

    /**
     * Konfirmasi pembayaran
     */
    public function confirm($id)
    {
        $order = Order::findOrFail($id);

        // ubah status menjadi selesai / confirmed
        $order->update([
            'status' => 'confirmed'
        ]);

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }

    /**
     * Tolak pembayaran
     */
    public function reject($id)
    {
        $order = Order::findOrFail($id);

        // ubah status menjadi ditolak
        $order->update([
            'status' => 'rejected'
        ]);

        return back()->with('error', 'Pembayaran ditolak!');
    }
}
