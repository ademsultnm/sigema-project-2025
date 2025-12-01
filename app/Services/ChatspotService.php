<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class ChatspotService
{
    public function processMessage(string $message, User $user): string
    {
        return $this->askOllama($message, $user);
    }

    // ==========================================================
    //  OLLAMA LLM — ini ai nya
    // ==========================================================
    private function askOllama(string $prompt, User $user): string
    {
        try {
            $intent = $this->detectIntent($prompt);

            // ---------------------------
            // Info siswa dan kelas
            // ---------------------------
            $kelas = DB::table('kelas_siswa')
                ->join('kelas', 'kelas.id', '=', 'kelas_siswa.kelas_id')
                ->where('siswa_id', $user->siswa_id)
                ->orderBy('tahun_ajaran', 'desc')
                ->value('kelas.nama');

            $sppInfo = "Tidak relevan.";
            if ($intent === 'spp' && $user->siswa_id) {
                $tagihan = DB::table('tagihan_spp')
                    ->where('siswa_id', $user->siswa_id)
                    ->where('status', 'Belum Lunas')
                    ->orderBy('jatuh_tempo', 'asc')
                    ->get();

                if ($tagihan->isEmpty()) {
                    $sppInfo = "Tidak ada tagihan SPP yang belum dibayar.";
                } else {
                    $sppInfo = $tagihan->map(function ($t) {
                        $tanggal = date('d M Y', strtotime($t->jatuh_tempo));
                        return "- {$t->deskripsi} — Rp " .
                            number_format($t->jumlah_tagihan, 0, ',', '.') .
                            " | Jatuh tempo: {$tanggal}";
                    })->join("\n");
                }
            }

            $taskInfo = "Tidak relevan.";
            if ($intent === 'task' && $user->siswa_id) {
                $kelasIds = DB::table('kelas_siswa')
                    ->where('siswa_id', $user->siswa_id)
                    ->orderBy('tahun_ajaran', 'desc')
                    ->pluck('kelas_id');

                if ($kelasIds->isEmpty()) {
                    $taskInfo = "Tidak ada kelas aktif.";
                } else {
                    $tasks = DB::table('e_learning')
                        ->join('e_learning_kelas', 'e_learning.id', '=', 'e_learning_kelas.e_learning_id')
                        ->whereIn('e_learning_kelas.kelas_id', $kelasIds)
                        ->where('e_learning.tipe', 'tugas')
                        ->where(function ($q) {
                            $q->whereNull('e_learning.batas_waktu')
                                ->orWhere('e_learning.batas_waktu', '>=', now());
                        })
                        ->orderBy('e_learning.batas_waktu', 'asc')
                        ->select('e_learning.judul', 'e_learning.batas_waktu')
                        ->get();

                    if ($tasks->isEmpty()) {
                        $taskInfo = "Tidak ada tugas aktif.";
                    } else {
                        $taskInfo = $tasks->map(function ($t) {
                            $deadline = $t->batas_waktu
                                ? date('d M Y H:i', strtotime($t->batas_waktu))
                                : '-';
                            return "- {$t->judul} (deadline: {$deadline})";
                        })->join("\n");
                    }
                }
            }

            // ======================================================
            // SYSTEM PROMPT — bahasa Indonesia wajib + data konteks
            // ======================================================
            $system = "
Kamu adalah GemaAI, asisten AI untuk siswa sekolah.
Kamu WAJIB menjawab 100% dalam bahasa Indonesia dengan gaya santai, sopan, dan jelas.
Jangan menggunakan bahasa Inggris kecuali untuk nama atau istilah asing.
Jangan mengarang data.

Informasi siswa:
- Nama: {$user->name}
- Peran: {$user->role}
- Kelas: " . ($kelas ?: 'Tidak diketahui') . "

Intent pengguna: {$intent}

Jika intent = 'spp', gunakan data berikut:
{$sppInfo}

Jika intent = 'task', gunakan data berikut:
{$taskInfo}

Jika intent = 'general':
- Jawab singkat, relevan, dan tetap arahkan percakapan ke hal-hal sekolah.
";

            $response = Http::post('http://localhost:11434/api/generate', [
                'model' => 'llama3',
                'prompt' => $system . "\nUser: {$prompt}\nAI:",
                'stream' => false,
            ]);

            if ($response->failed()) {
                return "GemaAI sedang tidak dapat diakses.";
            }

            return $response->json('response') ?? "AI tidak memberikan respon.";

        } catch (\Exception $e) {
            return "Terjadi kesalahan AI: " . $e->getMessage();
        }
    }

    private function detectIntent(string $msg): string
    {
        $msg = strtolower($msg);

        $sppWords = ['spp', 'bayar', 'tagihan', 'tunggakan', 'payment', 'pembayaran'];
        foreach ($sppWords as $w) {
            if (str_contains($msg, $w)) {
                return 'spp';
            }
        }

        $taskWords = ['tugas', 'pr', 'penugasan', 'deadline', 'pekerjaan rumah'];
        foreach ($taskWords as $w) {
            if (str_contains($msg, $w)) {
                return 'task';
            }
        }

        return 'general';
    }
}
