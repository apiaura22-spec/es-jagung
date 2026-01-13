@extends('layouts.user')

@section('content')
<div class="container py-4">

    <h3>Detail Pesanan #{{ $order->id }}</h3>

    <div class="card mt-4">
        <div class="card-body">

            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>

            {{-- Jika sudah ada bukti pembayaran --}}
            @if ($order->paymentProof)
                <div class="mt-3">
                    <p class="fw-bold">Bukti Pembayaran:</p>
                    <img src="{{ asset('storage/' . $order->paymentProof->file) }}"
                         class="img-fluid rounded"
                         style="max-width: 300px;">
                </div>
            @endif

            {{-- FORM UPLOAD (Pending + Belum Upload) --}}
            @if ($order->status == 'pending' && !$order->paymentProof)

                {{-- Loading Info --}}
                <div id="loadingBox" style="display:none;" class="alert alert-info mt-3">
                    Mengupload bukti pembayaran...
                </div>

                {{-- Form Upload --}}
                <form id="uploadForm" enctype="multipart/form-data" class="mt-4">
                    @csrf
                    <label class="form-label fw-semibold">Upload Bukti Pembayaran:</label>
                    <input type="file" name="bukti" class="form-control mb-3" required>

                    <button type="submit" class="btn btn-primary">
                        Kirim Bukti Pembayaran
                    </button>
                </form>
            @endif

        </div>
    </div>
</div>

{{-- SCRIPT AJAX --}}
<script>
document.getElementById('uploadForm')?.addEventListener('submit', function(e) {
    e.preventDefault();

    document.getElementById('loadingBox').style.display = 'block';

    let formData = new FormData(this);

    fetch("{{ route('user.order.uploadPayment', $order->id) }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('loadingBox').innerHTML =
                "Bukti berhasil dikirim! Menunggu admin mengonfirmasi...";

            checkStatus(); // mulai auto-check
        } else {
            alert("Gagal upload!");
        }
    });
});

// 🔥 AUTO CHECK STATUS TIAP 3 DETIK
function checkStatus() {
    setInterval(() => {
        fetch("{{ route('user.order.checkStatus', $order->id) }}")
            .then(res => res.json())
            .then(data => {
                if (data.status === 'confirmed') {
                    window.location.href = "{{ route('user.order.detail', $order->id) }}";
                }
            });
    }, 3000);
}
</script>

@endsection
