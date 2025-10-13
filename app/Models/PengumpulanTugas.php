<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengumpulanTugas extends Model
{
    use HasFactory;

    protected $table = 'pengumpulan_tugas';

    protected $fillable = [
        'e_learning_id',
        'siswa_id',
        'file_data',
        'file_name',
        'file_mime',
        'waktu_pengumpulan',
        'nilai',
        'catatan_guru',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function eLearning()
    {
        return $this->belongsTo(ELearning::class, 'e_learning_id');
    }
}
