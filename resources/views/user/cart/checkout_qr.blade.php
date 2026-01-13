@extends('layouts.app')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-gradient-to-b from-yellow-100 via-yellow-200 to-yellow-300 p-4 font-sans">
    {{-- Main Container --}}
    <div class="w-full max-w-3xl bg-white rounded-3xl shadow-2xl border-4 border-yellow-500/80 p-8 transform transition duration-500 hover:shadow-3xl">

        {{-- Header Checkout --}}
        <h2 class="text-4xl font-black text-orange-600 text-center mb-8 tracking-wide">
            <span class="inline-block transform rotate-6">🌽</span> Checkout Pesanan #{{ $order->id }} <span class="inline-block transform -rotate-6">🧀</span>
        </h2>

        {{-- Rincian Pesanan --}}
        <div class="mb-8 bg-yellow-50 p-6 rounded-2xl border-4 border-lime-300/60 shadow-lg transition duration-300 hover:shadow-xl">
            <h3 class="font-extrabold text-orange-700 text-2xl mb-4 flex items-center">
                <span class="mr-2 text-3xl">📝</span> Rincian Pesanan:
            </h3>
            
            <ul class="list-none space-y-3 text-gray-800">
                @foreach($order->items as $item)
                    <li class="flex justify-between items-center text-lg border-b border-yellow-200 pb-2">
                        <span class="text-orange-900 font-medium">{{ $item->produk->nama }} <span class="text-sm text-gray-500">(x{{ $item->quantity }})</span></span>
                        <span class="font-bold text-orange-600">Rp {{ number_format($item->price * $item->quantity,0,',','.') }}</span>
                    </li>
                @endforeach
            </ul>
            
            <p class="mt-6 pt-4 border-t-2 border-orange-300 font-extrabold text-orange-700 text-2xl flex justify-between">
                <span>Total:</span> 
                <span>Rp {{ number_format($order->total_price,0,',','.') }}</span>
            </p>
        </div>

        {{-- QR & Upload --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            
            {{-- QR / Link Pembayaran --}}
            <div class="flex flex-col items-center bg-yellow-200/50 p-6 rounded-3xl border-4 border-orange-400 shadow-xl transition duration-300 hover:scale-[1.02]">
                <h3 class="font-extrabold text-orange-700 text-xl mb-4 flex items-center">
                    <span class="mr-2 text-3xl">💰</span> QR / Link Pembayaran
                </h3>
                
                {{-- KODE QR MENGGUNAKAN PATH BYPASS: public/images/qr.jpg --}}
                <div class="bg-white p-2 rounded-lg shadow-inner">
                    <img src="{{ asset('storage/images/qr.jpg') }}" alt="QR Payment" class="w-52 h-52 object-contain rounded-md border-2 border-gray-200">
                </div>
                
               <a href="{{ route('user.dashboard') }}" class="mt-4 text-sm text-orange-500 hover:text-orange-700 font-semibold underline">
                    kembali ke dashboard?
               </a>

            </div>

            {{-- Form Upload Bukti --}}
            <div class="bg-orange-100 p-6 rounded-3xl border-4 border-yellow-500 shadow-xl flex flex-col justify-between transition duration-300 hover:scale-[1.02]">
                <h3 class="font-extrabold text-orange-700 text-xl mb-4 flex items-center">
                    <span class="mr-2 text-3xl">📤</span> Upload Bukti Pembayaran
                </h3>
                
                <form action="{{ route('user.cart.upload_proof', $order->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <label class="block">
                        <span class="sr-only">Choose file</span>
                        <input type="file" name="payment_proof" 
                               class="block w-full text-sm text-orange-700 
                                     file:mr-4 file:py-2 file:px-4 
                                     file:rounded-full file:border-0 
                                     file:text-sm file:font-semibold
                                     file:bg-yellow-400 file:text-orange-800
                                     hover:file:bg-yellow-500"
                               required>
                    </label>

                    <button type="submit" 
                            class="w-full bg-orange-500 text-white font-bold py-3 rounded-full hover:bg-orange-600 transition shadow-lg transform hover:scale-[1.05] flex items-center justify-center">
                        <span class="mr-2">⬆️</span> Upload Bukti
                    </button>
                </form>
                
                @if($order->payment_proof)
                    <p class="mt-4 text-green-600 font-bold text-center bg-green-100 p-2 rounded-lg border border-green-300">
                        Bukti sudah diupload! <span class="text-xl">✅</span>
                    </p>
                @endif
            </div>
        </div>

        {{-- Pesan Success / Error --}}
        @if(session('success'))
            <div class="mt-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg shadow-md text-center">
                <p class="font-bold text-lg">{{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div class="mt-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-lg shadow-md text-center">
                <p class="font-bold text-lg">{{ session('error') }}</p>
            </div>
        @endif

        {{-- Kembali ke Dashboard --}}
        <div class="mt-10 text-center">
            <a href="{{ route('user.dashboard') }}" 
               class="inline-flex items-center bg-orange-600 text-white font-extrabold px-8 py-3 rounded-full hover:bg-orange-700 transition shadow-xl transform hover:-translate-y-1">
                <span class="text-xl mr-3">🏠</span> Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

@endsection