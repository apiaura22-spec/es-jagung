@extends('user.layout.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detail Pesanan #{{ $order->id }}</h1>
        <a href="{{ route('orders.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Riwayat
        </a>
    </div>

    {{-- Info Status & Harga --}}
    <div class="bg-white rounded-xl shadow-sm border p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500 uppercase tracking-wider font-semibold">Status Pesanan</p>
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase 
                    {{ $order->status === 'done' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                    {{ $order->status }}
                </span>
            </div>
            <div>
                <p class="text-sm text-gray-500 uppercase tracking-wider font-semibold">Total Pembayaran</p>
                <p class="text-xl font-bold text-orange-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <h2 class="text-xl mb-4 font-bold text-gray-800"><i class="fas fa-box me-2 text-yellow-500"></i>Produk yang Dibeli</h2>

    <div class="space-y-4">
        @foreach($order->items as $item)
            <div class="flex flex-col md:flex-row gap-4 items-start md:items-center border p-4 rounded-xl bg-white shadow-sm hover:shadow-md transition-shadow">

                {{-- Gambar Produk (DISAMAKAN DENGAN WELCOME) --}}
                <div class="shrink-0">
                    <img src="{{ asset('storage/produk/'.$item->produk->gambar) }}"
                         class="w-24 h-24 object-cover rounded-lg border shadow-sm"
                         onerror="this.src='{{ asset('produk/'.$item->produk->gambar) }}'; this.onerror=null; this.src='https://placehold.co/100x100?text=Produk'">
                </div>

                {{-- Info Produk --}}
                <div class="flex-1 w-full">
                    {{-- PERBAIKAN: Gunakan $item->produk->nama sesuai Model --}}
                    <p class="text-lg font-bold text-gray-800">{{ $item->produk->nama }}</p>
                    
                    <div class="flex justify-between items-center mt-1">
                        <p class="text-sm text-gray-600">
                            {{ $item->quantity }} x <span class="font-medium text-gray-800">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                        </p>
                        <p class="font-bold text-indigo-600">
                            Subtotal: Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                        </p>
                    </div>

                    {{-- FORM ULASAN --}}
                    @if($order->status === 'done')
                        <div class="mt-4 pt-4 border-t border-dashed">
                            <p class="text-xs font-bold text-gray-500 uppercase mb-2">Beri Ulasan untuk Produk Ini:</p>
                            <form action="{{ route('review.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="produk_id" value="{{ $item->produk->id }}">
                                <input type="hidden" name="order_id" value="{{ $order->id }}">

                                <div class="flex flex-wrap gap-2 items-center">
                                    <select name="rating" class="border rounded-lg px-3 py-2 text-sm bg-gray-50 focus:ring-2 focus:ring-yellow-400 outline-none" required>
                                        <option value="">Rating</option>
                                        <option value="5">⭐⭐⭐⭐⭐</option>
                                        <option value="4">⭐⭐⭐⭐</option>
                                        <option value="3">⭐⭐⭐</option>
                                        <option value="2">⭐⭐</option>
                                        <option value="1">⭐</option>
                                    </select>

                                    <div class="flex-1 min-w-[200px] flex gap-2">
                                        <input type="text" name="ulasan"
                                               class="border rounded-lg px-3 py-2 text-sm w-full bg-gray-50 focus:ring-2 focus:ring-indigo-400 outline-none"
                                               placeholder="Tulis ulasan Anda..."
                                               required>

                                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition-colors">
                                            Kirim
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    {{-- Bukti Pembayaran --}}
    @if($order->payment_proof)
        <div class="mt-8 bg-white p-6 rounded-xl border shadow-sm">
            <h2 class="text-lg mb-3 font-bold text-gray-800"><i class="fas fa-receipt me-2 text-green-500"></i>Bukti Pembayaran</h2>
            <div class="relative group w-40">
                <img src="{{ asset('storage/payment_proofs/'.$order->payment_proof) }}"
                     class="w-40 rounded-lg border shadow-sm cursor-pointer hover:opacity-75 transition-opacity"
                     onclick="window.open(this.src)"
                     onerror="this.src='https://placehold.co/160x200?text=Bukti+Bayar'">
                <p class="text-[10px] text-gray-400 mt-1 italic text-center">Klik untuk memperbesar</p>
            </div>
        </div>
    @endif
</div>
@endsection