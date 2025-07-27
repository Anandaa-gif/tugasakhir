@extends('layout.tampil')

@section('konten')
    <div class="container py-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0 d-flex align-items-center">
                    <i class="fas fa-undo-alt me-2"></i> Data Pengembalian
                </h4>
            </div>
            <div class="card-body">
                {{-- Filter --}}
                <div class="row mb-4">
                    <div class="col-md-8">
                        <form id="filterForm" action="{{ route('pengembalian.tampil8') }}" method="GET"
                            class="d-flex gap-2 align-items-center">
                            <input type="text" name="search" class="form-control"
                                placeholder="Cari nama / judul buku..." value="{{ request('search') }}">
                        </form>
                    </div>
                    <div class="col-md-4 mt-2 mt-md-0">
                        <div class="d-flex justify-content-md-end">
                            <a href="{{ route('pengembalian.tambah8') }}" class="btn btn-success">
                                <i class="fas fa-plus"></i> <span>Tambah Pengembalian</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Info pencarian --}}
                @if (request('search'))
                    <div class="alert alert-light mb-3">
                        <i class="fas fa-info-circle me-2"></i>
                        Menampilkan {{ $pengembalian->total() }} hasil untuk: <strong>"{{ request('search') }}"</strong>
                    </div>
                @endif

                {{-- Pesan Sukses --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Tabel --}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Peminjam</th>
                                <th>Judul Buku</th>
                                <th>Tgl Harus Kembali</th>
                                <th>Tgl Dikembalikan</th>
                                <th>Keterlambatan</th>
                                <th>Denda</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengembalian as $index => $item)
                                <tr>
                                    <td>{{ $pengembalian->firstItem() + $index }}</td>
                                    <td>{{ $item->peminjaman->anggota->namalengkap ?? '-' }}</td>
                                    <td>{{ $item->peminjaman->buku->judul_buku ?? '-' }}</td>
                                    <td>
                                        {{ optional($item->peminjaman)->tanggal_kembali
                                            ? \Carbon\Carbon::parse($item->peminjaman->tanggal_kembali)->format('d-m-Y')
                                            : '-' }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') }}</td>
                                    <td>
                                        @if ($item->keterlambatan && $item->keterlambatan !== 'Tepat Waktu')
                                            <span class="badge bg-danger text-white">
                                                <i class="fas fa-clock"></i> {{ $item->keterlambatan }}
                                            </span>
                                        @else
                                            <span class="badge bg-success text-white">
                                                <i class="fas fa-check-circle"></i> Tepat Waktu
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="text-danger fw-semibold">Rp
                                            {{ number_format($item->jumlah_denda ?? 0, 0, ',', '.') }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                                            <a href="{{ route('pengembalian.edit7', $item->id) }}"
                                                class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('pengembalian.delete7', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?');"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-muted text-center py-3">
                                        <i class="fas fa-info-circle me-2"></i>Belum ada data pengembalian.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4 d-flex justify-content-end">
                    {{ $pengembalian->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
    {{-- Script pencarian otomatis --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.getElementById('filterForm');
            const searchInput = filterForm.querySelector('input[name="search"]');
            let timeout = null;

            searchInput.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    filterForm.submit();
                }, 500);
            });
        });
    </script>
@endsection
