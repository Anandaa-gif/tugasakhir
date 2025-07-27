@extends('layout.tampil')

@section('konten')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header bg-gradient-primary text-white rounded-top-3">
                        <h4 class="mb-0 fw-semibold"><i class="fas fa-plus-circle me-2"></i>Tambah Peminjaman</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('peminjaman.submit8') }}" method="POST" class="needs-validation" novalidate
                            autocomplete="off">
                            @csrf

                            {{-- Anggota --}}
                            <div class="mb-3">
                                <label for="anggota_id" class="form-label fw-medium">Nama Anggota</label>
                                <select name="anggota_id" id="anggota_id"
                                    class="form-select form-select-lg select2 transition-all @error('anggota_id') is-invalid @enderror"
                                    required>
                                    <option value="">-- Pilih Anggota --</option>
                                    @foreach ($anggota as $a)
                                        <option value="{{ $a->id }}"
                                            {{ old('anggota_id') == $a->id ? 'selected' : '' }}>
                                            {{ $a->namalengkap ?? ($a->nama ?? 'Nama Tidak Diketahui') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('anggota_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Buku --}}
                            <div class="mb-3">
                                <label for="buku_id" class="form-label fw-medium">Judul Buku</label>
                                <select name="buku_id[]" id="buku_id"
                                    class="form-select form-select-lg select2 transition-all @error('buku_id') is-invalid @enderror"
                                    multiple required>
                                    @foreach ($buku as $b)
                                        <option value="{{ $b->id }}"
                                            {{ in_array($b->id, old('buku_id', [])) ? 'selected' : '' }}>
                                            {{ $b->judul_buku }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('buku_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror


                                {{-- Tanggal Pinjam --}}
                                <div class="mb-3">
                                    <label for="tanggal_pinjam" class="form-label fw-medium">Tanggal Pinjam</label>
                                    <input type="date" name="tanggal_pinjam" id="tanggal_pinjam"
                                        value="{{ old('tanggal_pinjam') }}"
                                        class="form-control form-control-lg transition-all @error('tanggal_pinjam') is-invalid @enderror"
                                        required>
                                    @error('tanggal_pinjam')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Tanggal Kembali --}}
                                <div class="mb-3">
                                    <label for="tanggal_kembali" class="form-label fw-medium">Tanggal Kembali</label>
                                    <input type="date" name="tanggal_kembali" id="tanggal_kembali"
                                        value="{{ old('tanggal_kembali') }}"
                                        class="form-control form-control-lg transition-all @error('tanggal_kembali') is-invalid @enderror">
                                    @error('tanggal_kembali')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Status --}}
                                <div class="mb-4">
                                    <label for="status" class="form-label fw-medium">Status</label>
                                    <select name="status" id="status"
                                        class="form-select form-select-lg transition-all @error('status') is-invalid @enderror"
                                        required>
                                        <option value="dipinjam" {{ old('status') == 'dipinjam' ? 'selected' : '' }}>
                                            Dipinjam
                                        </option>
                                        <option value="dikembalikan"
                                            {{ old('status') == 'dikembalikan' ? 'selected' : '' }}>
                                            Dikembalikan</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Tombol --}}
                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="{{ route('peminjaman.tampil9') }}"
                                        class="btn btn-outline-secondary btn-lg transition-all" style="min-width: 120px;">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary btn-lg transition-all"
                                        style="min-width: 120px;">
                                        <i class="fas fa-save me-1"></i> Simpan
                                    </button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Style (selaras dengan form anggota) --}}
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
    @endsection

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    theme: 'bootstrap4',
                    placeholder: 'Pilih data...',
                    width: '100%',
                    allowClear: true
                });

                // Form validation
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
            });
        </script>
    @endpush
