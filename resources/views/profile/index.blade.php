@extends('layouts.app')

@section('title', 'Profil Saya — Galeri Sekolah')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
        <div class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Profil Saya</h1>
            <p class="mt-2 text-sm text-slate-600">Kelola informasi pribadi dan kata sandi akun Anda.</p>
        </div>

        <div class="grid gap-6 lg:grid-cols-[minmax(0,20rem)_minmax(0,1fr)]">
            {{-- Profile card --}}
            <aside class="h-fit rounded-2xl border border-slate-200 bg-white p-6 text-center shadow-sm">
                <div class="relative mx-auto size-28">
                    <div data-preview-wrapper class="size-full overflow-hidden rounded-full ring-4 ring-brand-50">
                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="size-full object-cover">
                    </div>
                    <img id="avatar-preview" src="" alt="Pratinjau avatar" class="hidden absolute inset-0 size-full rounded-full object-cover ring-4 ring-brand-50">
                </div>

                <h2 class="mt-5 text-lg font-semibold text-slate-900">{{ $user->name }}</h2>
                <p class="mt-1 text-sm text-slate-500">{{ $user->email }}</p>

                <div class="mt-5 flex flex-wrap justify-center gap-2">
                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold {{ $user->role === 'admin' ? 'bg-brand-100 text-brand-800' : 'bg-slate-100 text-slate-600' }}">
                        <i data-lucide="shield" class="size-3.5"></i>
                        {{ ucfirst($user->role) }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold {{ $user->status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                        <i data-lucide="{{ $user->status === 'active' ? 'circle-check' : 'circle-x' }}" class="size-3.5"></i>
                        {{ $user->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>

                <div class="mt-6 border-t border-slate-100 pt-5">
                    <p class="flex items-center justify-center gap-2 text-xs text-slate-500">
                        <i data-lucide="calendar" class="size-3.5"></i>
                        Bergabung sejak {{ $user->created_at ? $user->created_at->translatedFormat('F Y') : '-' }}
                    </p>
                </div>
            </aside>

            {{-- Edit form --}}
            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-5">
                    <span class="grid size-10 place-items-center rounded-xl bg-brand-50 text-brand-600">
                        <i data-lucide="user-cog" class="size-5"></i>
                    </span>
                    <div>
                        <h2 class="text-base font-semibold text-slate-900">Ubah profil</h2>
                        <p class="text-xs text-slate-500">Perbarui data diri Anda di bawah ini.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="name" class="mb-1.5 block text-sm font-medium text-slate-700">Nama lengkap</label>
                            <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-100">
                        </div>

                        <div>
                            <label for="email" class="mb-1.5 block text-sm font-medium text-slate-700">Alamat email</label>
                            <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-100">
                        </div>
                    </div>

                    <div>
                        <label for="avatar" class="mb-1.5 block text-sm font-medium text-slate-700">Foto profil <span class="font-normal text-slate-400">(opsional)</span></label>
                        <input id="avatar" type="file" name="avatar" accept="image/*" data-image-preview="avatar-preview" class="block w-full cursor-pointer rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-brand-50 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-brand-700 hover:file:bg-brand-100 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                        <p class="mt-1.5 text-xs text-slate-400">Biarkan kosong jika tidak ingin mengganti foto profil.</p>
                    </div>

                    <div class="grid gap-5 border-t border-slate-100 pt-6 sm:grid-cols-2">
                        <div>
                            <label for="password" class="mb-1.5 block text-sm font-medium text-slate-700">Kata sandi baru <span class="font-normal text-slate-400">(opsional)</span></label>
                            <input id="password" type="password" name="password" autocomplete="new-password" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-100">
                        </div>

                        <div>
                            <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-slate-700">Konfirmasi kata sandi</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-100">
                        </div>
                    </div>

                    <p class="flex items-center gap-2 text-xs text-slate-500">
                        <i data-lucide="info" class="size-4 shrink-0 text-brand-600"></i>
                        Kosongkan jika tidak ingin mengubah kata sandi.
                    </p>

                    <div class="flex justify-end border-t border-slate-100 pt-6">
                        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">
                            <i data-lucide="save" class="size-4"></i>
                            Simpan perubahan
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </div>
@endsection
