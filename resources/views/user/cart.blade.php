@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Keranjang Belanja</h1>

    @if($cartItems->isEmpty())
        <p>Keranjang Anda kosong.</p>
    @else
    <table class="min-w-full border border-gray-300 mb-4">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">Produk</th>
                <th class="border px-4 py-2">Harga</th>
                <th class="border px-4 py-2">Jumlah</th>
                <th class="border px-4 py-2">Subtotal</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cartItems as $item)
            <tr>
                <td class="border px-4 py-2">{{ $item->product->name }}</td>
                <td class="border px-4 py-2">Rp {{ number_format($item->product->price,0,',','.') }}</td>
                <td class="border px-4 py-2">{{ $item->quantity }}</td>
                <td class="border px-4 py-2">
                    Rp {{ number_format($item->product->price * $item->quantity,0,',','.') }}
                </td>
                <td class="border px-4 py-2">
                    <a href="{{ route('cart.delete', $item->id) }}" class="text-red-500 hover:underline">Hapus</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-right">
        <a href="{{ route('checkout.show') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Checkout
        </a>
    </div>
    @endif
</div>
@endsection
