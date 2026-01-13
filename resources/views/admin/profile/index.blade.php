@extends('admin.layout')

@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
                <div class="card-header bg-warning py-5"></div>
                <div class="card-body text-center" style="margin-top: -50px;">
                    <div class="mx-auto shadow-sm" style="width: 100px; height: 100px; background: white; border-radius: 25px; display: flex; align-items: center; justify-content: center; border: 4px solid #fff;">
                        <span class="fs-1 fw-bold text-warning">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>
                    <h4 class="fw-bold mt-3 mb-1">{{ $user->name }}</h4>
                    <p class="text-muted small mb-3">Administrator System</p>
                    <div class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                        <i class="fa-solid fa-circle me-1" style="font-size: 0.5rem;"></i> Akun Aktif
                    </div>
                </div>
                <div class="card-footer bg-white border-0 py-4 px-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Email</span>
                        <span class="small fw-bold">{{ $user->email }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted small">Bergabung Sejak</span>
                        <span class="small fw-bold">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            @if(session('success'))
                <div class="alert alert-success border-0 rounded-4 shadow-sm mb-4">
                    <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                </div>
            @endif

            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Informasi Pribadi</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control rounded-3" value="{{ $user->name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Alamat Email</label>
                                <input type="email" name="email" class="form-control rounded-3" value="{{ $user->email }}" required>
                            </div>
                            <div class="col-12 text-end mt-3">
                                <button type="submit" class="btn btn-primary px-4 rounded-pill shadow-sm">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0 text-danger">Keamanan & Password</h5>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-4 border-0">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.profile.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Password Saat Ini</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-lock text-muted"></i></span>
                                <input type="password" name="current_password" class="form-control border-start-0 ps-0" placeholder="Masukkan password lama" required>
                                <button class="btn btn-outline-secondary border-start-0 toggle-password" type="button">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-muted">Password Baru</label>
                                <input type="password" name="password" class="form-control" placeholder="Min. 8 karakter" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-muted">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru" required>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-warning px-4 fw-bold rounded-pill text-white shadow-sm">
                                <i class="fa-solid fa-key me-2"></i> Perbarui Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    });
</script>
@endsection