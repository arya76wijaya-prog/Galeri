<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Photo $photo, Request $request)
    {
        $userId = auth()->id();
        $sessionId = $request->session()->getId();

        $exists = $photo->likes()
            ->where(function ($q) use ($userId, $sessionId) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } else {
                    $q->where('session_id', $sessionId);
                }
            })
            ->exists();

        if (! $exists) {
            $photo->likes()->create([
                'user_id' => $userId,
                'session_id' => $sessionId,
            ]);
        }

        $likesCount = $photo->likes()->count();
        $liked = $photo->likes()
            ->where(function ($q) use ($userId, $sessionId) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } else {
                    $q->where('session_id', $sessionId);
                }
            })
            ->exists();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'liked' => $liked,
                'likesCount' => $likesCount,
                'message' => 'Anda menyukai foto ini.',
            ]);
        }

        return back()->with('status', 'Anda menyukai foto ini.');
    }

    public function destroy(Photo $photo, Request $request)
    {
        $userId = auth()->id();
        $sessionId = $request->session()->getId();

        $photo->likes()
            ->where(function ($q) use ($userId, $sessionId) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } else {
                    $q->where('session_id', $sessionId);
                }
            })
            ->delete();

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
