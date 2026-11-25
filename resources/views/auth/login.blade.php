@extends('layouts.app')

@section('title', 'Masuk — Galeri Sekolah')

@section('content')
    <div class="mx-auto flex max-w-md flex-col px-4 py-12 sm:px-6 lg:py-16">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="mx-auto grid size-12 place-items-center rounded-xl bg-brand-50 text-brand-600">
                <i data-lucide="log-in" class="size-6"></i>
            </div>

            <h1 class="mt-5 text-center text-2xl font-bold tracking-tight text-slate-900">Masuk ke akun Anda</h1>
            <p class="mt-2 text-center text-sm text-slate-500">Suka, komentari, dan laporkan foto favorit Anda.</p>

            <form method="POST" action="{{ route('login.store') }}" class="mt-7 space-y-5">
                @csrf

                <div>
                    <label for="username" class="mb-1.5 block text-sm font-medium text-slate-700">Username</label>
                    <div class="relative">
                        <i data-lucide="user" class="pointer-events-none absolute left-3 top-1/2 size-4 -translate-y-1/2 text-slate-400"></i>
                        <input id="username" type="text" name="username" value="{{ old('username') }}" autofocus required autocomplete="username" placeholder="Masukkan username" class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-100">
                    </div>
                </div>

                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium text-slate-700">Kata sandi</label>
                    <div class="relative">
                        <i data-lucide="lock-keyhole" class="pointer-events-none absolute left-3 top-1/2 size-4 -translate-y-1/2 text-slate-400"></i>
                        <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan kata sandi" class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-100">
                    </div>
                </div>

                <div class="flex items-center justify-between gap-3">
                    <label class="inline-flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="remember" value="1" @checked(old('remember')) class="size-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                        Ingat saya
                    </label>
                    <span class="text-sm text-slate-400">Lupa kata sandi?</span>
                </div>

                <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">
                    <i data-lucide="log-in" class="size-4"></i>
                    Masuk
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-slate-500">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-semibold text-brand-700 transition hover:text-brand-800">Daftar sekarang</a>
            </p>
        </div>

        <div class="mt-5 rounded-2xl border border-brand-200 bg-brand-50 p-4">
            <p class="flex items-center gap-2 text-xs font-semibold text-brand-800">
                <i data-lucide="info" class="size-4"></i>
                Akun demo
            </p>
            <ul class="mt-2 space-y-1 pl-6 text-xs text-brand-800">
                <li><span class="font-medium">Admin:</span> admin / password</li>
                <li><span class="font-medium">User:</span> user / password</li>
            </ul>
        </div>
    </div>
@endsection
