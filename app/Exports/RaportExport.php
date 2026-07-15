<?php

namespace App\Exports;

use App\Models\Raport;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RaportExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
protected $filters;

public function __construct($filters)
{
$this->filters = $filters;
}

public function query()
{
    $query = Raport::with(['siswa.kelas', 'mataPelajaran']);

      // 1. Filter Nama Siswa
    if (!empty($this->filters['nama_siswa'])) {
        $query->whereHas('siswa', function ($q) {
        $q->where('nama', 'like', '%' . $this->filters['nama_siswa'] . '%');
        });
    }

    // 2. Filter Kelas (Many-to-Many check)
    if (!empty($this->filters['kelas_id'])) {
        $query->whereHas('siswa.kelas', function ($q) {
        $q->where('kelas.id', $this->filters['kelas_id']);
        });
    }

    // 3. Filter Mapel
    if (!empty($this->filters['mata_pelajaran_id'])) {
        $query->where('mata_pelajaran_id', $this->filters['mata_pelajaran_id']);
    }

    // 4. Filter Lainnya
    if (!empty($this->filters['semester'])) {
        $query->where('semester', $this->filters['semester']);
    }
    if (!empty($this->filters['tahun_ajaran'])) {
        $query->where('tahun_ajaran', $this->filters['tahun_ajaran']);
    }

    return $query;
}

public function headings(): array
{
    return [
        'Nama Siswa',
        'Kelas Terakhir',
        'Mata Pelajaran',
        'Semester',
        'Tahun Ajaran',
        'Rata-rata Nilai',
        'Keterangan'
    ];
}

public function map($raport): array
{
// Ambil kelas terakhir siswa
// $kelas = $raport->siswa && $raport->siswa->kelas->isNotEmpty()
//       ? $raport->siswa->kelas->last()->nama
//       : '-';
$kelas = $raport->siswa && $raport->siswa->kelas
    ? $raport->siswa->kelas->nama
    : '-';

return [
    $raport->siswa->nama ?? 'Siswa Dihapus',
    $kelas,
    $raport->mataPelajaran->nama ?? '-',
    $raport->semester,
    $raport->tahun_ajaran,
    $raport->rata_rata_nilai,
    $raport->keterangan,
];
}
}
