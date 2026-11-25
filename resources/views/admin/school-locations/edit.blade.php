@extends('layouts.admin')

@section('title', 'Edit Lokasi')
@section('heading', 'Edit Lokasi')
@section('subheading', 'Perbarui detail titik lokasi pada peta sekolah')

@section('content')
    <div class="mx-auto max-w-3xl">
        <form method="POST" action="{{ route('admin.school-locations.update', $location) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-sm font-semibold text-slate-900">Informasi lokasi</h2>
                <p class="mt-1 text-xs text-slate-500">Isi nama, deskripsi, dan koordinat lokasi.</p>

                <div class="mt-5 space-y-4">
                    <div>
                        <label for="name" class="block text-xs font-semibold text-slate-600">Nama lokasi <span class="text-rose-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $location->name) }}" required autofocus class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 placeholder:text-slate-400 focus:border-brand-500 focus:ring-brand-500" placeholder="Contoh: Lapangan Utama">
                    </div>

                    <div>
                        <label for="description" class="block text-xs font-semibold text-slate-600">Deskripsi</label>
                        <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 placeholder:text-slate-400 focus:border-brand-500 focus:ring-brand-500" placeholder="Ceritakan tentang lokasi ini...">{{ old('description', $location->description) }}</textarea>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="latitude" class="block text-xs font-semibold text-slate-600">Latitude <span class="text-rose-500">*</span></label>
                            <input type="number" id="latitude" name="latitude" step="any" value="{{ old('latitude', $location->latitude) }}" required class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 placeholder:text-slate-400 focus:border-brand-500 focus:ring-brand-500" placeholder="Contoh: -6.2088">
                        </div>
                        <div>
                            <label for="longitude" class="block text-xs font-semibold text-slate-600">Longitude <span class="text-rose-500">*</span></label>
                            <input type="number" id="longitude" name="longitude" step="any" value="{{ old('longitude', $location->longitude) }}" required class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 placeholder:text-slate-400 focus:border-brand-500 focus:ring-brand-500" placeholder="Contoh: 106.8456">
                        </div>
                    </div>

                    <div class="flex items-start gap-2 rounded-lg bg-sky-50 px-3 py-2.5 text-xs text-sky-800">
                        <i data-lucide="info" class="mt-0.5 size-4 shrink-0"></i>
                        <p>Koordinat dapat disalin dari OpenStreetMap dengan cara klik kanan pada titik lokasi yang diinginkan, lalu pilih opsi salin koordinat.</p>
                    </div>

                    <div class="sm:w-48">
                        <label for="status" class="block text-xs font-semibold text-slate-600">Status</label>
                        <select id="status" name="status" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 focus:border-brand-500 focus:ring-brand-500">
                            @foreach (['active' => 'Aktif', 'inactive' => 'Nonaktif'] as $value => $label)
                                <option value="{{ $value }}" {{ old('status', $location->status) === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-sm font-semibold text-slate-900">Gambar lokasi</h2>
                <p class="mt-1 text-xs text-slate-500">Gambar akan ditampilkan pada detail lokasi. Format: JPG, PNG, atau WebP.</p>

                <div class="mt-5 flex flex-wrap items-center gap-5">
                    <div class="flex items-center gap-4">
                        <img id="location-preview" alt="Pratinjau gambar lokasi" class="peer hidden size-32 rounded-xl border border-slate-200 object-cover">
                        <div data-preview-wrapper class="peer-not-[.hidden]:hidden">
                            @if ($location->image_url)
                                <img src="{{ $location->image_url }}" alt="Gambar saat ini" class="size-32 rounded-xl border border-slate-200 object-cover">
                            @else
                                <div class="grid size-32 place-items-center rounded-xl border border-dashed border-slate-300 bg-slate-50 text-slate-400">
                                    <i data-lucide="map-pin" class="size-8"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="min-w-56 flex-1">
                        <label for="image" class="block text-xs font-semibold text-slate-600">Ganti gambar</label>
                        <input type="file" id="image" name="image" accept="image/*" data-image-preview="location-preview" class="mt-1 block w-full text-xs text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-slate-700 hover:file:bg-slate-200">
                    </div>
                </div>
            </section>

            <div class="flex flex-wrap items-center justify-end gap-3">
                <a href="{{ route('admin.school-locations.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    <i data-lucide="x" class="size-4"></i> Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700">
                    <i data-lucide="save" class="size-4"></i> Simpan perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
