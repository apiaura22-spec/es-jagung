@extends('admin.layout') 

@section('title', 'Dashboard Utama')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<h1 class="mb-4">Dashboard Admin</h1>

<div class="row">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card text-white bg-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col me-2">
                        <div class="fs-4 fw-bold">{{ $totalProduk ?? 0 }}</div> 
                        <div class="text-xs fw-bold text-uppercase">Total Produk</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-box fa-2x"></i></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card text-white bg-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col me-2">
                        <div class="fs-4 fw-bold">{{ $totalPesanan ?? 0 }}</div>
                        <div class="text-xs fw-bold text-uppercase">Total Pesanan</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-shopping-cart fa-2x"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card text-white bg-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col me-2">
                        <div class="fs-4 fw-bold">{{ $totalPelanggan ?? 0 }}</div>
                        <div class="text-xs fw-bold text-uppercase">Total Pelanggan</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-users fa-2x"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card text-white bg-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col me-2">
                        <div class="fs-4 fw-bold">10</div> 
                        <div class="text-xs fw-bold text-uppercase">Aksi Laporan</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-chart-bar fa-2x"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card text-white bg-info shadow h-100 py-2 border-0" id="card-pesanan-baru">
            <div class="card-body">
                <h5 class="card-title d-flex justify-content-between">
                    Pesanan Baru 
                    <span class="spinner-grow spinner-grow-sm text-light" role="status"></span>
                </h5>
                <p class="card-text fs-3 fw-bold" id="count-pesanan-baru">{{ $pesananBaru ?? 0 }}</p>
                <small class="text-white-50">*Mengecek pesanan baru secara otomatis...</small>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card text-white bg-success shadow h-100 py-2">
            <div class="card-body">
                <h5 class="card-title">Pesanan Selesai</h5>
                <p class="card-text fs-3 fw-bold">{{ $pesananSelesai ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 fw-bold text-primary">Produk Terbaru</h6>
    </div>
    <div class="card-body">
        @if(isset($produk) && count($produk) > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Tanggal Ditambahkan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produk as $item)
                    <tr>
                        <td>{{ $item->nama }}</td>
                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>{{ $item->stok }}</td>
                        <td>{{ $item->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-info text-center">
            Tidak ada data produk terbaru untuk ditampilkan.
        </div>
        @endif
    </div>
</div>

<script>
    // PERBAIKAN: Menggunakan count awal dari PHP
    let currentNewOrderCount = {{ $pesananBaru ?? 0 }};
    let isInitialLoad = true;

    function checkRealtimeOrders() {
        // PERBAIKAN: Nama route disesuaikan dengan web.php (admin.pesanan.index)
        fetch("{{ route('admin.pesanan.index') }}", {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.text();
        })
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            // Mencari elemen dengan class 'status-pending' yang ada di halaman pesanan
            const newOrders = doc.querySelectorAll('.status-pending').length;

            // Logika pengecekan pesanan baru
            if (newOrders > currentNewOrderCount && !isInitialLoad) {
                
                // Efek Suara
                let audio = new Audio('https://assets.mixkit.co/active_storage/sfx/2354/2354-preview.mp3');
                audio.play().catch(e => console.log("Audio play blocked"));

                // Notifikasi Popup
                Swal.fire({
                    title: 'PESANAN BARU MASUK! 🛒',
                    text: `Ada ${newOrders - currentNewOrderCount} pesanan baru yang perlu dicek.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0dcaf0',
                    confirmButtonText: 'Lihat Pesanan',
                    cancelButtonText: 'Tutup',
                    backdrop: `rgba(0,123,255,0.3)`
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('admin.pesanan.index') }}";
                    }
                });

                // Update angka tampilan di dashboard
                document.getElementById('count-pesanan-baru').innerText = newOrders;
            }

            currentNewOrderCount = newOrders;
            isInitialLoad = false;
        })
        .catch(err => console.error("Realtime Check Error:", err));
    }

    // Jalankan setiap 10 detik agar tidak membebani server namun tetap responsif
    setInterval(checkRealtimeOrders, 10000);
</script>

@endsection