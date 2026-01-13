<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        // 1. Ambil data dari Midtrans
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $orderId   = $request->order_id;
        $statusCode = $request->status_code;
        $grossAmount = $request->gross_amount;
        $signature   = $request->signature_key;

        // 2. Validasi Signature Key (Keamanan)
        $hashed = hash("sha512", $orderId . $statusCode . $grossAmount . $serverKey);

        if ($hashed !== $signature) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // 3. Ambil ID Order asli dari format 'ORDER-ID-TIME'
        // Contoh: 'ORDER-15-172536' -> ID-nya adalah 15
        $parts = explode('-', $orderId);
        $originalOrderId = $parts[1] ?? null;

        $order = Order::find($originalOrderId);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // 4. Update Status Berdasarkan Response Midtrans
        $transactionStatus = $request->transaction_status;
        $type = $request->payment_type;

        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            $order->update(['status' => 'success']);
        } elseif ($transactionStatus == 'pending') {
            $order->update(['status' => 'pending']);
        } elseif ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
            $order->update(['status' => 'failed']);
        }

        return response()->json(['message' => 'Callback handled successfully']);
    }
}