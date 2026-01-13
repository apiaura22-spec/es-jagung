@extends('user.layout.app')

@section('title', 'Pembayaran Midtrans')

@section('content')
<div class="container mt-4 text-center">
    <h3>Checkout Pesanan</h3>
    <p>Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
</div>

<!-- Snap JS -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<script>
snap.pay('{{ $snapToken }}', {
    onSuccess: function(result){ window.location.href = "{{ route('user.orders.index') }}"; },
    onPending: function(result){ alert("Pembayaran pending"); window.location.href = "{{ route('user.orders.index') }}"; },
    onError: function(result){ alert("Terjadi error"); window.location.href = "{{ route('user.cart.index') }}"; },
    onClose: function(){ alert("Anda menutup popup pembayaran."); }
});
</script>
@endsection
