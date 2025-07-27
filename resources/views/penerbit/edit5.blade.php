@extends('layout.tampil')

@section('konten')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-primary text-white rounded-top">
                        <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Data Penerbit</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('penerbit.update5', $penerbit->id) }}" method="POST" class="needs-validation"
                            novalidate>
                            @csrf
                            @method('PUT')

                            {{-- Kode Penerbit --}}
                            <div class="mb-3 row">
                                <label for="kode_penerbit" class="col-md-4 col-form-label text-end fw-medium">Kode
                                    Penerbit</label>
                                <div class="col-md-8">
                                    <input type="text" name="kode_penerbit" id="kode_penerbit"
                                        value="{{ old('kode_penerbit', $penerbit->kode_penerbit) }}"
                                        class="form-control form-control-lg @error('kode_penerbit') is-invalid @enderror"
                                        required>
                                    @error('kode_penerbit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Nama Penerbit --}}
                            <div class="mb-4 row">
                                <label for="name" class="col-md-4 col-form-label text-end fw-medium">Nama
                                    Penerbit</label>
                                <div class="col-md-8">
                                    <input type="text" name="name" id="name"
                                        value="{{ old('name', $penerbit->name) }}"
                                        class="form-control form-control-lg @error('name') is-invalid @enderror" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Tombol --}}
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <a href="{{ route('penerbit.tampil6') }}" class="btn btn-outline-secondary btn-lg me-2">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div> <!-- /.card-body -->
                </div> <!-- /.card -->
            </div>
        </div>
    </div>

    {{-- Tambahan CSS --}}
    <style>
        .form-control-lg {
            border-radius: 0.375rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
        }

        .btn-lg:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
        }

        .card:hover {
            transform: translateY(-1px);
            transition: transform 0.2s ease-in-out;
        }
    </style>

    {{-- Validasi Bootstrap --}}
    <script>
        (() => {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
@endsection
