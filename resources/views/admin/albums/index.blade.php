@extends('layouts.admin')

@section('title', 'Kelola Album')
@section('heading', 'Album')
@section('subheading', 'Kelola album dan kategori galeri sekolah')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <p class="text-sm text-slate-600">Total {{ $albums->total() }} album ditemukan.</p>
            <a href="{{ route('admin.albums.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700">
                <i data-lucide="plus" class="size-4"></i> Tambah Album
            </a>
        </div>

        <form method="GET" action="{{ route('admin.albums.index') }}" class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end">
                <div class="flex-1">
                    <label for="q" class="block text-xs font-semibold text-slate-600">Cari album</label>
                    <input type="text" id="q" name="q" value="{{ $search }}" placeholder="Judul atau slug album..." class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 placeholder:text-slate-400 focus:border-brand-500 focus:ring-brand-500">
                </div>
                <div class="sm:w-48">
                    <label for="status" class="block text-xs font-semibold text-slate-600">Status</label>
                    <select id="status" name="status" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 focus:border-brand-500 focus:ring-brand-500">
                        @foreach (['' => 'Semua status', 'draft' => 'Draft', 'published' => 'Published'] as $value => $label)
                            <option value="{{ $value }}" {{ (string) $status === (string) $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700">
                    <i data-lucide="filter" class="size-4"></i> Filter
                </button>
                <a href="{{ route('admin.albums.index') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    <i data-lucide="rotate-ccw" class="size-4"></i> Reset
                </a>
            </div>
        </form>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-4 py-3">Cover</th>
                            <th class="px-4 py-3">Album</th>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-center">Jumlah foto</th>
                            <th class="px-4 py-3">Pembuat</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($albums as $album)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3">
                                    @if ($album->cover_url)
                                        <img src="{{ $album->cover_url }}" alt="Cover {{ $album->title }}" class="size-14 rounded-lg border border-slate-200 object-cover">
                                    @else
                                        <div class="grid size-14 place-items-center rounded-lg bg-slate-100 text-slate-400">
                                            <i data-lucide="image" class="size-5"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-medium text-slate-800">{{ $album->title }}</p>
                                    <p class="mt-0.5 text-xs text-slate-400">{{ $album->slug }}</p>
                                </td>
                                <td class="px-4 py-3 text-slate-600">{{ $album->category }}</td>
                                <td class="px-4 py-3">
                                    @if ($album->status === 'published')
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700">Published</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-amber-50 px-2 py-0.5 text-xs font-medium text-amber-700">Draft</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center text-slate-600">{{ $album->photos_count }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $album->creator?->name ?? '-' }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-xs text-slate-500">{{ $album->event_date?->format('d M Y') ?? $album->created_at?->format('d M Y') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.albums.edit', $album) }}" class="inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50" aria-label="Edit album">
                                            <i data-lucide="pencil" class="size-4"></i> Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.albums.destroy', $album) }}" data-confirm="Hapus album ini beserta semua fotonya?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 rounded-lg border border-rose-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-rose-600 hover:bg-rose-50" aria-label="Hapus album">
                                                <i data-lucide="trash-2" class="size-4"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-10 text-center text-sm text-slate-400">Tidak ada album yang cocok dengan pencarian Anda.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-100 px-4 py-3">
                {{ $albums->links() }}
            </div>
        </div>
    </div>
@endsection
