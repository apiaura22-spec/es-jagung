@extends('admin.layout')

@section('title', 'Manajemen Produk - Uni Icis')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark">Katalog Produk</h3>
        <p class="text-muted small">Kelola menu Es Jagung dan ketersediaan stok Anda.</p>
    </div>
    <a href="{{ route('admin.produk.create') }}" class="btn btn-warning rounded-pill px-4 fw-bold shadow-sm">
        <i class="fas fa-plus me-2"></i> Tambah Produk Baru
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4" width="80">Gambar</th>
                        <th>Informasi Produk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produks as $produk)
                    <tr>
                        <td class="ps-4">
                            @if($produk->gambar)
                                <img src="{{ asset('produk/' . $produk->gambar) }}" 
                                     class="rounded-3 shadow-sm object-fit-cover" 
                                     width="60" height="60" alt="{{ $produk->nama }}">
                            @else
                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted" style="width: 60px; height: 60px;">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-dark mb-0">{{ $produk->nama }}</div>
                            <small class="text-muted">ID: #PROD-00{{ $produk->id }}</small>
                        </td>
                        <td>
                            <span class="fw-semibold text-dark">Rp {{ number_format($produk->harga,0,',','.') }}</span>
                        </td>
                        <td>
                            @if($produk->stok > 10)
                                <span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3">
                                    <i class="fas fa-check-circle me-1"></i> {{ $produk->stok }} Tersedia
                                </span>
                            @elseif($produk->stok > 0)
                                <span class="badge rounded-pill bg-warning bg-opacity-10 text-warning px-3">
                                    <i class="fas fa-exclamation-triangle me-1"></i> {{ $produk->stok }} Menipis
                                </span>
                            @else
                                <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger px-3">
                                    <i class="fas fa-times-circle me-1"></i> Habis
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.produk.edit', $produk->id) }}" 
                                   class="btn btn-light btn-sm rounded-3 shadow-sm border"
                                   title="Edit Produk">
                                    <i class="fas fa-edit text-warning"></i>
                                </a>
                                
                                <form action="{{ route('admin.produk.destroy', $produk->id) }}" 
                                      method="POST" 
                                      class="d-inline" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light btn-sm rounded-3 shadow-sm border" title="Hapus Produk">
                                        <i class="fas fa-trash text-danger"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-box-open fa-3x mb-3 opacity-25"></i>
                            <p>Belum ada produk yang ditambahkan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if(method_exists($produks, 'links'))
<div class="mt-4 d-flex justify-content-center">
    {{ $produks->links() }}
</div>
@endif

<style>
    .table thead th {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        padding: 15px 10px;
        color: #6c757d;
    }
    .object-fit-cover {
        object-fit: cover;
    }
    .btn-light:hover {
        background-color: #fff;
        transform: translateY(-2px);
    }
</style>
@endsection