@extends('layouts.app')

@section('title', 'Galeri Sekolah — Galeri Sekolah')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
        {{-- Heading --}}
        <div class="mb-8">
            <span class="inline-flex items-center gap-2 rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-700">
                <i data-lucide="images" class="size-3.5"></i>
                Kumpulan dokumentasi sekolah
            </span>
            <h1 class="mt-4 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Galeri Sekolah</h1>
            <p class="mt-2 max-w-2xl text-sm leading-relaxed text-slate-600 sm:text-base">
                Jelajahi album foto kegiatan, fasilitas, dan prestasi sekolah. Cari berdasarkan kata kunci atau pilih kategori favorit Anda.
            </p>
        </div>

        {{-- Filter --}}
        <form method="GET" action="{{ route('gallery.index') }}" class="mb-8 grid gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:grid-cols-[minmax(0,1fr)_auto] lg:grid-cols-[minmax(0,1fr)_14rem_auto_auto]">
            <div class="relative">
                <label for="gallery-search" class="sr-only">Cari album</label>
                <i data-lucide="search" class="pointer-events-none absolute left-3 top-1/2 size-4 -translate-y-1/2 text-slate-400"></i>
                <input id="gallery-search" type="text" name="q" value="{{ $search }}" placeholder="Cari album..." class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-100">
            </div>

            <div>
                <label for="gallery-category" class="sr-only">Kategori</label>
                <select id="gallery-category" name="category" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-100">
                    <option value="">Semua kategori</option>
                    @foreach ($categories as $item)
                        <option value="{{ $item }}" @selected($category === $item)>{{ $item }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">
                <i data-lucide="search" class="size-4"></i>
                Cari
            </button>

            <a href="{{ route('gallery.index') }}" class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:border-brand-300 hover:text-brand-700">
                <i data-lucide="rotate-ccw" class="size-4"></i>
                Reset
            </a>
        </form>

        {{-- Results info --}}
        @if ($albums->count())
            <p class="mb-5 text-sm text-slate-500">Menampilkan {{ $albums->count() }} dari {{ $albums->total() }} album.</p>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($albums as $album)
                    <a href="{{ route('gallery.show', $album) }}" class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:border-brand-300 hover:shadow-lg">
                        <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">
                            @if ($album->cover_url)
                                <img src="{{ $album->cover_url }}" alt="{{ $album->title }}" loading="lazy" class="size-full object-cover transition duration-500 group-hover:scale-105">
                            @else
                                <div class="grid size-full place-items-center bg-gradient-to-br from-brand-50 to-brand-100 text-brand-400">
                                    <i data-lucide="image-off" class="size-10"></i>
                                </div>
                            @endif

                            @if ($album->category)
                                <span class="absolute left-3 top-3 rounded-full bg-white/90 px-2.5 py-1 text-xs font-semibold text-brand-700 shadow-sm backdrop-blur">{{ $album->category }}</span>
                            @endif
                        </div>

                        <div class="flex flex-1 flex-col p-5">
                            <h2 class="text-lg font-semibold text-slate-900 transition group-hover:text-brand-700">{{ $album->title }}</h2>
                            <p class="mt-2 line-clamp-2 text-sm leading-relaxed text-slate-600">{{ Str::limit($album->description ?? '', 120) }}</p>

                            <div class="mt-4 flex flex-wrap items-center gap-x-4 gap-y-2 border-t border-slate-100 pt-4 text-xs text-slate-500">
                                <span class="inline-flex items-center gap-1">
                                    <i data-lucide="camera" class="size-3.5"></i>
                                    {{ $album->photos_count }} foto
                                </span>
                                <span class="inline-flex items-center gap-1">
                                    <i data-lucide="heart" class="size-3.5"></i>
                                    {{ $album->likes_count }} suka
                                </span>
                                @if ($album->event_date)
                                    <span class="inline-flex items-center gap-1">
                                        <i data-lucide="calendar-days" class="size-3.5"></i>
                                        {{ $album->event_date->translatedFormat('d M Y') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $albums->links() }}
            </div>
        @else
            <div class="grid place-items-center rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center">
                <span class="grid size-14 place-items-center rounded-full bg-brand-50 text-brand-600">
                    <i data-lucide="search-x" class="size-6"></i>
                </span>
                <h2 class="mt-4 text-base font-semibold text-slate-800">Album tidak ditemukan</h2>
                <p class="mt-1 max-w-sm text-sm text-slate-500">Coba ubah kata kunci atau kategori pencarian Anda, atau lihat semua album yang tersedia.</p>
                <a href="{{ route('gallery.index') }}" class="mt-5 inline-flex items-center gap-2 rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-brand-700 transition hover:border-brand-300">
                    <i data-lucide="rotate-ccw" class="size-4"></i>
                    Lihat semua album
                </a>
            </div>
        @endif
    </div>
@endsection
