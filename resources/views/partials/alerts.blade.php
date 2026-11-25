@if (session('status'))
    <div class="mx-auto mt-4 max-w-7xl px-4 sm:px-6 lg:px-8" data-alert>
        <div class="flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            <i data-lucide="circle-check" class="mt-0.5 size-4 shrink-0"></i>
            <span class="flex-1">{{ session('status') }}</span>
            <button type="button" class="alert-close text-emerald-600 hover:text-emerald-900" aria-label="Tutup notifikasi">
                <i data-lucide="x" class="size-4"></i>
            </button>
        </div>
    </div>
@endif

@if (session('error'))
    <div class="mx-auto mt-4 max-w-7xl px-4 sm:px-6 lg:px-8" data-alert>
        <div class="flex items-start gap-3 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
            <i data-lucide="circle-alert" class="mt-0.5 size-4 shrink-0"></i>
            <span class="flex-1">{{ session('error') }}</span>
            <button type="button" class="alert-close text-rose-600 hover:text-rose-900" aria-label="Tutup notifikasi">
                <i data-lucide="x" class="size-4"></i>
            </button>
        </div>
    </div>
@endif

@if ($errors->any())
    <div class="mx-auto mt-4 max-w-7xl px-4 sm:px-6 lg:px-8" data-alert>
        <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
            <div class="flex items-start gap-3">
                <i data-lucide="triangle-alert" class="mt-0.5 size-4 shrink-0"></i>
                <div class="flex-1">
                    <p class="font-semibold">Terdapat kesalahan pada formulir:</p>
                    <ul class="mt-1 list-inside list-disc space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="alert-close text-rose-600 hover:text-rose-900" aria-label="Tutup notifikasi">
                    <i data-lucide="x" class="size-4"></i>
                </button>
            </div>
        </div>
    </div>
@endif
