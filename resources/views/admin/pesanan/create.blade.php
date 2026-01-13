@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh; background: linear-gradient(135deg, #fff8e7, #fffbea);">
    <div class="card shadow-lg w-100" style="max-width: 480px; border-radius: 15px; border: none;">
        
        <!-- Header -->
        <div class="card-header text-white text-center" style="background: linear-gradient(90deg, #ffc107, #ff9800); border-top-left-radius: 15px; border-top-right-radius: 15px;">
            <h4 class="mb-0">🍧 <strong>Tambah Produk Es Jagung</strong></h4>
        </div>

        <!-- Body -->
        <div class="card-body p-4" style="background-color: white; border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
            <form action="{{ route('produk.store') }}" method="POST" class="needs-validation" novalidate>
                @csrf

                <!-- Nama Produk -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Produk</label>
                    <div class="input-group">
                        <span class="input-group-text">📛</span>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Es Jagung Keju" required>
                        <div class="invalid-feedback">Nama produk wajib diisi.</div>
                    </div>
                </div>

                <!-- Harga -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Harga (Rp)</label>
                    <div class="input-group">
                        <span class="input-group-text">💰</span>
                        <input type="number" name="harga" class="form-control" placeholder="Contoh: 15000" required>
                        <div class="invalid-feedback">Harga wajib diisi.</div>
                    </div>
                </div>

                <!-- Stok -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Stok</label>
                    <div class="input-group">
                        <span class="input-group-text">📦</span>
                        <input type="number" name="stok" class="form-control" placeholder="Contoh: 25" required>
                        <div class="invalid-feedback">Stok wajib diisi.</div>
                    </div>
                </div>

                <!-- Tombol -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn fw-bold px-4 py-2 text-white" style="background: linear-gradient(90deg, #ffc107, #ff9800); border-radius: 8px;">
                        💾 Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script validasi bootstrap -->
<script>
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>
@endsection
