@extends('admin.layout')

@section('title', 'Kelola Pesanan - Admin')

@section('content')
<div id="realtime-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark">Daftar Pesanan</h3>
            <p class="text-muted small">Pantau arus transaksi dan kelola status pengiriman pelanggan.</p>
        </div>
        <div class="text-end">
            <span class="badge bg-dark rounded-pill px-3 py-2 shadow-sm">Total: {{ $orders->count() }} Pesanan</span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-circle-check me-3 fs-4"></i>
                <div>
                    <strong>Berhasil!</strong> {{ session('success') }}
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4" width="100">Order ID</th>
                            <th>Pelanggan</th>
                            <th>Total Bayar</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th>Bukti</th>
                            <th class="text-center">Manajemen Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                        <tr class="animate__animated animate__fadeIn">
                            <td class="ps-4">
                                <span class="fw-bold text-primary">#{{ $order->id }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-3 bg-light rounded-circle d-flex align-items-center justify-content-center text-dark fw-bold" style="width: 35px; height: 35px; font-size: 0.8rem;">
                                        {{ substr($order->user->name ?? 'G', 0, 1) }}
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-dark">{{ $order->user->name ?? 'Guest' }}</span>
                                        <small class="text-muted" style="font-size: 0.75rem;">
                                            <i class="fa-regular fa-clock me-1"></i>{{ $order->created_at->format('d M, H:i') }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold text-dark">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                @php
                                    $metode = trim(strtolower($order->metode_pembayaran));
                                @endphp

                                @if($metode == 'cash')
                                    <span class="badge border text-dark fw-bold px-2 py-1" style="background-color: #fff9db; border-color: #ffec99 !important; font-size: 0.65rem;">
                                        <i class="fa-solid fa-money-bill-wave text-success me-1"></i> TUNAI
                                    </span>
                                @elseif($metode == 'midtrans')
                                    <span class="badge border text-dark fw-bold px-2 py-1" style="background-color: #e7f5ff; border-color: #a5d8ff !important; font-size: 0.65rem;">
                                        <i class="fa-solid fa-credit-card text-primary me-1"></i> MIDTRANS
                                    </span>
                                @else
                                    <span class="badge border bg-light text-muted fw-bold px-2 py-1" style="font-size: 0.65rem;">
                                        <i class="fa-solid fa-circle-question me-1"></i> BELUM DIPILIH
                                    </span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $statusMap = [
                                        'baru'             => ['bg' => 'bg-info text-white', 'text' => 'Baru'],
                                        'pending'          => ['bg' => 'bg-secondary text-white', 'text' => 'Menunggu'],
                                        'payment_uploaded' => ['bg' => 'bg-warning text-dark', 'text' => 'Cek Bayar'],
                                        'confirmed'        => ['bg' => 'bg-info text-white', 'text' => 'Dikonfirmasi'],
                                        'processing'       => ['bg' => 'bg-warning text-white', 'text' => 'Diproses'],
                                        'ready_to_pickup'  => ['bg' => 'bg-primary text-white', 'text' => 'Siap'],
                                        'done'             => ['bg' => 'bg-success text-white', 'text' => 'Selesai'],
                                        'rejected'         => ['bg' => 'bg-danger text-white', 'text' => 'Ditolak'],
                                    ];
                                    $current = $statusMap[$order->status] ?? ['bg' => 'bg-dark text-white', 'text' => $order->status];
                                @endphp
                                <span class="badge {{ $current['bg'] }} rounded-pill px-3 py-2 fw-normal" style="font-size: 0.7rem;">
                                    {{ strtoupper($current['text']) }}
                                </span>
                            </td>
                            <td>
                                @if ($order->paymentProof)
                                    <a href="{{ asset('storage/' . $order->paymentProof->file) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $order->paymentProof->file) }}"
                                            class="rounded-3 border shadow-sm object-fit-cover"
                                            style="width: 40px; height: 40px;"
                                            alt="Bukti Bayar">
                                    </a>
                                @elseif($metode == 'cash')
                                    <div class="d-flex flex-column">
                                        <span class="text-success fw-bold" style="font-size: 0.65rem;">
                                            <i class="fa-solid fa-shop me-1"></i>BAYAR DI TOKO
                                        </span>
                                        <small class="text-muted" style="font-size: 0.6rem;">Tanpa Bukti</small>
                                    </div>
                                @else
                                    <span class="text-muted small" style="font-size: 0.65rem;">
                                        <i class="fa-solid fa-hourglass-start me-1"></i>Belum ada
                                    </span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.pesanan.detail', $order->id) }}" class="btn btn-sm btn-light border rounded-3" title="Detail">
                                        <i class="fa-solid fa-eye text-muted"></i>
                                    </a>

                                    @if (in_array($order->status, ['payment_uploaded', 'pending', 'baru']))
                                        <form action="{{ route('admin.pesanan.confirm', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success rounded-3 px-3 shadow-sm">
                                                Konfirmasi
                                            </button>
                                        </form> 
                                        <form action="{{ route('admin.pesanan.reject', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-3">Tolak</button>
                                        </form>
                                    @elseif ($order->status === 'confirmed')
                                        <form action="{{ route('admin.pesanan.process', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning text-white rounded-3 px-3 shadow-sm">
                                                <i class="fa-solid fa-spinner fa-spin me-1"></i> Proses
                                            </button>
                                        </form>
                                    @elseif ($order->status === 'processing')
                                        <form action="{{ route('admin.pesanan.ready', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-info text-white rounded-3 px-3 shadow-sm">
                                                <i class="fa-solid fa-bell me-1"></i> Siap
                                            </button>
                                        </form>
                                    @elseif ($order->status === 'ready_to_pickup')
                                        <form action="{{ route('admin.pesanan.done', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-dark rounded-3 px-3 shadow-sm">
                                                Selesaikan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fa-solid fa-receipt fa-3x mb-3 opacity-25"></i>
                                    <p>Tidak ada pesanan masuk saat ini.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection