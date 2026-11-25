@extends('layouts.app')

@section('title', 'Beranda — Galeri Sekolah')

@section('content')
    {{-- Hero --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-brand-50 via-white to-brand-100">
        <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 py-16 sm:px-6 lg:grid-cols-2 lg:px-8 lg:py-24">
            <div>
                <span class="inline-flex items-center gap-2 rounded-full border border-brand-200 bg-white/80 px-3 py-1 text-xs font-semibold text-brand-700">
                    <i data-lucide="sparkles" class="size-3.5"></i>
                    Dokumentasi digital sekolah
                </span>

                <h1 class="mt-5 text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl lg:text-6xl">
                    Mengabadikan <span class="text-brand-600">hari-hari sekolah</span> dalam satu galeri.
                </h1>

                <p class="mt-5 max-w-xl text-base leading-relaxed text-slate-600 sm:text-lg">
                    Jelajahi kegiatan, fasilitas, dan prestasi sekolah melalui album foto yang terus bertambah. Temukan pula sudut-sudut menarik di peta sekolah kami.
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('gallery.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-brand-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">
                        <i data-lucide="images" class="size-4"></i>
                        Jelajahi Galeri
                    </a>
                </div>

                <dl class="mt-10 grid max-w-lg grid-cols-3 gap-4 border-t border-brand-200/70 pt-6">
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Album</dt>
                        <dd class="mt-1 text-2xl font-bold text-brand-700">{{ $stats['albums'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Foto</dt>
                        <dd class="mt-1 text-2xl font-bold text-brand-700">{{ $stats['photos'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Lokasi</dt>
                        <dd class="mt-1 text-2xl font-bold text-brand-700">{{ $stats['locations'] }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Slideshow foto otomatis --}}
            <div class="relative hidden lg:block" aria-hidden="true">
                <div class="absolute inset-4 rotate-3 rounded-3xl bg-gradient-to-tr from-brand-200 to-brand-50"></div>
                <div class="relative aspect-[4/3] place-items-center rounded-3xl border border-white/80 bg-white/70 shadow-xl backdrop-blur overflow-hidden">
                    <div class="relative size-full h-full">
                        @php
                            $slides = $albums->filter(fn ($a) => $a->cover_url)->take(4)->values();
                        @endphp

                        <div class="relative size-full h-full overflow-hidden">
                            @for ($i = 0; $i < 4; $i++)
                                @php
                                    $album = $slides[$i] ?? null;
                                @endphp
                                <div class="absolute inset-0 transition-opacity duration-2000 ease-in-out {{ $i === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}" style="animation: slide-fade 24s infinite; animation-delay: {{ -$i * 6 }}s;">
                                    @if ($album)
                                        <img src="{{ $album->cover_url }}" alt="{{ $album->title }}" class="size-full object-cover rounded-2xl" loading="lazy">
                                    @else
                                        <div class="size-full grid place-items-center bg-slate-100 rounded-2xl text-slate-400">
                                            <i data-lucide="images" class="size-16"></i>
                                        </div>
                                    @endif
                                </div>
                            @endfor
                        </div>

                        <style>
                            @keyframes slide-fade {
                                0%, 12% { opacity: 1; z-index: 10; transform: scale(1); }
                                20%, 100% { opacity: 0; z-index: 0; transform: scale(1.05); }
                            }
                        </style>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Album terbaru --}}
    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-20">
        <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Album terbaru</h2>
                <p class="mt-2 text-sm text-slate-600">Potret terkini dari kehidupan sehari-hari di sekolah.</p>
            </div>
            <a href="{{ route('gallery.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-brand-700 transition hover:text-brand-800">
                Lihat semua galeri
                <i data-lucide="arrow-right" class="size-4"></i>
            </a>
        </div>

        @if ($albums->count())
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
                            <h3 class="text-lg font-semibold text-slate-900 transition group-hover:text-brand-700">{{ $album->title }}</h3>
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
        @else
            <div class="grid place-items-center rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center">
                <span class="grid size-14 place-items-center rounded-full bg-brand-50 text-brand-600">
                    <i data-lucide="images" class="size-6"></i>
                </span>
                <h3 class="mt-4 text-base font-semibold text-slate-800">Belum ada album</h3>
                <p class="mt-1 max-w-sm text-sm text-slate-500">Album pertama akan tampil di sini setelah ditambahkan dan diterbitkan.</p>
            </div>
        @endif
    </section>

    {{-- Peta lokasi sekolah di halaman depan --}}
    <section id="peta" class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8 lg:py-16">
        <div class="grid gap-8 sm:grid-cols-[1fr_1fr] items-center">
            <div class="space-y-3">
                <span class="inline-flex items-center gap-2 rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-700">
                    <i data-lucide="map-pin" class="size-3.5"></i>
                    Lokasi sekolah kami
                </span>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">SMK TI Dwiguna</h2>
                <p class="text-sm leading-relaxed text-slate-600 sm:text-base">
                    Kami berlokasi di area strategis dengan fasilitas lengkap untuk mendukung kegiatan belajar mengajar dan prestasi siswa. Kunjungi kami langsung atau jelajahi melalui peta di bawah ini.
                </p>
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('gallery.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-brand-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-700">
                        <i data-lucide="images" class="size-4"></i> Jelajahi Galeri
                    </a>
                </div>
            </div>

            <div class="relative w-full h-64 sm:h-80 rounded-2xl border border-slate-200 bg-slate-100 overflow-hidden shadow-sm sm:aspect-[1/1]">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.663967028855!2d106.807133!3d-6.4371864!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69e901c47640f7%3A0x2251ab94bef61b08!2sSMK%20TI%20Dwiguna!5e0!3m2!1sid!2sid!4v1795140074729!5m2!1sid!2sid"
                    width="600"
                    height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="strict-origin-when-cross-origin"
                    class="size-full"
                ></iframe>
            </div>
        </div>
    </section>
@endsection
