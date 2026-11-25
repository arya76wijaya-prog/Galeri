@extends('layouts.admin')

@section('title', 'Edit Foto')
@section('heading', 'Edit Foto')
@section('subheading', 'Perbarui album dan keterangan foto')

@section('content')
    <div class="mx-auto max-w-3xl">
        <form method="POST" action="{{ route('admin.photos.update', $photo) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-sm font-semibold text-slate-900">Detail foto</h2>
                <p class="mt-1 text-xs text-slate-500">Ubah album atau keterangan foto di bawah ini.</p>

                <div class="mt-5 space-y-4">
                    <div>
                        <label for="album_id" class="block text-xs font-semibold text-slate-600">Album <span class="text-rose-500">*</span></label>
                        <select id="album_id" name="album_id" required class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 focus:border-brand-500 focus:ring-brand-500">
                            @foreach ($albums as $album)
                                <option value="{{ $album->id }}" {{ (string) old('album_id', $photo->album_id) === (string) $album->id ? 'selected' : '' }}>{{ $album->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="caption" class="block text-xs font-semibold text-slate-600">Keterangan</label>
                        <textarea id="caption" name="caption" rows="4" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 placeholder:text-slate-400 focus:border-brand-500 focus:ring-brand-500" placeholder="Tuliskan keterangan foto (opsional)...">{{ old('caption', $photo->caption) }}</textarea>
                    </div>
                </div>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-sm font-semibold text-slate-900">Ganti gambar</h2>
                <p class="mt-1 text-xs text-slate-500">Kosongkan jika tidak ingin mengubah gambar foto.</p>

                <div class="mt-5 flex flex-wrap items-center gap-5">
                    <div class="flex items-center gap-4">
                        <img id="photo-preview" alt="Pratinjau foto" class="peer hidden size-32 rounded-xl border border-slate-200 object-cover">
                        <div data-preview-wrapper class="peer-not-[.hidden]:hidden">
                            <img src="{{ $photo->image_url }}" alt="Foto saat ini" class="size-32 rounded-xl border border-slate-200 object-cover">
                        </div>
                    </div>
                    <div class="min-w-56 flex-1">
                        <label for="image" class="block text-xs font-semibold text-slate-600">Berkas gambar baru</label>
                        <input type="file" id="image" name="image" accept="image/*" data-image-preview="photo-preview" class="mt-1 block w-full text-xs text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-slate-700 hover:file:bg-slate-200">
                    </div>
                </div>
            </section>

            <div class="flex flex-wrap items-center justify-end gap-3">
                <a href="{{ route('admin.photos.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    <i data-lucide="x" class="size-4"></i> Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700">
                    <i data-lucide="save" class="size-4"></i> Simpan perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
