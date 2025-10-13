<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: sans-serif; }
        h1, h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total { font-weight: bold; text-align: right; }
    </style>
</head>
<body>
    <h1>Laporan Keuangan SPP</h1>
    <h2>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</h2>

    <table>
        <thead>
            <tr>
                <th>Tanggal Bayar</th>
                <th>Nama Siswa</th>
                <th>Deskripsi</th>
                <th>Jumlah</th>
                <th>Metode</th>
                <th>Verifikator</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pembayarans as $pembayaran)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d-m-Y H:i') }}</td>
                    <td>{{ $pembayaran->siswa->nama ?? 'N/A' }}</td>
                    <td>{{ $pembayaran->tagihan->deskripsi ?? 'N/A' }}</td>
                    <td>Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                    <td>{{ $pembayaran->metode_pembayaran }}</td>
                    <td>{{ $pembayaran->verifikator->name ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="total">Total Pemasukan:</td>
                <td>Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
