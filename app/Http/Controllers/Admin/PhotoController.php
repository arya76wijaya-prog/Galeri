<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Photo;
use App\Support\HandlesImageUploads;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PhotoController extends Controller
{
    use HandlesImageUploads;

    public function index(Request $request)
    {
        $albumId = trim((string) $request->query('album_id', '')) ?: null;
        $search = trim((string) $request->query('q', ''));

        $photos = Photo::query()
            ->when($albumId, fn ($query) => $query->where('album_id', $albumId))
            ->when($search, fn ($query) => $query->where('caption', 'like', "%{$search}%"))
            ->with(['album', 'uploader'])
            ->withCount('likes', 'comments')
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $albums = Album::orderBy('title')->get(['id', 'title']);

        return view('admin.photos.index', compact('photos', 'albums', 'albumId', 'search'));
    }

    public function create()
    {
        return view('admin.photos.create', [
            'albums' => Album::orderBy('title')->get(['id', 'title']),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'album_id' => ['required', Rule::exists('albums', 'id')],
            'caption' => ['nullable', 'string', 'max:1000'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:101376'],
        ], [
            'album_id.required' => 'Album wajib dipilih.',
            'image.required' => 'Foto wajib diunggah.',
            'image.image' => 'File harus berupa gambar.',
            'image.max' => 'Ukuran foto maksimal 99 MB.',
        ]);

        Photo::create([
            'album_id' => $data['album_id'],
            'caption' => $data['caption'] ?? null,
            'image_path' => $this->storeImage($request->file('image'), "photos/album-{$data['album_id']}"),
            'uploaded_by' => auth()->id(),
        ]);

        return back()->with('status', 'Foto berhasil diunggah.');
    }

    public function bulkStore(Request $request)
    {
        $data = $request->validate([
            'album_id' => ['required', Rule::exists('albums', 'id')],
            'caption' => ['nullable', 'string', 'max:1000'],
            'photos' => ['required', 'array', 'min:1', 'max:20'],
            'photos.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:101376'],
        ], [
            'album_id.required' => 'Album wajib dipilih.',
            'photos.required' => 'Pilih minimal satu foto.',
            'photos.min' => 'Pilih minimal satu foto.',
            'photos.max' => 'Maksimal 20 foto per unggahan.',
            'photos.*.image' => 'Setiap berkas harus berupa gambar.',
            'photos.*.max' => 'Ukuran setiap foto maksimal 99 MB.',
        ]);

        $paths = $this->storeImages($request->file('photos'), "photos/album-{$data['album_id']}");

        foreach ($paths as $path) {
            Photo::create([
                'album_id' => $data['album_id'],
                'caption' => $data['caption'] ?? null,
                'image_path' => $path,
                'uploaded_by' => auth()->id(),
            ]);
        }

        return back()->with('status', count($paths).' foto berhasil diunggah.');
    }

    public function edit(Photo $photo)
    {
        return view('admin.photos.edit', [
            'photo' => $photo,
            'albums' => Album::orderBy('title')->get(['id', 'title']),
        ]);
    }

    public function update(Request $request, Photo $photo)
    {
        $data = $request->validate([
            'album_id' => ['required', Rule::exists('albums', 'id')],
            'caption' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:101376'],
        ], [
            'album_id.required' => 'Album wajib dipilih.',
            'image.image' => 'File harus berupa gambar.',
            'image.max' => 'Ukuran foto maksimal 99 MB.',
        ]);

        $oldImage = $photo->image_path;

        $photo->album_id = $data['album_id'];
        $photo->caption = $data['caption'] ?? null;

        if ($request->hasFile('image')) {
            $photo->image_path = $this->storeImage(
                $request->file('image'),
                "photos/album-{$data['album_id']}"
            );
        }

        $photo->save();

        if ($request->hasFile('image')) {
            $this->deleteImage($oldImage);
        }

        return redirect()->route('admin.photos.index')->with('status', 'Foto berhasil diperbarui.');
    }

    public function destroy(Photo $photo)
    {
        $this->deleteImage($photo->image_path);
        $photo->delete();

        return back()->with('status', 'Foto berhasil dihapus.');
    }
}
