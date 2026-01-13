<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'kategori'   => 'required|in:gaji,operasional,bahan_baku',
            'jumlah'     => 'required|numeric',
            'tanggal'    => 'required|date',
        ]);

        Expense::create($request->all());

        return back()->with('success', 'Catatan pengeluaran berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        Expense::findOrFail($id)->delete();
        return back()->with('success', 'Data berhasil dihapus!');
    }
}