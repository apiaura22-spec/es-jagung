<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items.produk'])->latest()->get();
        return view('admin.pesanan.index', compact('orders'));
    }

    public function detail($id)
    {
        $order = Order::with(['user', 'items.produk', 'paymentProof'])->findOrFail($id);
        return view('admin.pesanan.detail', compact('order'));
    }

    public function confirm($id)
    {
        return DB::transaction(function () use ($id) {
            $order = Order::with('items.produk')->findOrFail($id);
            
            if (in_array($order->status, ['pending', 'payment_uploaded'])) {
                foreach ($order->items as $item) {
                    $produk = $item->produk;
                    if ($produk->stok < $item->quantity) {
                        return back()->with('error', "Gagal Konfirmasi! Stok {$produk->nama} tidak cukup.");
                    }
                    $produk->decrement('stok', $item->quantity);
                }
                $order->update(['status' => 'confirmed']);
                return back()->with('success', 'Pembayaran dikonfirmasi & Stok telah dipotong!');
            }
            return back()->with('error', 'Pesanan tidak dapat dikonfirmasi.');
        });
    }

    public function process($id)
    {
        Order::findOrFail($id)->update(['status' => 'processing']);
        return back()->with('success', 'Pesanan sedang diproses!');
    }

    public function ready($id)
    {
        // Status ini yang memicu pop-up "Siap Diambil" di sisi User
        Order::findOrFail($id)->update(['status' => 'ready_to_pickup']);
        return back()->with('success', 'Pesanan siap diambil! User akan menerima notifikasi.');
    }

    public function done($id)
    {
        Order::findOrFail($id)->update(['status' => 'done']);
        return back()->with('success', 'Pesanan selesai!');
    }

    public function reject($id)
    {
        $order = Order::with('items.produk')->findOrFail($id);
        if (in_array($order->status, ['confirmed', 'processing', 'ready_to_pickup'])) {
            foreach ($order->items as $item) {
                $item->produk->increment('stok', $item->quantity);
            }
        }
        $order->update(['status' => 'rejected']);
        return back()->with('success', 'Pesanan telah ditolak.');
    }
}