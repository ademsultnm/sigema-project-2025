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
    ];

    /**
     * Mendefinisikan relasi "hasOne" ke model User.
     * Satu Siswa memiliki satu Akun User.
     */

    public function user()
    {
        return $this->hasOne(User::class, 'siswa_id');
    }

    // menggunakan belongs to many
    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_siswa', 'siswa_id', 'kelas_id')
        ->withPivot('tahun_ajaran')
        ->withTimestamps();
    }
}
