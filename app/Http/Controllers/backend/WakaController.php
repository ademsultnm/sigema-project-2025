<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class WakaController extends Controller
{
    private $roleName = 'Waka Kurikulum';
    private $roleNameLowercase = 'waka kurikulum';

    /**
     * Menampilkan daftar semua pengguna dengan peran Waka Kurikulum.
     */
    public function index()
    {
        $users = User::whereRaw('LOWER(role) = ?', [$this->roleNameLowercase])->latest()->paginate(10);
        // FIX: Mengganti nama variabel menjadi 'wakakurikulums' agar sesuai dengan view
        return view('backend.pages.waka.index', ['wakakurikulums' => $users]);
    }

    /**
     * Menampilkan form untuk membuat akun Waka Kurikulum baru.
     */
    public function create()
    {
        return view('backend.pages.waka.create');
    }

    /**
     * Menyimpan akun Waka Kurikulum baru ke database.
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
            'role' => $this->roleName,
        ]);

        return redirect()->route('waka.index')->with('success', 'Akun Waka Kurikulum berhasil ditambahkan.');
    }

    /**
     * Helper function untuk verifikasi peran.
     */
    private function verifyRole(User $user)
    {
        if (strtolower($user->role) !== $this->roleNameLowercase) {
            abort(404);
        }
    }

    /**
     * Menampilkan detail akun Waka Kurikulum.
     * Laravel akan otomatis melakukan route model binding (User $waka)
     */
    public function show(User $waka)
    {
        $this->verifyRole($waka);
        // Mengirim data ke view dengan nama variabel yang konsisten
        $wakakurikulum = $waka;
        return view('backend.pages.waka.show', compact('wakakurikulum'));
    }

    /**
     * Menampilkan form untuk mengedit akun Waka Kurikulum.
     */
    public function edit(User $waka)
    {
        $this->verifyRole($waka);
        // Mengirim data ke view dengan nama variabel yang konsisten
        $wakakurikulum = $waka;
        return view('backend.pages.waka.edit', compact('wakakurikulum'));
    }

    /**
     * Memperbarui data akun Waka Kurikulum di database.
     */
    public function update(Request $request, User $waka)
    {
        $this->verifyRole($waka);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $waka->id,
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $waka->name = $request->name;
        $waka->email = $request->email;
        if ($request->filled('password')) {
            $waka->password = Hash::make($request->password);
        }
        $waka->save();

        return redirect()->route('waka.index')->with('success', 'Akun Waka Kurikulum berhasil diperbarui.');
    }

    /**
     * Menghapus akun Waka Kurikulum dari database.
     */
    public function destroy(User $waka)
    {
        $this->verifyRole($waka);
        $waka->delete();
        return redirect()->route('waka.index')->with('success', 'Akun Waka Kurikulum berhasil dihapus.');
    }
}

