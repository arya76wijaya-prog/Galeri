<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use App\Models\SchoolLocation;

class HomeController extends Controller
{
    public function index()
    {
        $albums = Album::published()
            ->with('photos')
            ->withCount('photos', 'likes')
            ->latest('published_at')
            ->take(6)
            ->get();

        $stats = [
            'albums' => Album::published()->count(),
            'photos' => Photo::count(),
            'locations' => SchoolLocation::active()->count(),
        ];

        return view('home.index', compact('albums', 'stats'));
    }

    public function about()
    {
        return view('home.about');
    }
}
