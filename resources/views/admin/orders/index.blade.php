@extends('admin.layout')

@section('title', 'Kelola Pesanan - Admin')

@section('content')
<div id="realtime-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark">Daftar Pesanan</h3>
            <p class="text-muted small">Pantau arus transaksi dan kelola status pengiriman pelanggan secara otomatis.</p>
        </div>
        <div class="text-end">
            <span class="badge bg-dark rounded-pill px-3 py-2 shadow-sm">Total: {{ $orders->count() }} Pesanan</span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-circle-check me-3 fs-4"></i>
                <div><strong>Berhasil!</strong> {{ session('success') }}</div>
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
                            <th>Status Pesanan</th>
                            <th>Bukti Bayar</th>
                            <th class="text-center">Aksi Manajemen</th>
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
                                    <div class="avatar-sm me-3 bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-primary fw-bold" style="width: 35px; height: 35px; font-size: 0.8rem;">
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
                                {!! $order->metode_label !!}
                            </td>
                            <td>
                                {!! $order->status_label !!}
                            </td>
                            <td>
                                @if ($order->payment_proof)
                                    <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $order->payment_proof) }}"
                                            class="rounded-3 border shadow-sm object-fit-cover"
                                            style="width: 40px; height: 40px;" alt="Bukti">
                                    </a>
                                @elseif($order->isCash())
                                    <span class="text-success fw-bold" style="font-size: 0.7rem;">
                                        <i class="fa-solid fa-hand-holding-dollar me-1"></i> BAYAR DI OUTLET
                                    </span>
                                @else
                                    <span class="text-muted" style="font-size: 0.7rem;">
                                        <i class="fa-solid fa-hourglass-start me-1"></i> Menunggu...
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.pesanan.detail', $order->id) }}" class="btn btn-sm btn-light border rounded-3" title="Detail">
                                        <i class="fa-solid fa-eye text-muted"></i>
                                    </a>

                                    @if (in_array($order->status, ['pending', 'baru']))
                                        <form action="{{ route('admin.pesanan.confirm', $order->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success rounded-3 px-3 shadow-sm fw-bold">TERIMA</button>
                                        </form> 
                                        <form action="{{ route('admin.pesanan.reject', $order->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 border-0">Tolak</button>
                                        </form>
                                    @elseif ($order->status === 'confirmed')
                                        <form action="{{ route('admin.pesanan.process', $order->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-dark rounded-3 px-3 shadow-sm">
                                                <i class="fa-solid fa-fire me-1"></i> MASAK
                                            </button>
                                        </form>
                                    @elseif ($order->status === 'processing')
                                        <form action="{{ route('admin.pesanan.ready', $order->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary rounded-3 px-3 shadow-sm">
                                                <i class="fa-solid fa-check me-1"></i> SIAP
                                            </button>
                                        </form>
                                    @elseif ($order->status === 'ready_to_pickup')
                                        <form action="{{ route('admin.pesanan.done', $order->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success rounded-3 px-3 shadow-sm">
                                                <i class="fa-solid fa-flag-checkered me-1"></i> SELESAI
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-receipt fa-3x mb-3 opacity-25"></i>
                                <p>Belum ada pesanan masuk.</p>
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