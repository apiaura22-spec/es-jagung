@extends('user.layout.app')

@section('content')
<style>
    /* Desain khusus untuk halaman detail */
    .product-detail-card {
        border-radius: 25px;
        overflow: hidden;
        border: none;
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
    }

    .img-zoom-container {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .img-zoom-container img {
        transition: transform .5s ease;
    }

    .img-zoom-container:hover img {
        transform: scale(1.1);
    }

    .price-tag {
        font-size: 1.8rem;
        font-weight: 700;
        color: #28a745;
        display: block;
        margin-bottom: 10px;
    }

    .qty-input {
        border-radius: 10px !important;
        border: 2px solid #ffc107;
        font-weight: bold;
        text-align: center;
    }

    .btn-add-cart {
        border-radius: 12px;
        padding: 12px 25px;
        transition: all 0.3s;
        background: linear-gradient(45deg, #ffc107, #ff9800);
        border: none;
    }

    .btn-add-cart:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(255, 152, 0, 0.4);
    }

    .review-bubble {
        background: #fff;
        border-radius: 15px;
        padding: 15px;
        margin-bottom: 15px;
        border-left: 5px solid #ffc107;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }

    .star-rating {
        color: #ffc107;
        font-size: 0.9rem;
    }

    .section-title {
        position: relative;
        padding-bottom: 10px;
        margin-bottom: 20px;
        font-weight: 700;
    }

    .section-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 4px;
        background: #ffc107;
        border-radius: 2px;
    }
</style>

<div class="container py-4">
    <div class="card product-detail-card shadow-lg mb-5">
        <div class="row g-0">
            <div class="col-md-5 p-4">
                <div class="img-zoom-container">
                    <img src="{{ asset('produk/' . $produk->gambar) }}"
                         class="img-fluid w-100"
                         style="height: 400px; object-fit: cover;">
                </div>
            </div>

            <div class="col-md-7 p-4 p-lg-5 d-flex flex-column justify-content-center">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}" class="text-decoration-none text-muted">Produk</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $produk->nama }}</li>
                    </ol>
                </nav>

                <h1 class="fw-bold mb-2">{{ $produk->nama }}</h1>
                
                <div class="mb-3">
                    @php $avgRating = $produk->reviews->avg('rating') ?? 0; @endphp
                    <span class="star-rating">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="{{ $i <= $avgRating ? 'fas' : 'far' }} fa-star"></i>
                        @endfor
                    </span>
                    <span class="text-muted small ms-2">({{ $produk->reviews->count() }} Ulasan)</span>
                </div>

                <span class="price-tag text-warning">Rp {{ number_format($produk->harga,0,',','.') }}</span>
                
                <p class="text-muted mb-4" style="line-height: 1.8;">
                    {{ $produk->description ?? 'Nikmati kesegaran es jagung dengan bahan pilihan terbaik dan rasa yang otentik.' }}
                </p>

                <div class="mb-4">
                    @if($produk->stok > 0)
                        <span class="badge rounded-pill bg-light text-success border border-success px-3 py-2">
                            <i class="fas fa-check-circle me-1"></i> Stok Tersedia: {{ $produk->stok }}
                        </span>
                    @else
                        <span class="badge rounded-pill bg-light text-danger border border-danger px-3 py-2">
                            <i class="fas fa-times-circle me-1"></i> Stok Habis
                        </span>
                    @endif
                </div>

                @if($produk->stok > 0)
                <form action="{{ route('user.cart.add', $produk->id) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="d-flex align-items-center gap-3">
                        <div class="input-group" style="width: 140px;">
                            <button class="btn btn-outline-warning" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">-</button>
                            <input type="number" name="qty" class="form-control qty-input border-warning" value="1" min="1" max="{{ $produk->stok }}" required>
                            <button class="btn btn-outline-warning" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">+</button>
                        </div>
                        <button type="submit" class="btn btn-add-cart text-white fw-bold flex-grow-1">
                            <i class="fas fa-shopping-basket me-2"></i> Tambah Ke Keranjang
                        </button>
                    </div>
                </form>
                @endif

                <div class="d-flex gap-2">
                    <a href="{{ route('user.dashboard') }}" class="btn btn-light border-0 shadow-sm rounded-pill px-4">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <h4 class="section-title">Ulasan Pelanggan</h4>
            <div class="pe-lg-4">
                @forelse($produk->reviews as $review)
                    <div class="review-bubble animate__animated animate__fadeInUp">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold text-dark">{{ $review->user->name }}</span>
                            <span class="star-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                @endfor
                            </span>
                        </div>
                        <p class="text-muted mb-0 small">"{{ $review->ulasan }}"</p>
                    </div>
                @empty
                    <div class="text-center py-5 bg-white rounded-4 shadow-sm">
                        <i class="far fa-comment-dots fa-3x text-light-emphasis mb-3"></i>
                        <p class="text-muted">Belum ada ulasan untuk produk ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="col-lg-5">
            @auth
                @php
                    $order = \App\Models\Order::where('user_id', auth()->id())
                        ->where('status', 'done')
                        ->whereHas('items', function ($q) use ($produk) {
                            $q->where('produk_id', $produk->id);
                        })->first();
                @endphp

                @if($order)
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-warning text-white fw-bold border-0 py-3 text-center">
                        <i class="fas fa-pen-nib me-2"></i> Bagikan Pengalamanmu
                    </div>
                    <div class="card-body p-4 bg-white">
                        <form action="{{ route('user.review.store', $order->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Beri Bintang</label>
                                <select name="rating" class="form-select border-0 bg-light" required>
                                    <option value="5">Excellent (5 Bintang)</option>
                                    <option value="4">Good (4 Bintang)</option>
                                    <option value="3">Average (3 Bintang)</option>
                                    <option value="2">Poor (2 Bintang)</option>
                                    <option value="1">Bad (1 Bintang)</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Ulasan Anda</label>
                                <textarea name="ulasan" class="form-control border-0 bg-light" rows="4" placeholder="Bagaimana rasa es jagungnya?" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-warning w-100 text-white fw-bold py-2 shadow-sm rounded-pill">
                                Kirim Ulasan <i class="fas fa-paper-plane ms-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            @endauth
        </div>
    </div>
</div>
@endsection