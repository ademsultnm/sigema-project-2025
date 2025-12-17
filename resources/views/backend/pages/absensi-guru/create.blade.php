@extends('backend.layouts.app')
@section('title', 'Input Absensi Guru')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none"><i class="bi bi-justify fs-3"></i></a>
        </header>

        <div class="page-heading">
            <h3>Input Absensi Harian Guru</h3>
        </div>

        <div class="page-content">
            <div class="card">
                <div class="card-header">Form Absensi Massal</div>
                <div class="card-body">
                    <form action="{{ route('absensi-guru.store') }}" method="POST">
                        @csrf
                        
                        {{-- PENGATURAN UMUM (TANGGAL & JENJANG) --}}
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal" class="fw-bold">Tanggal Absensi:</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenjang" class="fw-bold">Jenjang:</label>
                                    <select class="form-control" id="jenjang" name="jenjang" required>
                                        <option value="SMP">SMP</option>
                                        <option value="SMA">SMA</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- TABEL ABSENSI --}}
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th style="width: 35%">Nama Guru</th>
                                        <th style="width: 15%" class="bg-success text-white">Hadir</th>
                                        <th style="width: 15%" class="bg-warning text-dark">Sakit</th>
                                        <th style="width: 15%" class="bg-info text-white">Izin</th>
                                        <th style="width: 15%" class="bg-danger text-white">Alpha</th>
                                    </tr>
                                    {{-- Tombol Set All --}}
                                    <tr>
                                        <td colspan="2" class="text-end fw-bold">Set Semua ke:</td>
                                        <td class="text-center"><button type="button" onclick="setAll('hadir')" class="btn btn-sm btn-outline-success">All Hadir</button></td>
                                        <td class="text-center"><button type="button" onclick="setAll('sakit')" class="btn btn-sm btn-outline-warning">All Sakit</button></td>
                                        <td class="text-center"><button type="button" onclick="setAll('izin')" class="btn btn-sm btn-outline-info">All Izin</button></td>
                                        <td class="text-center"><button type="button" onclick="setAll('alpha')" class="btn btn-sm btn-outline-danger">All Alpha</button></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($gurus as $guru)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="fw-bold">{{ $guru->nama }}</td>
                                            
                                            {{-- RADIO BUTTONS --}}
                                            {{-- Name menggunakan array: kehadiran[ID_GURU] --}}
                                            
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input radio-hadir" type="radio" name="kehadiran[{{ $guru->id }}]" value="hadir" checked>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input radio-sakit" type="radio" name="kehadiran[{{ $guru->id }}]" value="sakit">
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input radio-izin" type="radio" name="kehadiran[{{ $guru->id }}]" value="izin">
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input radio-alpha" type="radio" name="kehadiran[{{ $guru->id }}]" value="alpha"> </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-save"></i> Simpan Absensi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT SEDERHANA UNTUK PILIH SEMUA --}}
    <script>
        function setAll(status) {
            let radios = document.querySelectorAll('.radio-' + status);
            radios.forEach(radio => {
                radio.checked = true;
            });
        }
    </script>
@endsection