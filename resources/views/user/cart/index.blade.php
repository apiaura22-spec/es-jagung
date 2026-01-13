@extends('user.layout.app')

@section('title', 'Keranjang Belanja - Es Jagung Uni Icis')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}" class="text-decoration-none text-warning">Home</a></li>
            <li class="breadcrumb-item active">Keranjang</li>
        </ol>
    </nav>

    <div class="d-flex align-items-center justify-content-between mb-4 animate__animated animate__fadeIn">
        <div>
            <h2 class="fw-bold text-dark mb-1">Keranjang Belanja 🛒</h2>
            <p class="text-muted">Pastikan pesanan es jagungmu sudah sesuai ya!</p>
        </div>
        <a href="{{ route('user.dashboard') }}" class="btn btn-light rounded-pill px-4 shadow-sm border">
            <i class="fas fa-arrow-left me-2"></i>Tambah Produk
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 alert-dismissible fade show mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(count($cartItems) > 0)
        <div class="row g-4">
            <div class="col-lg-8 animate__animated animate__fadeInLeft">
                @php $total = 0; @endphp

                @foreach($cartItems as $id => $item)
                    @php
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    @endphp

                    <div class="card border-0 shadow-sm rounded-4 mb-3 overflow-hidden cart-item-card">
                        <div class="card-body p-3">
                            <div class="row align-items-center g-3">
                                <div class="col-4 col-md-2">
                                    <div class="position-relative">
                                        <img src="{{ isset($item['image']) && $item['image'] 
                                            ? asset('produk/' . $item['image']) 
                                            : asset('produk/default.png') }}"
                                             alt="{{ $item['name'] }}"
                                             class="img-fluid rounded-4 shadow-sm item-img">
                                        <span class="position-absolute top-0 start-0 badge rounded-pill bg-warning text-dark m-1 shadow-sm">
                                            x{{ $item['quantity'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-8 col-md-6">
                                    <h5 class="fw-bold mb-1 text-dark">{{ $item['name'] }}</h5>
                                    <p class="text-warning fw-bold mb-0">
                                        Rp {{ number_format($item['price'],0,',','.') }} <span class="text-muted fw-normal small">/ porsi</span>
                                    </p>
                                    <div class="d-md-none mt-2">
                                        <p class="fw-black mb-0">Total: Rp {{ number_format($subtotal,0,',','.') }}</p>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 text-md-end border-top border-md-top-0 pt-3 pt-md-0 d-flex d-md-block justify-content-between align-items-center">
                                    <div class="d-none d-md-block mb-2">
                                        <small class="text-muted d-block">Subtotal</small>
                                        <h5 class="fw-black text-dark mb-0">Rp {{ number_format($subtotal,0,',','.') }}</h5>
                                    </div>

                                    <form action="{{ route('user.cart.remove', $id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger border-0 rounded-pill btn-sm px-3 hover-shake" onclick="return confirm('Hapus item ini?')">
                                            <i class="fas fa-trash-alt me-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-lg-4 animate__animated animate__fadeInRight">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px; z-index: 10;">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0"><i class="fas fa-file-invoice me-2 text-warning"></i>Ringkasan Pesanan</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Total Harga ({{ count($cartItems) }} Menu)</span>
                            <span class="fw-bold">Rp {{ number_format($total,0,',','.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Biaya Layanan</span>
                            <span class="text-success fw-bold">GRATIS</span>
                        </div>
                        
                        <hr class="my-4 opacity-25">

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0 text-dark">Total Bayar</h5>
                            <h4 class="fw-black mb-0 text-warning">Rp {{ number_format($total,0,',','.') }}</h4>
                        </div>

                        <a href="{{ route('user.cart.checkout.show') }}"
                           class="btn btn-warning w-100 py-3 rounded-4 fw-bold text-white shadow-sm mb-3 btn-checkout">
                            Lanjut ke Pembayaran <i class="fas fa-chevron-right ms-2"></i>
                        </a>

                        <form action="{{ route('user.cart.clear') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link w-100 text-muted text-decoration-none btn-sm" onclick="return confirm('Kosongkan semua keranjang?')">
                                <i class="fas fa-broom me-1"></i> Kosongkan Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm rounded-5 py-5 animate__animated animate__zoomIn">
            <div class="card-body text-center py-5">
                <div class="empty-cart-animation mb-4">
                    <i class="fas fa-shopping-basket fa-5x text-light opacity-50"></i>
                </div>
                <h4 class="fw-bold">Yah, keranjangmu masih kosong...</h4>
                <p class="text-muted mb-4">Mungkin ini saat yang tepat untuk mencicipi kesegaran Es Jagung Uni Icis! 🍧</p>
                <a href="{{ route('user.dashboard') }}" class="btn btn-warning text-white px-5 py-3 rounded-pill fw-bold shadow">
                    Cari Es Jagung Sekarang
                </a>
            </div>
        </div>
    @endif
</div>

<style>
    /* Global Styles */
    body { background-color: #fcfbf7; }
    .fw-black { font-weight: 900; }
    
    /* Card Styles */
    .cart-item-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid transparent !important;
    }
    .cart-item-card:hover {
        transform: translateX(10px);
        border-color: #ffc107 !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
    }

    /* Image Styles */
    .item-img {
        width: 100%;
        aspect-ratio: 1/1;
        object-fit: cover;
    }

    /* Button Styles */
    .btn-checkout {
        transition: all 0.3s;
        background: linear-gradient(45deg, #ffc107, #ff9800);
        border: none;
    }
    .btn-checkout:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(255, 193, 7, 0.4) !important;
        filter: brightness(1.1);
    }

    .hover-shake:hover {
        animation: shake 0.5s;
        color: #dc3545 !important;
    }

    @keyframes shake {
        0% { transform: rotate(0deg); }
        25% { transform: rotate(5deg); }
        50% { transform: rotate(-5deg); }
        75% { transform: rotate(5deg); }
        100% { transform: rotate(0deg); }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .cart-item-card:hover {
            transform: translateY(-5px);
        }
    }
</style>
@endsection