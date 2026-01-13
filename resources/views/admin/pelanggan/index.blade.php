@extends('admin.layout')

@section('title', 'Data Pelanggan - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark">Data Pelanggan</h3>
        <p class="text-muted small">Kelola dan lihat daftar pengguna yang terdaftar di aplikasi Es Jagung Uni Icis.</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-light border rounded-pill px-3 shadow-sm small">
            <i class="fa-solid fa-file-export me-1"></i> Export
        </button>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4" width="100">ID User</th>
                        <th>Informasi Pelanggan</th>
                        <th>Alamat Email</th>
                        <th>Tanggal Bergabung</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggans as $pelanggan)
                    <tr>
                        <td class="ps-4 text-muted fw-medium">#USR-{{ str_pad($pelanggan->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle-sm me-3">
                                    {{ substr($pelanggan->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $pelanggan->name }}</div>
                                    <small class="text-muted" style="font-size: 0.7rem;">Verified Member</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fa-regular fa-envelope me-2 text-muted small"></i>
                                <span class="text-dark">{{ $pelanggan->email }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="text-dark">{{ $pelanggan->created_at->format('d M Y') }}</span>
                                <small class="text-muted small" style="font-size: 0.7rem;">
                                    {{ $pelanggan->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-2 fw-normal" style="font-size: 0.7rem;">
                                <i class="fa-solid fa-circle fa-2xs me-1"></i> Aktif
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fa-solid fa-users-slash fa-3x mb-3 opacity-25"></i>
                            <p class="text-muted">Belum ada pelanggan yang terdaftar.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* User Avatar Styling */
    .avatar-circle-sm {
        width: 40px;
        height: 40px;
        background: linear-gradient(45deg, #ffc107, #ff9800);
        color: #fff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
        box-shadow: 0 4px 10px rgba(255, 152, 0, 0.2);
    }

    /* Table Header Styling */
    .table thead th {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        padding: 15px 10px;
        color: #555;
        border-bottom: 1px solid #eee;
    }

    /* Row Hover Effect */
    .table tbody tr {
        transition: all 0.2s;
    }

    .table tbody tr:hover {
        background-color: #fcfcfc;
    }

    .badge i {
        font-size: 0.5rem;
        vertical-align: middle;
    }
</style>
@endsection