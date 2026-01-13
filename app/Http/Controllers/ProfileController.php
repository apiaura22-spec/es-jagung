<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan form edit profil user.
     */
    public function edit(Request $request): View
    {
        // Diperbarui: Mengarahkan ke user.profile.edit sesuai struktur folder kita
        return view('user.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update informasi profil user.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // Ambil data tervalidasi
        $data = $request->validated();

        // Logika tambahan untuk Password (jika diisi maka diupdate)
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $user->fill($data);

        // Jika email berubah, reset verifikasi
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Redirect kembali ke halaman edit profil user dengan pesan sukses
        return Redirect::route('user.profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Hapus akun user (Opsional).
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('status', 'Akun telah dihapus.');
    }
}