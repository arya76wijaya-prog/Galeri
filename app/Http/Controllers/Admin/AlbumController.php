<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Support\HandlesImageUploads;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AlbumController extends Controller
{
    use HandlesImageUploads;

    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));
        $status = trim((string) $request->query('status', '')) ?: null;

        $albums = Album::query()
            ->search($search)
            ->when($status, fn ($query) => $query->where('status', $status))
            ->with('creator')
            ->withCount('photos')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.albums.index', compact('albums', 'search', 'status'));
    }

    public function create()
    {
        return view('admin.albums.create', [
            'album' => new Album(['status' => 'published']),
            'categories' => config('gallery.categories'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateAlbum($request);

        $album = Album::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'category' => $data['category'] ?? null,
            'created_by' => auth()->id(),
            'event_date' => $data['event_date'] ?? null,
        ]);

        if ($request->hasFile('cover_photo')) {
            $album->cover_photo = $this->storeImage(
                $request->file('cover_photo'),
                "albums/album-{$album->id}"
            );
            $album->save();
        }

        return redirect()->route('admin.albums.index')->with('status', 'Album berhasil dibuat.');
    }

    public function edit(Album $album)
    {
        return view('admin.albums.edit', [
            'album' => $album,
            'categories' => config('gallery.categories'),
        ]);
    }

    public function update(Request $request, Album $album)
    {
        $data = $this->validateAlbum($request, $album);

        $album->fill([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'category' => $data['category'] ?? null,
            'event_date' => $data['event_date'] ?? null,
        ]);
        $album->save();

        if ($request->hasFile('cover_photo')) {
            $oldCover = $album->cover_photo;
            $album->cover_photo = $this->storeImage(
                $request->file('cover_photo'),
                "albums/album-{$album->id}"
            );
            $album->save();
            $this->deleteImage($oldCover);
        }

        return redirect()->route('admin.albums.index')->with('status', 'Album berhasil diperbarui.');
    }

    public function destroy(Album $album)
    {
        foreach ($album->photos as $photo) {
            $this->deleteImage($photo->image_path);
        }

        $this->deleteImage($album->cover_photo);
        $album->delete();

        return redirect()->route('admin.albums.index')->with('status', 'Album beserta fotonya berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateAlbum(Request $request, ?Album $album = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'category' => ['nullable', Rule::in(config('gallery.categories'))],
            'cover_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:101376'],
            'event_date' => ['nullable', 'date'],
        ], [
            'title.required' => 'Judul album wajib diisi.',
            'cover_photo.image' => 'File cover harus berupa gambar.',
            'cover_photo.max' => 'Ukuran cover maksimal 99 MB.',
            'event_date.date' => 'Format tanggal kegiatan tidak valid.',
        ]);
    }
}
