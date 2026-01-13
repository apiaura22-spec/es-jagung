@extends('admin.layout')

@section('title', 'Kelola Pesanan - Admin')

@section('content')
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
                        <th>Status</th>
                        <th>Bukti</th>
                        <th class="text-center">Manajemen Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                    <tr>
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
                            <span class="fw-bold text-dark">Rp {{ number_format($order->total_price,0,',','.') }}</span>
                        </td>
                        <td>
                            @php
                                $statusMap = [
                                    'pending'          => ['bg' => 'bg-secondary', 'text' => 'Menunggu'],
                                    'payment_uploaded' => ['bg' => 'bg-warning text-dark', 'text' => 'Perlu Dicek'],
                                    'confirmed'        => ['bg' => 'bg-info text-white', 'text' => 'Dikonfirmasi'],
                                    'processing'       => ['bg' => 'bg-warning text-white', 'text' => 'Diproses'],
                                    'ready_to_pickup'  => ['bg' => 'bg-primary text-white', 'text' => 'Siap Diambil'],
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
                                <a href="{{ asset('storage/' . $order->paymentProof->file) }}" target="_blank" class="payment-thumb">
                                    <img src="{{ asset('storage/' . $order->paymentProof->file) }}"
                                        class="rounded-3 border shadow-sm object-fit-cover"
                                        alt="Bukti Bayar" width="45" height="45">
                                </a>
                            @else
                                <span class="text-muted small italic"><i class="fa-solid fa-hourglass-start me-1"></i>Belum ada</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-center gap-2">
                                {{-- Tombol Detail --}}
                                <a href="{{ route('admin.pesanan.detail', $order->id) }}" class="btn btn-sm btn-light border rounded-3" title="Detail Pesanan">
                                    <i class="fa-solid fa-eye text-muted"></i>
                                </a>

                                {{-- Alur Kerja Berdasarkan Status --}}
                                @if ($order->status === 'payment_uploaded' || $order->status === 'pending')
                                    <form action="{{ route('admin.pesanan.confirm', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success rounded-3 px-3" onclick="return confirm('Konfirmasi pembayaran ini?')">
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
                                        <button type="submit" class="btn btn-sm btn-warning text-white rounded-3 px-3">
                                            <i class="fa-solid fa-spinner fa-spin me-1"></i> Proses
                                        </button>
                                    </form>

                                @elseif ($order->status === 'processing')
                                    <form action="{{ route('admin.pesanan.ready', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-info text-white rounded-3 px-3">
                                            <i class="fa-solid fa- bell me-1"></i> Siap Diambil
                                        </button>
                                    </form>

                                @elseif ($order->status === 'ready_to_pickup')
                                    <form action="{{ route('admin.pesanan.done', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-dark rounded-3 px-3">
                                            <i class="fa-solid fa-check-double me-1"></i> Selesaikan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
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

<style>
    .table thead th {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        padding: 15px 10px;
        color: #555;
    }
    .payment-thumb img {
        transition: transform 0.2s;
    }
    .payment-thumb img:hover {
        transform: scale(1.1);
        z-index: 10;
    }
    .btn-sm {
        font-size: 0.75rem;
        font-weight: 600;
    }
    .object-fit-cover {
        object-fit: cover;
    }
</style>
@endsection