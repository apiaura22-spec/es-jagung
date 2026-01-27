<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('produk')->where('user_id', Auth::id())->get();
        if($cartItems->isEmpty()) return redirect()->route('user.cart.index');
        
        $total = $cartItems->sum(fn($item) => ($item->produk->harga ?? 0) * $item->jumlah);
        $clientKey = config('midtrans.client_key'); 

        return view('user.checkout.index', compact('cartItems', 'total', 'clientKey'));
    }

    public function store(Request $request)
    {
        $request->validate(['payment_method' => 'required|in:midtrans,cash']);
        $cartItems = Cart::with('produk')->where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) return response()->json(['error' => 'Keranjang kosong'], 400);

        try {
            return DB::transaction(function () use ($request, $cartItems) {
                $totalPrice = $cartItems->sum(fn($item) => ($item->produk->harga ?? 0) * $item->jumlah);
                $metode = $request->payment_method;

                // Simpan Order
                $order = new Order();
                $order->user_id = Auth::id();
                $order->total_price = $totalPrice;
                $order->metode_pembayaran = $metode; // OTOMATIS MENYIMPAN midtrans/cash
                $order->status = ($metode === 'cash') ? 'baru' : 'pending';
                $order->save();

                // Simpan Items
                foreach ($cartItems as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'produk_id' => $item->produk_id,
                        'jumlah' => $item->jumlah,
                        'harga' => $item->produk->harga,
                    ]);
                }

                Cart::where('user_id', Auth::id())->delete();

                if ($metode === 'cash') {
                    return response()->json(['success' => true, 'redirect_url' => route('user.orders.index')]);
                } else {
                    // Logic Midtrans
                    \Midtrans\Config::$serverKey = config('midtrans.server_key');
                    \Midtrans\Config::$isProduction = config('midtrans.is_production');
                    \Midtrans\Config::$isSanitized = true;
                    
                    $params = [
                        'transaction_details' => ['order_id' => 'INV-'.$order->id.'-'.time(), 'gross_amount' => (int)$totalPrice],
                        'customer_details' => ['first_name' => Auth::user()->name, 'email' => Auth::user()->email],
                    ];

                    $snapToken = \Midtrans\Snap::getSnapToken($params);
                    $order->update(['snap_token' => $snapToken]);

                    return response()->json(['snapToken' => $snapToken, 'order_id' => $order->id]);
                }
            });
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}