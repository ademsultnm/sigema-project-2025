<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    /**
     * Menampilkan daftar semua user dengan role 'Admin'.
     */
    public function index()
    {
        // Menggunakan strtolower untuk memastikan konsistensi
        $admins = User::whereRaw('LOWER(role) = ?', ['admin'])->latest()->get();
        return view('backend.pages.admin.index', compact('admins'));
    }

    /**
     * Menampilkan form untuk membuat admin baru.
     */
    public function create()
    {
        return view('backend.pages.admin.create');
    }

    /**
     * Menyimpan admin baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Admin', // Disimpan sebagai 'Admin' agar konsisten
        ]);

        return redirect()->route('admin.index')->with('success', 'Admin berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail seorang admin.
     */
    public function show(User $admin)
    {
        // FIX: Menggunakan strtolower untuk perbandingan case-insensitive
        // if (strtolower($admin->role) !== 'admin') {
        //     abort(404);
        // }
        return view('backend.pages.admin.show', compact('admin'));
    }

    /**
     * Menampilkan form untuk mengedit data admin.
     */
    public function edit(User $admin)
    {
        // FIX: Menggunakan strtolower untuk perbandingan case-insensitive
        // if (strtolower($admin->role) !== 'admin') {
        //     abort(404);
        // }
        return view('backend.pages.admin.edit', compact('admin'));
    }

    /**
     * Memperbarui data admin di database.
     */
    public function update(Request $request, User $admin)
    {
        // FIX: Menggunakan strtolower untuk perbandingan case-insensitive
        // if (strtolower($admin->role) !== 'admin') {
        //     abort(404);
        // }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $admin->id,
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;
        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }
        $admin->save();

        return redirect()->route('admin.index')->with('success', 'Data admin berhasil diperbarui.');
    }

    /**
     * Menghapus admin dari database.
     */
    public function destroy(User $admin)
    {
        // FIX: Menggunakan strtolower untuk perbandingan case-insensitive
        // if (strtolower($admin->role) !== 'admin') {
        //     abort(404);
        // }

        // Mencegah user menghapus akunnya sendiri
        if (auth()->id() == $admin->id) {
            return redirect()->route('admin.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $admin->delete();

        return redirect()->route('admin.index')->with('success', 'Admin berhasil dihapus.');
    }
}

