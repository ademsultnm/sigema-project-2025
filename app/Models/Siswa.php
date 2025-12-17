<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $table = 'siswa';

    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'jenjang',
        // 'kelas_id' dihapus karena pakai tabel perantara
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'siswa_id');
    }

    // Gunakan belongsToMany
    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_siswa', 'siswa_id', 'kelas_id')
                    ->withPivot('tahun_ajaran')
                    ->withTimestamps();
    }
}