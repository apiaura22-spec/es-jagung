<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan Mingguan</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 20px;
            font-size: 12px;
        }
        h2, h4 {
            text-align: center;
            margin: 0;
        }
        h4 {
            margin-top: 5px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }
        td {
            vertical-align: top;
        }
        th, td {
            padding: 8px;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
        }
        .signature p {
            margin: 3px 0;
        }
        .no-data {
            text-align: center;
            font-style: italic;
            color: #888;
        }
    </style>
</head>
<body>
    <h2>Laporan Penjualan Mingguan</h2>
    <h4>Tanggal Cetak: {{ date('d-m-Y') }}</h4>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Pesanan</th>
                <th>Nama Pelanggan</th>
                <th>Daftar Produk</th>
                <th>Total Harga (Rp)</th>
                <th>Tanggal Pesanan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $index => $order)
            <tr>
                <td style="text-align:center;">{{ $index + 1 }}</td>
                <td style="text-align:center;">#{{ $order->id }}</td>
                <td>{{ $order->user->name }}</td>
                <td>
                    @foreach($order->items as $item)
                        • {{ $item->produk->nama }} ({{ $item->quantity }}) <br>
                    @endforeach
                </td>
                <td style="text-align:right;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                <td style="text-align:center;">{{ $order->created_at->format('d-m-Y H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="no-data">Belum ada pesanan pada minggu ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p><strong>Total Pesanan:</strong> {{ $orders->count() }}</p>
        <p><strong>Total Pendapatan:</strong> 
            Rp {{ number_format($orders->sum('total_price'), 0, ',', '.') }}
        </p>
    </div>

    <div class="signature">
        <p>Sungai Penuh, {{ date('d-m-Y') }}</p>
        <p><strong>Admin Penjualan</strong></p>
        <br><br><br>
        <p>__________________________</p>
    </div>
</body>
</html>
