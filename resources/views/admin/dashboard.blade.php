@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('heading', 'Dashboard')
@section('subheading', 'Ringkasan aktivitas galeri sekolah')

@section('content')
    @php
        $statCards = [
            ['label' => 'Album', 'value' => $stats['albums'], 'icon' => 'folder-open', 'tone' => 'bg-brand-50 text-brand-600'],
            ['label' => 'Foto', 'value' => $stats['photos'], 'icon' => 'images', 'tone' => 'bg-sky-50 text-sky-600'],
            ['label' => 'Pengguna', 'value' => $stats['users'], 'icon' => 'users', 'tone' => 'bg-violet-50 text-violet-600'],
            ['label' => 'Lokasi', 'value' => $stats['locations'], 'icon' => 'map-pin', 'tone' => 'bg-teal-50 text-teal-600'],
            ['label' => 'Komentar pending', 'value' => $stats['pending_comments'], 'icon' => 'message-square', 'tone' => 'bg-amber-50 text-amber-600'],
            ['label' => 'Laporan pending', 'value' => $stats['pending_reports'], 'icon' => 'flag', 'tone' => 'bg-rose-50 text-rose-600'],
        ];
    @endphp

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
        @foreach ($statCards as $stat)
            <div class="flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <span class="grid size-11 shrink-0 place-items-center rounded-xl {{ $stat['tone'] }}">
                    <i data-lucide="{{ $stat['icon'] }}" class="size-5"></i>
                </span>
                <div>
                    <p class="text-2xl font-semibold text-slate-900">{{ $stat['value'] }}</p>
                    <p class="text-xs font-medium text-slate-500">{{ $stat['label'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6 flex flex-wrap items-center gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <p class="mr-auto text-sm font-semibold text-slate-700">Aksi cepat</p>
        <a href="{{ route('admin.albums.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700">
            <i data-lucide="folder-plus" class="size-4"></i> Tambah Album
        </a>
        <a href="{{ route('admin.photos.create') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
            <i data-lucide="image-plus" class="size-4"></i> Unggah Foto
        </a>
        <a href="{{ route('admin.school-locations.create') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
            <i data-lucide="map-pin-plus" class="size-4"></i> Tambah Lokasi
        </a>
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-3">
        <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                <div>
                    <h2 class="text-sm font-semibold text-slate-900">Album terbaru</h2>
                    <p class="mt-0.5 text-xs text-slate-500">Album yang baru dibuat</p>
                </div>
                <a href="{{ route('admin.albums.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-brand-600 hover:text-brand-700">
                    Lihat semua <i data-lucide="arrow-right" class="size-4"></i>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-5 py-3">Album</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Dibuat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($recentAlbums as $album)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-3">
                                    <a href="{{ route('admin.albums.edit', $album) }}" class="font-medium text-slate-800 hover:text-brand-600">{{ $album->title }}</a>
                                    <p class="mt-0.5 text-xs text-slate-400">{{ $album->slug }}</p>
                                </td>
                                <td class="px-5 py-3">
                                    @if ($album->status === 'published')
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700">Published</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-amber-50 px-2 py-0.5 text-xs font-medium text-amber-700">Draft</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-5 py-3 text-xs text-slate-500">{{ $album->created_at?->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-5 py-8 text-center text-sm text-slate-400">Belum ada album.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                <div>
                    <h2 class="text-sm font-semibold text-slate-900">Komentar terbaru</h2>
                    <p class="mt-0.5 text-xs text-slate-500">Aktivitas komentar pengunjung</p>
                </div>
                <a href="{{ route('admin.comments.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-brand-600 hover:text-brand-700">
                    Lihat semua <i data-lucide="arrow-right" class="size-4"></i>
                </a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($recentComments as $comment)
                    <div class="px-5 py-4">
                        <p class="line-clamp-2 text-sm text-slate-700">{{ $comment->content }}</p>
                        <div class="mt-2 flex flex-wrap items-center gap-2 text-xs text-slate-500">
                            <span class="font-medium text-slate-600">{{ $comment->user?->name ?? 'Pengguna' }}</span>
                            <span class="text-slate-300">&bull;</span>
                            <span>{{ $comment->photo?->album?->title ?? 'Album tidak tersedia' }}</span>
                            @if ($comment->status === 'pending')
                                <span class="inline-flex items-center rounded-full bg-amber-50 px-2 py-0.5 text-xs font-medium text-amber-700">Pending</span>
                            @elseif ($comment->status === 'approved')
                                <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700">Disetujui</span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-rose-50 px-2 py-0.5 text-xs font-medium text-rose-700">Ditolak</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="px-5 py-8 text-center text-sm text-slate-400">Belum ada komentar.</p>
                @endforelse
            </div>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                <div>
                    <h2 class="text-sm font-semibold text-slate-900">Laporan pending</h2>
                    <p class="mt-0.5 text-xs text-slate-500">Perlu ditinjau administrator</p>
                </div>
                <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-brand-600 hover:text-brand-700">
                    Lihat semua <i data-lucide="arrow-right" class="size-4"></i>
                </a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($pendingReports as $report)
                    <a href="{{ route('admin.reports.show', $report) }}" class="block px-5 py-4 hover:bg-slate-50">
                        <div class="flex items-start gap-3">
                            <span class="grid size-8 shrink-0 place-items-center rounded-lg bg-rose-50 text-rose-600">
                                <i data-lucide="flag" class="size-4"></i>
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-slate-800">{{ $report->reason_label ?? $report->reason }}</p>
                                <p class="mt-0.5 truncate text-xs text-slate-500">{{ $report->photo?->album?->title ?? 'Album tidak tersedia' }}</p>
                                <p class="mt-1 text-xs text-slate-400">Oleh {{ $report->user?->name ?? 'Pengguna' }} &bull; {{ $report->created_at?->format('d M Y') }}</p>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="px-5 py-8 text-center text-sm text-slate-400">Tidak ada laporan pending.</p>
                @endforelse
            </div>
        </section>
    </div>
@endsection
