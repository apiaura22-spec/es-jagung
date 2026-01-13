@extends('user.layout.app')

@section('content')
<div class="container py-4">
    <h3 class="section-title mb-4"><i class="fas fa-shopping-cart text-warning me-2"></i>Keranjang Belanja</h3>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 p-3">Produk</th>
                                <th class="border-0 p-3 text-center">Harga</th>
                                <th class="border-0 p-3 text-center" style="width: 150px;">Jumlah</th>
                                <th class="border-0 p-3 text-center">Subtotal</th>
                                <th class="border-0 p-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cartItems as $item)
                            <tr>
                                <td class="p-3">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('produk/' . $item->produk->gambar) }}" class="rounded-3 me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                        <span class="fw-bold">{{ $item->produk->nama }}</span>
                                    </div>
                                </td>
                                <td class="p-3 text-center text-muted">Rp {{ number_format($item->produk->harga,0,',','.') }}</td>
                                <td class="p-3">
                                    <form action="{{ route('user.cart.update', $item->id) }}" method="POST">
                                        @csrf
                                        <div class="input-group input-group-sm">
                                            <input type="number" name="qty" class="form-control text-center border-warning" value="{{ $item->qty }}" min="1" onchange="this.form.submit()">
                                        </div>
                                    </form>
                                </td>
                                <td class="p-3 text-center fw-bold text-warning">Rp {{ number_format($item->produk->harga * $item->qty, 0,',','.') }}</td>
                                <td class="p-3 text-center">
                                    <form action="{{ route('user.cart.destroy', $item->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger border-0 rounded-circle" onclick="return confirm('Hapus produk ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="fas fa-shopping-basket fa-3x text-light-emphasis mb-3"></i>
                                    <p class="text-muted">Keranjang Anda masih kosong.</p>
                                    <a href="{{ route('user.dashboard') }}" class="btn btn-warning text-white rounded-pill px-4">Mulai Belanja</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 100px;">
                <h5 class="fw-bold mb-4">Ringkasan Pesanan</h5>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Total Harga</span>
                    <span class="fw-bold">Rp {{ number_format($totalHarga, 0,',','.') }}</span>
                </div>
                <hr class="opacity-25">
                <div class="d-flex justify-content-between mb-4">
                    <span class="fw-bold fs-5">Total Bayar</span>
                    <span class="fw-bold fs-5 text-warning">Rp {{ number_format($totalHarga, 0,',','.') }}</span>
                </div>
                
                @if(count($cartItems) > 0)
                <a href="{{ route('user.checkout') }}" class="btn btn-warning text-white fw-bold w-100 py-3 rounded-pill shadow-sm">
                    Checkout Sekarang <i class="fas fa-chevron-right ms-2"></i>
                </a>
                @endif
                <p class="small text-center text-muted mt-3 mb-0">Pastikan pesanan Anda sudah benar.</p>
            </div>
        </div>
    </div>
</div>
@endsection