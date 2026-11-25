<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Photo $photo, Request $request)
    {
        $photo->likes()->firstOrCreate(['user_id' => auth()->user()?->id]);

        $likesCount = $photo->likes()->count();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'liked' => true,
                'likesCount' => $likesCount,
                'message' => 'Anda menyukai foto ini.',
            ]);
        }

        return back()->with('status', 'Anda menyukai foto ini.');
    }

    public function destroy(Photo $photo, Request $request)
    {
        $photo->likes()->where('user_id', auth()->user()?->id)->delete();

        $likesCount = $photo->likes()->count();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'liked' => false,
                'likesCount' => $likesCount,
                'message' => 'Suka dibatalkan.',
            ]);
        }

        return back()->with('status', 'Suka dibatalkan.');
    }
}
