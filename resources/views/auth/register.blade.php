@extends('layouts.app')

@section('title', 'Daftar — Galeri Sekolah')

@section('content')
    <div class="mx-auto max-w-md px-4 py-12 sm:px-6 lg:py-16">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="mx-auto grid size-12 place-items-center rounded-xl bg-brand-50 text-brand-600">
                <i data-lucide="user-plus" class="size-6"></i>
            </div>

            <h1 class="mt-5 text-center text-2xl font-bold tracking-tight text-slate-900">Buat akun baru</h1>
            <p class="mt-2 text-center text-sm text-slate-500">Bergabung dan ikut menyimpan kenangan sekolah.</p>

            <form method="POST" action="{{ route('register.store') }}" class="mt-7 space-y-5">
                @csrf

                <div>
                    <label for="name" class="mb-1.5 block text-sm font-medium text-slate-700">Nama lengkap</label>
                    <div class="relative">
                        <i data-lucide="user-round" class="pointer-events-none absolute left-3 top-1/2 size-4 -translate-y-1/2 text-slate-400"></i>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" autofocus required autocomplete="name" placeholder="Nama Anda" class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-100">
                    </div>
                </div>

                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-slate-700">Alamat email</label>
                    <div class="relative">
                        <i data-lucide="mail" class="pointer-events-none absolute left-3 top-1/2 size-4 -translate-y-1/2 text-slate-400"></i>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nama@email.com" class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-100">
                    </div>
                </div>

                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium text-slate-700">Kata sandi</label>
                    <div class="relative">
                        <i data-lucide="lock-keyhole" class="pointer-events-none absolute left-3 top-1/2 size-4 -translate-y-1/2 text-slate-400"></i>
                        <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-100">
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-slate-700">Konfirmasi kata sandi</label>
                    <div class="relative">
                        <i data-lucide="lock-keyhole" class="pointer-events-none absolute left-3 top-1/2 size-4 -translate-y-1/2 text-slate-400"></i>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi kata sandi" class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-100">
                    </div>
                </div>

                <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">
                    <i data-lucide="user-plus" class="size-4"></i>
                    Daftar
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-slate-500">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-semibold text-brand-700 transition hover:text-brand-800">Masuk di sini</a>
            </p>
        </div>

        <p class="mt-5 flex items-start justify-center gap-2 text-center text-xs text-slate-500">
            <i data-lucide="shield-check" class="mt-0.5 size-4 shrink-0 text-brand-600"></i>
            Akun yang baru didaftarkan akan mendapat peran sebagai user.
        </p>
    </div>
@endsection
