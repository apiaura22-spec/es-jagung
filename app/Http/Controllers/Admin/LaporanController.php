<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil input tanggal (Default: Hari Ini)
        $selectedDate = $request->tanggal ?? now()->format('Y-m-d');
        $years = Order::selectRaw('YEAR(created_at) as year')->distinct()->pluck('year');

        // --- FITUR SEKALI KLIK: LAPORAN RINGKASAN ---
        
        // Pemasukan Hari Ini
        $penghasilanHariIni = Order::whereDate('created_at', now())
            ->where('status', 'done')
            ->sum('total_price');

        // Pemasukan 7 Hari Terakhir (Mingguan)
        $penghasilanMingguIni = Order::where('created_at', '>=', now()->subDays(7))
            ->where('status', 'done')
            ->sum('total_price');

        // Pemasukan Bulan Ini
        $penghasilanBulanIni = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', 'done')
            ->sum('total_price');

        // --- DATA DETAIL HARIAN (Berdasarkan Filter Tanggal) ---

        // 2. Ambil Data Pemasukan (Status 'done' pada tanggal terpilih)
        $orders = Order::whereDate('created_at', $selectedDate)
            ->where('status', 'done')
            ->with(['user', 'items.produk'])
            ->get();

        $totalPemasukan = $orders->sum('total_price');

        // 3. Ambil Rincian Barang Terjual (Harian)
        $detailBarang = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('produks', 'order_items.produk_id', '=', 'produks.id')
            ->whereDate('orders.created_at', $selectedDate)
            ->where('orders.status', 'done')
            ->select('produks.nama', DB::raw('SUM(order_items.quantity) as total_qty'), DB::raw('SUM(order_items.price * order_items.quantity) as subtotal'))
            ->groupBy('produks.nama')
            ->get();

        // 4. Ambil Data Pengeluaran (Harian)
        $expenses = Expense::whereDate('tanggal', $selectedDate)->get();
        
        $totalGaji = $expenses->where('kategori', 'gaji')->sum('jumlah');
        $totalOperasional = $expenses->where('kategori', 'operasional')->sum('jumlah');
        $totalBahanBaku = $expenses->where('kategori', 'bahan_baku')->sum('jumlah');
        $totalPengeluaran = $expenses->sum('jumlah');

        // 5. Hitung Laba Bersih (Harian)
        $labaBersih = $totalPemasukan - $totalPengeluaran;

        return view('admin.laporan.index', compact(
            'orders', 'years', 'selectedDate', 'totalPemasukan', 
            'detailBarang', 'expenses', 'totalGaji', 'totalOperasional', 
            'totalBahanBaku', 'totalPengeluaran', 'labaBersih',
            'penghasilanHariIni', 'penghasilanMingguIni', 'penghasilanBulanIni'
        ));
    }

    public function pdf(Request $request)
    {
        $selectedDate = $request->tanggal ?? now()->format('Y-m-d');

        $orders = Order::whereDate('created_at', $selectedDate)->where('status', 'done')->get();
        $expenses = Expense::whereDate('tanggal', $selectedDate)->get();
        
        $totalPemasukan = $orders->sum('total_price');
        $totalPengeluaran = $expenses->sum('jumlah');
        $labaBersih = $totalPemasukan - $totalPengeluaran;

        $data = [
            'orders' => $orders,
            'expenses' => $expenses,
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'labaBersih' => $labaBersih,
            'selectedDate' => $selectedDate,
        ];

        $pdf = Pdf::loadView('admin.laporan.pdf', $data);
        return $pdf->download("laporan-harian-{$selectedDate}.pdf");
    }
}