@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh; background: linear-gradient(135deg, #fff8e7, #fffbea);">
    <div class="card shadow-lg w-100" style="max-width: 480px; border-radius: 15px; border: none;">
        <div class="card-header text-white text-center" style="background: linear-gradient(90deg, #0d6efd, #6610f2); border-top-left-radius: 15px; border-top-right-radius: 15px;">
            <h4 class="mb-0">👤 <strong>Tambah Pelanggan</strong></h4>
        </div>

        <div class="card-body p-4" style="background-color: white; border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
            <form action="{{ route('pelanggan.store') }}" method="POST" class="needs-validation" novalidate>
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold">Nama</label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: John Doe" required>
                    <div class="invalid-feedback">Nama wajib diisi.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Contoh: john@example.com" required>
                    <div class="invalid-feedback">Email wajib diisi dan harus valid.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                    <div class="invalid-feedback">Password wajib diisi.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                    <div class="invalid-feedback">Konfirmasi password wajib diisi.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">No. HP</label>
                    <input type="text" name="no_hp" class="form-control" placeholder="Contoh: 08123456789" required>
                    <div class="invalid-feedback">No. HP wajib diisi.</div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn fw-bold px-4 py-2 text-white" style="background: linear-gradient(90deg, #0d6efd, #6610f2); border-radius: 8px;">
                        💾 Simpan Pelanggan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

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
})();
</script>
@endsection
