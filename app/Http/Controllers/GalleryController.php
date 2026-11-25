<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));
        $category = trim((string) $request->query('category', '')) ?: null;

        $albums = Album::published()
            ->search($search)
            ->category($category)
            ->with('creator')
            ->withCount('photos', 'likes')
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        $categories = Album::published()
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('gallery.index', compact('albums', 'categories', 'search', 'category'));
    }

    public function show(Album $album)
    {
        abort_unless($album->status === 'published', 404);

        $album->loadCount('photos');

        $photos = $album->photos()
            ->withCount('likes')
            ->with(['approvedComments.user', 'uploader'])
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('gallery.detail', compact('album', 'photos'));
    }
}
