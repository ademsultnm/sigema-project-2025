<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiSiswa extends Model
{
    use HasFactory;

    protected $table = 'absensi_siswa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'siswa_id',
        'kelas_id', // <-- PERBAIKAN DI SINI
        'tanggal',
        'kehadiran',
        'jenjang',
    ];

    /**
     * Mendefinisikan relasi ke model Siswa.
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    /**
     * Mendefinisikan relasi ke model Kelas.
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}

