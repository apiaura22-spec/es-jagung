@extends('user.layout.app')

@section('title', 'Pesanan Saya')

@section('content')
<style>
    body { background-color: #f8f9fa; }
    
    .header-ecommerce {
        padding: 30px 0 15px;
    }
    .header-ecommerce h2 {
        font-weight: 700;
        color: #333;
        font-size: 1.5rem;
    }

    /* Container List Pesanan */
    .order-card-wrapper {
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.08);
        margin-bottom: 16px;
        border: 1px solid #eee;
    }

    /* Bagian Atas: Tanggal & Status */
    .order-card-header {
        padding: 12px 16px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .order-date {
        font-size: 0.85rem;
        color: #6c757d;
    }

    /* Bagian Tengah: Produk */
    .order-card-body {
        padding: 16px;
    }
    .product-thumbnail {
        width: 60px; /* Ukuran gambar kecil ala e-commerce */
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #f0f0f0;
    }
    .product-info-main {
        flex: 1;
        padding-left: 12px;
    }
    .product-title {
        font-weight: 600;
        font-size: 0.95rem;
        color: #333;
        margin-bottom: 2px;
    }
    .product-meta {
        font-size: 0.8rem;
        color: #999;
    }

    /* Bagian Bawah: Total & Tombol */
    .order-card-footer {
        padding: 12px 16px;
        border-top: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .total-price-text {
        font-size: 0.9rem;
        color: #666;
    }
    .total-price-amount {
        font-weight: 700;
        color: #ffc107;
        font-size: 1rem;
    }

    /* Status Badge Minimalis */
    .status-tag {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 4px;
    }

    /* Tombol Aksi */
    .btn-ecommerce-sm {
        font-size: 0.85rem;
        font-weight: 600;
        padding: 6px 16px;
        border-radius: 6px;
        transition: 0.2s;
        text-decoration: none;
    }
    .btn-outline-dark-sm {
        border: 1px solid #333;
        color: #333;
    }
    .btn-outline-dark-sm:hover {
        background: #333;
        color: #fff;
    }
</style>

<div class="container" style="max-width: 650px;">
    <div class="header-ecommerce">
        <h2>Pesanan Saya</h2>
    </div>

    <div id="order-list-container">
        @forelse($orders as $order)
            <div class="order-card-wrapper animate__animated animate__fadeIn">
                <div class="order-card-header">
                    <div class="order-date">
                        <i class="far fa-calendar-alt me-1"></i> {{ $order->created_at->format('d M Y') }}
                        <span class="mx-2 text-light">|</span>
                        <span class="fw-bold text-dark">#{{ $order->id }}</span>
                    </div>
                    
                    @php
                        $statusMap = [
                            'pending'          => ['bg' => '#f8f9fa', 'text' => '#6c757d', 'label' => 'Menunggu'],
                            'payment_uploaded' => ['bg' => '#fff9db', 'text' => '#f59f00', 'label' => 'Dibayar'],
                            'confirmed'        => ['bg' => '#e7f5ff', 'text' => '#1c7ed6', 'label' => 'Dikonfirmasi'],
                            'processing'       => ['bg' => '#f3f0ff', 'text' => '#7950f2', 'label' => 'Diproses'],
                            'ready_to_pickup'  => ['bg' => '#fff5f5', 'text' => '#fa5252', 'label' => 'Siap Diambil'],
                            'done'             => ['bg' => '#ebfbee', 'text' => '#40c057', 'label' => 'Selesai'],
                        ];
                        $st = $statusMap[$order->status] ?? ['bg' => '#eee', 'text' => '#333', 'label' => $order->status];
                    @endphp
                    
                    <span class="status-tag" style="background: {{ $st['bg'] }}; color: {{ $st['text'] }};">
                        {{ $st['label'] }}
                    </span>
                </div>

                <div class="order-card-body">
                    @foreach($order->items as $item)
                    <div class="d-flex align-items-center {{ !$loop->last ? 'mb-3' : '' }}">
                        <img src="{{ asset('produk/'.$item->produk->gambar) }}" class="product-thumbnail" onerror="this.src='https://placehold.co/60x60?text=Jagung'">
                        <div class="product-info-main">
                            <div class="product-title">{{ $item->produk->nama }}</div>
                            <div class="product-meta">{{ $item->quantity }} Porsi x Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="order-card-footer">
                    <div>
                        <span class="total-price-text">Total Belanja: </span>
                        <span class="total-price-amount">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>

                    <div class="d-flex align-items-center">
                        @if($order->status === 'done')
                            <a href="{{ route('user.produk.detail', $order->items->first()->produk_id) }}" class="btn-ecommerce-sm btn-outline-dark-sm">
                                Beri Ulasan
                            </a>
                        @elseif($order->status === 'ready_to_pickup')
                             <small class="text-danger fw-bold"><i class="fas fa-store me-1"></i> Ambil di kedai</small>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <img src="https://illustrations.popsy.co/amber/shopping-bag.svg" style="width: 150px;" class="mb-3">
                <p class="text-muted">Belum ada transaksi berlangsung.</p>
                <a href="{{ route('user.dashboard') }}" class="btn btn-warning text-white fw-bold">Pesan Sekarang</a>
            </div>
        @endforelse
    </div>
</div>

<script>
    // Logic auto-refresh untuk status "Siap Diambil" tetap aktif
    function playNotificationSound() {
        const audio = new Audio('https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3');
        audio.play().catch(e => console.log("Audio play blocked"));
    }

    function refreshOrders() {
        fetch(window.location.href, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const freshContent = doc.getElementById('order-list-container').innerHTML;
            const currentContainer = document.getElementById('order-list-container');

            if (freshContent.trim() !== currentContainer.innerHTML.trim()) {
                if (freshContent.includes('Siap Diambil') && !currentContainer.innerHTML.includes('Siap Diambil')) {
                    playNotificationSound();
                    Swal.fire({
                        title: 'Pesanan Siap! 🍧',
                        text: 'Pesanan kamu sudah siap diambil di kedai Uni Icis.',
                        icon: 'success',
                        confirmButtonColor: '#ffc107'
                    });
                }
                currentContainer.innerHTML = freshContent;
            }
        })
        .catch(error => console.error('Error:', error));
    }
    setInterval(refreshOrders, 4000);
</script>
@endsection