@extends('admin.layout')

@section('title', 'Edit Produk - ' . $produk->nama)

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Edit Detail Produk</h3>
            <p class="text-muted small mb-0">Perbarui informasi, harga, atau stok untuk produk <strong>{{ $produk->nama }}</strong>.</p>
        </div>
        <a href="{{ route('admin.produk.index') }}" class="btn btn-light border rounded-pill px-3 shadow-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <div class="col-md-7">
                                <div class="mb-4">
                                    <label class="form-label fw-semibold text-dark">Nama Produk</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-tag text-muted"></i></span>
                                        <input type="text" name="nama" class="form-control border-start-0 ps-0 bg-light" value="{{ $produk->nama }}" placeholder="Contoh: Es Jagung Keju" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-semibold text-dark">Harga (Rp)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">Rp</span>
                                            <input type="number" name="harga" class="form-control bg-light" value="{{ $produk->harga }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-semibold text-dark">Stok</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-cubes text-muted"></i></span>
                                            <input type="number" name="stok" class="form-control border-start-0 ps-0 bg-light" value="{{ $produk->stok }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-dark">Ganti Gambar Produk</label>
                                    <input type="file" name="gambar" id="productImage" class="form-control bg-light" accept="image/*" onchange="previewImage(this)">
                                    <small class="text-muted d-block mt-2">Biarkan kosong jika tidak ingin mengganti gambar.</small>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <label class="form-label fw-semibold text-dark d-block mb-3 text-center">Visualisasi Gambar</label>
                                
                                <div class="card bg-light border-dashed rounded-4 p-3 text-center h-100 d-flex flex-column align-items-center justify-content-center">
                                    <div id="imageDisplayArea">
                                        @if($produk->gambar)
                                            <div class="mb-2">
                                                <small class="text-muted d-block mb-2">Gambar Saat Ini:</small>
                                                <img src="{{ asset('storage/'.$produk->gambar) }}" id="currentImage" alt="Gambar Produk" class="rounded-3 shadow-sm img-fluid" style="max-height: 200px; object-fit: cover;">
                                            </div>
                                        @else
                                            <div class="py-4 text-muted" id="noImageText">
                                                <i class="fa-solid fa-image fa-3x mb-2 opacity-25"></i>
                                                <p class="small mb-0">Belum ada gambar</p>
                                            </div>
                                        @endif
                                        
                                        <div id="newImagePreviewContainer" class="mt-3 d-none">
                                            <hr>
                                            <small class="text-warning d-block mb-2 fw-bold">Pratinjau Gambar Baru:</small>
                                            <img id="imagePreview" src="#" alt="Preview" class="rounded-3 shadow-sm img-fluid border border-warning" style="max-height: 200px; object-fit: cover;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 border-top pt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-warning rounded-pill px-5 fw-bold shadow-sm">
                                <i class="fa-solid fa-rotate me-2"></i> Perbarui Data Produk
                            </button>
                            <a href="{{ route('admin.produk.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const container = document.getElementById('newImagePreviewContainer');
        const currentImg = document.getElementById('currentImage');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('d-none');
                if(currentImg) currentImg.classList.add('opacity-50'); // Memberi efek redup pada gambar lama
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Validasi Bootstrap
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
    .border-dashed {
        border: 2px dashed #dee2e6;
    }
    .input-group-text {
        border-color: #dee2e6;
    }
    .form-control:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
    }
    .bg-light {
        background-color: #f8f9fa !important;
    }
</style>
@endsection