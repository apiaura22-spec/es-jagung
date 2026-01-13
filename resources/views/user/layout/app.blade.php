<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Es Jagung Uni Icis')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <style>
        :root {
            --primary-color: #ffc107; 
            --secondary-color: #4b3621; 
            --accent-color: #ff9800; 
            --light-bg: #fffcf2;
        }

        /* 🔹 Animasi Loading Screen */
        #loading-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: var(--light-bg);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s ease;
        }

        .loader {
            width: 50px;
            height: 50px;
            border: 5px solid var(--primary-color);
            border-bottom-color: transparent;
            border-radius: 50%;
            display: inline-block;
            box-sizing: border-box;
            animation: rotation 1s linear infinite;
        }

        @keyframes rotation { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            color: var(--secondary-color);
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Navbar Modern Glassmorphism */
        .navbar {
            background: rgba(255, 193, 7, 0.9) !important;
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            padding: 0.7rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.3rem;
            color: var(--secondary-color) !important;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .float-ani {
            animation: floating 3s ease-in-out infinite;
            display: inline-block;
        }

        @keyframes floating {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-8px) rotate(5deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }

        .nav-link { font-weight: 600; color: var(--secondary-color) !important; border-radius: 12px; transition: 0.3s; padding: 0.5rem 1.2rem !important; }
        .nav-link:hover:not(.active) { background: rgba(255, 255, 255, 0.4); transform: translateY(-2px); }
        .nav-link.active { background: var(--secondary-color); color: #fff !important; box-shadow: 0 4px 12px rgba(75, 54, 33, 0.2); }

        .btn-logout-custom { border: 2px solid var(--secondary-color); border-radius: 12px; font-weight: 600; transition: 0.3s; background: transparent; }
        .btn-logout-custom:hover { background: var(--secondary-color) !important; color: #fff !important; }

        /* 🔹 Sosial Media Mewah */
        .social-container { display: flex; justify-content: center; gap: 25px; }
        .social-icon-wrapper { position: relative; display: inline-block; transition: transform 0.3s ease; }
        .social-icon-wrapper:hover { transform: translateY(-5px); }
        
        .social-glow {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 45px; height: 45px;
            border-radius: 50%;
            filter: blur(15px);
            opacity: 0;
            transition: 0.3s;
            z-index: 1;
        }
        .social-icon-wrapper:hover .social-glow { opacity: 0.7; transform: translate(-50%, -50%) scale(1.4); }

        .social-link { position: relative; z-index: 2; color: white; font-size: 1.8rem; text-decoration: none; }

        /* Footer */
        footer { 
            background-color: var(--secondary-color); 
            color: #f8f9fa; 
            padding: 3.5rem 0 2rem 0;
            border-top-left-radius: 50px; 
            border-top-right-radius: 50px; 
            margin-top: 60px;
        }

        /* Swal Custom */
        .swal2-popup { border-radius: 25px !important; font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body>

    <div id="loading-overlay">
        <div class="loader mb-3"></div>
        <span class="fw-bold text-uppercase tracking-widest" style="letter-spacing: 2px; font-size: 0.8rem;">Menyajikan Kesegaran...</span>
    </div>

    <nav class="navbar navbar-expand-lg sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('user.dashboard') }}">
                <span class="float-ani">🍨</span> 
                <span>Es Jagung <span class="text-white" style="text-shadow: 2px 2px var(--secondary-color);">Uni Icis</span></span>
            </a>
            
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarUser">
                <i class="fas fa-bars" style="color: var(--secondary-color);"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarUser">
                <ul class="navbar-nav ms-auto align-items-center mt-3 mt-lg-0">
                    <li class="nav-item"><a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}"><i class="fas fa-home me-1"></i> Home</a></li>
                    <li class="nav-item"><a href="{{ route('user.cart.index') }}" class="nav-link {{ request()->routeIs('user.cart.*') ? 'active' : '' }}"><i class="fas fa-shopping-cart me-1"></i> Keranjang</a></li>
                    <li class="nav-item"><a href="{{ route('user.profile.edit') }}" class="nav-link {{ request()->routeIs('user.profile.*') ? 'active' : '' }}"><i class="fas fa-user-circle me-1"></i> Profil</a></li>
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <form action="{{ route('logout') }}" method="POST" id="logout-form">
                            @csrf
                            <button type="button" onclick="confirmLogout()" class="nav-link btn-logout-custom px-4 w-100 text-start text-lg-center">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-5 animate__animated animate__fadeIn">
        @yield('content')
    </main>

    <footer class="text-center">
        <div class="container">
            <h4 class="fw-bold mb-2">Es Jagung Uni Icis</h4>
            <p class="small opacity-75 mb-4">Segarkan harimu dengan olahan jagung manis terbaik di kota.</p>
            
            <div class="social-container mb-4">
                <div class="social-icon-wrapper">
                    <div class="social-glow" style="background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);"></div>
                    <a href="https://www.instagram.com/esjagunghawai_uniicis?igsh=cmd1ZXo5ajd5MHN2" target="_blank" class="social-link">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>

                <div class="social-icon-wrapper">
                    <div class="social-glow" style="background: #25d366;"></div>
                    <a href="https://wa.me/6283194959873?text=Halo%20Uni%20Icis,%20saya%20mau%20pesan%20Es%20Jagung%20Hawai%20dong!" target="_blank" class="social-link">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>

            <hr class="w-25 mx-auto opacity-25">
            <p class="small mb-0 opacity-50">&copy; {{ date('Y') }} Es Jagung Uni Icis. Dibuat dengan ❤️</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        window.addEventListener('load', function() {
            const loader = document.getElementById('loading-overlay');
            loader.style.opacity = '0';
            setTimeout(() => { loader.style.display = 'none'; }, 500);
        });

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil! ✨',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                showClass: { popup: 'animate__animated animate__zoomIn' }
            });
        @endif

        function confirmLogout() {
            Swal.fire({
                title: 'Yakin mau keluar?',
                text: "Jangan lupa balik lagi untuk kesegaran es jagung kami! 🍨",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#4b3621',
                confirmButtonText: 'Ya, Logout!',
                cancelButtonText: 'Nanti dulu'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>
</body>
</html>