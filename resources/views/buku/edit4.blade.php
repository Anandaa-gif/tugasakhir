@extends('layout.tampil')

@section('konten')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-gradient-primary text-white rounded-top-3">
                    <h4 class="mb-0 fw-semibold">Edit Data Buku</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('buku.update4', $buku->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <label for="kode_buku" class="col-md-4 col-form-label text-end fw-medium">Kode Buku</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control form-control-lg transition-all" name="kode_buku" id="kode_buku" 
                                            placeholder="Masukkan Kode Buku" value="{{ old('kode_buku', $buku->kode_buku) }}" required>
                                        <div class="invalid-feedback">Kode buku wajib diisi.</div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="judul_buku" class="col-md-4 col-form-label text-end fw-medium">Judul Buku</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control form-control-lg transition-all" name="judul_buku" id="judul_buku" 
                                            placeholder="Masukkan Judul Buku" value="{{ old('judul_buku', $buku->judul_buku) }}" required>
                                        <div class="invalid-feedback">Judul buku wajib diisi.</div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="isbn" class="col-md-4 col-form-label text-end fw-medium">ISBN</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control form-control-lg transition-all" name="isbn" id="isbn" 
                                            placeholder="Masukkan ISBN" value="{{ old('isbn', $buku->isbn) }}" required>
                                        <div class="invalid-feedback">ISBN wajib diisi.</div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="penulis" class="col-md-4 col-form-label text-end fw-medium">Penulis</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control form-control-lg transition-all" name="penulis" id="penulis" 
                                            placeholder="Masukkan Nama Penulis" value="{{ old('penulis', $buku->penulis) }}" required>
                                        <div class="invalid-feedback">Nama penulis wajib diisi.</div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="tahun_terbit" class="col-md-4 col-form-label text-end fw-medium">Tahun Terbit</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control form-control-lg transition-all" name="tahun_terbit" id="tahun_terbit" 
                                            placeholder="Masukkan Tahun Terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" required>
                                        <div class="invalid-feedback">Tahun terbit wajib diisi.</div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="foto" class="col-md-4 col-form-label text-end fw-medium">Foto Buku</label>
                                    <div class="col-md-8">
                                        <input type="file" class="form-control transition-all" name="foto" id="foto" accept="image/*">
                                        @if ($buku->foto)
                                            <img src="{{ asset('foto/' . $buku->foto) }}" alt="Foto Buku" class="mt-2 rounded shadow-sm" style="max-width: 150px; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                        @endif
                                        <div class="form-text">Pilih file gambar (jpg, png, dll).</div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="stok" class="col-md-4 col-form-label text-end fw-medium">Stok</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control form-control-lg transition-all" name="stok" id="stok" 
                                            placeholder="Masukkan Jumlah Stok" value="{{ old('stok', $buku->stok) }}" min="0" required>
                                        <div class="invalid-feedback">Stok harus berupa angka positif.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <label for="penerbit_id" class="col-md-4 col-form-label text-end fw-medium">Penerbit</label>
                                    <div class="col-md-8">
                                        <select name="penerbit_id" class="form-select form-select-lg transition-all" id="penerbit_id" required>
                                            <option value="">-- Pilih Penerbit --</option>
                                            @foreach ($penerbit as $p)
                                                <option value="{{ $p->id }}" {{ old('penerbit_id', $buku->penerbit_id) == $p->id ? 'selected' : '' }}>
                                                    {{ $p->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">Penerbit wajib dipilih.</div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="jenis_id" class="col-md-4 col-form-label text-end fw-medium">Jenis</label>
                                    <div class="col-md-8">
                                        <select name="jenis_id" class="form-select form-select-lg transition-all" required>
                                            <option value="">-- Pilih Jenis --</option>
                                            @foreach ($jenis as $j)
                                                <option value="{{ $j->id }}" {{ old('jenis_id', $buku->jenis_id) == $j->id ? 'selected' : '' }}>
                                                    {{ $j->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">Jenis wajib dipilih.</div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="kategori_id" class="col-md-4 col-form-label text-end fw-medium">Kategori</label>
                                    <div class="col-md-8">
                                        <select name="kategori_id" class="form-select form-select-lg transition-all" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach ($kategori as $k)
                                                <option value="{{ $k->id }}" {{ old('kategori_id', $buku->kategori_id) == $k->id ? 'selected' : '' }}>
                                                    {{ $k->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">Kategori wajib dipilih.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-md-12 text-end">
                                <a href="{{ route('buku.tampil5') }}" class="btn btn-outline-secondary btn-lg me-2 transition-all" style="min-width: 120px;">
                                    <i class="fas fa-arrow-left me-1"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg transition-all" style="min-width: 120px;">
                                    <i class="fas fa-save me-1"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #007bff, #0056b3);
        }
        .form-control-lg, .form-select-lg {
            border-radius: 0.375rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .form-control:focus, .form-select:focus {
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
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</div>
@endsection