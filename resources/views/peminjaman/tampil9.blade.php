@extends('layout.tampil')

@section('konten')
    <div class="container py-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0 d-flex align-items-center">
                    <i class="fas fa-book-reader me-2"></i> Data Peminjaman
                </h4>
            </div>
            <div class="card-body">
                {{-- Filter & Tambah --}}
                <div class="row mb-4">
                    <div class="col-md-8">
                        <form id="filterForm" action="{{ route('peminjaman.tampil9') }}" method="GET"
                            class="d-flex gap-2 align-items-center">
                            <input type="text" name="search" class="form-control"
                                placeholder="Cari nama / judul buku..." value="{{ request('search') }}">
                        </form>
                    </div>
                    <div class="col-md-4 mt-2 mt-md-0">
                        <div class="d-flex justify-content-md-end">
                            <a href="{{ route('peminjaman.tambah9') }}" class="btn btn-success">
                                <i class="fas fa-plus"></i> <span>Tambah Peminjaman</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Info pencarian --}}
                @if (request('search'))
                    <div class="alert alert-light mb-3">
                        <i class="fas fa-info-circle me-2"></i>
                        Menampilkan {{ $peminjaman->total() }} hasil untuk: <strong>"{{ request('search') }}"</strong>
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
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($peminjaman as $index => $item)
                                <tr>
                                    <td>{{ $peminjaman->firstItem() + $index }}</td>
                                    <td>{{ $item->anggota->namalengkap ?? '-' }}</td>
                                    <td>{{ $item->buku->judul_buku ?? '-' }}</td>
                                    <td>{{ $item->tanggal_pinjam }}</td>
                                    <td>{{ $item->tanggal_kembali }}</td>
                                    <td>
                                        <span
                                            class="badge {{ strtolower($item->status) == 'dikembalikan' ? 'bg-success' : 'bg-danger' }}">
                                            <i class="fas fa-book"></i> {{ $item->status }}
                                        </span>

                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('peminjaman.edit8', $item->id) }}"
                                                class="btn btn-sm btn-outline-success" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('peminjaman.delete8', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?');">
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
                                    <td colspan="7" class="text-muted text-center py-3">
                                        <i class="fas fa-info-circle me-2"></i>Tidak ada data ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4 d-flex justify-content-end">
                    {{ $peminjaman->links('pagination::bootstrap-5') }}
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
