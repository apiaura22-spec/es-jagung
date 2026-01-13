<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'rating'    => 'required|integer|min:1|max:5',
            'ulasan'    => 'required|string|max:255',
        ]);

        Review::create([
            'produk_id' => $request->produk_id,
            'user_id'   => Auth::id(),
            'rating'    => $request->rating,
            'ulasan'    => $request->ulasan,
        ]);

        return back()->with('success', 'Terima kasih atas ulasan Anda ⭐');
    }
}
