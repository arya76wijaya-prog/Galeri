<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolLocation;
use App\Support\HandlesImageUploads;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SchoolLocationController extends Controller
{
    use HandlesImageUploads;

    public function index()
    {
        $locations = SchoolLocation::latest()->paginate(10);

        return view('admin.school-locations.index', compact('locations'));
    }

    public function create()
    {
        return view('admin.school-locations.create', [
            'location' => new SchoolLocation(['status' => 'active']),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateLocation($request);

        $location = SchoolLocation::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'status' => $data['status'],
        ]);

        if ($request->hasFile('image')) {
            $location->image_path = $this->storeImage($request->file('image'), 'locations');
            $location->save();
        }

        return redirect()->route('admin.school-locations.index')->with('status', 'Lokasi berhasil ditambahkan.');
    }

    public function edit(SchoolLocation $location)
    {
        return view('admin.school-locations.edit', compact('location'));
    }

    public function update(Request $request, SchoolLocation $location)
    {
        $data = $this->validateLocation($request);

        $location->fill([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'status' => $data['status'],
        ]);

        if ($request->hasFile('image')) {
            $oldImage = $location->image_path;
            $location->image_path = $this->storeImage($request->file('image'), 'locations');
            $this->deleteImage($oldImage);
        }

        $location->save();

        return redirect()->route('admin.school-locations.index')->with('status', 'Lokasi berhasil diperbarui.');
    }

    public function destroy(SchoolLocation $location)
    {
        $this->deleteImage($location->image_path);
        $location->delete();

        return back()->with('status', 'Lokasi berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateLocation(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:101376'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ], [
            'name.required' => 'Nama lokasi wajib diisi.',
            'latitude.required' => 'Latitude wajib diisi.',
            'latitude.between' => 'Latitude harus antara -90 dan 90.',
            'longitude.required' => 'Longitude wajib diisi.',
            'longitude.between' => 'Longitude harus antara -180 dan 180.',
            'image.image' => 'File harus berupa gambar.',
            'image.max' => 'Ukuran gambar maksimal 99 MB.',
        ]);
    }
}
