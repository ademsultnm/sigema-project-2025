<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Raport</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <h3 style="text-align:center;">Laporan Data Raport Siswa <br> SMA Gema 45 Surabaya</h3>
    <p>Tanggal Cetak: {{ date('d-m-Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Semester</th>
                <th>Rata-rata</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($raports as $raport)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $raport->siswa->nama ?? 'Siswa Dihapus' }}</td>
                    <td>
                        @if($raport->siswa && $raport->siswa->kelas->isNotEmpty())
                            {{ $raport->siswa->kelas->last()->nama }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $raport->mataPelajaran->nama ?? '-' }}</td>
                    <td>{{ $raport->semester }} / {{ $raport->tahun_ajaran }}</td>
                    <td>{{ $raport->rata_rata_nilai }}</td>
                    <td>{{ $raport->keterangan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;">Data tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
