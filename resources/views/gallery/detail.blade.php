@extends('layouts.app')

@section('title', $album->title.' — Galeri Sekolah')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 lg:py-10">
        {{-- Breadcrumb --}}
        <nav aria-label="Breadcrumb" class="mb-6 flex flex-wrap items-center gap-2 text-sm text-slate-500">
            <a href="{{ route('gallery.index') }}" class="inline-flex items-center gap-1 transition hover:text-brand-700">
                <i data-lucide="images" class="size-4"></i>
                Galeri
            </a>
            <i data-lucide="chevron-right" class="size-4 text-slate-300"></i>
            <span class="font-medium text-slate-800">{{ $album->title }}</span>
        </nav>

        {{-- Album header --}}
        <section class="mb-12 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm lg:grid lg:grid-cols-[minmax(0,1fr)_minmax(0,1.25fr)]">
            <div class="relative aspect-[4/3] overflow-hidden bg-slate-100 lg:aspect-auto lg:h-full lg:min-h-72">
                @if ($album->cover_url)
                    <img src="{{ $album->cover_url }}" alt="{{ $album->title }}" class="size-full object-cover">
                @else
                    <div class="grid size-full place-items-center bg-gradient-to-br from-brand-50 to-brand-100 text-brand-400">
                        <i data-lucide="image-off" class="size-12"></i>
                    </div>
                @endif
            </div>

            <div class="p-6 sm:p-8 lg:p-10">
                <div class="flex flex-wrap items-center gap-2">
                    @if ($album->category)
                        <span class="inline-flex items-center gap-1 rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-700">
                            <i data-lucide="tag" class="size-3.5"></i>
                            {{ $album->category }}
                        </span>
                    @endif
                    @if ($album->event_date)
                        <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">
                            <i data-lucide="calendar-days" class="size-3.5"></i>
                            {{ $album->event_date->translatedFormat('d F Y') }}
                        </span>
                    @endif
                </div>

                <h1 class="mt-4 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">{{ $album->title }}</h1>

                @if ($album->description)
                    <p class="mt-4 max-w-2xl text-sm leading-relaxed text-slate-600 sm:text-base">{{ $album->description }}</p>
                @endif

                <div class="mt-7 flex flex-wrap items-center gap-x-6 gap-y-3 border-t border-slate-100 pt-6 text-sm text-slate-500">
                    <span class="inline-flex items-center gap-2">
                        <i data-lucide="camera" class="size-4 text-brand-600"></i>
                        {{ $album->photos_count }} foto
                    </span>
                    @if ($album->creator)
                        <span class="inline-flex items-center gap-2">
                            <i data-lucide="user-round" class="size-4 text-brand-600"></i>
                            Diunggah oleh <span class="font-medium text-slate-700">{{ $album->creator->name }}</span>
                        </span>
                    @endif
                </div>
            </div>
        </section>

        {{-- Photos --}}
        <section>
            <div class="mb-6 flex flex-wrap items-end justify-between gap-3">
                <div>
                    <h2 class="text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">Foto dalam album</h2>
                    <p class="mt-1 text-sm text-slate-500">Klik foto untuk melihat tampilan penuh.</p>
                </div>
                <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-slate-600 shadow-sm ring-1 ring-slate-200">{{ $photos->total() }} foto</span>
            </div>

            @if ($photos->count())
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($photos as $photo)
                        <article class="flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                            {{-- Image opens shared lightbox --}}
                            <button type="button" data-open-modal="photo-lightbox" data-modal-full="{{ $photo->image_url }}" data-modal-caption="{{ $photo->caption ?? $album->title }}" class="group relative block w-full overflow-hidden bg-slate-100" aria-label="Lihat foto {{ $photo->caption ?? $album->title }}">
                                <img src="{{ $photo->image_url }}" alt="{{ $photo->caption ?? $album->title }}" loading="lazy" class="aspect-[4/3] w-full object-cover transition duration-500 group-hover:scale-105">
                                <span class="absolute bottom-3 right-3 grid size-9 place-items-center rounded-full bg-slate-900/60 text-white opacity-0 backdrop-blur transition group-hover:opacity-100">
                                    <i data-lucide="maximize-2" class="size-4"></i>
                                </span>
                            </button>

                            <div class="flex flex-1 flex-col p-4">
                                @if ($photo->caption)
                                    <p class="text-sm font-medium leading-relaxed text-slate-800">{{ $photo->caption }}</p>
                                @endif

                                <div class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-slate-500">
                                    <span class="inline-flex items-center gap-1">
                                        <i data-lucide="heart" class="size-3.5"></i>
                                        <span id="like-count-{{ $photo->id }}">{{ $photo->likes_count }}</span> suka
                                    </span>
                                    <span class="inline-flex items-center gap-1">
                                        <i data-lucide="message-circle" class="size-3.5"></i>
                                        {{ $photo->visible_comments_count }} komentar
                                    </span>
                                </div>

                                {{-- Approved comments --}}
                                @if ($photo->publicComments->count())
                                    <ul class="mt-3 space-y-3 border-t border-slate-100 pt-3">
                                        @foreach ($photo->publicComments as $comment)
                                            <li class="flex items-start justify-between gap-2">
                                                <div class="min-w-0">
                                                    <p class="flex flex-wrap items-baseline gap-x-2 text-xs">
                                                        <span class="font-semibold text-slate-800">{{ $comment->user?->name ?? 'Pengunjung' }}</span>
                                                        <span class="text-slate-400">{{ $comment->created_at->diffForHumans() }}</span>
                                                    </p>
                                                    <p class="mt-0.5 break-words text-xs leading-relaxed text-slate-600">{{ $comment->content }}</p>
                                                </div>

                                                @auth
                                                    @if (auth()->id() === $comment->user_id || auth()->user()->isAdmin())
                                                        <form method="POST" action="{{ route('comments.destroy', $comment) }}" data-confirm="Hapus komentar ini?">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="grid size-7 shrink-0 place-items-center rounded-lg text-slate-400 transition hover:bg-rose-50 hover:text-rose-600" aria-label="Hapus komentar">
                                                                <i data-lucide="trash-2" class="size-3.5"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endauth
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif

                                {{-- Actions --}}
                                <div class="mt-4 flex flex-wrap items-center gap-2 border-t border-slate-100 pt-4">
                                    <button type="button" data-like-url="{{ route('photos.like', $photo) }}" data-unlike-url="{{ route('photos.unlike', $photo) }}" data-liked="{{ $photo->liked_by_auth ? '1' : '0' }}" data-count-target="like-count-{{ $photo->id }}" data-busy="0" aria-pressed="{{ $photo->liked_by_auth ? 'true' : 'false' }}" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold transition hover:border-rose-300 hover:bg-rose-50">
                                        <i data-lucide="heart" class="size-4 {{ $photo->liked_by_auth ? 'fill-current text-rose-600' : 'text-slate-500' }}"></i>
                                        <span data-like-label>{{ $photo->liked_by_auth ? 'Suka' : 'Sukai' }}</span>
                                    </button>

                                    <button type="button" data-open-modal="report-modal-{{ $photo->id }}" class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-xs font-medium text-slate-500 transition hover:bg-slate-100 hover:text-rose-600">
                                        <i data-lucide="flag" class="size-3.5"></i>
                                        Laporkan
                                    </button>
                                </div>

                                {{-- Comment form --}}
                                <form method="POST" action="{{ route('comments.store', $photo) }}" class="mt-4 space-y-2">
                                    @csrf
                                    <label for="comment-{{ $photo->id }}" class="sr-only">Tulis komentar</label>
                                    <textarea id="comment-{{ $photo->id }}" name="content" rows="2" required maxlength="1000" placeholder="Tulis komentar..." class="w-full resize-none rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-100">{{ old('content') }}</textarea>
                                    <div class="flex flex-wrap items-center justify-between gap-2">
                                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-brand-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-brand-700">
                                            <i data-lucide="send" class="size-3.5"></i>
                                            Kirim komentar
                                        </button>
                                        <p class="text-[11px] text-slate-400">Komentar menunggu moderasi admin.</p>
                                    </div>
                                </form>
                            </div>

                            {{-- Report modal --}}
                                <div id="report-modal-{{ $photo->id }}" data-modal class="hidden fixed inset-0 z-50 items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm">
                                    <div role="dialog" aria-modal="true" aria-labelledby="report-title-{{ $photo->id }}" class="max-h-[90vh] w-full max-w-md overflow-y-auto rounded-2xl bg-white shadow-2xl">
                                        <div class="flex items-start justify-between gap-4 border-b border-slate-100 p-5">
                                            <div>
                                                <h3 id="report-title-{{ $photo->id }}" data-modal-title class="text-base font-semibold text-slate-900">Laporkan foto</h3>
                                                <p class="mt-1 text-xs text-slate-500">Bantu kami menjaga galeri tetap nyaman.</p>
                                            </div>
                                            <button type="button" data-close-modal class="grid size-8 shrink-0 place-items-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700" aria-label="Tutup">
                                                <i data-lucide="x" class="size-4"></i>
                                            </button>
                                        </div>

                                        <form method="POST" action="{{ route('reports.store', $photo) }}" class="space-y-4 p-5">
                                            @csrf

                                            <img data-modal-photo src="{{ $photo->image_url }}" alt="{{ $photo->caption ?? $album->title }}" class="aspect-video w-full rounded-xl border border-slate-200 object-cover">

                                            <div>
                                                <label for="reason-{{ $photo->id }}" class="mb-1.5 block text-xs font-semibold text-slate-700">Alasan laporan</label>
                                                <select id="reason-{{ $photo->id }}" name="reason" required class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-100">
                                                    @foreach (config('gallery.report_reasons') as $value => $label)
                                                        <option value="{{ $value }}">{{ $label }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div>
                                                <label for="report-description-{{ $photo->id }}" class="mb-1.5 block text-xs font-semibold text-slate-700">Keterangan tambahan <span class="font-normal text-slate-400">(opsional)</span></label>
                                                <textarea id="report-description-{{ $photo->id }}" name="description" rows="3" maxlength="1000" placeholder="Jelaskan masalahnya..." class="w-full resize-none rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-100"></textarea>
                                            </div>

                                            <div class="flex justify-end gap-2 pt-1">
                                                <button type="button" data-close-modal class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50">Batal</button>
                                                <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl bg-rose-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-rose-700">
                                                    <i data-lucide="flag" class="size-4"></i>
                                                    Kirim laporan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $photos->links() }}
                </div>
            @else
                <div class="grid place-items-center rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center">
                    <span class="grid size-14 place-items-center rounded-full bg-brand-50 text-brand-600">
                        <i data-lucide="image-off" class="size-6"></i>
                    </span>
                    <h3 class="mt-4 text-base font-semibold text-slate-800">Belum ada foto</h3>
                    <p class="mt-1 max-w-sm text-sm text-slate-500">Album ini belum memiliki foto yang dapat ditampilkan.</p>
                </div>
            @endif
        </section>
    </div>

    {{-- Shared lightbox --}}
    <div id="photo-lightbox" data-modal class="hidden fixed inset-0 z-50 items-center justify-center bg-slate-950/90 p-4 backdrop-blur-sm">
        <div role="dialog" aria-modal="true" aria-label="Pratinjau foto" class="relative flex max-h-full w-full max-w-5xl flex-col items-center gap-4">
            <button type="button" data-close-modal class="absolute -top-1 right-0 z-10 grid size-10 place-items-center rounded-full bg-white/10 text-white transition hover:bg-white/20" aria-label="Tutup pratinjau">
                <i data-lucide="x" class="size-5"></i>
            </button>
            <img data-modal-image src="" alt="" class="max-h-[75vh] w-auto max-w-full rounded-xl object-contain shadow-2xl">
            <p data-modal-caption class="max-w-2xl text-center text-sm text-slate-200"></p>
            <a href="{{ route('gallery.index') }}" class="inline-flex items-center gap-2 rounded-lg bg-white/10 px-4 py-2 text-xs font-medium text-white transition hover:bg-white/20">
                <i data-lucide="arrow-left" class="size-4"></i>
                Kembali ke galeri
            </a>
        </div>
    </div>
@endsection
