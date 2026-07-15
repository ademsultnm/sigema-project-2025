<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth; // <-- Pastikan ini ada

class GuruController extends Controller
{
    /**
     * Menampilkan daftar guru dengan fungsionalitas filter dan pencarian.
     */
    public function index(Request $request)
    {
        $query = Guru::with('user');

        $query->when($request->search, function ($q, $search) {
            return $q->where('nama', 'like', "%{$search}%")->orWhere('mata_pelajaran', 'like', "%{$search}%");
        });

        $query->when($request->jenjang, function ($q, $jenjang) {
            return $q->where('jenjang', $jenjang);
        });

        // ambil hasil dengan paginasi dan urutkan berdasarkan data terbaru
        // $gurus = $query->latest()->paginate(10);
        // ambil hasil dengan paginasi dan urutan berdasarkan data lama berada diatas sendiri
        $gurus = $query->oldest()->paginate(10);

        return view('backend.pages.guru.index', compact('gurus'));
    }

    /**
     * Menampilkan form untuk membuat guru baru.
     */
    public function create()
    {
        return view('backend.pages.guru.create');
    }

    /**
     * Menyimpan data guru baru. Logika bervariasi berdasarkan peran pengguna.
     */
    public function store(Request $request)
    {
        $userRole = strtolower(Auth::user()->role);

        $validationRules = [
            'nama' => 'required|string|max:255',
            'mata_pelajaran' => 'required|string|max:255',
            'jenjang' => 'required|in:SMP,SMA',
        ];

        // HANYA Super Admin yang bisa memvalidasi dan membuat akun
        if ($userRole === 'super admin') {
            $validationRules['email'] = 'required|string|email|max:255|unique:users';
            $validationRules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
        }

        $request->validate($validationRules);

        try {
            DB::beginTransaction();

            $guru = new Guru();
            $guru->nama = $request->nama;
            $guru->mata_pelajaran = $request->mata_pelajaran;
            $guru->jenjang = $request->jenjang;
            $guru->save();

            // HANYA Super Admin yang bisa membuat akun
            if ($userRole === 'super admin') {
                User::create([
                    'name' => $request->nama,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'Guru',
                    'guru_id' => $guru->id,
                ]);
            }

            DB::commit();
            return redirect()->route('guru.index')->with('success', 'Data Guru berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->withInput();
        }
    }
    
    public function show(Guru $guru)
    {
        $guru->load('user');
        return view('backend.pages.guru.show', compact('guru'));
    }

    public function edit(Guru $guru)
    {
        $guru->load('user');
        return view('backend.pages.guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $userRole = strtolower(Auth::user()->role);

        $validationRules = [
            'nama' => 'required|string|max:255',
            'mata_pelajaran' => 'required|string|max:255',
            'jenjang' => 'required|in:SMP,SMA',
        ];

        // HANYA Super Admin yang bisa memvalidasi dan mengubah akun
        if ($userRole === 'super admin') {
            if ($guru->user) {
                $validationRules['email'] = 'required|string|email|max:255|unique:users,email,' . $guru->user->id;
            } else {
                $validationRules['email'] = 'required|string|email|max:255|unique:users';
            }
            $validationRules['password'] = ['nullable', 'confirmed', Rules\Password::defaults()];
        }

        $request->validate($validationRules);

        try {
            DB::beginTransaction();

            $guru->nama = $request->nama;
            $guru->mata_pelajaran = $request->mata_pelajaran;
            $guru->jenjang = $request->jenjang;
            $guru->save();

            // HANYA Super Admin yang bisa mengubah atau membuat akun
            if ($userRole === 'super admin') {
                $user = $guru->user;

                if ($user) {
                    $user->name = $request->nama;
                    $user->email = $request->email;
                    if ($request->filled('password')) {
                        $user->password = Hash::make($request->password);
                    }
                    $user->save();
                } else {
                    if ($request->filled('password') && $request->filled('email')) {
                        User::create([
                            'name' => $request->nama,
                            'email' => $request->email,
                            'password' => Hash::make($request->password),
                            'role' => 'Guru',
                            'guru_id' => $guru->id,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('guru.index')->with('success', 'Data Guru berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Guru $guru)
    {
        try {
            DB::beginTransaction();
            if ($guru->user) {
                $guru->user->delete();
            }
            $guru->delete();
            DB::commit();
            return redirect()->route('guru.index')->with('success', 'Guru dan akun terkait berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}

