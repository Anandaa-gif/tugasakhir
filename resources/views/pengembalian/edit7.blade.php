@extends('layout.tampil')

@section('konten')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header bg-gradient-primary text-white rounded-top-3">
                        <h4 class="mb-0 fw-semibold">Edit Pengembalian</h4>
                    </div>
                    <div class="card-body p-4">

                        {{-- Menampilkan error validasi --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('pengembalian.update7', $pengembalian->id) }}" method="POST"
                            class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')

                            {{-- Peminjaman --}}
                            <div class="mb-3 row">
                                <label for="peminjaman_id"
                                    class="col-md-4 col-form-label text-md-end fw-medium">Peminjaman</label>
                                <div class="col-md-8">
                                    <select id="peminjaman_id" name="peminjaman_id" class="form-select" required>
                                        @foreach ($peminjaman as $item)
                                            <option value="{{ $item->id }}"
                                                data-nama="{{ $item->anggota->namalengkap ?? '-' }}"
                                                data-tanggal-kembali="{{ $item->tanggal_kembali }}"
                                                data-tanggal-pinjam="{{ $item->tanggal_pinjam }}"
                                                {{ $item->id == $pengembalian->peminjaman_id ? 'selected' : '' }}>
                                                {{ $item->anggota->namalengkap ?? '-' }} -
                                                {{ $item->buku->judul_buku ?? '-' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Nama --}}
                            <div class="mb-3 row">
                                <label for="nama" class="col-md-4 col-form-label text-md-end fw-medium">Nama</label>
                                <div class="col-md-8">
                                    <input type="text" id="nama" name="nama" class="form-control" readonly
                                        required>
                                </div>
                            </div>

                            {{-- Tanggal Pengembalian --}}
                            <div class="mb-3 row">
                                <label for="tanggal_kembali" class="col-md-4 col-form-label text-md-end fw-medium">Tanggal
                                    Kembali</label>
                                <div class="col-md-8">
                                    <input type="date" id="tanggal_kembali" name="tanggal_kembali" class="form-control"
                                        value="{{ \Carbon\Carbon::parse($pengembalian->tanggal_kembali)->format('Y-m-d') }}"
                                        required>
                                </div>
                            </div>

                            {{-- Keterlambatan --}}
                            <div class="mb-3 row">
                                <label for="keterlambatan_display"
                                    class="col-md-4 col-form-label text-md-end fw-medium">Keterlambatan</label>
                                <div class="col-md-8">
                                    <input type="text" id="keterlambatan_display" class="form-control" readonly>
                                    <input type="hidden" name="keterlambatan" id="keterlambatan"
                                        value="{{ $pengembalian->keterlambatan }}">
                                </div>
                            </div>

                            {{-- Jumlah Denda --}}
                            <div class="mb-3 row">
                                <label for="jumlah_denda_display"
                                    class="col-md-4 col-form-label text-md-end fw-medium">Jumlah Denda</label>
                                <div class="col-md-8">
                                    <input type="text" id="jumlah_denda_display" class="form-control" readonly>
                                    <input type="hidden" name="jumlah_denda" id="jumlah_denda"
                                        value="{{ $pengembalian->jumlah_denda }}">
                                </div>
                            </div>

                            {{-- Tanggal Harus Kembali (hidden) --}}
                            <input type="hidden" name="tanggal_harus_kembali" id="tanggal_harus_kembali">

                            {{-- Tombol --}}
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <a href="{{ route('pengembalian.tampil8') }}"
                                        class="btn btn-outline-secondary btn-lg me-2">
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

        {{-- Script --}}
        <script>
            const peminjamanSelect = document.getElementById('peminjaman_id');
            const namaInput = document.getElementById('nama');
            const tanggalKembaliInput = document.getElementById('tanggal_kembali');
            const keterlambatanInput = document.getElementById('keterlambatan');
            const keterlambatanDisplay = document.getElementById('keterlambatan_display');
            const jumlahDendaInput = document.getElementById('jumlah_denda');
            const jumlahDendaDisplay = document.getElementById('jumlah_denda_display');
            const tanggalHarusKembaliInput = document.getElementById('tanggal_harus_kembali');

            function updateFields() {
                const selected = peminjamanSelect.options[peminjamanSelect.selectedIndex];
                const nama = selected.getAttribute('data-nama') || '';
                const tanggalHarusKembali = selected.getAttribute('data-tanggal-kembali');
                const tanggalAktual = tanggalKembaliInput.value;

                namaInput.value = nama;
                tanggalHarusKembaliInput.value = tanggalHarusKembali;

                if (tanggalAktual && tanggalHarusKembali) {
                    const tglKembali = new Date(tanggalAktual);
                    const tglHarusKembali = new Date(tanggalHarusKembali);
                    const batas = new Date(tglHarusKembali);
                    batas.setDate(batas.getDate() + 1);

                    let keterlambatan = 0;
                    if (tglKembali > batas) {
                        keterlambatan = Math.ceil((tglKembali - batas) / (1000 * 60 * 60 * 24));
                    }

                    const denda = keterlambatan * 1000;

                    keterlambatanDisplay.value = keterlambatan > 0 ? `${keterlambatan} hari` : 'Tepat Waktu';
                    keterlambatanInput.value = keterlambatan > 0 ? 'Telat' : 'Tepat Waktu';
                    jumlahDendaDisplay.value = `Rp ${denda.toLocaleString('id-ID')}`;
                    jumlahDendaInput.value = denda;
                } else {
                    keterlambatanDisplay.value = '-';
                    keterlambatanInput.value = 'Tepat Waktu';
                    jumlahDendaDisplay.value = '-';
                    jumlahDendaInput.value = 0;
                }
            }

            peminjamanSelect.addEventListener('change', updateFields);
            tanggalKembaliInput.addEventListener('change', updateFields);
            window.addEventListener('DOMContentLoaded', updateFields);
        </script>

        <style>
            .bg-gradient-primary {
                background: linear-gradient(135deg, #007bff, #0056b3);
            }

            .btn-lg:hover {
                transform: translateY(-1px);
                box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
            }

            .form-control:focus,
            .form-select:focus {
                border-color: #007bff;
                box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
            }

            .card {
                transition: transform 0.2s;
            }

            .card:hover {
                transform: translateY(-2px);
            }
        </style>
    </div>
@endsection
