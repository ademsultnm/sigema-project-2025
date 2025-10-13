@extends('backend.layouts.app')
@section('title', 'Materi & Tugas')
@section('content')
    <div id="main">
        <div class="page-heading">
            <h3>Materi & Tugas</h3>
            <p class="text-subtitle text-muted">Daftar materi dan tugas untuk kelas Anda.</p>
        </div>
        <div class="page-content">
            @forelse ($eLearnings as $item)
                <div class="card">
                    <div class="card-header">
                        <span class="badge {{ $item->tipe == 'tugas' ? 'bg-danger' : 'bg-info' }}">{{ ucfirst($item->tipe) }}</span>
                        <h4 class="card-title mt-2">{{ $item->judul }}</h4>
                        <p class="text-muted small">
                            {{ $item->mataPelajaran->nama ?? 'N/A' }} | Oleh: {{ $item->guru->nama ?? 'N/A' }}
                        </p>
                    </div>
                    <div class="card-body">
                        <p>{{ Str::limit($item->deskripsi, 150) }}</p>
                         @if ($item->tipe == 'tugas' && $item->batas_waktu)
                            <p class="text-danger small">Batas Waktu: {{ \Carbon\Carbon::parse($item->batas_waktu)->format('d F Y, H:i') }}</p>
                        @endif
                        <a href="{{ route('siswa.elearning.show', $item->id) }}" class="btn btn-primary">Lihat Detail</a>
                    </div>
                </div>
            @empty
                <div class="card">
                    <div class="card-body">
                        <p class="text-center">Belum ada materi atau tugas untuk kelas Anda.</p>
                    </div>
                </div>
            @endforelse
            {{ $eLearnings->links() }}
        </div>
    </div>
@endsection
