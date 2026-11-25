@extends('layouts.admin')

@section('title', 'Kelola Pengguna')
@section('heading', 'Pengguna')
@section('subheading', 'Kelola akun dan peran pengguna galeri sekolah')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <p class="text-sm text-slate-600">Total {{ $users->total() }} pengguna ditemukan.</p>
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700">
                <i data-lucide="user-plus" class="size-4"></i> Tambah Pengguna
            </a>
        </div>

        <form method="GET" action="{{ route('admin.users.index') }}" class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end">
                <div class="flex-1">
                    <label for="q" class="block text-xs font-semibold text-slate-600">Cari pengguna</label>
                    <input type="text" id="q" name="q" value="{{ $search }}" placeholder="Nama atau email..." class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 placeholder:text-slate-400 focus:border-brand-500 focus:ring-brand-500">
                </div>
                <div class="sm:w-40">
                    <label for="role" class="block text-xs font-semibold text-slate-600">Peran</label>
                    <select id="role" name="role" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 focus:border-brand-500 focus:ring-brand-500">
                        @foreach (['' => 'Semua peran', 'admin' => 'Admin'] as $value => $label)
                            <option value="{{ $value }}" {{ (string) $role === (string) $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:w-40">
                    <label for="status" class="block text-xs font-semibold text-slate-600">Status</label>
                    <select id="status" name="status" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 focus:border-brand-500 focus:ring-brand-500">
                        @foreach (['' => 'Semua status', 'active' => 'Aktif', 'inactive' => 'Nonaktif'] as $value => $label)
                            <option value="{{ $value }}" {{ (string) $status === (string) $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700">
                    <i data-lucide="filter" class="size-4"></i> Filter
                </button>
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    <i data-lucide="rotate-ccw" class="size-4"></i> Reset
                </a>
            </div>
        </form>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-4 py-3">Pengguna</th>
                            <th class="px-4 py-3">Peran</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-center">Foto</th>
                            <th class="px-4 py-3 text-center">Komentar</th>
                            <th class="px-4 py-3">Bergabung</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($users as $user)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="size-10 shrink-0 rounded-full border border-slate-200 object-cover">
                                        <div>
                                            <p class="font-medium text-slate-800">
                                                {{ $user->name }}
                                                @if ($user->is(auth()->user()))
                                                    <span class="ml-1 inline-flex items-center rounded-full bg-brand-50 px-2 py-0.5 text-xs font-medium text-brand-700">Akun Anda</span>
                                                @endif
                                            </p>
                                            <p class="mt-0.5 text-xs text-slate-500">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @if ($user->role === 'admin')
                                        <span class="inline-flex items-center rounded-full bg-violet-50 px-2 py-0.5 text-xs font-medium text-violet-700">Admin</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-violet-50 px-2 py-0.5 text-xs font-medium text-violet-700">Admin</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if ($user->status === 'active')
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700">Aktif</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-rose-50 px-2 py-0.5 text-xs font-medium text-rose-700">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center text-slate-600">{{ $user->uploaded_photos_count }}</td>
                                <td class="px-4 py-3 text-center text-slate-600">{{ $user->comments_count }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-xs text-slate-500">{{ $user->created_at?->format('d M Y') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50" aria-label="Edit pengguna">
                                            <i data-lucide="pencil" class="size-4"></i> Edit
                                        </a>
                                        @unless ($user->is(auth()->user()))
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" data-confirm="Hapus pengguna ini?">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-1 rounded-lg border border-rose-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-rose-600 hover:bg-rose-50" aria-label="Hapus pengguna">
                                                    <i data-lucide="trash-2" class="size-4"></i> Hapus
                                                </button>
                                            </form>
                                        @endunless
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center text-sm text-slate-400">Tidak ada pengguna yang cocok dengan pencarian Anda.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-100 px-4 py-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
