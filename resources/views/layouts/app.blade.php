<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Galeri Sekolah — dokumentasi kegiatan, fasilitas, dan prestasi sekolah.">
    <title>@yield('title', config('app.name'))</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js" defer></script>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased flex flex-col">
    <header class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/90 backdrop-blur">
        <nav class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8" aria-label="Navigasi utama">
            <a href="{{ route('home') }}" class="flex items-center gap-2 font-semibold text-slate-900">
                <span class="grid size-9 shrink-0 place-items-center overflow-hidden rounded-xl bg-white shadow-sm">
                    <img src="/images/logo-dwiguna.webp" alt="Logo SMK TI Dwiguna" class="size-full object-contain">
                </span>
                <span class="text-lg tracking-tight">Galeri<span class="text-brand-600">Sekolah</span></span>
            </a>

            <div class="hidden items-center gap-1 md:flex">
                <a href="{{ route('home') }}" class="rounded-lg px-3 py-2 text-sm font-medium transition hover:bg-slate-100 hover:text-brand-700 {{ request()->routeIs('home') ? 'text-brand-700' : 'text-slate-600' }}">Beranda</a>
                <a href="{{ route('gallery.index') }}" class="rounded-lg px-3 py-2 text-sm font-medium transition hover:bg-slate-100 hover:text-brand-700 {{ request()->routeIs('gallery.*') ? 'text-brand-700' : 'text-slate-600' }}">Galeri</a>
                <a href="{{ route('about') }}" class="rounded-lg px-3 py-2 text-sm font-medium transition hover:bg-slate-100 hover:text-brand-700 {{ request()->routeIs('about') ? 'text-brand-700' : 'text-slate-600' }}">Tentang</a>
                <a href="{{ route('home') }}#peta" class="rounded-lg px-3 py-2 text-sm font-medium transition hover:bg-slate-100 hover:text-brand-700 {{ request()->routeIs('home') ? 'text-brand-700' : 'text-slate-600' }}">
                    Maps
                </a>
            </div>

            <div class="hidden items-center gap-2 md:flex">
                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">
                            <i data-lucide="layout-dashboard" class="size-4"></i> Dashboard
                        </a>
                    @endif
                    <a href="{{ route('profile.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:border-brand-300 hover:text-brand-700">
                        <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="size-6 rounded-full object-cover">
                        <span class="max-w-28 truncate">{{ auth()->user()->name }}</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-500 transition hover:bg-slate-100 hover:text-rose-600">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:text-brand-700">Masuk</a>
                @endauth
            </div>

            <button id="mobile-menu-button" type="button" class="grid size-10 place-items-center rounded-lg border border-slate-200 text-slate-600 md:hidden" aria-label="Buka menu" aria-expanded="false">
                <i data-lucide="menu" class="size-5"></i>
            </button>
        </nav>

        <div id="mobile-menu" class="hidden border-t border-slate-200 bg-white px-4 py-3 md:hidden">
            <div class="flex flex-col gap-1">
                <a href="{{ route('home') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100">Beranda</a>
                <a href="{{ route('gallery.index') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100">Galeri</a>
                <a href="{{ route('about') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100">Tentang</a>
                <div class="my-2 border-t border-slate-100"></div>
                @auth
                    <a href="{{ route('profile.index') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100">Profil Saya</a>
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-brand-700 hover:bg-brand-50">Dashboard Admin</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full rounded-lg px-3 py-2 text-left text-sm font-medium text-rose-600 hover:bg-rose-50">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100">Masuk</a>
                @endauth
            </div>
        </div>
    </header>

    @include('partials.alerts')

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-3 px-4 py-8 text-sm text-slate-500 sm:flex-row sm:px-6 lg:px-8">
            <p>&copy; {{ date('Y') }} Galeri Sekolah. Dokumentasi kegiatan sekolah.</p>

            <div class="flex items-center gap-3">
                <a href="#" class="text-slate-500 hover:text-brand-600 transition" aria-label="Instagram">
                    <i data-lucide="instagram" class="size-5"></i>
                </a>
                <a href="#" class="text-slate-500 hover:text-brand-600 transition" aria-label="YouTube">
                    <i data-lucide="youtube" class="size-5"></i>
                </a>
                <a href="#" class="text-slate-500 hover:text-brand-600 transition" aria-label="TikTok">
                    <i data-lucide="tiktok" class="size-5"></i>
                </a>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
