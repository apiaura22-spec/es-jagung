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
    .payment-option {
        cursor: pointer;
        transition: all 0.2s;
        border: 2px solid #f1f1f1;
        display: flex;
        align-items: center;
        padding: 1rem;
        border-radius: 1rem;
        width: 100%;
        margin-bottom: 10px;
    }
    .payment-option:hover {
        background-color: #fffdf5;
        border-color: #ffc107;
    }
    .payment-option input[type="radio"] {
        margin-right: 15px;
        width: 20px;
        height: 20px;
        accent-color: #ffc107;
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
                            @php
                                // Cek apakah data berbentuk Object atau Array
                                $isObject = is_object($item);
                                $nama = $isObject ? ($item->produk->nama_produk ?? $item->name) : ($item['produk']['nama_produk'] ?? $item['name'] ?? 'Produk');
                                $harga = $isObject ? ($item->produk->harga ?? $item->price) : ($item['produk']['harga'] ?? $item['price'] ?? 0);
                                $qty = $isObject ? ($item->jumlah ?? $item->quantity) : ($item['jumlah'] ?? $item['quantity'] ?? 0);
                            @endphp
                            <tr>
                                <td class="py-3">
                                    <span class="fw-bold text-dark">{{ $nama }}</span>
                                </td>
                                <td>Rp {{ number_format($harga, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <span class="badge badge-qty rounded-pill px-3">{{ $qty }}</span>
                                </td>
                                <td class="text-end fw-bold text-warning">
                                    Rp {{ number_format($harga * $qty, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mobile View --}}
                <div class="d-md-none">
                    @foreach($cartItems as $item)
                    @php
                        $isObject = is_object($item);
                        $nama = $isObject ? ($item->produk->nama_produk ?? $item->name) : ($item['produk']['nama_produk'] ?? $item['name'] ?? 'Produk');
                        $harga = $isObject ? ($item->produk->harga ?? $item->price) : ($item['produk']['harga'] ?? $item['price'] ?? 0);
                        $qty = $isObject ? ($item->jumlah ?? $item->quantity) : ($item['jumlah'] ?? $item['quantity'] ?? 0);
                    @endphp
                    <div class="product-list-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-bold mb-0">{{ $nama }}</h6>
                            <small class="text-muted">{{ $qty }}x @ Rp {{ number_format($harga, 0, ',', '.') }}</small>
                        </div>
                        <span class="fw-bold text-warning">Rp {{ number_format($harga * $qty, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>

                <h5 class="fw-bold mt-4">Pilih Metode Pembayaran</h5>
<div class="mb-3">
    <label class="d-flex align-items-center p-3 border rounded-3 mb-2" style="cursor: pointer;">
        <input type="radio" name="payment_method" value="midtrans" id="method-midtrans" checked class="me-3">
        <div>
            <div class="fw-bold">Transfer / QRIS / E-Wallet</div>
            <small class="text-muted">Bayar otomatis via Midtrans Secure</small>
        </div>
    </label>
    <label class="d-flex align-items-center p-3 border rounded-3" style="cursor: pointer;">
        <input type="radio" name="payment_method" value="cash" id="method-cash" class="me-3">
        <div>
            <div class="fw-bold">Bayar Tunai di Tempat (Cash)</div>
            <small class="text-muted">Bayar saat mengambil pesanan di outlet</small>
        </div>
    </label>
</div>

<button id="pay-button" class="btn btn-success w-100 btn-lg rounded-3 fw-bold mt-3">
    <i class="fas fa-check-circle me-2"></i> KONFIRMASI PESANAN
</button>
                
                <div class="text-center mt-3">
                    <small class="text-muted"><i class="fas fa-info-circle me-1"></i> Pesanan diambil sendiri di outlet Es Jagung Uni Icis.</small>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
<script>
document.getElementById('pay-button').onclick = function() {
    const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
    
    this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses...';
    this.disabled = true;

    fetch("{{ route('user.cart.checkout.process') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            payment_method: selectedMethod
        })
    })
    .then(res => res.json())
    .then(data => {
        if(data.error){
            alert(data.error);
            this.innerHTML = '<i class="fas fa-check-circle me-2"></i> KONFIRMASI PESANAN';
            this.disabled = false;
            return;
        }

        if (selectedMethod === 'cash') {
            // Jika cash, langsung redirect tanpa alert
            if(data.redirect_url) {
                window.location.href = data.redirect_url;
            } else {
                window.location.href = "{{ route('user.orders.index') }}";
            }
        } else {
            // Jika midtrans, munculkan popup Snap
            if(data.snapToken) {
                snap.pay(data.snapToken, {
                    onSuccess: function(result){ window.location.href = "{{ route('user.orders.index') }}"; },
                    onPending: function(result){ window.location.href = "{{ route('user.orders.index') }}"; },
                    onError: function(result){ alert("Kesalahan pembayaran"); location.reload(); },
                    onClose: function(){ 
                        this.innerHTML = '<i class="fas fa-check-circle me-2"></i> KONFIRMASI PESANAN';
                        this.disabled = false;
                    }
                });
            } else {
                alert("Gagal mendapatkan token pembayaran.");
                this.innerHTML = '<i class="fas fa-check-circle me-2"></i> KONFIRMASI PESANAN';
                this.disabled = false;
            }
        }
    })
    .catch(err => {
        console.error(err);
        this.disabled = false;
        this.innerHTML = '<i class="fas fa-check-circle me-2"></i> KONFIRMASI PESANAN';
    });
};
</script>
@endsection