@extends('layout.tampil')

@section('konten')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 rounded-3 transition-all">
                    <div class="card-header bg-gradient-primary text-white rounded-top-3">
                        <h4 class="mb-0 fw-semibold">Edit Data Pengunjung</h4>
                    </div>
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('pengunjung.update6', $kunjungan->id) }}" method="POST"
                            class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')

                            <!-- Nama Lengkap -->
                            <div class="mb-3 row">
                                <label for="nama" class="col-md-4 col-form-label text-end fw-medium">Nama
                                    Lengkap</label>
                                <div class="col-md-8">
                                    <input type="text" name="nama" id="nama"
                                        class="form-control form-control-lg transition-all @error('nama') is-invalid @enderror"
                                        value="{{ old('nama', $kunjungan->name) }}" placeholder="Masukkan Nama Lengkap"
                                        required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Jenis Pengunjung -->
                            <div class="mb-3 row">
                                <label for="type" class="col-md-4 col-form-label text-end fw-medium">Jenis
                                    Pengunjung</label>
                                <div class="col-md-8">
                                    <select name="tipe" id="type"
                                        class="form-select form-select-lg transition-all @error('tipe') is-invalid @enderror"
                                        onchange="toggleTamuFields(this)" required>
                                        <option value="">-- Pilih Jenis --</option>
                                        <option value="siswa"
                                            {{ old('tipe', $kunjungan->type) == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                        <option value="guru"
                                            {{ old('tipe', $kunjungan->type) == 'guru' ? 'selected' : '' }}>Guru</option>
                                        <option value="tamu"
                                            {{ old('tipe', $kunjungan->type) == 'tamu' ? 'selected' : '' }}>Tamu</option>
                                    </select>
                                    @error('tipe')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Tujuan Kunjungan -->
                            <div class="mb-3 row">
                                <label for="tujuan_kunjungan" class="col-md-4 col-form-label text-end fw-medium">Tujuan
                                    Kunjungan</label>
                                <div class="col-md-8">
                                    <input type="text" name="tujuan_kunjungan" id="tujuan_kunjungan"
                                        class="form-control form-control-lg transition-all @error('tujuan_kunjungan') is-invalid @enderror"
                                        value="{{ old('tujuan_kunjungan', $kunjungan->tujuan) }}"
                                        placeholder="Masukkan Tujuan Kunjungan" required>
                                    @error('tujuan_kunjungan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Tanggal Kunjungan -->
                            <div class="mb-3 row">
                                <label for="waktu_kunjungan" class="col-md-4 col-form-label text-end fw-medium">Tanggal
                                    Kunjungan</label>
                                <div class="col-md-8">
                                    <input type="date" name="waktu_kunjungan" id="waktu_kunjungan"
                                        class="form-control form-control-lg transition-all @error('waktu_kunjungan') is-invalid @enderror"
                                        value="{{ old('waktu_kunjungan', \Carbon\Carbon::parse($kunjungan->waktu_kunjung)->format('Y-m-d')) }}"
                                        required>
                                    @error('waktu_kunjungan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Alamat -->
                            <div class="mb-3 row {{ old('tipe', $kunjungan->type) == 'tamu' ? 'd-md-flex' : 'd-none' }}"
                                id="alamatField">
                                <label for="alamat" class="col-md-4 col-form-label text-end fw-medium">Alamat</label>
                                <div class="col-md-8">
                                    <input type="text" name="alamat" id="alamat"
                                        class="form-control form-control-lg transition-all @error('alamat') is-invalid @enderror"
                                        value="{{ old('alamat', $kunjungan->alamat) }}" placeholder="Masukkan Alamat">
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kesan & Pesan -->
                            <div class="mb-4 row {{ old('tipe', $kunjungan->type) == 'tamu' ? 'd-md-flex' : 'd-none' }}"
                                id="kesanPesanField">
                                <label for="kesan_pesan" class="col-md-4 col-form-label text-end fw-medium">Kesan &
                                    Pesan</label>
                                <div class="col-md-8">
                                    <textarea name="kesan_pesan" id="kesan_pesan"
                                        class="form-control form-control-lg transition-all @error('kesan_pesan') is-invalid @enderror" rows="3"
                                        placeholder="Masukkan Kesan dan Pesan">{{ old('kesan_pesan', $kunjungan->kesan_pesan) }}</textarea>
                                    @error('kesan_pesan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Tombol -->
                            <div class="row mt-5">
                                <div class="col-md-12 text-end">
                                    <a href="{{ route('pengunjung.tampil7') }}"
                                        class="btn btn-outline-secondary btn-lg me-2 transition-all"
                                        style="min-width: 120px;">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary btn-lg transition-all"
                                        style="min-width: 120px;">
                                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
        // Bootstrap form validation
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

        // Toggle fields berdasarkan jenis pengunjung
        function toggleTamuFields(select) {
            const alamat = document.getElementById('alamatField');
            const kesan = document.getElementById('kesanPesanField');
            if (select.value === 'tamu') {
                alamat.classList.remove('d-none');
                alamat.classList.add('d-md-flex');
                kesan.classList.remove('d-none');
                kesan.classList.add('d-md-flex');
            } else {
                alamat.classList.remove('d-md-flex');
                alamat.classList.add('d-none');
                kesan.classList.remove('d-md-flex');
                kesan.classList.add('d-none');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('type');
            toggleTamuFields(select);
        });
    </script>
@endsection
