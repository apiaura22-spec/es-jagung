@extends('layouts.app')

@section('title', 'Pembayaran - Es Jagung Uni Icis')

@section('content')

<div class="min-h-screen flex items-center justify-center">
    <div class="max-w-lg w-full bg-yellow-50 bg-opacity-90 rounded-2xl shadow-2xl border-4 border-yellow-300 p-6">

```
    <h2 class="text-3xl font-extrabold text-orange-700 text-center mb-6">
        🍧 Pembayaran Order #{{ $order->id }}
    </h2>

    <!-- Info Total dan Status -->
    <div class="mb-6 bg-yellow-200 p-4 rounded-xl border-2 border-yellow-300">
        <p class="text-yellow-900 font-bold mb-2">
            💰 Total Harga: 
            <span class="text-orange-800">
                Rp {{ number_format($order->total_price, 0, ',', '.') }}
            </span>
        </p>
        <p class="text-yellow-900 font-bold">
            📌 Status: 
            <span class="text-orange-800">{{ ucfirst($order->status) }}</span>
        </p>
    </div>

    <!-- QR Bank -->
    <div class="mb-6 text-center">
        <h3 class="text-xl font-bold text-orange-700 mb-3">📲 Scan QR Bank untuk membayar</h3>
        @if($qrFile)
            <div class="inline-block p-4 bg-yellow-300 rounded-xl border-2 border-orange-300 shadow-lg">
                <img src="{{ $qrFile }}" alt="QR Bank" class="w-48 h-48 object-contain rounded-lg mx-auto">
            </div>
        @else
            <p class="text-red-700 font-bold mt-2">QR Bank tidak tersedia</p>
        @endif
    </div>

    <!-- Form Upload Bukti -->
    <form action="{{ route('user.order.uploadPayment', $order->id) }}" 
          method="POST" enctype="multipart/form-data" class="mb-4">
        @csrf

        <label for="bukti" class="block mb-2 font-semibold text-orange-800">
            📤 Upload Bukti Pembayaran
        </label>

        <input type="file" name="bukti" id="bukti" required
               class="w-full p-2 rounded-lg border-2 border-orange-300 bg-yellow-100 mb-4">

        <button type="submit" 
                class="w-full bg-orange-500 text-yellow-100 font-bold py-2 rounded-xl hover:bg-orange-600 transition shadow-md">
            Kirim Bukti Pembayaran
        </button>
    </form>

    <!-- Pesan Success / Error -->
    @if(session('success'))
        <p class="mt-4 text-green-700 font-semibold text-center">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p class="mt-4 text-red-700 font-semibold text-center">{{ session('error') }}</p>
    @endif

    <!-- DETAIL PESANAN SETELAH UPLOAD BUKTI -->
    @if($order->payment_proof)
        <div class="mt-8 bg-green-100 border-2 border-green-300 p-4 rounded-xl shadow-lg">

            <h3 class="text-2xl font-bold text-green-700 mb-4 text-center">📦 Detail Pesanan</h3>

            <!-- Bukti Pembayaran -->
            <p class="text-green-900 font-semibold mb-2">🧾 Bukti Pembayaran:</p>
            <div class="mb-4 text-center">
                <img src="{{ asset('storage/' . $order->payment_proof) }}"
                     alt="Bukti Pembayaran"
                     class="w-56 rounded-lg border-2 border-green-400 shadow-md mx-auto">
            </div>

            <!-- Item Pesanan -->
            <p class="text-green-900 font-semibold mb-2">🛍️ Daftar Item:</p>
            <ul class="list-disc ml-6 text-green-800 mb-4">
                @foreach($order->items as $item)
                    <li>
                        {{ $item->product->name }}  
                        ({{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }})
                    </li>
                @endforeach
            </ul>

            <!-- Total -->
            <p class="text-green-900 font-bold">
                Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}
            </p>

            <!-- Status -->
            <p class="mt-2 text-green-800">
                ⏳ Status Pesanan: <span class="font-bold">{{ ucfirst($order->status) }}</span>
            </p>
        </div>
    @endif

</div>
```

</div>
@endsection
