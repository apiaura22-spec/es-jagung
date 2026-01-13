<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\PaymentProof;

class UserOrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->get();
        return view('user.orders.index', compact('orders'));
    }

    public function detail($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->with('paymentProof')
            ->firstOrFail();

        return view('user.orders.detail', compact('order'));
    }

    public function uploadPaymentProof(Request $request, $id)
    {
        $request->validate([
            'bukti' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $path = $request->file('bukti')->store('payment_proofs', 'public');

        PaymentProof::create([
            'order_id' => $order->id,
            'file'     => $path,
        ]);

        $order->update(['status' => 'processing']);

        return response()->json(['success' => true]);
    }

    // 🔥 Dipanggil setiap 3 detik oleh AJAX
    public function checkStatus($id)
    {
        $order = Order::findOrFail($id);

        return response()->json([
            'status' => $order->status
        ]);
    }
}
