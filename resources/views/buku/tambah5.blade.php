@extends('layout.tampil')

@section('konten')
    <div class="container py-5">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header bg-gradient-primary text-white rounded-top-3">
                <h4 class="mb-0 fw-semibold text-center">Form Tambah Buku</h4>
            </div>

            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('buku.submit4') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf

                    <div class="row">
                        {{-- Kiri --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kode_buku" class="form-label fw-medium">Kode Buku</label>
                                <input type="text" name="kode_buku" id="kode_buku"
                                    class="form-control form-control-lg transition-all @error('kode_buku') is-invalid @enderror"
                                    value="{{ old('kode_buku') }}" required>
                                @error('kode_buku')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="judul_buku" class="form-label fw-medium">Judul Buku</label>
                                <input type="text" name="judul_buku" id="judul_buku"
                                    class="form-control form-control-lg transition-all @error('judul_buku') is-invalid @enderror"
                                    value="{{ old('judul_buku') }}" required>
                                @error('judul_buku')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="isbn" class="form-label fw-medium">ISBN</label>
                                <input type="text" name="isbn" id="isbn"
                                    class="form-control form-control-lg transition-all @error('isbn') is-invalid @enderror"
                                    value="{{ old('isbn') }}" required>
                                @error('isbn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="penulis" class="form-label fw-medium">Penulis</label>
                                <input type="text" name="penulis" id="penulis"
                                    class="form-control form-control-lg transition-all @error('penulis') is-invalid @enderror"
                                    value="{{ old('penulis') }}" required>
                                @error('penulis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tahun_terbit" class="form-label fw-medium">Tahun Terbit</label>
                                <input type="text" name="tahun_terbit" id="tahun_terbit"
                                    class="form-control form-control-lg transition-all @error('tahun_terbit') is-invalid @enderror"
                                    value="{{ old('tahun_terbit') }}" required>
                                @error('tahun_terbit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="foto" class="form-label fw-medium">Foto Buku</label>
                                <input type="file" name="foto" id="foto"
                                    class="form-control form-control-lg transition-all @error('foto') is-invalid @enderror"
                                    accept="image/*">
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <img id="preview" src="#" class="img-thumbnail mt-2 d-none" width="150" />
                            </div>

                            <div class="mb-3">
                                <label for="stok" class="form-label fw-medium">Stok</label>
                                <input type="number" name="stok" id="stok"
                                    class="form-control form-control-lg transition-all @error('stok') is-invalid @enderror"
                                    value="{{ old('stok', 0) }}" min="0" required>
                                @error('stok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Kanan --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="penerbit_id" class="form-label fw-medium">Penerbit</label>
                                <select name="penerbit_id" id="penerbit_id"
                                    class="form-select form-select-lg transition-all @error('penerbit_id') is-invalid @enderror"
                                    required>
                                    <option value="">-- Pilih Penerbit --</option>
                                    @foreach ($penerbit as $p)
                                        <option value="{{ $p->id }}" {{ old('penerbit_id') == $p->id ? 'selected' : '' }}>
                                            {{ $p->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('penerbit_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="jenis_id" class="form-label fw-medium">Jenis</label>
                                <select name="jenis_id" id="jenis_id"
                                    class="form-select form-select-lg transition-all @error('jenis_id') is-invalid @enderror"
                                    required>
                                    <option value="">-- Pilih Jenis --</option>
                                    @foreach ($jenis as $j)
                                        <option value="{{ $j->id }}" {{ old('jenis_id') == $j->id ? 'selected' : '' }}>
                                            {{ $j->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jenis_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="kategori_id" class="form-label fw-medium">Kategori</label>
                                <select name="kategori_id" id="kategori_id"
                                    class="form-select form-select-lg transition-all @error('kategori_id') is-invalid @enderror"
                                    required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($kategori as $k)
                                        <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Tombol --}}
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

        {{-- Style --}}
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

        {{-- Script Preview --}}
        <script>
            document.getElementById('foto').onchange = evt => {
                const [file] = evt.target.files;
                const preview = document.getElementById('preview');
                if (file) {
                    preview.src = URL.createObjectURL(file);
                    preview.classList.remove('d-none');
                }
            };

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
            })();
        </script>
    </div>
@endsection
