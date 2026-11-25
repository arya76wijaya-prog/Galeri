@extends('layouts.admin')

@section('title', 'Detail Laporan')
@section('heading', 'Detail Laporan')
@section('subheading', 'Periksa laporan dan perbarui status peninjauan')

@section('content')
    <div class="space-y-6">
        <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-brand-600">
            <i data-lucide="arrow-left" class="size-4"></i> Kembali ke daftar laporan
        </a>

        <div class="grid gap-6 xl:grid-cols-3">
            <div class="space-y-6 xl:col-span-2">
                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-sm font-semibold text-slate-900">Foto yang dilaporkan</h2>
                    <div class="mt-5 flex flex-wrap items-start gap-5">
                        @if ($report->photo?->image_url)
                            <img src="{{ $report->photo->image_url }}" alt="Foto yang dilaporkan" class="size-40 rounded-xl border border-slate-200 object-cover">
                        @else
                            <div class="grid size-40 place-items-center rounded-xl border border-dashed border-slate-300 bg-slate-50 text-slate-400">
                                <i data-lucide="image-off" class="size-8"></i>
                            </div>
                        @endif
                        <dl class="min-w-56 flex-1 space-y-3 text-sm">
                            <div>
                                <dt class="text-xs font-semibold text-slate-500">Album</dt>
                                <dd class="mt-0.5 text-slate-800">{{ $report->photo?->album?->title ?? 'Album tidak tersedia' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold text-slate-500">Keterangan foto</dt>
                                <dd class="mt-0.5 text-slate-700">{{ $report->photo?->caption ?: '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold text-slate-500">ID foto</dt>
                                <dd class="mt-0.5 text-slate-700">#{{ $report->photo_id }}</dd>
                            </div>
                        </dl>
                    </div>
                </section>

                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-sm font-semibold text-slate-900">Detail laporan</h2>
                    <dl class="mt-5 grid gap-4 text-sm sm:grid-cols-2">
                        <div>
                            <dt class="text-xs font-semibold text-slate-500">Alasan</dt>
                            <dd class="mt-0.5 font-medium text-slate-800">{{ $report->reason_label }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold text-slate-500">Kode alasan</dt>
                            <dd class="mt-0.5 text-slate-700">{{ $report->reason }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold text-slate-500">Pelapor</dt>
                            <dd class="mt-0.5 text-slate-800">{{ $report->user?->name ?? 'Pengguna' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold text-slate-500">Waktu dilaporkan</dt>
                            <dd class="mt-0.5 text-slate-700">{{ $report->created_at?->format('d M Y H:i') }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-xs font-semibold text-slate-500">Deskripsi tambahan</dt>
                            <dd class="mt-1 whitespace-pre-line rounded-lg bg-slate-50 p-3 text-slate-700">{{ $report->description ?: 'Tidak ada deskripsi tambahan.' }}</dd>
                        </div>
                    </dl>
                </section>
            </div>

            <div class="space-y-6">
                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-sm font-semibold text-slate-900">Status peninjauan</h2>
                    <ol class="mt-5 space-y-4 text-sm">
                        <li class="flex gap-3">
                            <span class="mt-0.5 grid size-6 shrink-0 place-items-center rounded-full bg-slate-100 text-slate-500">
                                <i data-lucide="flag" class="size-3.5"></i>
                            </span>
                            <div>
                                <p class="font-medium text-slate-800">Laporan dibuat</p>
                                <p class="mt-0.5 text-xs text-slate-500">{{ $report->created_at?->format('d M Y H:i') }}</p>
                            </div>
                        </li>
                        <li class="flex gap-3">
                            <span class="mt-0.5 grid size-6 shrink-0 place-items-center rounded-full {{ $report->reviewed_at ? 'bg-brand-50 text-brand-600' : 'bg-slate-100 text-slate-400' }}">
                                <i data-lucide="eye" class="size-3.5"></i>
                            </span>
                            <div>
                                <p class="font-medium text-slate-800">Ditinjau</p>
                                @if ($report->reviewed_at)
                                    <p class="mt-0.5 text-xs text-slate-500">Oleh {{ $report->reviewer?->name ?? 'Administrator' }} &bull; {{ $report->reviewed_at?->format('d M Y H:i') }}</p>
                                @else
                                    <p class="mt-0.5 text-xs text-slate-400">Belum ditinjau</p>
                                @endif
                            </div>
                        </li>
                        <li class="flex gap-3">
                            <span class="mt-0.5 grid size-6 shrink-0 place-items-center rounded-full bg-slate-100 text-slate-500">
                                <i data-lucide="circle-check" class="size-3.5"></i>
                            </span>
                            <div>
                                <p class="font-medium text-slate-800">Status saat ini</p>
                                @if ($report->status === 'pending')
                                    <span class="mt-1 inline-flex items-center rounded-full bg-amber-50 px-2 py-0.5 text-xs font-medium text-amber-700">Pending</span>
                                @elseif ($report->status === 'reviewed')
                                    <span class="mt-1 inline-flex items-center rounded-full bg-sky-50 px-2 py-0.5 text-xs font-medium text-sky-700">Ditinjau</span>
                                @elseif ($report->status === 'resolved')
                                    <span class="mt-1 inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700">Selesai</span>
                                @else
                                    <span class="mt-1 inline-flex items-center rounded-full bg-rose-50 px-2 py-0.5 text-xs font-medium text-rose-700">Ditolak</span>
                                @endif
                            </div>
                        </li>
                    </ol>
                </section>

                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-sm font-semibold text-slate-900">Perbarui status</h2>
                    <form method="POST" action="{{ route('admin.reports.update', $report) }}" class="mt-5 space-y-4">
                        @csrf
                        @method('PATCH')
                        <div>
                            <label for="status" class="block text-xs font-semibold text-slate-600">Status</label>
                            <select id="status" name="status" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 focus:border-brand-500 focus:ring-brand-500">
                                @foreach (['pending' => 'Pending', 'reviewed' => 'Ditinjau', 'resolved' => 'Selesai', 'rejected' => 'Ditolak'] as $value => $label)
                                    <option value="{{ $value }}" {{ old('status', $report->status) === $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="review_note" class="block text-xs font-semibold text-slate-600">Catatan peninjauan (opsional)</label>
                            <textarea id="review_note" name="review_note" rows="3" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 placeholder:text-slate-400 focus:border-brand-500 focus:ring-brand-500" placeholder="Tuliskan catatan peninjauan...">{{ old('review_note') }}</textarea>
                            <p class="mt-1 text-xs text-slate-400">Catatan ini hanya untuk referensi dan tidak disimpan.</p>
                        </div>
                        <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700">
                            <i data-lucide="save" class="size-4"></i> Simpan status
                        </button>
                    </form>
                </section>

                <section class="rounded-2xl border border-rose-200 bg-white p-6 shadow-sm">
                    <h2 class="text-sm font-semibold text-rose-700">Hapus laporan</h2>
                    <p class="mt-1 text-xs text-slate-500">Laporan yang dihapus tidak dapat dikembalikan.</p>
                    <form method="POST" action="{{ route('admin.reports.destroy', $report) }}" data-confirm="Hapus laporan ini?" class="mt-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-2 rounded-lg border border-rose-200 bg-white px-4 py-2 text-sm font-semibold text-rose-600 hover:bg-rose-50">
                            <i data-lucide="trash-2" class="size-4"></i> Hapus laporan
                        </button>
                    </form>
                </section>
            </div>
        </div>
    </div>
@endsection
