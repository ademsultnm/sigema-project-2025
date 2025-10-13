@extends('backend.layouts.app')
@section('title', 'Detail Materi/Tugas')
@section('content')
<div id="main">
    <div class="page-heading">
        <h3>{{ $eLearning->judul }}</h3>
        <p class="text-subtitle text-muted">
            {{ $eLearning->mataPelajaran->nama ?? 'N/A' }} | Oleh: {{ $eLearning->guru->nama ?? 'N/A' }}
        </p>
    </div>
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <div class="mb-4">
                    <h5>Deskripsi</h5>
                    <p>{{ $eLearning->deskripsi }}</p>
                </div>

                @if ($eLearning->file_name)
                    <div class="mb-4">
                        <h5>Lampiran</h5>
                        <a href="{{ route('e_learning.download', $eLearning->id) }}" class="btn btn-success">
                            <i class="bi bi-download"></i> Download Materi/Soal ({{ $eLearning->file_name }})
                        </a>
                    </div>
                @endif

                {{-- FORM UPLOAD JAWABAN (HANYA JIKA TIPE TUGAS) --}}
                @if ($eLearning->tipe == 'tugas')
                    <hr>
                    <div class="mt-4">
                        <h5>Unggah Jawaban</h5>
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if ($jawabanTerkirim)
                             <div class="alert alert-info">
                                Anda sudah mengunggah jawaban pada: <strong>{{ \Carbon\Carbon::parse($jawabanTerkirim->waktu_pengumpulan)->format('d F Y, H:i') }}</strong>.
                                <br>Mengunggah file baru akan menggantikan file sebelumnya.
                            </div>
                        @endif
                        
                        <form action="{{ route('siswa.elearning.submit', $eLearning->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="file_jawaban">Pilih File Jawaban (Maks: 5MB)</label>
                                <input type="file" name="file_jawaban" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Unggah Jawaban</button>
                        </form>
                    </div>
                @endif
                <div class="mt-4">
                     <a href="{{ route('siswa.elearning.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
