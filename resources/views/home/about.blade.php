@extends('layouts.app')

@section('title', 'Tentang Sekolah — Galeri Sekolah')

@section('content')
    {{-- Hero --}}
    <section class="border-b border-slate-200 bg-gradient-to-br from-brand-50 via-white to-brand-100">
        <div class="mx-auto max-w-4xl px-4 py-16 text-center sm:px-6 lg:px-8 lg:py-20">
            <span class="inline-flex items-center gap-2 rounded-full border border-brand-200 bg-white/80 px-3 py-1 text-xs font-semibold text-brand-700">
                <i data-lucide="school" class="size-3.5"></i>
                Tentang Sekolah
            </span>
            <h1 class="mt-5 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl lg:text-5xl">
                Cerita sekolah, dalam <span class="text-brand-600">setiap foto</span>.
            </h1>
            <p class="mx-auto mt-5 max-w-2xl text-base leading-relaxed text-slate-600 sm:text-lg">
                Galeri Sekolah adalah ruang digital untuk mendokumentasikan kegiatan, fasilitas, dan prestasi sekolah. Semua album dikumpulkan dalam satu tempat agar siswa, guru, dan orang tua dapat menikmatinya bersama.
            </p>
            <a href="{{ route('gallery.index') }}" class="mt-8 inline-flex items-center gap-2 rounded-xl bg-brand-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">
                <i data-lucide="images" class="size-4"></i>
                Jelajahi Galeri
            </a>
        </div>
    </section>

    {{-- Fitur --}}
    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-20">
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Apa yang bisa Anda lakukan?</h2>
            <p class="mt-3 text-sm leading-relaxed text-slate-600 sm:text-base">
                Dirancang sederhana agar semua orang bisa ikut berbagi dan menghargai momen sekolah.
            </p>
        </div>

        <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <span class="grid size-11 place-items-center rounded-xl bg-brand-50 text-brand-600">
                    <i data-lucide="folder-open" class="size-5"></i>
                </span>
                <h3 class="mt-4 text-base font-semibold text-slate-900">Album</h3>
                <p class="mt-2 text-sm leading-relaxed text-slate-600">Foto-foto dirangkum per album berdasarkan kegiatan atau kategori sehingga mudah dijelajahi.</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <span class="grid size-11 place-items-center rounded-xl bg-brand-50 text-brand-600">
                    <i data-lucide="image" class="size-5"></i>
                </span>
                <h3 class="mt-4 text-base font-semibold text-slate-900">Foto</h3>
                <p class="mt-2 text-sm leading-relaxed text-slate-600">Lihat dokumentasi berkualitas dalam tampilan galeri yang nyaman di layar besar maupun ponsel.</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <span class="grid size-11 place-items-center rounded-xl bg-rose-50 text-rose-600">
                    <i data-lucide="heart" class="size-5"></i>
                </span>
                <h3 class="mt-4 text-base font-semibold text-slate-900">Like</h3>
                <p class="mt-2 text-sm leading-relaxed text-slate-600">Berikan apresiasi pada foto favorit Anda hanya dengan satu ketukan.</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <span class="grid size-11 place-items-center rounded-xl bg-amber-50 text-amber-600">
                    <i data-lucide="message-circle" class="size-5"></i>
                </span>
                <h3 class="mt-4 text-base font-semibold text-slate-900">Komentar</h3>
                <p class="mt-2 text-sm leading-relaxed text-slate-600">Sampaikan kesan dan cerita Anda. Komentar akan tampil setelah melalui peninjauan admin.</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <span class="grid size-11 place-items-center rounded-xl bg-slate-100 text-slate-600">
                    <i data-lucide="flag" class="size-5"></i>
                </span>
                <h3 class="mt-4 text-base font-semibold text-slate-900">Laporan</h3>
                <p class="mt-2 text-sm leading-relaxed text-slate-600">Bantu menjaga galeri tetap nyaman dengan melaporkan konten yang tidak sesuai.</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <span class="grid size-11 place-items-center rounded-xl bg-emerald-50 text-emerald-600">
                    <i data-lucide="map-pin" class="size-5"></i>
                </span>
                <h3 class="mt-4 text-base font-semibold text-slate-900">Peta Sekolah</h3>
                <p class="mt-2 text-sm leading-relaxed text-slate-600">Temukan lokasi penting di lingkungan sekolah lewat peta interaktif yang mudah dipakai.</p>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="mx-auto max-w-7xl px-4 pb-16 sm:px-6 lg:px-8 lg:pb-24">
        <div class="relative overflow-hidden rounded-3xl bg-brand-700 px-6 py-12 text-center text-white sm:px-12">
            <div class="absolute -right-10 -top-10 size-48 rounded-full bg-white/10" aria-hidden="true"></div>
            <div class="absolute -bottom-16 -left-10 size-56 rounded-full bg-white/5" aria-hidden="true"></div>
            <i data-lucide="images" class="relative mx-auto size-8 text-brand-100"></i>
            <h2 class="relative mt-4 text-2xl font-bold sm:text-3xl">Mulai jelajahi galeri sekolah</h2>
            <p class="relative mx-auto mt-3 max-w-xl text-sm text-brand-100">Ratusan momen sudah menanti untuk dilihat. Siapa tahu Anda menemukan foto kenangan Anda.</p>
            <a href="{{ route('gallery.index') }}" class="relative mt-7 inline-flex items-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-semibold text-brand-700 shadow-sm transition hover:bg-brand-50">
                Lihat semua galeri
                <i data-lucide="arrow-right" class="size-4"></i>
            </a>
        </div>
    </section>
@endsection
