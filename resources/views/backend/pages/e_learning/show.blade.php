@extends('backend.layouts.app')
@section('title', 'Detail E-Learning')
@section('content')
<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <h3>Detail E-Learning</h3>
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header"><h5>Detail E-Learning</h5></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Guru</label>
                            <p class="form-control-static">{{ $eLearning->guru->nama ?? 'N/A' }}</p>
                        </div>

                        <div class="form-group">
                            <label>Mata Pelajaran</label>
                            <p class="form-control-static">{{ $eLearning->mataPelajaran->nama ?? 'N/A' }}</p>
                        </div>
                        
                         <div class="form-group">
                            <label>Kelas yang Ditugaskan</label>
                            <div>
                                @forelse($eLearning->kelas as $kelas)
                                    <span class="badge bg-primary me-1">{{ $kelas->nama }}</span>
                                @empty
                                    <p class="form-control-static text-muted">Materi/tugas ini belum ditugaskan ke kelas manapun.</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Judul</label>
                            <p class="form-control-static">{{ $eLearning->judul }}</p>
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <p class="form-control-static">{{ $eLearning->deskripsi }}</p>
                        </div>
                        
                        <div class="form-group">
                            <label>File Materi/Tugas</label>
                            <div>
                                @if ($eLearning->file_name)
                                    <a href="{{ route('e_learning.download', $eLearning->id) }}" class="btn btn-success">
                                        <i class="bi bi-download"></i> Download ({{ $eLearning->file_name }})
                                    </a>
                                @else
                                    <p class="form-control-static">Tidak ada file yang diunggah.</p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Jenjang</label>
                            <p class="form-control-static">{{ $eLearning->jenjang }}</p>
                        </div>
                        
                         <div class="form-group">
                            <label>Tipe</label>
                             <p class="form-control-static"><span class="badge {{ $eLearning->tipe == 'tugas' ? 'bg-danger' : 'bg-info' }}">{{ ucfirst($eLearning->tipe) }}</span></p>
                        </div>
                        
                        @if($eLearning->tipe == 'tugas' && $eLearning->batas_waktu)
                        <div class="form-group">
                            <label>Batas Waktu</label>
                            <p class="form-control-static">{{ \Carbon\Carbon::parse($eLearning->batas_waktu)->format('d F Y, H:i') }}</p>
                        </div>
                        @endif

                        <a href="{{ route('e_learning.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                        <a href="{{ route('e_learning.edit', $eLearning->id) }}" class="btn btn-primary mt-3">Edit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

