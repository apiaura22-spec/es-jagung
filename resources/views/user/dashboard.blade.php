@extends('user.layout.app')

@section('title', 'Dashboard - Es Jagung Uni Icis')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* Desain Card & Hover */
    .product-card { 
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); 
        cursor: pointer; 
        border: none !important;
    }
    .product-card:hover { 
        transform: translateY(-8px); 
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important; 
    }
    
    .stats-card {
        transition: all 0.3s ease;
        border: none !important;
    }
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
    }

    .image-wrapper { 
        height: 160px; 
        overflow: hidden; 
        background: #f8f9fa; 
        position: relative;
    }
    .image-wrapper img { 
        width: 100%; 
        height: 100%; 
        object-fit: cover; 
    }

    .out-of-stock-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
        backdrop-filter: blur(2px);
    }

    .notification-scroll::-webkit-scrollbar { width: 4px; }
    .notification-scroll::-webkit-scrollbar-thumb { background: #ffc107; border-radius: 10px; }
</style>

<div class="container-fluid py-4">
    <div class="row g-4">

        {{-- 1. NOTIFIKASI SYSTEM --}}
        @if(isset($showNotification) && $showNotification && count($notifications))
        <div class="col-12 animate__animated animate__fadeIn">
            <div class="card border-0 shadow-sm rounded-4 border-start border-4 border-info">
                <div class="card-body">
                    <h6 class="fw-bold mb-3 d-flex align-items-center">
                        <span class="me-2">🔔</span> Notifikasi Terbaru
                        <span class="badge bg-danger ms-2 rounded-pill">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    </h6>
                    <div class="notification-scroll" style="max-height: 150px; overflow-y: auto;">
                        @foreach($notifications as $notif)
                            <div class="alert alert-light border-0 d-flex justify-content-between align-items-center mb-2 py-2 shadow-sm">
                                <span class="small"><i class="bi bi-info-circle me-2"></i>{{ $notif->data['message'] ?? 'Status pesanan Anda telah diperbarui' }}</span>
                                <small class="text-muted" style="font-size: 0.7rem;">{{ $notif->created_at->diffForHumans() }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- 2. WELCOME CARD --}}
        <div class="col-12 animate__animated animate__fadeIn">
            <div class="card border-0 shadow-sm rounded-4 text-dark overflow-hidden" style="background: linear-gradient(45deg, #fff9e6, #fff);">
                <div class="card-body py-4 position-relative">
                    <div class="position-relative" style="z-index: 2;">
                        <h4 class="fw-bold mb-1">Selamat Datang, {{ Auth::user()->name ?? 'Pelanggan' }} 🍨</h4>
                        <p class="text-muted mb-0">Siap menikmati kesegaran jagung manis hari ini?</p>
                    </div>
                    <i class="fas fa-ice-cream position-absolute end-0 bottom-0 opacity-10" style="font-size: 6rem; margin-right: 20px; transform: rotate(15deg);"></i>
                </div>
            </div>
        </div>

        {{-- 3. STATS CARDS --}}
        <div class="col-6 col-md-6 animate__animated animate__fadeInLeft">
            <a href="javascript:void(0)" onclick="filterProduk('all')" class="text-decoration-none">
                <div class="card stats-card shadow-sm rounded-4 bg-white border-bottom border-4 border-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted small text-uppercase mb-1">Produk Ready</h6>
                                <h3 class="fw-bold mb-0 text-success">{{ $totalProduk ?? 0 }}</h3>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded-3 text-success">
                                <i class="fas fa-check-circle fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-6 animate__animated animate__fadeInRight">
            <a href="javascript:void(0)" onclick="filterProduk('habis')" class="text-decoration-none">
                <div class="card stats-card shadow-sm rounded-4 bg-white border-bottom border-4 border-danger">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted small text-uppercase mb-1">Stok Habis</h6>
                                <h3 class="fw-bold mb-0 text-danger">{{ $produkHabis ?? 0 }}</h3>
                            </div>
                            <div class="bg-danger bg-opacity-10 p-3 rounded-3 text-danger">
                                <i class="fas fa-exclamation-triangle fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- 4. DAFTAR PRODUK & TOMBOL RIWAYAT --}}
        <div id="section-produk" class="col-12 mt-3 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold mb-0">🍧 Produk Tersedia</h5>
                <div id="filter-indicator" class="badge bg-warning text-dark rounded-pill px-3 py-1 d-none mt-1" style="font-size: 0.7rem;">Menampilkan Produk Habis</div>
            </div>
            <a href="{{ route('user.orders.index') }}" class="btn btn-sm btn-outline-warning rounded-pill px-3 fw-bold shadow-sm">
               <i class="fas fa-history me-1"></i> Riwayat Pesanan
            </a>
        </div>

        @forelse($produks as $item)
            @php
                $avgRating = round($item->reviews->avg('rating'), 1);
                $totalReview = $item->reviews->count();
                $isHabis = ($item->stok <= 0); 
            @endphp
            
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 produk-wrapper {{ $isHabis ? 'status-habis' : 'status-ready' }} animate__animated animate__zoomIn">
                <div class="card product-card shadow-sm rounded-4 h-100 overflow-hidden {{ $isHabis ? 'opacity-75' : '' }}">
                    <div class="image-wrapper">
                        @if($isHabis)
                            <div class="out-of-stock-overlay">
                                <span class="badge bg-danger px-3 py-2 rounded-pill shadow">HABIS</span>
                            </div>
                        @endif
                        <img src="{{ $item->gambar ? asset('produk/'.$item->gambar) : asset('produk/default.png') }}"
                               class="img-fluid" alt="{{ $item->nama }}">
                    </div>
                    <div class="card-body p-3 d-flex flex-column">
                        <h6 class="fw-bold mb-1 text-truncate" title="{{ $item->nama }}">{{ $item->nama }}</h6>
                        <div class="mb-2 d-flex align-items-center">
                            <span class="text-warning me-1">★</span>
                            <small class="text-muted fw-bold">{{ $avgRating ?: '0' }}</small>
                            <small class="text-muted ms-1" style="font-size: 0.7rem;">({{ $totalReview }})</small>
                        </div>
                        <p class="fw-bold text-dark mb-3">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                        
                        @if($isHabis)
                            <button class="btn btn-light btn-sm fw-semibold mt-auto rounded-3" disabled>Tidak Tersedia</button>
                        @else
                            <a href="{{ route('user.produk.detail', $item->id) }}"
                               class="btn btn-warning btn-sm fw-semibold text-white mt-auto rounded-3 shadow-sm">
                                Pesan Sekarang
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-store-slash fa-3x text-muted mb-3"></i>
                <p class="text-muted">Maaf, saat ini belum ada produk yang tersedia.</p>
            </div>
        @endforelse

    </div>
</div>

<script>
    function filterProduk(type) {
        const readyItems = document.querySelectorAll('.status-ready');
        const habisItems = document.querySelectorAll('.status-habis');
        const indicator = document.getElementById('filter-indicator');

        if (type === 'habis') {
            readyItems.forEach(el => el.classList.add('d-none'));
            habisItems.forEach(el => el.classList.remove('d-none'));
            indicator.classList.remove('d-none');
        } else {
            readyItems.forEach(el => el.classList.remove('d-none'));
            habisItems.forEach(el => el.classList.remove('d-none'));
            indicator.classList.add('d-none');
        }
        document.getElementById('section-produk').scrollIntoView({ behavior: 'smooth' });
    }

    let notifiedOrders = new Set();
    function checkRealtimeStatus() {
        fetch("{{ route('user.orders.index') }}", {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const orders = doc.querySelectorAll('.order-card');
            orders.forEach((order) => {
                const idElement = order.querySelector('.text-dark b');
                const statusBadge = order.querySelector('.status-badge');
                if (idElement && statusBadge) {
                    const orderId = idElement.innerText.trim();
                    const statusText = statusBadge.innerText.trim();
                    if (statusText === 'SIAP DIAMBIL' && !notifiedOrders.has(orderId)) {
                        Swal.fire({
                            title: 'PESANAN SIAP! 🍧',
                            text: 'Yuk jemput Es Jagungmu sekarang di outlet! ✨',
                            icon: 'success',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 8000,
                            timerProgressBar: true
                        });
                        let audio = new Audio('https://assets.mixkit.co/active_storage/sfx/2358/2358-preview.mp3');
                        audio.play().catch(e => console.log("Audio play blocked"));
                        notifiedOrders.add(orderId);
                    }
                }
            });
        }).catch(err => console.error("Notif Error:", err));
    }
    setInterval(checkRealtimeStatus, 7000);
</script>
@endsection