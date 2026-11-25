@extends('layouts.admin')

@section('title', 'Kelola Komentar')
@section('heading', 'Komentar')
@section('subheading', 'Tinjau dan moderasi komentar pengunjung')

@section('content')
    <div class="space-y-6">
        <form method="GET" action="{{ route('admin.comments.index') }}" class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end">
                <div class="flex-1">
                    <label for="q" class="block text-xs font-semibold text-slate-600">Cari komentar</label>
                    <input type="text" id="q" name="q" value="{{ $search }}" placeholder="Cari kata dalam komentar..." class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 placeholder:text-slate-400 focus:border-brand-500 focus:ring-brand-500">
                </div>
                <div class="sm:w-48">
                    <label for="status" class="block text-xs font-semibold text-slate-600">Status</label>
                    <select id="status" name="status" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 focus:border-brand-500 focus:ring-brand-500">
                        @foreach (['' => 'Semua status', 'pending' => 'Pending', 'approved' => 'Disetujui', 'rejected' => 'Ditolak'] as $value => $label)
                            <option value="{{ $value }}" {{ (string) $status === (string) $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700">
                    <i data-lucide="filter" class="size-4"></i> Filter
                </button>
                <a href="{{ route('admin.comments.index') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    <i data-lucide="rotate-ccw" class="size-4"></i> Reset
                </a>
            </div>
        </form>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-4 py-3">Komentar</th>
                            <th class="px-4 py-3">Foto / Album</th>
                            <th class="px-4 py-3">Pengguna</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($comments as $comment)
                            <tr class="hover:bg-slate-50">
                                <td class="max-w-72 px-4 py-3 text-slate-700">
                                    <span class="line-clamp-3">{{ $comment->content }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-slate-600">{{ $comment->photo?->album?->title ?? 'Album tidak tersedia' }}</p>
                                    <p class="mt-0.5 text-xs text-slate-400">Foto #{{ $comment->photo_id }}</p>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-slate-600">{{ $comment->user?->name ?? 'Pengguna' }}</td>
                                <td class="px-4 py-3">
                                    @if ($comment->status === 'pending')
                                        <span class="inline-flex items-center rounded-full bg-amber-50 px-2 py-0.5 text-xs font-medium text-amber-700">Pending</span>
                                    @elseif ($comment->status === 'approved')
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700">Disetujui</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-rose-50 px-2 py-0.5 text-xs font-medium text-rose-700">Ditolak</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-xs text-slate-500">{{ $comment->created_at?->format('d M Y H:i') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap items-center justify-end gap-2">
                                        <form method="POST" action="{{ route('admin.comments.approve', $comment) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center gap-1 rounded-lg border border-emerald-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-emerald-700 hover:bg-emerald-50">
                                                <i data-lucide="check" class="size-4"></i> Setujui
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.comments.reject', $comment) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center gap-1 rounded-lg border border-amber-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-amber-700 hover:bg-amber-50">
                                                <i data-lucide="x" class="size-4"></i> Tolak
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}" data-confirm="Hapus komentar ini?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 rounded-lg border border-rose-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-rose-600 hover:bg-rose-50" aria-label="Hapus komentar">
                                                <i data-lucide="trash-2" class="size-4"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-sm text-slate-400">Tidak ada komentar yang cocok dengan pencarian Anda.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-100 px-4 py-3">
                {{ $comments->links() }}
            </div>
        </div>
    </div>
@endsection
