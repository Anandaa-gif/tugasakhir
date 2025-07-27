@extends('layout.tampil')

@section('konten')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header bg-gradient-primary text-white rounded-top-3 text-center">
                        <h4 class="mb-0 fw-semibold">Tambah Pengembalian</h4>
                    </div>
                    <div class="card-body p-4">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('pengembalian.submit7') }}" method="POST" class="needs-validation"
                            novalidate>
                            @csrf

                            {{-- Pilih Peminjaman --}}
                            <div class="mb-3 row">
                                <label for="peminjaman_id"
                                    class="col-md-4 col-form-label text-md-end fw-medium">Peminjaman</label>
                                <div class="col-md-8">
                                    <select id="peminjaman_id" name="peminjaman_id"
                                        class="form-select select2 @error('peminjaman_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Peminjaman --</option>
                                        @foreach ($peminjaman as $item)
                                            <option value="{{ $item->id }}"
                                                data-nama="{{ $item->anggota->namalengkap }}"
                                                data-tanggal="{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('Y-m-d') }}"
                                                {{ old('peminjaman_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->anggota->namalengkap }} - {{ $item->buku->judul_buku }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('peminjaman_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Nama --}}
                            <div class="mb-3 row">
                                <label for="nama" class="col-md-4 col-form-label text-md-end fw-medium">Nama</label>
                                <div class="col-md-8">
                                    <input type="text" id="nama" name="nama" class="form-control" readonly
                                        value="{{ old('nama') }}" placeholder="Otomatis dari peminjaman">
                                </div>
                            </div>

                            {{-- Tanggal Harus Kembali --}}
                            <div class="mb-3 row">
                                <label for="tanggal_harus_kembali"
                                    class="col-md-4 col-form-label text-md-end fw-medium">Tanggal Harus Kembali</label>
                                <div class="col-md-8">
                                    <input type="date" id="tanggal_harus_kembali" name="tanggal_harus_kembali"
                                        class="form-control" readonly value="{{ old('tanggal_harus_kembali') }}">
                                </div>
                            </div>

                            {{-- Tanggal Kembali --}}
                            <div class="mb-3 row">
                                <label for="tanggal_kembali" class="col-md-4 col-form-label text-md-end fw-medium">Tanggal
                                    Kembali</label>
                                <div class="col-md-8">
                                    <input type="date" id="tanggal_kembali" name="tanggal_kembali"
                                        class="form-control @error('tanggal_kembali') is-invalid @enderror"
                                        value="{{ old('tanggal_kembali', now()->toDateString()) }}" required>
                                    @error('tanggal_kembali')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Keterlambatan --}}
                            <div class="mb-3 row">
                                <label for="keterlambatan" class="col-md-4 col-form-label text-md-end fw-medium">Status
                                    Keterlambatan</label>
                                <div class="col-md-8">
                                    <select id="keterlambatan" name="keterlambatan"
                                        class="form-select @error('keterlambatan') is-invalid @enderror" required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Telat" {{ old('keterlambatan') == 'Telat' ? 'selected' : '' }}>
                                            Telat</option>
                                        <option value="Tepat Waktu"
                                            {{ old('keterlambatan') == 'Tepat Waktu' ? 'selected' : '' }}>Tepat Waktu
                                        </option>
                                    </select>
                                    @error('keterlambatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Tombol --}}
                            <div class="row mt-4">
                                <div class="col-md-12 text-end">
                                    <a href="{{ route('pengembalian.tampil8') }}"
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

        <style>
            .bg-gradient-primary {
                background: linear-gradient(135deg, #007bff, #0056b3);
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

            .card:hover {
                transform: translateY(-2px);
            }
        </style>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#peminjaman_id').select2({
                    placeholder: "-- Pilih Peminjaman --",
                    width: '100%'
                });

                $('#peminjaman_id').on('change', function() {
                    const selectedOption = $(this).find('option:selected');
                    const nama = selectedOption.data('nama') || '';
                    const tanggal = selectedOption.data('tanggal') || '';
                    $('#nama').val(nama);
                    $('#tanggal_harus_kembali').val(tanggal);
                    hitungKeterlambatan();
                });

                $('#tanggal_kembali').on('change', hitungKeterlambatan);

                function hitungKeterlambatan() {
                    const kembali = new Date($('#tanggal_kembali').val());
                    const harus = new Date($('#tanggal_harus_kembali').val());
                    if (!isNaN(kembali) && !isNaN(harus)) {
                        const status = kembali > harus ? 'Telat' : 'Tepat Waktu';
                        $('#keterlambatan').val(status);
                    }
                }

                if ($('#peminjaman_id').val()) {
                    $('#peminjaman_id').trigger('change');
                }
            });
        </script>
    @endsection
