@extends('layouts.admin')

@section('title', 'Unggah Foto')
@section('heading', 'Unggah Foto')
@section('subheading', 'Tambahkan satu atau beberapa foto ke album galeri')

@section('content')
    <div class="grid gap-6 xl:grid-cols-2">
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="grid size-10 place-items-center rounded-xl bg-brand-50 text-brand-600">
                    <i data-lucide="image-plus" class="size-5"></i>
                </span>
                <div>
                    <h2 class="text-sm font-semibold text-slate-900">Unggah satu foto</h2>
                    <p class="mt-0.5 text-xs text-slate-500">Tambahkan satu foto ke album pilihan.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.photos.store') }}" enctype="multipart/form-data" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label for="single_album_id" class="block text-xs font-semibold text-slate-600">Album <span class="text-rose-500">*</span></label>
                    <select id="single_album_id" name="album_id" required class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 focus:border-brand-500 focus:ring-brand-500">
                        <option value="">Pilih album</option>
                        @foreach ($albums as $album)
                            <option value="{{ $album->id }}" {{ old('album_id') == $album->id ? 'selected' : '' }}>{{ $album->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="single_caption" class="block text-xs font-semibold text-slate-600">Keterangan</label>
                    <textarea id="single_caption" name="caption" rows="3" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 placeholder:text-slate-400 focus:border-brand-500 focus:ring-brand-500" placeholder="Tuliskan keterangan foto (opsional)...">{{ old('caption') }}</textarea>
                </div>

                <div>
                    <div class="flex flex-wrap items-center gap-4">
                        <img id="single-photo-preview" alt="Pratinjau foto" class="peer hidden size-32 rounded-xl border border-slate-200 object-cover">
                        <div data-preview-wrapper class="peer-not-[.hidden]:hidden">
                            <div class="grid size-32 place-items-center rounded-xl border border-dashed border-slate-300 bg-slate-50 text-slate-400">
                                <i data-lucide="image" class="size-8"></i>
                            </div>
                        </div>
                    </div>
                    <label for="single_image" class="mt-4 block text-xs font-semibold text-slate-600">Berkas gambar <span class="text-rose-500">*</span></label>
                    <input type="file" id="single_image" name="image" accept="image/*" required data-image-preview="single-photo-preview" class="mt-1 block w-full text-xs text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-slate-700 hover:file:bg-slate-200">
                    <p class="mt-2 text-xs text-slate-400">Format JPG, PNG, atau WebP, maksimal 99 MB.</p>
                </div>

                <div class="flex flex-wrap items-center justify-end gap-3 pt-2">
                    <a href="{{ route('admin.photos.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        <i data-lucide="x" class="size-4"></i> Batal
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700">
                        <i data-lucide="upload" class="size-4"></i> Unggah foto
                    </button>
                </div>
            </form>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="grid size-10 place-items-center rounded-xl bg-sky-50 text-sky-600">
                    <i data-lucide="images" class="size-5"></i>
                </span>
                <div>
                    <h2 class="text-sm font-semibold text-slate-900">Unggah banyak foto</h2>
                    <p class="mt-0.5 text-xs text-slate-500">Tambahkan beberapa foto sekaligus ke satu album.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.photos.bulk-store') }}" enctype="multipart/form-data" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label for="bulk_album_id" class="block text-xs font-semibold text-slate-600">Album <span class="text-rose-500">*</span></label>
                    <select id="bulk_album_id" name="album_id" required class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 focus:border-brand-500 focus:ring-brand-500">
                        <option value="">Pilih album</option>
                        @foreach ($albums as $album)
                            <option value="{{ $album->id }}" {{ old('album_id') == $album->id ? 'selected' : '' }}>{{ $album->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="bulk_caption" class="block text-xs font-semibold text-slate-600">Keterangan bersama</label>
                    <textarea id="bulk_caption" name="caption" rows="3" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 placeholder:text-slate-400 focus:border-brand-500 focus:ring-brand-500" placeholder="Keterangan yang sama untuk semua foto (opsional)...">{{ old('caption') }}</textarea>
                </div>

                <div>
                    <label for="bulk_photos" class="block text-xs font-semibold text-slate-600">Berkas gambar <span class="text-rose-500">*</span></label>
                    <input type="file" id="bulk_photos" name="photos[]" accept="image/*" multiple required data-multi-preview="bulk-preview" class="mt-1 block w-full text-xs text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-slate-700 hover:file:bg-slate-200">
                    <p class="mt-2 text-xs text-slate-500">Maksimal 20 foto, 99 MB per foto. Format yang didukung: JPG, PNG, dan WebP.</p>
                    <div id="bulk-preview" class="hidden mt-3 flex flex-wrap gap-2 rounded-xl border border-dashed border-slate-200 bg-slate-50 p-3"></div>
                </div>

                <div class="flex flex-wrap items-center justify-end gap-3 pt-2">
                    <a href="{{ route('admin.photos.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        <i data-lucide="x" class="size-4"></i> Batal
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700">
                        <i data-lucide="upload-cloud" class="size-4"></i> Unggah semua foto
                    </button>
                </div>
            </form>
        </section>
    </div>
@endsection
