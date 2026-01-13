<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // Tampilkan halaman checkout
    public function index()
    {
        $cartItems = Cart::with('produk')->where('user_id', Auth::id())->get();
        $total = $cartItems->sum(fn($item) => $item->produk->harga * $item->jumlah);

        if($cartItems->isEmpty()){
            return redirect()->route('user.cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        return view('user.checkout.index', compact('cartItems', 'total'));
    }

    // Proses checkout
    public function store(Request $request)
    {
        $cartItems = Cart::with('produk')->where('user_id', Auth::id())->get();
        if($cartItems->isEmpty()){
            return redirect()->route('user.cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        // Buat order
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_harga' => $cartItems->sum(fn($item) => $item->produk->harga * $item->jumlah),
            'status' => 'baru', // status default
        ]);

        // Simpan detail order
        foreach ($cartItems as $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'produk_id' => $item->produk->id,
                'jumlah' => $item->jumlah,
                'harga' => $item->produk->harga,
            ]);

            // Kurangi stok produk
            $item->produk->stok -= $item->jumlah;
            $item->produk->save();
        }

        // Hapus keranjang user
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('user.dashboard')->with('success', 'Checkout berhasil! Pesanan Anda telah dibuat.');
    }
}
