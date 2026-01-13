<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Es Jagung Uni Icis - Segarnya Legendaris</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --primary-orange: #ff5722;
            --corn-yellow: #ffb300;
            --dark-brown: #5d4037;
            --soft-white: #fffdf7;
        }

        body {
            background: linear-gradient(135deg, #fff9c4 0%, #ffecb3 100%);
            font-family: 'Poppins', sans-serif;
            color: var(--dark-brown);
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        /* --- Animasi Keren --- */
        @keyframes floating { 
            0%, 100% { transform: translateY(0) rotate(0deg); } 
            50% { transform: translateY(-20px) rotate(5deg); } 
        }

        @keyframes pulse-light {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.8; }
            100% { transform: scale(1); opacity: 1; }
        }

        @keyframes shine {
            100% { left: 125%; }
        }

        /* Hero Section */
        .hero { min-height: 100vh; display: flex; align-items: center; position: relative; }
        .hero-card {
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 40px;
            padding: 60px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.08);
        }
        
        .hero-img { 
            max-width: 100%; 
            filter: drop-shadow(0 20px 30px rgba(0,0,0,0.2)); 
            animation: floating 4s ease-in-out infinite; 
        }

        /* Tombol Animasi */
        .btn-main { padding: 15px 40px; border-radius: 50px; font-weight: 700; text-transform: uppercase; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); border: none; text-decoration: none; display: inline-block; position: relative; overflow: hidden; }
        .btn-login { background: linear-gradient(45deg, var(--primary-orange), #ff7043); color: white !important; }
        .btn-register { background: white; color: var(--dark-brown) !important; }
        .btn-main:hover { transform: scale(1.1) translateY(-5px); box-shadow: 0 15px 30px rgba(255, 87, 34, 0.3); }

        /* Card Produk & Diskon Strip */
        .custom-card { border: none; border-radius: 25px; transition: all 0.5s; background: white; height: 100%; overflow: hidden; position: relative; }
        .custom-card:hover { transform: translateY(-15px) rotate(1deg); box-shadow: 0 30px 60px rgba(0,0,0,0.15) !important; }
        
        /* STRIP DISKON SERU */
        .discount-strip {
            position: absolute;
            top: 20px;
            right: -35px;
            background: linear-gradient(45deg, #f44336, #ff9800);
            color: white;
            padding: 5px 40px;
            transform: rotate(45deg);
            font-weight: 800;
            font-size: 0.75rem;
            z-index: 15;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            text-transform: uppercase;
            animation: pulse-light 2s infinite;
        }

        .card-img-container { height: 220px; overflow: hidden; background-color: #f8f9fa; position: relative; }
        .card-img-top { width: 100%; height: 100%; object-fit: cover; transition: transform 0.8s; }
        .custom-card:hover .card-img-top { transform: scale(1.1) rotate(-2deg); }

        /* Judul Section dengan Efek */
        .section-title { font-weight: 800; margin-bottom: 3rem; position: relative; display: inline-block; }
        .section-title::after { content: ''; width: 50%; height: 6px; background: var(--primary-orange); position: absolute; bottom: -10px; left: 25%; border-radius: 10px; }

        /* Outlet Section - Style Sebelumnya */
        .contact-icon { background: var(--primary-orange); color: white; width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 15px; flex-shrink: 0; transition: 0.3s; }
        .address-card div:hover .contact-icon { transform: scale(1.2) rotate(10deg); background: var(--corn-yellow); }
        .text-purple { color: #6f42c1; }

        .shape { position: absolute; z-index: -1; opacity: 0.3; animation: floating 6s ease-in-out infinite; }
    </style>
</head>
<body>

<div class="shape" style="top: 10%; left: 5%; color: var(--corn-yellow); font-size: 80px;"><i class="fas fa-ice-cream"></i></div>
<div class="shape" style="top: 40%; right: 5%; color: var(--primary-orange); font-size: 60px; animation-delay: 2s;"><i class="fas fa-sun"></i></div>

<div class="container hero">
    <div class="row w-100 justify-content-center">
        <div class="col-lg-12 hero-card animate__animated animate__fadeIn">
            <div class="row align-items-center">
                <div class="col-lg-7 text-center text-lg-start">
                    <span class="badge bg-white text-orange mb-3 px-3 py-2 rounded-pill shadow-sm animate__animated animate__bounceIn" style="font-weight: 700; color: var(--primary-orange);">
                        <i class="fas fa-magic me-1"></i> NEW: Es Ubi Ungu Special!
                    </span>
                    <h1 class="animate__animated animate__fadeInLeft">
                        Jangan Coba-Coba<br>
                        <span style="color: var(--primary-orange);">Nanti Gak Bisa Berhenti!!</span>
                    </h1>
                    
                    <p class="animate__animated animate__fadeInLeft animate__delay-1s">
                        @php
                            $hariIni = date('l');
                            $tglIni = date('j');
                        @endphp
                        @if($hariIni == 'Friday')
                            <strong>Promo Jumat Berkah!</strong> Nikmati segarnya resep rahasia Uni Icis dengan harga lebih hemat hari ini.
                        @elseif($tglIni <= 5)
                            <strong>Promo Gajian!</strong> Awali bulanmu dengan manisnya jagung pilihan favorit warga Sungai Penuh.
                        @else
                            Dibuat dari jagung manis pilihan dengan resep rahasia Uni Icis yang melegenda. Segar, Manis, dan Mengenyangkan!
                        @endif
                    </p>

                    <div class="d-flex gap-3 justify-content-center justify-content-lg-start animate__animated animate__fadeInUp animate__delay-1s">
                        <a href="{{ route('login') }}" class="btn btn-main btn-login">
                            <i class="fas fa-sign-in-alt me-2"></i> Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-main btn-register">
                            Daftar Akun
                        </a>
                    </div>
                </div>
                <div class="col-lg-5 text-center mt-5 mt-lg-0">
                    <div class="animate__animated animate__zoomIn">
                        <img src="{{ asset('produk/logo.png') }}" class="hero-img" alt="Logo Uni Icis" onerror="this.src='https://placehold.co/500x500?text=Uni+Icis'">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="produk-kami" class="container py-5">
    <div class="text-center mb-5">
        <h2 class="section-title animate__animated animate__fadeIn">Menu Favorit Uni Icis</h2>
    </div>

    <div class="row g-4">
        @forelse($products as $index => $p)
        <div class="col-6 col-md-4 col-lg-3 animate__animated animate__fadeInUp" style="animation-delay: {{ $index * 0.1 }}s">
            <div class="card custom-card shadow-sm border-0 h-100">
                
                <div class="discount-strip">-20%</div>

                <div class="position-absolute top-0 start-0 m-2 d-flex flex-column gap-1" style="z-index: 10;">
                    @if($index == 0)
                    <span class="badge bg-danger px-3 py-2 rounded-pill shadow animate__animated animate__flash animate__infinite animate__slow">
                        <i class="fas fa-fire me-1"></i> HOT
                    </span>
                    @endif
                </div>

                <div class="card-img-container">
                    <img src="{{ asset('produk/' . $p->gambar) }}" class="card-img-top" alt="{{ $p->nama }}" onerror="this.src='https://placehold.co/400x300?text=Produk'">
                </div>
                
                <div class="card-body d-flex flex-column text-center text-lg-start">
                    <h5 class="fw-bold mb-1 text-dark" style="font-size: 1.1rem;">{{ $p->nama }}</h5>
                    <div class="mb-3">
                        <span class="price-original">Rp {{ number_format($p->harga + 3000, 0, ',', '.') }}</span><br>
                        <span class="text-orange fw-bold h5 mb-0" style="color: var(--primary-orange);">Rp {{ number_format($p->harga, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ route('public.produk.detail', $p->id) }}" class="btn btn-outline-warning btn-sm rounded-pill mt-auto fw-bold py-2">
                        <i class="fas fa-eye me-1"></i> Detail Menu
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5"><p class="text-muted">Menu sedang diperbarui...</p></div>
        @endforelse
    </div>
</div>

<div class="container py-5">
    <div class="text-center mb-5"><h2 class="section-title">Lokasi Outlet Kami</h2></div>
    <div class="row g-4 align-items-center">
        <div class="col-lg-5">
            <div class="address-card animate__animated animate__fadeInLeft" style="background: white; border-radius: 30px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                <h4 class="fw-bold mb-4">Es Jagung Uni Icis</h4>
                <div class="d-flex align-items-start mb-4">
                    <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">Alamat Outlet 1</h6>
                        <p class="text-muted mb-0 small">Depan SMP Negeri 8 Kota Sungai Penuh, Jl. Yos Sudarso, Gedang, Jambi 37152</p>
                    </div>
                </div>
                <div class="d-flex align-items-start mb-4">
                    <div class="contact-icon" style="background: #6f42c1;"><i class="fas fa-rocket"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1 text-purple">COMING SOON!! Outlet 2</h6>
                        <p class="text-muted mb-0 small">Depan SMP Negeri 1 Kota Sungai Penuh, Jl. Martadinata, Gedang, Jambi 37152</p>
                    </div>
                </div>
                <div class="d-flex align-items-start mb-4">
                    <div class="contact-icon"><i class="fas fa-clock"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">Jam Operasional</h6>
                        <p class="text-muted mb-0 small">Setiap Hari: 10:00 - 18:00 WIB</p>
                    </div>
                </div>
                <div class="d-flex align-items-start">
                    <div class="contact-icon" style="background: #25d366;"><i class="fab fa-whatsapp"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">Hubungi Kami</h6>
                        <p class="text-muted mb-0 small">+62 822-9837-7590</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="map-container animate__animated animate__fadeInRight" style="border-radius: 30px; overflow: hidden; border: 5px solid white; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <iframe src="http://googleusercontent.com/maps.google.com/8" 
                        width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</div>

<footer class="text-center py-5">
    <p class="text-muted small">© 2026 Es Jagung Uni Icis. Crafted with ❤️ for your freshness.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>