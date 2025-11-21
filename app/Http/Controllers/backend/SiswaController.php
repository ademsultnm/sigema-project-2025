<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    /**
     * Menampilkan daftar siswa dengan fungsionalitas filter dan pencarian.
     */
    public function index(Request $request)
    {
        // Ambil semua kelas untuk dropdown filter
        $kelas = Kelas::orderBy('nama')->get();

        // Mulai query builder
        $query = Siswa::with('user', 'kelas');

        // Terapkan filter pencarian nama atau NIS jika ada
        $query->when($request->search, function ($q, $search) {
            return $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%");
        });

        // Terapkan filter jenjang jika ada
        $query->when($request->jenjang, function ($q, $jenjang) {
            return $q->where('jenjang', $jenjang);
        });

        // Terapkan filter kelas jika ada
        $query->when($request->kelas_id, function ($q, $kelas_id) {
            return $q->whereHas('kelas', function($subQuery) use ($kelas_id) {
                $subQuery->where('kelas.id', $kelas_id);
            });
        });

        // Ambil hasil dengan paginasi dan urutkan berdasarkan data terbaru
        $siswas = $query->latest()->paginate(10);

        return view('backend.pages.siswa.index', compact('siswas', 'kelas'));
    }

    /**
     * Menampilkan form untuk membuat data siswa baru.
     */
    public function create()
    {
        $kelas = Kelas::orderBy('nama')->get();
        return view('backend.pages.siswa.create', compact('kelas'));
    }

    /**
     * Menyimpan data siswa baru ke database.
     */
    public function store(Request $request)
    {
        // Aturan validasi dasar
        $validationRules = [
            'nis' => 'required|string|max:20|unique:siswa,nis',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'jenjang' => 'required|in:SMP,SMA',
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran' => 'required|string|max:9',
        ];

        // Tambahkan validasi akun jika yang membuat adalah Super Admin
        if (strtolower(Auth::user()->role) === 'super admin') {
            $validationRules['email'] = 'required|string|email|max:255|unique:users';
            $validationRules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
        }
        
        $request->validate($validationRules);

        try {
            DB::beginTransaction();

            // 1. Buat data siswa secara manual untuk memastikan semua field tersimpan
            $siswa = new Siswa();
            $siswa->nis = $request->nis;
            $siswa->nama = $request->nama;
            $siswa->jenis_kelamin = $request->jenis_kelamin;
            $siswa->tanggal_lahir = $request->tanggal_lahir;
            $siswa->alamat = $request->alamat;
            $siswa->jenjang = $request->jenjang;
            $siswa->save();
            
            // 2. Tetapkan kelas siswa di tabel pivot
            $siswa->kelas()->attach($request->kelas_id, ['tahun_ajaran' => $request->tahun_ajaran]);

            // 3. Jika Super Admin, buat juga akunnya
            if (strtolower(Auth::user()->role) === 'super admin' && $request->filled('email')) {
                User::create([
                    'name' => $request->nama,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'Murid',
                    'siswa_id' => $siswa->id,
                ]);
            }

            DB::commit();
            return redirect()->route('siswa.index')->with('success', 'Data Siswa berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
    
    /**
     * Menampilkan detail data siswa.
     */
    public function show(Siswa $siswa)
    {
        $siswa->load('user', 'kelas');
        return view('backend.pages.siswa.show', compact('siswa'));
    }

    /**
     * Menampilkan form untuk mengedit data siswa.
     */
    public function edit(Siswa $siswa)
    {
        $siswa->load('user', 'kelas');
        $kelas = Kelas::orderBy('nama')->get();
        return view('backend.pages.siswa.edit', compact('siswa', 'kelas'));
    }

    /**
     * Memperbarui data siswa di database.
     */
    public function update(Request $request, Siswa $siswa)
    {
        // Aturan validasi dasar
        $validationRules = [
            'nis' => 'required|string|max:20|unique:siswa,nis,' . $siswa->id,
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'jenjang' => 'required|in:SMP,SMA',
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran' => 'required|string|max:9',
        ];

        // Tambahkan validasi akun jika yang mengedit adalah Super Admin
        if (strtolower(Auth::user()->role) === 'super admin') {
            if ($siswa->user) { // Jika siswa sudah punya akun
                $validationRules['email'] = 'required|string|email|max:255|unique:users,email,' . $siswa->user->id;
            } else { // Jika siswa belum punya akun
                $validationRules['email'] = 'required|string|email|max:255|unique:users';
            }
            $validationRules['password'] = ['nullable', 'confirmed', Rules\Password::defaults()];
        }
        
        $request->validate($validationRules);

        try {
            DB::beginTransaction();

            // 1. Update data siswa secara manual
            $siswa->nis = $request->nis;
            $siswa->nama = $request->nama;
            $siswa->jenis_kelamin = $request->jenis_kelamin;
            $siswa->tanggal_lahir = $request->tanggal_lahir;
            $siswa->alamat = $request->alamat;
            $siswa->jenjang = $request->jenjang;
            $siswa->save();
            
            // 2. Gunakan sync untuk memperbarui kelas siswa di tabel pivot
            $siswa->kelas()->sync([$request->kelas_id => ['tahun_ajaran' => $request->tahun_ajaran]]);

            // 3. Logika update/create akun oleh Super Admin
            if (strtolower(Auth::user()->role) === 'super admin' && $request->filled('email')) {
                $user = $siswa->user;
                if ($user) { // Jika sudah ada, update
                    $user->name = $request->nama;
                    $user->email = $request->email;
                    if ($request->filled('password')) {
                        $user->password = Hash::make($request->password);
                    }
                    $user->save();
                } else { // Jika belum ada, buat baru
                     if ($request->filled('password')) { // Password wajib diisi saat membuat akun baru
                        User::create([
                            'name' => $request->nama,
                            'email' => $request->email,
                            'password' => Hash::make($request->password),
                            'role' => 'Murid',
                            'siswa_id' => $siswa->id,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('siswa.index')->with('success', 'Data Siswa berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menghapus data siswa dari database.
     */
    public function destroy(Siswa $siswa)
    {
        try {
            DB::beginTransaction();
            // Hapus relasi di pivot table dulu
            $siswa->kelas()->detach();
            // Hapus user jika ada
            if($siswa->user) {
                $siswa->user->delete();
            }
            // Hapus data siswa
            $siswa->delete();
            DB::commit();
            return redirect()->route('siswa.index')->with('success', 'Data Siswa berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus data siswa.');
        }
    }
}

