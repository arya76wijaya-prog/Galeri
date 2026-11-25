@extends('layouts.admin')

@section('title', 'Kelola Lokasi')
@section('heading', 'Lokasi Sekolah')
@section('subheading', 'Kelola titik lokasi yang ditampilkan pada peta sekolah')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <p class="text-sm text-slate-600">Total {{ $locations->total() }} lokasi terdaftar.</p>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.school-locations.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700">
                    <i data-lucide="map-pin-plus" class="size-4"></i> Tambah Lokasi
                </a>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-4 py-3">Gambar</th>
                            <th class="px-4 py-3">Lokasi</th>
                            <th class="px-4 py-3">Koordinat</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Dibuat</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($locations as $location)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3">
                                    @if ($location->image_url)
                                        <img src="{{ $location->image_url }}" alt="{{ $location->name }}" class="size-14 rounded-lg border border-slate-200 object-cover">
                                    @else
                                        <div class="grid size-14 place-items-center rounded-lg bg-slate-100 text-slate-400">
                                            <i data-lucide="map-pin" class="size-5"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="max-w-64 px-4 py-3">
                                    <p class="font-medium text-slate-800">{{ $location->name }}</p>
                                    <p class="mt-0.5 line-clamp-2 text-xs text-slate-500">{{ $location->description ?: '-' }}</p>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-xs text-slate-600">
                                    <span class="inline-flex items-center gap-1"><i data-lucide="navigation" class="size-3.5 text-slate-400"></i> {{ $location->latitude }}, {{ $location->longitude }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    @if ($location->status === 'active')
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700">Aktif</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-rose-50 px-2 py-0.5 text-xs font-medium text-rose-700">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-xs text-slate-500">{{ $location->created_at?->format('d M Y') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.school-locations.edit', $location) }}" class="inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50" aria-label="Edit lokasi">
                                            <i data-lucide="pencil" class="size-4"></i> Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.school-locations.destroy', $location) }}" data-confirm="Hapus lokasi ini?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 rounded-lg border border-rose-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-rose-600 hover:bg-rose-50" aria-label="Hapus lokasi">
                                                <i data-lucide="trash-2" class="size-4"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-sm text-slate-400">Belum ada lokasi terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-100 px-4 py-3">
                {{ $locations->links() }}
            </div>
        </div>
    </div>
@endsection
