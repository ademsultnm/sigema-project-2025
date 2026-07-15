@extends('backend.layouts.app')
@section('title', 'Detail Nilai - ' . $mapel->nama)
@section('content')
   <div id="main">
      <div class="page-heading d-flex justify-content-between align-items-center">
         <div>
            <h3>Detail Nilai: {{ $mapel->nama }}</h3>
            <p class="text-subtitle text-muted">Rincian riwayat nilai raport untuk mata pelajaran ini.</p>
         </div>
         <a href="{{ route('dashboard') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali ke
            Dashboard</a>
      </div>

      <div class="page-content">
         {{-- Section Ringkasan Atas (Kotak Besar) --}}
         <div class="row mb-4">
            <div class="col-md-12">
               <div class="card bg-primary text-white shadow">
                  <div class="card-body p-4 text-center">
                     <h5 class="text-white mb-2">Nilai Rata-rata Keseluruhan</h5>
                     <h1 class="font-extrabold text-white" style="font-size: 4rem;">{{ $rataRataMapel }}</h1>
                     <p class="text-white opacity-75 mb-0">{{ $siswa->nama }} - {{ $mapel->nama }}</p>
                  </div>
               </div>
            </div>
         </div>

         {{-- Section Tabel (Tampilan Excel Sheet) --}}
         <div class="card">
            <div class="card-header">
               <h5>Lembar Data Nilai</h5>
            </div>
            <div class="card-body p-0">
               <div class="table-responsive">
                  {{-- Style khusus untuk tabel agar mirip Excel --}}
                  <style>
                     .table-excel {
                        border-collapse: collapse;
                        width: 100%;
                     }

                     .table-excel th,
                     .table-excel td {
                        border: 1px solid #c7c7c7;
                        /* Garis grid */
                        padding: 8px 12px;
                     }

                     .table-excel thead th {
                        background-color: #f0f0f0;
                        /* Warna header excel */
                        font-weight: bold;
                        text-align: center;
                     }

                     .table-excel tbody tr:hover {
                        background-color: #e6f7ff;
                        /* Highlight row saat hover */
                     }

                     .cell-nilai {
                        text-align: center;
                        font-weight: bold;
                     }
                  </style>

                  <table class="table-excel mb-0">
                     <thead>
                        <tr>
                           <th style="width: 5%">No</th>
                           <th style="width: 20%">Tanggal Input</th>
                           <th style="width: 15%">Tahun Ajaran</th>
                           <th style="width: 10%">Semester</th>
                           <th style="width: 15%">Kelas</th>
                           <th style="width: 15%">Nilai</th>
                           <th style="width: 20%">Keterangan</th>
                        </tr>
                     </thead>
                     <tbody>
                        @forelse ($detailNilai as $data)
                           <tr>
                              <td class="text-center">{{ $loop->iteration }}</td>
                              {{-- Tanggal Input (Diambil dari created_at atau updated_at) --}}
                              <td class="text-center">
                                 {{ $data->created_at->format('d/m/Y') }} <br>
                                 <small class="text-muted">{{ $data->created_at->format('H:i') }}</small>
                              </td>
                              <td class="text-center">{{ $data->tahun_ajaran }}</td>
                              <td class="text-center">{{ $data->semester }}</td>
                              {{-- Mengambil kelas terakhir siswa saat data ini ada (Asumsi relasi many-to-many ambil latest,
                              atau jika di tabel raport ada kelas_id, pakai itu) --}}
                              <td class="text-center">
                                 {{-- Logika: Jika di raport ada kolom kelas, tampilkan. Jika tidak, ambil kelas siswa saat
                                 ini --}}
                                 {{ $data->siswa->kelas->last()->nama ?? '-' }}
                              </td>
                              <td class="cell-nilai" style="color: {{ $data->rata_rata_nilai >= 75 ? 'green' : 'red' }}">
                                 {{ $data->rata_rata_nilai }}
                              </td>
                              <td>{{ $data->keterangan }}</td>
                           </tr>
                        @empty
                           <tr>
                              <td colspan="7" class="text-center py-4 text-muted">
                                 Tidak ada data nilai rinci.
                              </td>
                           </tr>
                        @endforelse
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection