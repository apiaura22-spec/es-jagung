@extends('admin.layout.app')

@section('title', 'Daftar Pesanan - Uni Icis')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">Manajemen Pesanan</h3>
        <p class="text-muted small mb-0">Kelola konfirmasi pembayaran dan alur produksi pesanan pelanggan.</p>
    </div>
    <div class="text-end">
        <div class="p-2 px-3 bg-white shadow-sm rounded-3 border">
            <small class="text-muted d-block" style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase;">Total Transaksi</small>
            <span class="fw-bold text-dark">{{ $orders->count() }} Pesanan</span>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4" width="80">ID</th>
                        <th>Pelanggan</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Bukti Bayar</th>
                        <th class="text-center">Alur Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                    {{-- TAMBAHAN: class 'order-row' dan 'data-id' untuk script realtime --}}
                    <tr class="order-row" data-id="{{ $order->id }}">
                        <td class="ps-4">
                            <span class="fw-bold text-muted order-id-text" style="font-size: 0.85rem;">#{{ $order->id }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2 bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                    {{ substr($order->user->name, 0, 1) }}
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-dark">{{ $order->user->name }}</span>
                                    <small class="text-muted" style="font-size: 0.7rem;">{{ $order->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="fw-bold text-dark">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </td>
                        <td>
                            @php
                                $badge = match($order->status) {
                                    'processing' => ['bg' => 'bg-info status-pending', 'label' => 'Perlu Cek'], // Class status-pending untuk realtime
                                    'confirmed' => ['bg' => 'bg-warning text-dark', 'label' => 'Dikonfirmasi'],
                                    'processing_done' => ['bg' => 'bg-primary', 'label' => 'Siap'],
                                    'done' => ['bg' => 'bg-success', 'label' => 'Selesai'],
                                    default => ['bg' => 'bg-secondary', 'label' => $order->status]
                                };
                            @endphp
                            <span class="badge {{ $badge['bg'] }} status-badge rounded-pill px-3 py-2 fw-normal" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                                {{ strtoupper($badge['label']) }}
                            </span>
                        </td>
                        <td>
                            @if ($order->paymentProof)
                                <a href="{{ asset('payment_proofs/' . $order->paymentProof->file) }}" target="_blank" class="payment-link">
                                    <img src="{{ asset('payment_proofs/' . $order->paymentProof->file) }}"
                                         class="rounded-3 border shadow-sm object-fit-cover"
                                         style="width: 45px; height: 45px; transition: 0.3s;"
                                         alt="Bukti">
                                </a>
                            @else
                                <span class="badge bg-light text-muted border fw-normal"><i class="fas fa-clock me-1"></i>Belum Ada</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.pesanan.detail', $order->id) }}" class="btn btn-sm btn-light border rounded-3" title="Lihat Detail">
                                    <i class="fas fa-eye text-muted"></i>
                                </a>

                                @if ($order->status === 'processing')
                                    <form action="{{ route('admin.pesanan.confirm', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-success btn-sm rounded-3 px-3 shadow-sm">Konfirmasi</button>
                                    </form> 
                                    <form action="{{ route('admin.pesanan.reject', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-outline-danger btn-sm rounded-3 px-3">Tolak</button>
                                    </form>
                                @elseif ($order->status === 'confirmed')
                                    <form action="{{ route('admin.pesanan.process', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-warning btn-sm text-white rounded-3 px-3 shadow-sm">
                                            <i class="fas fa-spinner fa-spin me-1"></i> Proses
                                        </button>
                                    </form>
                                @elseif ($order->status === 'processing_done')
                                    <form action="{{ route('admin.pesanan.done', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-primary btn-sm rounded-3 px-3 shadow-sm">Selesaikan</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <img src="https://illustrations.popsy.co/gray/not-found.svg" alt="empty" style="width: 120px;" class="mb-3 opacity-50">
                            <p class="text-muted">Tidak ada pesanan yang ditemukan.</p>
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
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        color: #6c757d;
        padding: 15px 10px;
    }
    .payment-link:hover img {
        transform: scale(1.15);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
    }
    .object-fit-cover { object-fit: cover; }
    .btn-sm { font-size: 0.75rem; font-weight: 600; }
    /* Animasi highlight untuk baris baru */
    .new-order-highlight {
        animation: highlightFade 5s ease-out;
    }
    @keyframes highlightFade {
        0% { background-color: rgba(255, 193, 7, 0.2); }
        100% { background-color: transparent; }
    }
</style>

{{-- SCRIPT REALTIME UNTUK HALAMAN PESANAN --}}
<script>
    let existingOrders = new Set([@foreach($orders as $order)'{{ $order->id }}',@endforeach]);

    function refreshOrdersRealtime() {
        fetch(window.location.href, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newOrderRows = doc.querySelectorAll('.order-row');
            
            newOrderRows.forEach(row => {
                const id = row.getAttribute('data-id');
                if (!existingOrders.has(id)) {
                    // Ada pesanan baru! Refresh halaman agar tabel terupdate 
                    // atau Anda bisa menyisipkan barisnya secara manual di sini.
                    // Untuk kemudahan alur aksi admin, refresh halaman adalah yang paling aman:
                    window.location.reload();
                }
            });
        });
    }

    // Cek setiap 5 detik
    setInterval(refreshOrdersRealtime, 5000);
</script>
@endsection