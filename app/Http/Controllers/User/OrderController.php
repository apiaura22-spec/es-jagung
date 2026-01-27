<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('user.orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        // 1. Ambil item keranjang
        $cartItems = Cart::where('user_id', auth()->id())->get();
        
        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'Keranjang kosong'], 400);
        }

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->produk->harga * $item->jumlah;
        }

        // 2. Ambil metode pembayaran dari request (PENTING)
        $metodePembayaran = $request->input('payment_method'); // 'cash' atau 'midtrans'

        try {
            DB::beginTransaction();

            // 3. Simpan Order dengan detail yang benar
            $order = Order::create([
                'user_id'           => auth()->id(),
                'total_price'       => $total,
                'metode_pembayaran' => $metodePembayaran,
                // Jika CASH, status 'baru' (nunggu diambil). Jika MIDTRANS, 'pending' (nunggu bayar).
                'status'            => ($metodePembayaran === 'cash') ? 'baru' : 'pending',
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'  => $order->id,
                    'produk_id' => $item->produk_id,
                    'jumlah'    => $item->jumlah,
                    'harga'     => $item->produk->harga,
                ]);
            }

            Cart::where('user_id', auth()->id())->delete();
            DB::commit();

            // 4. Respon balik ke JavaScript di view
            if ($metodePembayaran === 'cash') {
                return response()->json([
                    'success'      => true,
                    'redirect_url' => route('user.orders.index')
                ]);
            } else {
                // Di sini Anda panggil fungsi pembuatan Snap Token Midtrans Anda
                // $snapToken = $this->getSnapToken($order); 
                return response()->json([
                    'snapToken' => 'TOKEN_DARI_MIDTRANS'
                ]);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}