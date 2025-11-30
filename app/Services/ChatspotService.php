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

    // -------------------------
    // OLLAMA ini ai nya yuaa
    // -------------------------
    private function askOllama(string $prompt, User $user): string
{
    try {
        $intent = $this->detectIntent($prompt);

        $siswa = DB::table('siswa')->where('id', $user->siswa_id)->first();
        $kelas = DB::table('kelas_siswa')
            ->join('kelas', 'kelas.id', 'kelas_siswa.kelas_id')
            ->where('siswa_id', $user->siswa_id)
            ->orderBy('tahun_ajaran', 'desc')
            ->value('kelas.nama');

        // ================================================
        // 1) SIAPKAN INFO SPP JIKA INTENT = 'spp'
        // ================================================
        $sppInfo = "Tidak relevan.";
        if ($intent === 'spp') {

            if (!$user->siswa_id) {
                $sppInfo = "User belum terhubung sebagai siswa.";
            } else {

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
        }

        // ================================================
        // 2) SIAPKAN INFO TUGAS JIKA INTENT = 'task'
        // ================================================
        $taskInfo = "Tidak relevan.";
        if ($intent === 'task') {

            if (!$user->siswa_id) {
                $taskInfo = "User belum terdaftar sebagai siswa.";
            } else {
                $kelasIds = DB::table('kelas_siswa')
                    ->where('siswa_id', $user->siswa_id)
                    ->orderBy('tahun_ajaran', 'desc')
                    ->pluck('kelas_id');

                if ($kelasIds->isEmpty()) {
                    $taskInfo = "Tidak ada kelas yang aktif.";
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
        }

        // ================================================
        // 3) SISTEM PROMPT
        // ================================================
        $system = "
Kamu adalah GemaAI, asisten AI untuk siswa.
Kamu **WAJIB** menjawab 100% dalam bahasa Indonesia, dengan gaya santai, sopan, dan mudah dipahami.
Jangan gunakan bahasa Inggris kecuali menyebut nama atau istilah asing.
Jangan mengarang data.

Informasi siswa:
- Nama: {$user->name}
- Peran: {$user->role}
- Kelas: " . ($kelas ?: 'Tidak diketahui') . "

Informasi tambahan:
- Intent pengguna: {$intent}

Jika intent = 'spp', gunakan data berikut:
{$sppInfo}

Jika intent = 'task', gunakan data berikut:
{$taskInfo}

Jika intent = general, jawab singkat dan arahkan kembali ke topik sekolah.
";

        // ================================================
        // 4) OLLAMA REQUEST
        // ================================================
        $response = Http::post('http://localhost:11434/api/generate', [
            'model' => 'llama3',
            'prompt' => $system . "\nUser: {$prompt}\nChatSpot:",
            'stream' => false,
        ]);

        if ($response->failed()) {
            return "AI sedang tidak dapat diakses.";
        }

        return $response->json('response') ?? "Tidak ada respon dari AI.";

    } catch (\Exception $e) {
        return "AI error: " . $e->getMessage();
    }
}




    // -------------------------
    // INTENT DETECTOR
    // -------------------------
    private function detectIntent(string $msg): string
    {
        $msg = strtolower($msg);

        // SPP intent
        $sppWords = ['spp', 'bayar', 'tagihan', 'tunggakan', 'payment', 'pembayaran'];
        foreach ($sppWords as $word) {
            if (str_contains($msg, $word)) {
                return 'spp';
            }
        }

        // Tugas intent
        $taskWords = ['tugas', 'pr', 'penugasan', 'deadline', 'pekerjaan rumah'];
        foreach ($taskWords as $word) {
            if (str_contains($msg, $word)) {
                return 'task';
            }
        }

        return 'general';
    }
}
