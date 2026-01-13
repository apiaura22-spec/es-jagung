<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Es Jagung')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        :root {
            --sidebar-width: 280px;
            --primary-yellow: #ffc107;
            --dark-sidebar: #1e1e2d;
            --bg-light: #f8f9fa;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background-color: var(--dark-sidebar);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: fixed;
            z-index: 1050;
        }

        .sidebar-header {
            padding: 30px 25px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .nav-link {
            padding: 14px 25px;
            color: #a2a3b7 !important;
            font-weight: 500;
            display: flex;
            align-items: center;
            transition: all 0.3s;
            margin: 4px 18px;
            border-radius: 12px;
        }

        .nav-link i {
            margin-right: 14px;
            font-size: 1.1rem;
            width: 25px;
            text-align: center;
        }

        .nav-link:hover {
            background-color: rgba(255,255,255,0.08);
            color: #fff !important;
            transform: translateX(5px);
        }

        .nav-link.active {
            background: linear-gradient(45deg, var(--primary-yellow), #ffca2c);
            color: #000 !important;
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.25);
            font-weight: 700;
        }

        /* Main Content Styling */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            transition: all 0.3s;
        }

        /* Top Navbar & Profile */
        .top-navbar {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 15px 40px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.04);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .profile-dropdown-toggle {
            cursor: pointer;
            padding: 5px 12px;
            border-radius: 50px;
            transition: background 0.2s;
        }

        .profile-dropdown-toggle:hover {
            background: #f1f3f5;
        }

        .admin-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(45deg, var(--primary-yellow), #ffdb6e);
            color: #000;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            box-shadow: 0 3px 8px rgba(255, 193, 7, 0.2);
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border-radius: 15px;
            padding: 10px;
            margin-top: 15px !important;
            min-width: 220px;
        }

        .dropdown-item {
            padding: 10px 15px;
            border-radius: 10px;
            font-weight: 500;
            color: #4a5568;
            transition: 0.2s;
        }

        .dropdown-item:hover {
            background-color: #fff9db;
            color: #856404;
        }

        .dropdown-item i {
            width: 20px;
            margin-right: 10px;
        }

        /* Content & Cards */
        .content-area {
            padding: 40px;
        }

        .card {
            border: 1px solid rgba(0,0,0,0.05);
            border-radius: 20px;
        }

        @media (max-width: 992px) {
            .sidebar { margin-left: calc(-1 * var(--sidebar-width)); }
            .main-wrapper { margin-left: 0; width: 100%; }
            .sidebar.show { margin-left: 0; }
            .top-navbar { padding: 15px 20px; }
        }
    </style>
</head>
<body>

<div class="d-flex">
    <div class="sidebar shadow" id="sidebar">
        <div class="sidebar-header">
            <h4 class="text-white fw-bold mb-0">🍧 UNI <span class="text-warning">ICIS</span></h4>
            <div class="badge bg-dark-subtle text-muted mt-2 border border-secondary" style="font-size: 0.65rem;">ADMIN DASHBOARD v2.0</div>
        </div>
        
        <ul class="nav flex-column mt-4">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    <i class="fa-solid fa-gauge-high me-2"></i> <span>Dashboard</span>
</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.produk.index') }}" class="nav-link {{ request()->routeIs('admin.produk.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-box-open"></i> Manajemen Produk
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.pesanan.index') }}" class="nav-link {{ request()->routeIs('admin.pesanan.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-receipt"></i> Kelola Pesanan
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.pelanggan.index') }}" class="nav-link {{ request()->routeIs('admin.pelanggan.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-group"></i> Data Pelanggan
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.laporan.index') }}" class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie"></i> Laporan Keuangan
                </a>
            </li>
        </ul>

        
    </div>

    <div class="main-wrapper">
        <nav class="top-navbar d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button class="btn btn-light d-lg-none me-3" onclick="document.getElementById('sidebar').classList.toggle('show')">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h5 class="fw-bold text-dark mb-0 d-none d-sm-block">@yield('title', 'Panel Kontrol')</h5>
            </div>
            
            <div class="dropdown">
                <div class="profile-dropdown-toggle d-flex align-items-center gap-3" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="text-end d-none d-md-block">
                        <p class="mb-0 fw-bold text-dark small">{{ Auth::user()->name }}</p>
                        <p class="mb-0 text-success fw-medium" style="font-size: 0.65rem;">
                            <i class="fa-solid fa-circle me-1" style="font-size: 0.4rem;"></i> Online
                        </p>
                    </div>
                    <div class="admin-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </div>
                
                <ul class="dropdown-menu dropdown-menu-end shadow-lg animate__animated animate__fadeIn">
                    <li class="px-3 py-2 border-bottom mb-2">
                        <span class="text-muted d-block small">Masuk sebagai</span>
                        <span class="fw-bold text-dark" style="font-size: 0.85rem;">{{ Auth::user()->email }}</span>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.profile.index') }}">
                            <i class="fa-solid fa-user-gear text-muted"></i> Profil Saya
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fa-solid fa-right-from-bracket"></i> Keluar Aplikasi
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="content-area">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-circle-check fs-4 me-3"></i>
                    <div>
                        <strong>Berhasil!</strong><br>
                        <small>{{ session('success') }}</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @yield('content')
        </div>
        
        <footer class="px-5 py-4 text-center text-muted small border-top bg-white mt-auto">
            <div class="d-flex justify-content-between align-items-center">
                <span>&copy; {{ date('Y') }} Es Jagung Uni Icis Dashboard.</span>
                <span class="d-none d-md-inline">Crafted with <i class="fa-solid fa-heart text-danger"></i> for Better Service.</span>
            </div>
        </footer>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>