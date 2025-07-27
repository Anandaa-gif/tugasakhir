@extends('layout.tampil')

@section('konten')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header bg-gradient-primary text-white rounded-top-3">
                        <h4 class="mb-0 fw-semibold">Tambah Anggota</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('dataanggota.submit1') }}" method="POST" id="formAnggota"
                            class="needs-validation" novalidate autocomplete="off">
                            @csrf

                            {{-- Jenis Anggota --}}
                            <div class="mb-3 row">
                                <label for="jenis" class="col-md-4 col-form-label text-end fw-medium">Jenis
                                    Anggota</label>
                                <div class="col-md-8">
                                    <select id="jenis" name="jenis"
                                        class="form-select form-select-lg transition-all @error('jenis') is-invalid @enderror"
                                        onchange="toggleKelas()" required>
                                        <option value="">-- Pilih Jenis --</option>
                                        <option value="Siswa" {{ old('jenis') == 'Siswa' ? 'selected' : '' }}>Siswa
                                        </option>
                                        <option value="Guru" {{ old('jenis') == 'Guru' ? 'selected' : '' }}>Guru</option>
                                        <option value="Karyawan" {{ old('jenis') == 'Karyawan' ? 'selected' : '' }}>Karyawan
                                        </option>
                                    </select>
                                    @error('jenis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- NIS --}}
                            <div class="mb-3 row">
                                <label for="nis" class="col-md-4 col-form-label text-end fw-medium">NIS</label>
                                <div class="col-md-8">
                                    <input type="text" id="nis" name="nis"
                                        class="form-control form-control-lg transition-all @error('nis') is-invalid @enderror"
                                        value="{{ old('nis') }}" placeholder="Masukkan NIS/NIP" required>
                                    @error('nis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Nama Lengkap --}}
                            <div class="mb-3 row">
                                <label for="namalengkap" class="col-md-4 col-form-label text-end fw-medium">Nama
                                    Lengkap</label>
                                <div class="col-md-8">
                                    <input type="text" id="namalengkap" name="namalengkap"
                                        class="form-control form-control-lg transition-all @error('namalengkap') is-invalid @enderror"
                                        value="{{ old('namalengkap') }}" placeholder="Masukkan Nama Lengkap" required>
                                    @error('namalengkap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Nomor Anggota (readonly, auto-generate) --}}
                            <div class="mb-3 row">
                                <label for="nomor_anggota" class="col-md-4 col-form-label text-end fw-medium">Nomor
                                    Anggota</label>
                                <div class="col-md-8">
                                    <input type="text" id="nomor_anggota"
                                        class="form-control form-control-lg transition-all bg-light"
                                        value="{{ $nomor_anggota }}" readonly disabled>
                                    <small class="text-muted">Nomor anggota dibuat otomatis oleh sistem</small>
                                </div>
                            </div>


                            {{-- Kelas (khusus Siswa) --}}
                            <div class="mb-3 row {{ old('jenis') == 'Siswa' ? '' : 'd-none' }}" id="kelasRow">
                                <label for="kelas" class="col-md-4 col-form-label text-end fw-medium">Kelas</label>
                                <div class="col-md-8">
                                    <select id="kelas" name="kelas"
                                        class="form-select form-select-lg transition-all @error('kelas') is-invalid @enderror">
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach (['7A', '7B', '7C', '7D', '8A', '8B', '8C', '8D', '9A', '9B', '9C', '9D'] as $kelas)
                                            <option value="{{ $kelas }}"
                                                {{ old('kelas') == $kelas ? 'selected' : '' }}>
                                                {{ $kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kelas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Alamat --}}
                            <div class="mb-3 row">
                                <label for="alamat" class="col-md-4 col-form-label text-end fw-medium">Alamat</label>
                                <div class="col-md-8">
                                    <input type="text" id="alamat" name="alamat"
                                        class="form-control form-control-lg transition-all @error('alamat') is-invalid @enderror"
                                        value="{{ old('alamat') }}" placeholder="Masukkan Alamat">
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- No HP --}}
                            <div class="mb-4 row">
                                <label for="no_hp" class="col-md-4 col-form-label text-end fw-medium">No Telepon</label>
                                <div class="col-md-8">
                                    <input type="text" id="no_hp" name="no_hp"
                                        class="form-control form-control-lg transition-all @error('no_hp') is-invalid @enderror"
                                        value="{{ old('no_hp') }}" placeholder="Masukkan No Telepon">
                                    @error('no_hp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Tombol --}}
                            <div class="row mt-5">
                                <div class="col-md-12 text-end">
                                    <a href="{{ route('dataanggota.tampil1') }}"
                                        class="btn btn-outline-secondary btn-lg me-2 transition-all"
                                        style="min-width: 120px;">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary btn-lg transition-all"
                                        style="min-width: 120px;">
                                        <i class="fas fa-save me-1"></i> Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Style dan Script --}}
        <style>
            .bg-gradient-primary {
                background: linear-gradient(135deg, #007bff, #0056b3);
            }

            .form-control-lg,
            .form-select-lg {
                border-radius: 0.375rem;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            }

            .form-control:focus,
            .form-select:focus {
                border-color: #007bff;
                box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
            }

            .transition-all {
                transition: all 0.2s ease-in-out;
            }

            .btn-lg:hover {
                transform: translateY(-1px);
                box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
            }

            .card {
                transition: transform 0.2s;
            }

            .card:hover {
                transform: translateY(-2px);
            }
        </style>

        <script>
            (function() {
                'use strict'
                var forms = document.querySelectorAll('.needs-validation')
                Array.prototype.slice.call(forms).forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
            })()

            function toggleKelas() {
                const jenis = document.getElementById('jenis').value;
                const kelasRow = document.getElementById('kelasRow');

                if (jenis === 'Siswa') {
                    kelasRow.classList.remove('d-none');
                    kelasRow.classList.add('d-md-flex');
                } else {
                    kelasRow.classList.remove('d-md-flex');
                    kelasRow.classList.add('d-none');
                    document.getElementById('kelas').value = '';
                }
            }

            window.onload = toggleKelas;
        </script>
    </div>
@endsection
