@extends('layouts.admin')

@section('title', 'Edit Album')
@section('heading', 'Edit Album')
@section('subheading', 'Perbarui detail album galeri sekolah')

@section('content')
    <div class="mx-auto max-w-4xl">
        <form method="POST" action="{{ route('admin.albums.update', $album) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-sm font-semibold text-slate-900">Informasi album</h2>
                <p class="mt-1 text-xs text-slate-500">Lengkapi detail album sebelum menyimpan.</p>

                <div class="mt-5 grid gap-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="title" class="block text-xs font-semibold text-slate-600">Judul album <span class="text-rose-500">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $album->title) }}" required autofocus class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 placeholder:text-slate-400 focus:border-brand-500 focus:ring-brand-500" placeholder="Contoh: Hari Ulang Tahun Sekolah">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="description" class="block text-xs font-semibold text-slate-600">Deskripsi</label>
                        <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 placeholder:text-slate-400 focus:border-brand-500 focus:ring-brand-500" placeholder="Ceritakan tentang album ini...">{{ old('description', $album->description) }}</textarea>
                    </div>

                    <div>
                        <label for="category" class="block text-xs font-semibold text-slate-600">Kategori</label>
                        <select id="category" name="category" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 focus:border-brand-500 focus:ring-brand-500">
                            <option value="">Pilih kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category }}" {{ old('category', $album->category) === $category ? 'selected' : '' }}>{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="event_date" class="block text-xs font-semibold text-slate-600">Tanggal kegiatan</label>
                        <input type="date" id="event_date" name="event_date" value="{{ old('event_date', $album->event_date?->format('Y-m-d')) }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 focus:border-brand-500 focus:ring-brand-500">
                    </div>

                    <div>
                        <label for="status" class="block text-xs font-semibold text-slate-600">Status</label>
                        <select id="status" name="status" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 focus:border-brand-500 focus:ring-brand-500">
                            @foreach (['draft' => 'Draft', 'published' => 'Published'] as $value => $label)
                                <option value="{{ $value }}" {{ old('status', $album->status) === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-sm font-semibold text-slate-900">Foto sampul</h2>
                <p class="mt-1 text-xs text-slate-500">Gambar akan ditampilkan sebagai sampul album. Format: JPG, PNG, atau WebP.</p>

                <div class="mt-5 flex flex-wrap items-center gap-5">
                    <div class="flex items-center gap-4">
                        <img id="cover-preview" alt="Pratinjau sampul" class="peer hidden size-32 rounded-xl border border-slate-200 object-cover">
                        <div data-preview-wrapper class="peer-not-[.hidden]:hidden">
                            @if ($album->cover_url)
                                <img src="{{ $album->cover_url }}" alt="Sampul saat ini" class="size-32 rounded-xl border border-slate-200 object-cover">
                            @else
                                <div class="grid size-32 place-items-center rounded-xl border border-dashed border-slate-300 bg-slate-50 text-slate-400">
                                    <i data-lucide="image" class="size-8"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="min-w-56 flex-1">
                        <label for="cover_photo" class="block text-xs font-semibold text-slate-600">Ganti gambar</label>
                        <input type="file" id="cover_photo" name="cover_photo" accept="image/*" data-image-preview="cover-preview" class="mt-1 block w-full text-xs text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-slate-700 hover:file:bg-slate-200">
                    </div>
                </div>
            </section>

            <div class="flex flex-wrap items-center justify-end gap-3">
                <a href="{{ route('admin.albums.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    <i data-lucide="x" class="size-4"></i> Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700">
                    <i data-lucide="save" class="size-4"></i> Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
