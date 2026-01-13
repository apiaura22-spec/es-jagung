@extends('user.layout.app')

@section('title', 'Edit Profil - Es Jagung Uni Icis')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-4 animate__animated animate__fadeIn">
                <h2 class="fw-bold text-dark">Pengaturan Profil 👤</h2>
                <p class="text-muted">Perbarui informasi akunmu agar pesanan es jagung makin lancar.</p>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden animate__animated animate__fadeInUp">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4 text-center">
                    <div class="bg-yellow-100 d-inline-block p-3 rounded-circle mb-3">
                        <span class="fs-1">🌽</span>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5 pt-0">
                    <form action="{{ route('user.profile.update') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-orange-700">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-yellow-50 border-0"><i class="fas fa-user text-warning"></i></span>
                                    <input type="text" name="name" class="form-control bg-yellow-50 border-0 py-3 rounded-end" 
                                           value="{{ old('name', auth()->user()->name) }}" required>
                                </div>
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-orange-700">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-yellow-50 border-0"><i class="fas fa-envelope text-warning"></i></span>
                                    <input type="email" name="email" class="form-control bg-yellow-50 border-0 py-3 rounded-end" 
                                           value="{{ old('email', auth()->user()->email) }}" required>
                                </div>
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label fw-bold text-orange-700">Nomor WhatsApp</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-yellow-50 border-0"><i class="fab fa-whatsapp fw-bold text-success"></i></span>
                                    <span class="input-group-text bg-yellow-50 border-0 border-start text-muted">+62</span>
                                    <input type="text" name="phone" class="form-control bg-yellow-50 border-0 py-3 rounded-end" 
                                           value="{{ old('phone', auth()->user()->phone) }}" placeholder="8123456xxx">
                                </div>
                                <small class="text-muted italic">*Nomor ini digunakan untuk konfirmasi pesanan oleh Uni Icis.</small>
                                @error('phone') <br><small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 mb-4 mt-2">
                                <hr class="opacity-25">
                                <h6 class="fw-bold mb-3"><i class="fas fa-lock me-2"></i>Ganti Password (Kosongkan jika tidak ingin mengubah)</h6>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-orange-700">Password Baru</label>
                                <input type="password" name="password" class="form-control bg-yellow-50 border-0 py-3 rounded-3" placeholder="••••••••">
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-orange-700">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control bg-yellow-50 border-0 py-3 rounded-3" placeholder="••••••••">
                            </div>
                        </div>

                        <div class="d-flex gap-3 mt-4">
                            <a href="{{ route('user.dashboard') }}" class="btn btn-light px-4 py-3 rounded-3 fw-bold flex-grow-1 border">Batal</a>
                            <button type="submit" class="btn btn-warning text-white px-5 py-3 rounded-3 fw-bold flex-grow-1 shadow-sm">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-orange-700 { color: #c2410c; }
    .bg-yellow-50 { background-color: #fefce8; }
    .rounded-4 { border-radius: 1.5rem; }
    
    .form-control:focus {
        background-color: #fefce8;
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
        border-color: #ffc107;
    }
</style>
@endsection