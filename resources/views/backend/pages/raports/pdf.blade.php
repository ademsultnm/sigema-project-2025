<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Raport</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        .header p { margin: 5px 0; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Data Raport Siswa</h2>
        <p>Dicetak pada: {{ date('d F Y, H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Semester</th>
                <th>Nilai</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($raports as $raport)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $raport->siswa->nama ?? 'Siswa Dihapus' }}</td>
                    
                    {{-- Logika Kelas --}}
                    <td>
                        @if($raport->siswa && $raport->siswa->kelas->isNotEmpty())
                            {{ $raport->siswa->kelas->last()->nama }}
                        @else
                            -
                        @endif
                    </td>

                    <td>{{ $raport->mataPelajaran->nama ?? '-' }}</td>
                    <td>
                        {{ $raport->semester }} <br>
                        <small>({{ $raport->tahun_ajaran }})</small>
                    </td>
                    <td class="text-center">{{ $raport->rata_rata_nilai }}</td>
                    <td>{{ $raport->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>