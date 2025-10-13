<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     *
     * @var string
     */
    protected $table = 'guru';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'mata_pelajaran',
        'jenjang',
    ];

    /**
     * Mendefinisikan relasi one-to-one ke model User.
     * Setiap Guru memiliki satu akun User.
     */
    public function user()
    {
        // Relasi ini mengasumsikan ada kolom 'guru_id' di tabel 'users'.
        return $this->hasOne(User::class);
    }
}

