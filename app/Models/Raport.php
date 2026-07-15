<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Raport extends Model
{
    use HasFactory;
    protected $table = 'raport';

    protected $fillable = [
        'siswa_id',
        'mata_pelajaran_id', // baru
        'semester',
        'tahun_ajaran',
        'rata_rata_nilai',
        'keterangan',
        'jenjang',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function mataPelajaran() {
        // return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
        return $this->belongsTo(MataPelajaran::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

}
