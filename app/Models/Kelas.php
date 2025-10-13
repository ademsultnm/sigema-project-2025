<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';

    protected $fillable = [
        'nama',
        'tingkat',
        'jenjang',
    ];
      public function siswas()
    {
        return $this->belongsToMany(Siswa::class, 'kelas_siswa')->withPivot('tahun_ajaran')->withTimestamps();
    }
     public function eLearning()
    {
        return $this->belongsToMany(ELearning::class, 'e_learning_kelas');
    }
}
