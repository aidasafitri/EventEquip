<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        // PERUBAHAN: validasi 'role' bukan 'roles' sebagai array
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|exists:roles,id',  // ← kunci perbaikan
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
        ]);

        // Attach role sebagai array satu elemen
        $user->roles()->attach([$validated['role']]);

        $this->logActivity(Auth::user(), "Membuat user baru: {$user->name}");

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dibuat');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|exists:roles,id',  // perbaikan: role (tunggal)
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
        ]);

        // Update password jika diisi
        if (!empty($validated['password'])) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        // Sync role (many-to-many) dengan array satu elemen
        $user->roles()->sync([$validated['role']]);

        $this->logActivity(Auth::user(), "Mengubah data user: {$user->name}");

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->withErrors('Tidak dapat menghapus user yang sedang login');
        }

        $this->logActivity(Auth::user(), "Menghapus user: {$user->name}");
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus');
    }

    private function logActivity($user, $action)
    {
        \App\Models\ActivityLog::create([
            'user_id' => $user->id,
            'action' => $action,
            'ip' => request()->ip(),
        ]);
    }
}