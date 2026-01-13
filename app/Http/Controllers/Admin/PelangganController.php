<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PelangganController extends Controller
{
    // Index - daftar pelanggan
    public function index()
    {
        $pelanggans = User::where('role', 'pelanggan')->get();
        return view('admin.pelanggan.index', compact('pelanggans'));
    }

    // Form tambah pelanggan
    public function create()
    {
        return view('admin.pelanggan.create');
    }

    // Simpan pelanggan baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'no_hp' => 'required|string|max:20',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'role' => 'pelanggan',
        ]);

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    // Form edit pelanggan
    public function edit(User $pelanggan)
    {
        return view('admin.pelanggan.edit', compact('pelanggan'));
    }

    // Update pelanggan
    public function update(Request $request, User $pelanggan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $pelanggan->id,
            'password' => 'nullable|string|min:6|confirmed',
            'no_hp' => 'required|string|max:20',
        ]);

        $pelanggan->name = $request->name;
        $pelanggan->email = $request->email;
        $pelanggan->no_hp = $request->no_hp;

        if($request->password){
            $pelanggan->password = Hash::make($request->password);
        }

        $pelanggan->save();

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil diperbarui.');
    }

    // Hapus pelanggan
    public function destroy(User $pelanggan)
    {
        $pelanggan->delete();
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus.');
    }
}
