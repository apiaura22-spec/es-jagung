@extends('layouts.admin') 

@section('content')
<div class="container mt-4">

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-header">
            <h4>Detail Pesanan #{{ $order->id }}</h4>
        </div>

        <div class="card-body">

            <p><strong>Pelanggan:</strong> {{ $order->user->name }}</p>
            <p><strong>Total Harga:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
            <p><strong>Status:</strong> 
                <span class="badge bg-primary text-uppercase">{{ $order->status }}</span>
            </p>

            <hr>

            <h5 class="mt-3 mb-3">Detail Item Pesanan:</h5>

            <ul class="list-group mb-4">
                @foreach ($order->items as $item)
                    <li class="list-group-item d-flex justify-content-between">
                        <span>{{ $item->product->name }} (x{{ $item->quantity }})</span>
                        <strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong>
                    </li>
                @endforeach
            </ul>

            <hr>

            <h5 class="mb-2">Bukti Pembayaran:</h5>

            @if ($order->paymentProof)
                <img 
                    src="{{ asset('storage/payment_proofs/' . $order->paymentProof->file) }}" 
                    alt="Bukti Pembayaran" 
                    class="img-fluid rounded shadow mb-3"
                    style="max-width: 300px;"
                >
            @else
                <p class="text-danger">Belum ada bukti pembayaran.</p>
            @endif

            <hr>

            {{-- Tombol Konfirmasi / Tolak --}}
            @if ($order->status == 'processing')

                <form action="{{ route('admin.order.confirm', $order->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-success">
                        ✓ Konfirmasi Pembayaran
                    </button>
                </form>

                <form action="{{ route('admin.order.reject', $order->id) }}" method="POST" class="d-inline ms-2">
                    @csrf
                    <button class="btn btn-danger">
                        ✗ Tolak Pembayaran
                    </button>
                </form>

            @endif

        </div>
    </div>
</div>
@endsection
