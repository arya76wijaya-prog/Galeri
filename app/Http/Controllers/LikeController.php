<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Support\VisitorIdentity;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Photo $photo, Request $request)
    {
        $identity = auth()->check()
            ? ['user_id' => auth()->id()]
            : ['visitor_id' => VisitorIdentity::get($request)];

        $photo->likes()->firstOrCreate($identity);

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
        $identityColumn = auth()->check() ? 'user_id' : 'visitor_id';
        $identity = auth()->check() ? auth()->id() : VisitorIdentity::get($request);

        $photo->likes()->where($identityColumn, $identity)->delete();

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
