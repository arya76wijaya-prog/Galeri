@extends('layouts.admin')

@section('title', 'Kelola Laporan')
@section('heading', 'Laporan')
@section('subheading', 'Tinjau laporan konten dari pengguna')

@section('content')
    <div class="space-y-6">
        <form method="GET" action="{{ route('admin.reports.index') }}" class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end">
                <div class="sm:w-64">
                    <label for="status" class="block text-xs font-semibold text-slate-600">Status</label>
                    <select id="status" name="status" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 focus:border-brand-500 focus:ring-brand-500">
                        @foreach (['' => 'Semua status', 'pending' => 'Pending', 'reviewed' => 'Ditinjau', 'resolved' => 'Selesai', 'rejected' => 'Ditolak'] as $value => $label)
                            <option value="{{ $value }}" {{ (string) $status === (string) $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700">
                    <i data-lucide="filter" class="size-4"></i> Filter
                </button>
                <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    <i data-lucide="rotate-ccw" class="size-4"></i> Reset
                </a>
            </div>
        </form>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-4 py-3">Alasan</th>
                            <th class="px-4 py-3">Foto / Album</th>
                            <th class="px-4 py-3">Pelapor</th>
                            <th class="px-4 py-3">Peninjau</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Dilaporkan</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($reports as $report)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3">
                                    <p class="font-medium text-slate-800">{{ $report->reason_label }}</p>
                                    <p class="mt-0.5 text-xs text-slate-400">{{ $report->reason }}</p>
                                </td>
                                <td class="px-4 py-3 text-slate-600">{{ $report->photo?->album?->title ?? 'Album tidak tersedia' }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-slate-600">{{ $report->user?->name ?? 'Pengguna' }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-slate-600">
                                    {{ $report->reviewer?->name ?? '-' }}
                                    @if ($report->reviewed_at)
                                        <p class="mt-0.5 text-xs text-slate-400">{{ $report->reviewed_at?->format('d M Y H:i') }}</p>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if ($report->status === 'pending')
                                        <span class="inline-flex items-center rounded-full bg-amber-50 px-2 py-0.5 text-xs font-medium text-amber-700">Pending</span>
                                    @elseif ($report->status === 'reviewed')
                                        <span class="inline-flex items-center rounded-full bg-sky-50 px-2 py-0.5 text-xs font-medium text-sky-700">Ditinjau</span>
                                    @elseif ($report->status === 'resolved')
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700">Selesai</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-rose-50 px-2 py-0.5 text-xs font-medium text-rose-700">Ditolak</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-xs text-slate-500">{{ $report->created_at?->format('d M Y H:i') }}</td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('admin.reports.show', $report) }}" class="inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                        <i data-lucide="eye" class="size-4"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center text-sm text-slate-400">Tidak ada laporan dengan status tersebut.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-100 px-4 py-3">
                {{ $reports->links() }}
            </div>
        </div>
    </div>
@endsection
