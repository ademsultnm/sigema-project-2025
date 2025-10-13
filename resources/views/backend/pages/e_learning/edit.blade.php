@extends('backend.layouts.app')
@section('title', 'Edit E-Learning')
@section('content')
<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <h3>Edit E-Learning</h3>
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header"><h5>Edit E-Learning</h5></div>
                    <div class="card-body">
                         @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Oops!</strong> Terjadi beberapa kesalahan:<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('e_learning.update', $eLearning->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="guru_id">Guru</label>
                                <select class="form-control" id="guru_id" name="guru_id" required>
                                    @foreach ($gurus as $guru)
                                    <option value="{{ $guru->id }}" @if ($guru->id === $eLearning->guru_id) selected @endif>{{ $guru->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="mata_pelajaran_id">Mata Pelajaran</label>
                                <select class="form-control" id="mata_pelajaran_id" name="mata_pelajaran_id" required>
                                    @foreach ($mataPelajarans as $mataPelajaran)
                                    <option value="{{ $mataPelajaran->id }}" @if ($mataPelajaran->id === $eLearning->mata_pelajaran_id) selected @endif>{{ $mataPelajaran->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="kelas_ids">Tugaskan ke Kelas (bisa pilih lebih dari satu)</label>
                                @php
                                    $selectedKelas = $eLearning->kelas->pluck('id')->toArray();
                                @endphp
                                <select class="form-control" id="kelas_ids" name="kelas_ids[]" multiple required>
                                    @foreach ($kelas as $kelasItem)
                                        <option value="{{ $kelasItem->id }}" {{ in_array($kelasItem->id, old('kelas_ids', $selectedKelas)) ? 'selected' : '' }}>
                                            {{ $kelasItem->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Tahan tombol Ctrl (atau Cmd di Mac) untuk memilih lebih dari satu kelas.</small>
                            </div>

                            <div class="form-group">
                                <label for="judul">Judul</label>
                                <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul', $eLearning->judul) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3" required>{{ old('deskripsi', $eLearning->deskripsi) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="materi_file">Unggah File Baru (Opsional)</label>
                                <input type="file" class="form-control @error('materi_file') is-invalid @enderror" id="materi_file" name="materi_file">
                                <small class="form-text text-muted">
                                    File saat ini: <strong>{{ $eLearning->file_name ?? 'Tidak ada' }}</strong><br>
                                    Unggah file baru untuk menggantikan. Maksimal 5MB.
                                </small>
                            </div>

                            <div class="form-group">
                                <label for="jenjang">Jenjang</label>
                                <select class="form-control" id="jenjang" name="jenjang" required>
                                    <option value="SMP" @if ($eLearning->jenjang === 'SMP') selected @endif>SMP</option>
                                    <option value="SMA" @if ($eLearning->jenjang === 'SMA') selected @endif>SMA</option>
                                </select>
                            </div>

                             <div class="form-group">
                                <label for="tipe">Tipe</label>
                                <select class="form-control" id="tipe" name="tipe" required>
                                    <option value="materi" @if ($eLearning->tipe === 'materi') selected @endif>Materi</option>
                                    <option value="tugas" @if ($eLearning->tipe === 'tugas') selected @endif>Tugas</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="batas_waktu">Batas Waktu (Jika Tugas)</label>
                                <input type="datetime-local" class="form-control @error('batas_waktu') is-invalid @enderror" id="batas_waktu" name="batas_waktu" value="{{ old('batas_waktu', $eLearning->batas_waktu) }}">
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
                            <a href="{{ route('e_learning.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

