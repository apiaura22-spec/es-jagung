@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">📊 Laporan Keuangan</h2>
    <button type="button" class="btn btn-danger shadow-sm" data-bs-toggle="modal" data-bs-target="#modalExpense">
        <i class="fas fa-plus-circle me-1"></i> Catat Pengeluaran / Gaji
    </button>
</div>

{{-- 🔹 RINGKASAN REALTIME (TAMBAHAN BARU) --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 bg-primary text-white h-100">
            <div class="card-body p-4 text-center">
                <h6 class="small text-uppercase opacity-75 mb-2">Penghasilan Hari Ini</h6>
                <h3 class="fw-bold mb-0">Rp {{ number_format($penghasilanHariIni, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 bg-success text-white h-100">
            <div class="card-body p-4 text-center">
                <h6 class="small text-uppercase opacity-75 mb-2">Total Minggu Ini</h6>
                <h3 class="fw-bold mb-0">Rp {{ number_format($penghasilanMingguIni, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 bg-warning text-dark h-100">
            <div class="card-body p-4 text-center">
                <h6 class="small text-uppercase opacity-75 mb-2">Total Bulan Ini</h6>
                <h3 class="fw-bold mb-0">Rp {{ number_format($penghasilanBulanIni, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
</div>

<hr class="my-4 opacity-25">

{{-- 🔹 Filter Detail Harian --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.laporan.index') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="tanggal" class="form-label small fw-bold text-muted text-uppercase">Detail Laporan Tanggal</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="fas fa-calendar-alt text-warning"></i></span>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $selectedDate }}">
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-warning w-100 fw-bold shadow-sm">
                    <i class="fas fa-search me-1"></i> Tampilkan
                </button>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{ route('admin.laporan.pdf', ['tanggal' => $selectedDate]) }}" class="btn btn-outline-danger fw-bold border-2">
                    <i class="fas fa-file-pdf me-1"></i> Download PDF Harian
                </a>
            </div>
        </form>
    </div>
</div>

<div class="alert alert-light border shadow-sm d-flex align-items-center mb-4">
    <i class="fas fa-info-circle me-3 fa-lg text-warning"></i>
    <div>
        <span class="d-block small text-uppercase fw-bold text-muted">Menampilkan Rincian Untuk Tanggal:</span>
        <h5 class="mb-0 fw-bold">{{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d F Y') }}</h5>
    </div>
</div>

{{-- 🔹 RINCIAN KEUANGAN TANGGAL TERPILIH --}}
<div class="row g-3 mb-4 text-white text-center">
    <div class="col-md-3">
        <div class="card bg-success border-0 shadow-sm p-3 h-100">
            <h6 class="small text-uppercase opacity-75">Pemasukan</h6>
            <h4 class="fw-bold mb-0">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger border-0 shadow-sm p-3 h-100">
            <h6 class="small text-uppercase opacity-75">Pengeluaran</h6>
            <h4 class="fw-bold mb-0">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info border-0 shadow-sm p-3 h-100">
            <h6 class="small text-uppercase opacity-75">Gaji</h6>
            <h4 class="fw-bold mb-0">Rp {{ number_format($totalGaji, 0, ',', '.') }}</h4>
        </div>
    </div>
    <div class="col-md-3">
    <div class="card bg-primary border-0 shadow-sm p-3 h-100">
        <h6 class="small text-uppercase opacity-75">Laba Bersih</h6>
        <h4 class="fw-bold mb-0">Rp {{ number_format($labaBersih, 0, ',', '.') }}</h4>
    </div>
</div>
</div>

<div class="row">
    {{-- Tabel Pesanan --}}
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm mb-4 rounded-4 overflow-hidden">
            <div class="card-header bg-warning fw-bold d-flex justify-content-between py-3 border-0">
                <span>🛒 Pesanan Selesai</span>
                <span class="badge bg-dark">{{ $orders->count() }} Transaksi</span>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Waktu</th>
                            <th>Items</th>
                            <th class="text-end px-3">Total (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="align-middle px-3">
                                <small class="fw-bold d-block">{{ $order->user->name }}</small>
                                <small class="text-muted">{{ $order->created_at->format('H:i') }} WIB</small>
                            </td>
                            <td class="align-middle">
                                @foreach($order->items as $item)
                                    <small class="d-block text-secondary">- {{ $item->produk->nama }} (x{{ $item->quantity }})</small>
                                @endforeach
                            </td>
                            <td class="text-end align-middle fw-bold px-3">{{ number_format($order->total_price, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center py-5 text-muted">Belum ada transaksi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Tabel Pengeluaran --}}
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm mb-4 rounded-4 overflow-hidden">
            <div class="card-header bg-danger text-white fw-bold py-3 border-0">💸 Biaya Keluar (Operasional)</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Keterangan</th>
                            <th class="text-end px-3">Jumlah</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses as $expense)
                        <tr>
                            <td class="align-middle px-3">
                                <span class="badge bg-secondary mb-1" style="font-size: 0.6rem;">{{ strtoupper($expense->kategori) }}</span>
                                <small class="d-block fw-bold">{{ $expense->keterangan }}</small>
                            </td>
                            <td class="text-danger text-end align-middle fw-bold px-3">Rp {{ number_format($expense->jumlah, 0, ',', '.') }}</td>
                            <td class="text-center align-middle">
                                <form action="{{ route('admin.expense.destroy', $expense->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn text-muted p-0"><i class="fas fa-times-circle"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center py-5 text-muted">Tidak ada pengeluaran.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL --}}
<div class="modal fade" id="modalExpense" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-danger text-white border-0">
                <h5 class="modal-title fw-bold">Tambah Pengeluaran</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.expense.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <input type="hidden" name="tanggal" value="{{ $selectedDate }}">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Kategori</label>
                        <select name="kategori" class="form-select" required>
                            <option value="operasional">Operasional</option>
                            <option value="gaji">Gaji Karyawan</option>
                            <option value="lainnya">Lain-lain</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Beli Es Batu" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Jumlah (Rp)</label>
                        <input type="number" name="jumlah" class="form-control" placeholder="0" required>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger fw-bold px-4 shadow-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection