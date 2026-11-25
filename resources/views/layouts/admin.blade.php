<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Galeri Sekolah')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js" defer></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 antialiased">
    @php
        $navItems = [
            ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'layout-dashboard', 'pattern' => 'admin.dashboard'],
            ['route' => 'admin.albums.index', 'label' => 'Album', 'icon' => 'folder-open', 'pattern' => 'admin.albums.*'],
            ['route' => 'admin.photos.index', 'label' => 'Foto', 'icon' => 'images', 'pattern' => 'admin.photos.*'],
            ['route' => 'admin.comments.index', 'label' => 'Komentar', 'icon' => 'message-square', 'pattern' => 'admin.comments.*'],
            ['route' => 'admin.reports.index', 'label' => 'Laporan', 'icon' => 'flag', 'pattern' => 'admin.reports.*'],
            ['route' => 'admin.users.index', 'label' => 'Pengguna', 'icon' => 'users', 'pattern' => 'admin.users.*'],
            ['route' => 'admin.school-locations.index', 'label' => 'Lokasi', 'icon' => 'map-pin', 'pattern' => 'admin.school-locations.*'],
        ];
    @endphp

    <button id="sidebar-overlay" type="button" class="fixed inset-0 z-30 hidden bg-slate-900/50 lg:hidden" aria-label="Tutup sidebar"></button>

    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 flex w-64 -translate-x-full flex-col border-r border-slate-800 bg-slate-900 text-slate-300 transition-transform duration-200 lg:translate-x-0">
        <div class="flex h-16 items-center gap-2 border-b border-slate-800 px-5">
            <span class="grid size-9 place-items-center rounded-xl bg-brand-600 text-white">
                <i data-lucide="images" class="size-5"></i>
            </span>
            <div>
                <p class="text-sm font-semibold text-white">Galeri Sekolah</p>
                <p class="text-xs text-slate-400">Panel Administrator</p>
            </div>
        </div>

        <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
            @foreach ($navItems as $item)
                <a href="{{ route($item['route']) }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs($item['pattern']) ? 'bg-brand-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i data-lucide="{{ $item['icon'] }}" class="size-4"></i>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <div class="border-t border-slate-800 p-3">
            <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white">
                <i data-lucide="external-link" class="size-4"></i> Lihat Website
            </a>
        </div>
    </aside>

    <div class="lg:pl-64">
        <header class="sticky top-0 z-20 flex h-16 items-center justify-between border-b border-slate-200 bg-white px-4 sm:px-6">
            <div class="flex items-center gap-3">
                <button id="sidebar-toggle" type="button" class="grid size-10 place-items-center rounded-lg border border-slate-200 text-slate-600 lg:hidden" aria-label="Buka sidebar">
                    <i data-lucide="menu" class="size-5"></i>
                </button>
                <div>
                    <h1 class="text-base font-semibold text-slate-900 sm:text-lg">@yield('heading', 'Admin')</h1>
                    <p class="hidden text-xs text-slate-500 sm:block">@yield('subheading', 'Kelola konten galeri sekolah')</p>
                </div>
            </div>

            <div class="relative">
                <button id="user-menu-button" type="button" class="flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-2 py-1.5 text-sm font-medium text-slate-700 hover:bg-slate-50" aria-expanded="false">
                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="size-7 rounded-full object-cover">
                    <span class="hidden max-w-32 truncate sm:inline">{{ auth()->user()->name }}</span>
                    <i data-lucide="chevron-down" class="size-4 text-slate-400"></i>
                </button>
                <div id="user-menu" class="absolute right-0 top-full mt-2 hidden w-52 rounded-xl border border-slate-200 bg-white p-1.5 shadow-lg">
                    <a href="{{ route('profile.index') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm text-slate-600 hover:bg-slate-50">
                        <i data-lucide="user" class="size-4"></i> Profil Saya
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left text-sm text-rose-600 hover:bg-rose-50">
                            <i data-lucide="log-out" class="size-4"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </header>

        @include('partials.alerts')

        <main class="p-4 sm:p-6">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
