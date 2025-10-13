<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\backend\AbsensiGuruController;
use App\Http\Controllers\backend\AbsensiSiswaController;
use App\Http\Controllers\backend\ELearningController;
use App\Http\Controllers\backend\GuruController;
use App\Http\Controllers\backend\AdminController;
use App\Http\Controllers\backend\StafController;
use App\Http\Controllers\backend\WakaController;
use App\Http\Controllers\backend\JawabanController;
use App\Http\Controllers\backend\JenjangController;
use App\Http\Controllers\backend\JurusanController;
use App\Http\Controllers\backend\KelasController;
use App\Http\Controllers\backend\MataPelajaranController;
use App\Http\Controllers\backend\NilaiController;
use App\Http\Controllers\backend\RaportController;
use App\Http\Controllers\backend\SiswaController;
use App\Http\Controllers\backend\SoalController;
use App\Http\Controllers\backend\TagihanSppController;
use App\Http\Controllers\backend\SiswaELearningController;
use App\Http\Controllers\backend\JawabanSiswaController;
use App\Http\Controllers\backend\LaporanKeuanganController;
use App\Http\Controllers\backend\SettingController;
use App\Http\Controllers\backend\JadwalPelajaranController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\frontend\AboutController;
use App\Http\Controllers\frontend\BlogController;
use App\Http\Controllers\frontend\ContactController;
use App\Http\Controllers\frontend\CourseController;
use App\Http\Controllers\frontend\EventController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.home');
});

// frontend routes
Route::get('about', [AboutController::class, 'index'])->name('about.frontend');
Route::get('course', [CourseController::class, 'index'])->name('course.frontend');
Route::get('event', [EventController::class, 'index'])->name('event.frontend');
Route::get('blog', [BlogController::class, 'index'])->name('blog.frontend');
Route::get('get-contact', [ContactController::class, 'index'])->name('contact.frontend');

Auth::routes();

// =====================================================================
// GRUP UNTUK SEMUA PENGGUNA YANG SUDAH LOGIN (TERMASUK MURID, GURU, DLL)
// =====================================================================
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Rute Dashboard dan Logout yang bisa diakses semua peran
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    Route::post('/logouts', [LoginController::class, 'logout'])->name('logouts');

    // Rute E-Learning untuk Siswa
    Route::get('materi-tugas', [SiswaELearningController::class, 'index'])->name('siswa.elearning.index');
    Route::get('materi-tugas/{eLearning}', [SiswaELearningController::class, 'show'])->name('siswa.elearning.show');
    Route::post('materi-tugas/submit/{eLearning}', [SiswaELearningController::class, 'submitTugas'])->name('siswa.elearning.submit');

    // Rute umum lainnya yang bisa diakses lebih dari satu peran (contoh: siswa & guru melihat nilai)
    Route::get('nilai', [NilaiController::class, 'index'])->name('nilai.index'); 
    Route::get('absensi_siswa', [AbsensiSiswaController::class, 'index'])->name('absensi_siswa.index');
    
});

// =====================================================================
// GRUP KHUSUS HANYA UNTUK ADMIN DAN SUPER ADMIN
// =====================================================================
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    
    Route::resource('jenjang', JenjangController::class);
    Route::resource('jurusan', JurusanController::class);
    Route::resource('mapel', MataPelajaranController::class);
    Route::resource('kelas_admin', KelasController::class);
    Route::resource('guru', GuruController::class);
    Route::resource('admin', AdminController::class);
    Route::resource('staf', StafController::class);
    Route::resource('waka', WakaController::class);
    
    Route::resource('e_learning', ELearningController::class);
    Route::get('e_learning/{eLearning}/download', [ELearningController::class, 'download'])->name('e_learning.download');
    
  Route::get('jawaban-siswa', [JawabanSiswaController::class, 'index'])->name('jawaban-siswa.index');
    Route::get('jawaban-siswa/{eLearning}', [JawabanSiswaController::class, 'show'])->name('jawaban-siswa.show');
    Route::get('jawaban-siswa/view/{pengumpulanTugas}', [JawabanSiswaController::class, 'viewJawaban'])->name('jawaban-siswa.view');

    Route::resource('soal', SoalController::class);
    Route::resource('jawaban', JawabanController::class);
    Route::resource('siswa', SiswaController::class);
     Route::resource('jadwal-pelajaran', JadwalPelajaranController::class);
    Route::resource('nilai', NilaiController::class)->except(['index']); // Index sudah ada di grup umum

    Route::resource('raports', RaportController::class);
    Route::resource('absensi-guru', AbsensiGuruController::class);

    Route::resource('absensi_siswa', AbsensiSiswaController::class)->except(['index', 'show']); // show standar tidak dipakai
    Route::get('absensi_siswa/show/{kelas}/{tanggal}', [AbsensiSiswaController::class, 'show_class'])->name('absensi_siswa.show_class');
    
    Route::resource('tagihan-spp', TagihanSppController::class);
     Route::get('laporan-keuangan', [LaporanKeuanganController::class, 'index'])->name('laporan-keuangan.index');
    Route::get('laporan-keuangan/pdf', [LaporanKeuanganController::class, 'exportPdf'])->name('laporan-keuangan.pdf');
    Route::get('laporan-keuangan/excel', [LaporanKeuanganController::class, 'exportExcel'])->name('laporan-keuangan.excel');

 // Rute untuk Pengaturan
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
    // Rute API untuk AJAX
    Route::get('/api/kelas/{kelas_id}/siswa', [NilaiController::class, 'getSiswaByKelas'])->name('api.siswa.by.kelas');
});

