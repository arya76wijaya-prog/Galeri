@extends('layouts.admin')

@section('title', 'Pengaturan')
@section('heading', 'Pengaturan')
@section('subheading', 'Informasi teknologi dan konfigurasi aplikasi galeri sekolah')

@section('content')
    <div class="space-y-6">
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-sm font-semibold text-slate-900">Tentang aplikasi</h2>
            <p class="mt-2 max-w-3xl text-sm leading-relaxed text-slate-600">
                Aplikasi Galeri Sekolah ini dibangun untuk mengelola album, foto, komentar, laporan, pengguna, dan lokasi sekolah. Berikut adalah tumpuan teknologi (tech stack) yang digunakan dalam aplikasi ini.
            </p>
        </section>

        <section>
            <h2 class="mb-3 text-sm font-semibold text-slate-900">Teknologi yang digunakan</h2>
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <span class="grid size-10 place-items-center rounded-xl bg-rose-50 text-rose-600"><i data-lucide="layers" class="size-5"></i></span>
                    <h3 class="mt-4 text-sm font-semibold text-slate-900">Laravel</h3>
                    <p class="mt-1 text-xs leading-relaxed text-slate-500">Framework PHP backend yang menangani routing, autentikasi, validasi, dan logika aplikasi.</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <span class="grid size-10 place-items-center rounded-xl bg-violet-50 text-violet-600"><i data-lucide="code-xml" class="size-5"></i></span>
                    <h3 class="mt-4 text-sm font-semibold text-slate-900">Blade</h3>
                    <p class="mt-1 text-xs leading-relaxed text-slate-500">Template engine Laravel untuk merender halaman publik dan panel administrator secara dinamis.</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <span class="grid size-10 place-items-center rounded-xl bg-sky-50 text-sky-600"><i data-lucide="database" class="size-5"></i></span>
                    <h3 class="mt-4 text-sm font-semibold text-slate-900">MySQL</h3>
                    <p class="mt-1 text-xs leading-relaxed text-slate-500">Sistem basis data relasional untuk menyimpan album, foto, komentar, laporan, dan pengguna.</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <span class="grid size-10 place-items-center rounded-xl bg-teal-50 text-teal-600"><i data-lucide="palette" class="size-5"></i></span>
                    <h3 class="mt-4 text-sm font-semibold text-slate-900">Tailwind CSS</h3>
                    <p class="mt-1 text-xs leading-relaxed text-slate-500">Utility-first CSS framework yang digunakan untuk seluruh tampilan dan responsivitas antarmuka.</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <span class="grid size-10 place-items-center rounded-xl bg-amber-50 text-amber-600"><i data-lucide="braces" class="size-5"></i></span>
                    <h3 class="mt-4 text-sm font-semibold text-slate-900">Vanilla JS</h3>
                    <p class="mt-1 text-xs leading-relaxed text-slate-500">JavaScript tanpa framework untuk interaksi ringan seperti pratinjau gambar, konfirmasi hapus, dan menu.</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <span class="grid size-10 place-items-center rounded-xl bg-slate-100 text-slate-600"><i data-lucide="hard-drive" class="size-5"></i></span>
                    <h3 class="mt-4 text-sm font-semibold text-slate-900">Laravel Storage</h3>
                    <p class="mt-1 text-xs leading-relaxed text-slate-500">Abstraksi penyimpanan file untuk mengelola unggahan gambar album, foto, dan lokasi.</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <span class="grid size-10 place-items-center rounded-xl bg-emerald-50 text-emerald-600"><i data-lucide="map" class="size-5"></i></span>
                    <h3 class="mt-4 text-sm font-semibold text-slate-900">Leaflet.js + OpenStreetMap</h3>
                    <p class="mt-1 text-xs leading-relaxed text-slate-500">Peta interaktif berbasis peta terbuka untuk menampilkan titik-titik lokasi sekolah.</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <span class="grid size-10 place-items-center rounded-xl bg-orange-50 text-orange-600"><i data-lucide="zap" class="size-5"></i></span>
                    <h3 class="mt-4 text-sm font-semibold text-slate-900">Vite</h3>
                    <p class="mt-1 text-xs leading-relaxed text-slate-500">Build tool modern yang mengompilasi aset CSS dan JavaScript aplikasi dengan cepat.</p>
                </div>
            </div>
        </section>

        <section class="grid gap-4 lg:grid-cols-2">
            <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5">
                <div class="flex items-start gap-3">
                    <i data-lucide="paperclip" class="mt-0.5 size-5 shrink-0 text-amber-600"></i>
                    <div>
                        <h3 class="text-sm font-semibold text-amber-900">Akses gambar hasil unggahan</h3>
                        <p class="mt-1 text-xs leading-relaxed text-amber-800">
                            Jalankan <code class="rounded bg-white/70 px-1.5 py-0.5 font-mono text-[11px] text-amber-900">php artisan storage:link</code> agar gambar yang disimpan melalui Laravel Storage dapat ditampilkan dari direktori publik.
                        </p>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl border border-sky-200 bg-sky-50 p-5">
                <div class="flex items-start gap-3">
                    <i data-lucide="file-cog" class="mt-0.5 size-5 shrink-0 text-sky-600"></i>
                    <div>
                        <h3 class="text-sm font-semibold text-sky-900">Koneksi basis data</h3>
                        <p class="mt-1 text-xs leading-relaxed text-sky-800">
                            Koneksi database diatur melalui berkas <code class="rounded bg-white/70 px-1.5 py-0.5 font-mono text-[11px] text-sky-900">.env</code>. Pastikan pengaturan <code class="rounded bg-white/70 px-1.5 py-0.5 font-mono text-[11px] text-sky-900">DB_*</code> sesuai dengan lingkungan server Anda.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
