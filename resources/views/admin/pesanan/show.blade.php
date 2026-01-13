@extends('admin.layout')

@section('content')
<div class="container mt-4">

<h3>Detail Pesanan #{{ $order->id }}</h3>

<div class="card shadow mt-3">
    <div class="card-body">

        <p><strong>Pelanggan:</strong> {{ $order->user->name ?? 'Tidak ditemukan' }}</p>

        <p><strong>Total Harga:</strong>
            Rp {{ number_format($order->total_price, 0, ',', '.') }}
        </p>

        <p><strong>Status:</strong>
            <span class="badge bg-primary">{{ $order->status }}</span>
        </p>

        <hr>

        <h5>Bukti Pembayaran:</h5>

        @if ($order->paymentProof)
            <img src="{{ asset('storage/payment_proofs/' . $order->paymentProof->file) }}"
                 class="img-fluid rounded shadow"
                 style="max-width: 300px;">
        @else
            <p class="text-danger">Belum ada bukti pembayaran.</p>
        @endif

    </div>
</div>

</div>
@endsection
