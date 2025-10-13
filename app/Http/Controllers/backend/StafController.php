<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class StafController extends Controller
{
    private $roleName = 'Staf Keuangan';
    private $roleNameLowercase = 'staf keuangan';

    public function index()
    {
        $users = User::where(function ($query) {
                        $query->whereRaw('LOWER(role) = ?', [$this->roleNameLowercase])
                              ->orWhereRaw('LOWER(role) = ?', ['staf']);
                    })->latest()->paginate(10);
        // Ganti nama variabel agar lebih jelas dan sesuai dengan view
        return view('backend.pages.staf.index', ['stafkeuangans' => $users]);
    }

    public function create()
    {
        return view('backend.pages.staf.create');
    }

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
            'role' => 'Staf', // Simpan sebagai 'Staf' agar konsisten dengan data awal
        ]);

        // Perbarui redirect ke route 'staf.index'
        return redirect()->route('staf.index')->with('success', 'Akun Staf Keuangan berhasil ditambahkan.');
    }
    
    private function verifyRole(User $user)
    {
        $userRole = strtolower($user->role);
        if ($userRole !== $this->roleNameLowercase && $userRole !== 'staf') {
            abort(404);
        }
    }

    public function show(User $staf)
    {
        $this->verifyRole($staf);
        // Ganti nama variabel agar konsisten
        $stafkeuangan = $staf;
        return view('backend.pages.staf.show', compact('stafkeuangan'));
    }

    public function edit(User $staf)
    {
        $this->verifyRole($staf);
        // Ganti nama variabel agar konsisten
        $stafkeuangan = $staf;
        return view('backend.pages.staf.edit', compact('stafkeuangan'));
    }

    public function update(Request $request, User $staf)
    {
        $this->verifyRole($staf);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $staf->id,
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $staf->name = $request->name;
        $staf->email = $request->email;
        if ($request->filled('password')) {
            $staf->password = Hash::make($request->password);
        }
        $staf->save();

        // Perbarui redirect ke route 'staf.index'
        return redirect()->route('staf.index')->with('success', 'Akun Staf Keuangan berhasil diperbarui.');
    }

    public function destroy(User $staf)
    {
        $this->verifyRole($staf);
        $staf->delete();
        // Perbarui redirect ke route 'staf.index'
        return redirect()->route('staf.index')->with('success', 'Akun Staf Keuangan berhasil dihapus.');
    }
}

