@extends('layouts.admin')

@section('title', 'Kelola Foto')
@section('heading', 'Foto')
@section('subheading', 'Kelola seluruh foto dalam galeri sekolah')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <p class="text-sm text-slate-600">Total {{ $photos->total() }} foto ditemukan.</p>
            <a href="{{ route('admin.photos.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700">
                <i data-lucide="image-plus" class="size-4"></i> Unggah Foto
            </a>
        </div>

        <form method="GET" action="{{ route('admin.photos.index') }}" class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end">
                <div class="flex-1">
                    <label for="q" class="block text-xs font-semibold text-slate-600">Cari foto</label>
                    <input type="text" id="q" name="q" value="{{ $search }}" placeholder="Cari berdasarkan keterangan..." class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 placeholder:text-slate-400 focus:border-brand-500 focus:ring-brand-500">
                </div>
                <div class="sm:w-56">
                    <label for="album_id" class="block text-xs font-semibold text-slate-600">Album</label>
                    <select id="album_id" name="album_id" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 focus:border-brand-500 focus:ring-brand-500">
                        <option value="">Semua album</option>
                        @foreach ($albums as $option)
                            <option value="{{ $option->id }}" {{ (string) $albumId === (string) $option->id ? 'selected' : '' }}>{{ $option->title }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700">
                    <i data-lucide="filter" class="size-4"></i> Filter
                </button>
                <a href="{{ route('admin.photos.index') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    <i data-lucide="rotate-ccw" class="size-4"></i> Reset
                </a>
            </div>
        </form>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-4 py-3">Foto</th>
                            <th class="px-4 py-3">Keterangan</th>
                            <th class="px-4 py-3">Album</th>
                            <th class="px-4 py-3">Diunggah oleh</th>
                            <th class="px-4 py-3 text-center">Suka</th>
                            <th class="px-4 py-3 text-center">Komentar</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($photos as $photo)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3">
                                    <img src="{{ $photo->image_url }}" alt="{{ $photo->caption ?: 'Foto galeri' }}" class="size-16 rounded-lg border border-slate-200 object-cover">
                                </td>
                                <td class="max-w-56 px-4 py-3 text-slate-700">
                                    <span class="line-clamp-2">{{ $photo->caption ?: '-' }}</span>
                                </td>
                                <td class="px-4 py-3 text-slate-600">{{ $photo->album?->title ?? '-' }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $photo->uploader?->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-center text-slate-600">
                                    <span class="inline-flex items-center gap-1"><i data-lucide="heart" class="size-4 text-rose-500"></i> {{ $photo->likes_count }}</span>
                                </td>
                                <td class="px-4 py-3 text-center text-slate-600">
                                    <span class="inline-flex items-center gap-1"><i data-lucide="message-circle" class="size-4 text-sky-500"></i> {{ $photo->comments_count }}</span>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-xs text-slate-500">{{ $photo->created_at?->format('d M Y') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.photos.edit', $photo) }}" class="inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50" aria-label="Edit foto">
                                            <i data-lucide="pencil" class="size-4"></i> Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.photos.destroy', $photo) }}" data-confirm="Hapus foto ini?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 rounded-lg border border-rose-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-rose-600 hover:bg-rose-50" aria-label="Hapus foto">
                                                <i data-lucide="trash-2" class="size-4"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-10 text-center text-sm text-slate-400">Tidak ada foto yang cocok dengan pencarian Anda.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-100 px-4 py-3">
                {{ $photos->links() }}
            </div>
        </div>
    </div>
@endsection
