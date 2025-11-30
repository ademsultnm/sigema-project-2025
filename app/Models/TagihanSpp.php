<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagihanSpp extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     *
     * @var string
     */
    protected $table = 'tagihan_spp';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'siswa_id',
        'deskripsi',
        'jumlah_tagihan',
        'jatuh_tempo',
        'status',
        'tahun_ajaran',
        'payment_status',
        'external_id',
        'payment_channel',
        'payment_date',
        'raw_callback',
    ];

     protected $casts = [
        'payment_date' => 'datetime',
        'raw_callback' => 'array',
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model Siswa.
     * Setiap tagihan dimiliki oleh satu siswa.
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
