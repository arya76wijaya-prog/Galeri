@extends('layouts.admin')

@section('title', 'Edit Pengguna')
@section('heading', 'Edit Pengguna')
@section('subheading', 'Perbarui data akun pengguna')

@section('content')
    <div class="mx-auto max-w-3xl">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
            @csrf
            @method('PUT')

            @if ($user->is(auth()->user()))
                <div class="flex items-start gap-3 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                    <i data-lucide="info" class="mt-0.5 size-4 shrink-0"></i>
                    <p>Anda sedang mengedit akun sendiri. Peran dan status tidak dapat diubah pada akun sendiri; perubahan tersebut akan diabaikan.</p>
                </div>
            @endif

            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-sm font-semibold text-slate-900">Informasi akun</h2>
                <p class="mt-1 text-xs text-slate-500">Isi data diri pengguna. Kosongkan kata sandi jika tidak ingin mengubahnya.</p>

                <div class="mt-5 grid gap-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="name" class="block text-xs font-semibold text-slate-600">Nama <span class="text-rose-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 placeholder:text-slate-400 focus:border-brand-500 focus:ring-brand-500" placeholder="Nama lengkap">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="email" class="block text-xs font-semibold text-slate-600">Email <span class="text-rose-500">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 placeholder:text-slate-400 focus:border-brand-500 focus:ring-brand-500" placeholder="nama@sekolah.sch.id">
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-semibold text-slate-600">Kata sandi baru</label>
                        <input type="password" id="password" name="password" autocomplete="new-password" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 placeholder:text-slate-400 focus:border-brand-500 focus:ring-brand-500" placeholder="Opsional">
                        <p class="mt-1 text-xs text-slate-400">Kosongkan jika tidak ingin mengubah kata sandi.</p>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold text-slate-600">Konfirmasi kata sandi baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 placeholder:text-slate-400 focus:border-brand-500 focus:ring-brand-500" placeholder="Ulangi kata sandi baru">
                    </div>
                </div>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-sm font-semibold text-slate-900">Peran dan status</h2>
                <p class="mt-1 text-xs text-slate-500">Tentukan hak akses dan status aktif akun.</p>

                <div class="mt-5 grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="role" class="block text-xs font-semibold text-slate-600">Peran</label>
                        <select id="role" name="role" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 focus:border-brand-500 focus:ring-brand-500">
                            @foreach (['admin' => 'Admin'] as $value => $label)
                                <option value="{{ $value }}" {{ old('role', $user->role) === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="status" class="block text-xs font-semibold text-slate-600">Status</label>
                        <select id="status" name="status" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 focus:border-brand-500 focus:ring-brand-500">
                            @foreach (['active' => 'Aktif', 'inactive' => 'Nonaktif'] as $value => $label)
                                <option value="{{ $value }}" {{ old('status', $user->status) === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </section>

            <div class="flex flex-wrap items-center justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    <i data-lucide="x" class="size-4"></i> Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700">
                    <i data-lucide="save" class="size-4"></i> Simpan perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
