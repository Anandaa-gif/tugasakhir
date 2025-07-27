@extends('layout.tampil')

@section('konten')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header bg-primary text-white rounded-top-3 py-3">
                        <h4 class="mb-0 fw-semibold">
                            <i class="fas fa-building me-2"></i>Tambah Penerbit
                        </h4>
                    </div>
                    <div class="card-body px-4 py-4">
                        <form action="{{ route('penerbit.submit5') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Kode Penerbit --}}
                            <div class="mb-3 row">
                                <label for="kode_penerbit" class="col-md-4 col-form-label text-end fw-medium">Kode</label>
                                <div class="col-md-8">
                                    <input type="text" name="kode_penerbit" id="kode_penerbit"
                                        class="form-control form-control-lg @error('kode_penerbit') is-invalid @enderror"
                                        placeholder="Kode Penerbit" required>
                                    @error('kode_penerbit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Nama Penerbit --}}
                            <div class="mb-4 row">
                                <label for="name" class="col-md-4 col-form-label text-end fw-medium">Nama</label>
                                <div class="col-md-8">
                                    <input type="text" name="name" id="name"
                                        class="form-control form-control-lg @error('name') is-invalid @enderror"
                                        placeholder="Nama Penerbit" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="row mt-4">
                                <div class="col-md-12 text-end">
                                    <a href="{{ route('penerbit.tampil6') }}" class="btn btn-outline-secondary btn-lg me-2">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save me-1"></i> Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
