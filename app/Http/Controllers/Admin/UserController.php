<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\HandlesImageUploads;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    use HandlesImageUploads;

    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));
        $role = trim((string) $request->query('role', '')) ?: null;
        $status = trim((string) $request->query('status', '')) ?: null;

        $users = User::query()
            ->when($search, fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            }))
            ->when($role, fn ($query) => $query->where('role', $role))
            ->when($status, fn ($query) => $query->where('status', $status))
            ->withCount('uploadedPhotos', 'comments')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'search', 'role', 'status'));
    }

    public function create()
    {
        return view('admin.users.create', ['user' => new User(['role' => 'admin', 'status' => 'active'])]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['admin'])],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        User::create($data);

        return redirect()->route('admin.users.index')->with('status', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in($user->is(auth()->user()) ? ['admin', 'user'] : ['admin'])],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.unique' => 'Email sudah digunakan pengguna lain.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
        ]);

        // Admin tidak boleh menonaktifkan atau menurunkan role akunnya sendiri.
        if ($user->is(auth()->user())) {
            $data['role'] = $user->role;
            $data['status'] = $user->status;
        }

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role = $data['role'];
        $user->status = $data['status'];

        if (! empty($data['password'])) {
            $user->password = $data['password'];
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('status', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        abort_if($user->is(auth()->user()), 403, 'Anda tidak dapat menghapus akun sendiri.');

        $this->deleteImage($user->avatar);
        $user->delete();

        return back()->with('status', 'Pengguna berhasil dihapus.');
    }
}
