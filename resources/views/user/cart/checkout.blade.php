@extends('user.layout.app')

@section('title', 'Checkout')

@section('content')
<style>
    .checkout-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    .product-list-item {
        border-bottom: 1px solid #f8f9fa;
        padding: 15px 0;
    }
    .product-list-item:last-child {
        border-bottom: none;
    }
    .summary-box {
        background-color: #fcfbf7;
        border-radius: 15px;
        padding: 20px;
    }
    .btn-pay {
        background: linear-gradient(45deg, #198754, #28a745);
        border: none;
        border-radius: 12px;
        padding: 15px;
        font-weight: 700;
        transition: all 0.3s;
    }
    .btn-pay:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        opacity: 0.9;
    }
    .badge-qty {
        background-color: #ffc107;
        color: #000;
        font-weight: 700;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="mb-4 d-flex align-items-center">
                <a href="{{ route('user.cart.index') }}" class="btn btn-outline-secondary btn-sm rounded-circle me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h2 class="fw-bold mb-0">Konfirmasi Pesanan ✨</h2>
            </div>

            <div class="card checkout-card p-4">
                <h5 class="fw-bold mb-4"><i class="fas fa-shopping-basket text-warning me-2"></i> Rincian Menu</h5>
                
                <div class="table-responsive d-none d-md-block">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 rounded-start">Produk</th>
                                <th class="border-0">Harga</th>
                                <th class="border-0 text-center">Jumlah</th>
                                <th class="border-0 text-end rounded-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                            <tr>
                                <td class="py-3">
                                    <span class="fw-bold text-dark">{{ $item['name'] }}</span>
                                </td>
                                <td>Rp {{ number_format($item['price'],0,',','.') }}</td>
                                <td class="text-center">
                                    <span class="badge badge-qty rounded-pill px-3">{{ $item['quantity'] }}</span>
                                </td>
                                <td class="text-end fw-bold text-warning">
                                    Rp {{ number_format($item['price'] * $item['quantity'],0,',','.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mobile View --}}
                <div class="d-md-none">
                    @foreach($cartItems as $item)
                    <div class="product-list-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-bold mb-0">{{ $item['name'] }}</h6>
                            <small class="text-muted">{{ $item['quantity'] }}x @ Rp {{ number_format($item['price'],0,',','.') }}</small>
                        </div>
                        <span class="fw-bold text-warning">Rp {{ number_format($item['price'] * $item['quantity'],0,',','.') }}</span>
                    </div>
                    @endforeach
                </div>

                <div class="summary-box mt-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Metode Pembayaran</span>
                        <span class="fw-bold text-dark"><i class="fas fa-shield-alt text-success me-1"></i> Midtrans Secure</span>
                    </div>
                    <hr class="my-3" style="border-style: dashed;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Total Pembayaran</h5>
                        <h3 class="fw-black text-success mb-0">Rp {{ number_format($total,0,',','.') }}</h3>
                    </div>
                </div>

                <button id="pay-button" class="btn btn-pay btn-lg w-100 mt-4 text-white">
                    <i class="fas fa-lock me-2"></i> BAYAR SEKARANG
                </button>
                
                <div class="text-center mt-3">
                    <small class="text-muted"><i class="fas fa-info-circle me-1"></i> Klik tombol di atas untuk memilih metode pembayaran aman.</small>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT TETAP SAMA (LOGIKA JANGAN DIUBAH) --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
<script>
document.getElementById('pay-button').onclick = function() {
    this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Menyiapkan Pembayaran...';
    this.disabled = true;

    fetch("{{ route('user.cart.checkout.process') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        this.innerHTML = '<i class="fas fa-lock me-2"></i> BAYAR SEKARANG';
        this.disabled = false;

        if(data.error){
            alert(data.error);
            return;
        }
        snap.pay(data.snapToken, {
            onSuccess: function(result){
                window.location.href = "{{ route('user.orders.index') }}";
            },
            onPending: function(result){
                window.location.href = "{{ route('user.orders.index') }}";
            },
            onError: function(result){
                alert("Terjadi kesalahan pada pembayaran");
                location.reload();
            },
            onClose: function(){
                alert("Anda belum menyelesaikan pembayaran.");
            }
        });
    })
    .catch(err => {
        console.error(err);
        this.disabled = false;
        this.innerHTML = '<i class="fas fa-lock me-2"></i> BAYAR SEKARANG';
    });
};
</script>
@endsection