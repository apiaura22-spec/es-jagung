<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Order;
use Midtrans\Snap;
use Midtrans\Config;
use Exception;

class CartController extends Controller
{
    // ================= CART =================
    public function index()
    {
        $cartItems = session()->get('cart', []);
        return view('user.cart.index', compact('cartItems'));
    }

    // ================= ADD CART (DIPERBARUI) =================
    public function add(Request $request, $id)
    {
        $product = Produk::findOrFail($id);
        $request->validate(['qty' => 'required|integer|min:1']);
        $cart = session()->get('cart', []);

        // CEK STOK: Apakah permintaan melebihi stok yang ada di database?
        $requestedQty = isset($cart[$id]) ? ($cart[$id]['quantity'] + $request->qty) : $request->qty;

        if ($requestedQty > $product->stok) {
            return redirect()->back()->with('error', "Maaf, stok tidak mencukupi. Sisa stok: {$product->stok}");
        }

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $request->qty;
        } else {
            $cart[$id] = [
                'name'     => $product->nama,
                'price'    => $product->harga,
                'image'    => $product->gambar,
                'quantity' => $request->qty,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('user.cart.index')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    // ================= HALAMAN CHECKOUT =================
    public function checkoutPage()
    {
        $cartItems = session()->get('cart', []);
        if (empty($cartItems)) {
            return redirect()->route('user.cart.index')
                ->with('error', 'Keranjang kosong');
        }

        $total = collect($cartItems)->sum(fn($item) => $item['price'] * $item['quantity']);

        $clientKey = env('MIDTRANS_CLIENT_KEY');
        $serverKey = env('MIDTRANS_SERVER_KEY');

        if (!$clientKey || !$serverKey) {
            return redirect()->route('user.cart.index')
                ->with('error', 'Konfigurasi Midtrans belum lengkap di file .env');
        }

        return view('user.cart.checkout', compact('cartItems', 'total', 'clientKey'));
    }

    // ================= PROSES CHECKOUT (DIPERBARUI DENGAN CEK STOK AKHIR) =================
    public function processCheckout(Request $request)
    {
        // Validasi payment_method
        $request->validate(['payment_method' => 'required|in:midtrans,cash']);
        
        $cartItems = session()->get('cart', []);
        if (empty($cartItems)) {
            return response()->json(['error' => 'Keranjang kosong'], 400);
        }

        // CEK STOK TERAKHIR: Sebelum buat order, pastikan stok masih tersedia di database
        foreach ($cartItems as $produkId => $item) {
            $product = Produk::find($produkId);
            if (!$product || $product->stok < $item['quantity']) {
                return response()->json([
                    'error' => "Gagal checkout. Stok '{$item['name']}' tidak mencukupi atau sudah habis."
                ], 400);
            }
        }

        $total = collect($cartItems)->sum(fn($item) => $item['price'] * $item['quantity']);
        $metodePembayaran = $request->payment_method;

        // 1. Simpan ke tabel orders dengan metode_pembayaran
        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => ($metodePembayaran === 'cash') ? 'baru' : 'pending',
            'total_price' => $total,
            'metode_pembayaran' => $metodePembayaran,
        ]);

        // 2. Simpan item detail
        foreach ($cartItems as $produkId => $item) {
            $order->items()->create([
                'produk_id' => $produkId,
                'quantity'  => $item['quantity'],
                'price'     => $item['price'],
            ]);
        }

        // 3. Kosongkan keranjang setelah order dibuat
        session()->forget('cart');

        // 4. Jika Cash, langsung return redirect tanpa Midtrans
        if ($metodePembayaran === 'cash') {
            return response()->json([
                'success' => true,
                'redirect_url' => route('user.orders.index')
            ]);
        }

        // 5. Jika Midtrans, buat snap token
        Config::$serverKey    = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION') === 'true';
        Config::$isSanitized  = env('MIDTRANS_SANITIZED', true);
        Config::$is3ds        = env('MIDTRANS_3DS', true);

        try {
            $params = [
                'transaction_details' => [
                    'order_id' => 'ORDER-' . $order->id . '-' . time(),
                    'gross_amount' => (int)$order->total_price,
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                ],
            ];

            $snapToken = Snap::getSnapToken($params);
            
            // Update order dengan snap_token
            $order->update(['snap_token' => $snapToken]);

            return response()->json([
                'snapToken' => $snapToken,
                'order_id' => $order->id
            ]);

        } catch (Exception $e) {
            return response()->json(['error' => 'Midtrans Error: ' . $e->getMessage()], 500);
        }
    }

    public function showOrder($id)
    {
        $order = Order::with('items.produk')->where('user_id', auth()->id())->findOrFail($id);
        return view('user.orders.show', compact('order'));
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->route('user.cart.index')->with('success', 'Produk dihapus');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('user.cart.index')->with('success', 'Keranjang dikosongkan');
    }
}