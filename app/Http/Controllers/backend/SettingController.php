<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    /**
     * Menampilkan halaman pengaturan.
     */
    public function index()
    {
        // Ambil nilai API Key saat ini dari file config
        $apiKey = config('settings.paydisini_api_key', '');
        return view('backend.pages.settings.index', compact('apiKey'));
    }

    /**
     * Memperbarui pengaturan (menyimpan API Key).
     */
    public function update(Request $request)
    {
        $request->validate([
            'paydisini_api_key' => 'nullable|string|max:255',
        ]);

        // Path ke file config settings
        $configPath = config_path('settings.php');

        // Baca konten file yang ada
        $config = File::exists($configPath) ? include($configPath) : [];

        // Update atau tambahkan nilai API key
        $config['paydisini_api_key'] = $request->input('paydisini_api_key');

        // Tulis kembali ke file config
        File::put($configPath, '<?php return ' . var_export($config, true) . ';');

        // Hapus cache config agar perubahan langsung terasa
        Artisan::call('config:clear');

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
