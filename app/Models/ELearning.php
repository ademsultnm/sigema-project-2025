<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ELearning extends Model
{
    use HasFactory;
    protected $table = 'e_learning';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'guru_id',
        'mata_pelajaran_id',
        'judul',
        'deskripsi',
        'jenjang',
        'tipe',
        'batas_waktu',
        // Kolom baru untuk file
        'file_data',
        'file_name',
        'file_mime',
    ];

    /**
     * Get the guru that owns the e-learning.
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    /**
     * Get the mata pelajaran that owns the e-learning.
     */
    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }
     public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'e_learning_kelas');
    }
      public function pengumpulanTugas()
    {
        return $this->hasMany(PengumpulanTugas::class);
    }
}
