@extends('user.layout.app')

@section('content')
<div class="container my-5">

    {{-- CARD PESANAN --}}
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold mb-0">
                    Detail Pesanan
                    <span class="text-muted">#{{ $order->id }}</span>
                </h3>

                {{-- STATUS --}}
                @php
                    $badge = match($order->status) {
                        'pending' => 'secondary',
                        'menunggu_verifikasi' => 'warning',
                        'confirmed' => 'info',
                        'processing_done' => 'primary',
                        'done' => 'success',
                        'rejected' => 'danger',
                        default => 'dark'
                    };
                @endphp

                <span class="badge bg-{{ $badge }} px-3 py-2 text-capitalize">
                    {{ str_replace('_',' ', $order->status) }}
                </span>
            </div>

            {{-- TOTAL --}}
            <div class="alert alert-light border rounded-3">
                <strong>Total Pembayaran:</strong>
                <span class="fs-5 fw-bold text-success">
                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                </span>
            </div>

            {{-- PRODUK --}}
            <h5 class="fw-bold mt-4 mb-3">🛒 Produk Dipesan</h5>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <strong>{{ $item->produk->nama }}</strong>
                            </td>
                            <td>
                                Rp {{ number_format($item->price,0,',','.') }}
                            </td>
                            <td>
                                {{ $item->quantity }}
                            </td>
                            <td class="fw-bold">
                                Rp {{ number_format($item->price * $item->quantity,0,',','.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- BUKTI PEMBAYARAN --}}
            @if($order->payment_proof)
                <hr>
                <h5 class="fw-bold mt-3 mb-3">📸 Bukti Pembayaran</h5>
                <div class="text-center">
                    <a href="{{ asset('storage/payment_proofs/'.$order->payment_proof) }}" target="_blank">
                        <img 
                            src="{{ asset('storage/payment_proofs/'.$order->payment_proof) }}"
                            class="img-thumbnail shadow"
                            style="max-width:300px"
                            alt="Bukti Pembayaran">
                    </a>
                    <p class="text-muted mt-2">Klik gambar untuk memperbesar</p>
                </div>
            @endif

            {{-- AKSI --}}
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('user.orders.index') }}" class="btn btn-outline-secondary">
                    ← Kembali ke Pesanan Saya
                </a>

                {{-- JIKA BELUM UPLOAD --}}
                @if($order->status === 'pending')
                    <span class="badge bg-warning text-dark px-3 py-2">
                        Menunggu Pembayaran
                    </span>
                @endif
            </div>

        </div>
    </div>

</div>
@endsection
