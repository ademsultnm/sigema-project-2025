<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranSpp extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_spp';

    protected $fillable = [
        'tagihan_id',
        'siswa_id',
        'jumlah_bayar',
        'tanggal_bayar',
        'metode_pembayaran',
        'bukti_pembayaran',
        'kode_referensi',
        'status_verifikasi',
        'verifikator_id',
        'catatan',
    ];

    /**
     * Relasi ke model Siswa.
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    /**
     * Relasi ke model User (untuk verifikator).
     */
    public function verifikator()
    {
        return $this->belongsTo(User::class, 'verifikator_id');
    }

    /**
     * Relasi ke model TagihanSpp.
     */
    public function tagihan()
    {
        return $this->belongsTo(TagihanSpp::class, 'tagihan_id');
    }
}
