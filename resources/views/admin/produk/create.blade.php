@extends('admin.layout')

@section('title', 'Tambah Produk Baru')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Tambah Produk Es Jagung</h3>
            <p class="text-muted small mb-0">Masukkan detail informasi produk baru untuk ditampilkan di katalog.</p>
        </div>
        <a href="{{ route('admin.produk.index') }}" class="btn btn-light border rounded-pill px-3 shadow-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark">Nama Produk</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-tag text-muted"></i></span>
                                    <input type="text" name="nama" class="form-control border-start-0 ps-0 bg-light" placeholder="Contoh: Es Jagung Keju Spesial" required>
                                    <div class="invalid-feedback">Nama produk wajib diisi.</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Harga Satuan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">Rp</span>
                                    <input type="number" name="harga" class="form-control bg-light" placeholder="0" required>
                                    <div class="invalid-feedback">Harga wajib diisi.</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Jumlah Stok</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-cubes text-muted"></i></span>
                                    <input type="number" name="stok" class="form-control border-start-0 ps-0 bg-light" placeholder="0" required>
                                    <div class="invalid-feedback">Stok wajib diisi.</div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark">Gambar Produk</label>
                                <div class="border rounded-3 p-3 text-center bg-light">
                                    <div id="imagePreviewContainer" class="mb-2 d-none">
                                        <img id="imagePreview" src="#" alt="Preview" class="rounded-3 shadow-sm" style="max-height: 200px;">
                                    </div>
                                    <div id="uploadPlaceholder">
                                        <i class="fa-solid fa-cloud-arrow-up fa-2x text-muted mb-2"></i>
                                        <p class="text-muted small mb-0">Klik untuk unggah atau seret gambar ke sini</p>
                                    </div>
                                    <input type="file" name="gambar" id="productImage" class="form-control mt-3" accept="image/*" onchange="previewImage(this)">
                                </div>
                                <small class="text-muted mt-2 d-block">* Format: JPG, PNG, WEBP. Maksimal 2MB.</small>
                            </div>
                        </div>

                        <div class="mt-5 border-top pt-4">
                            <button type="submit" class="btn btn-warning w-100 rounded-pill py-2 fw-bold shadow-sm">
                                <i class="fa-solid fa-floppy-disk me-2"></i> Simpan Produk Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Preview Gambar
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const container = document.getElementById('imagePreviewContainer');
        const placeholder = document.getElementById('uploadPlaceholder');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('d-none');
                placeholder.classList.add('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Bootstrap Validation
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function (form) {
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

<style>
    .form-control:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
    }
    .input-group-text {
        border-color: #dee2e6;
    }
    .bg-light {
        background-color: #f8f9fa !important;
    }
</style>
@endsection