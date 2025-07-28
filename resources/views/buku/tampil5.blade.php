@extends('layout.tampil')

@section('konten')
    <div class="container py-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0 d-flex align-items-center">
                    <i class="fas fa-book me-2"></i> Data Buku
                </h4>
            </div>
            <div class="card-body">

                {{-- Filter & Tombol Aksi --}}
                <div class="row mb-4">
                    <div class="col-md-8">
                        <form id="filterForm" action="{{ route('buku.tampil5') }}" method="GET"
                            class="d-flex flex-column flex-md-row gap-3 w-100 align-items-start align-items-md-center">

                            <div class="flex-grow-1">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Cari judul / penulis / kode / ISBN" value="{{ request('search') }}">
                            </div>
                        </form>
                    </div>

                    <div class="col-md-4 mt-3 mt-md-0">
                        <div class="d-flex justify-content-md-end gap-2">
                            <a href="{{ route('buku.tambah5') }}" class="btn btn-success" title="Tambah Buku">
                                <i class="fas fa-plus"></i>
                                <span class="d-none d-md-inline">Tambah</span>
                            </a>

                            <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#importExcelModal" title="Import Excel">
                                <i class="fas fa-file-import"></i>
                                <span class="d-none d-md-inline">Import</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Info pencarian --}}
                @if (request('search'))
                    <div class="alert alert-light mb-3">
                        <i class="fas fa-info-circle me-2"></i>
                        Menampilkan {{ $buku->total() }} hasil pencarian:
                        <strong>"{{ request('search') }}"</strong>
                    </div>
                @endif

                {{-- Notifikasi --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
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
                                <th>Kode Buku</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>ISBN</th>
                                <th>Penerbit</th>
                                <th>Jenis</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($buku as $index => $item)
                                <tr>
                                    <td>{{ $buku->firstItem() + $index }}</td>
                                    <td>{{ $item->kode_buku }}</td>
                                    <td>{{ $item->judul_buku }}</td>
                                    <td>{{ $item->penulis }}</td>
                                    <td>{{ $item->isbn }}</td>
                                    <td>{{ $item->penerbit->name ?? '-' }}</td>
                                    <td>{{ $item->jenis->name ?? '-' }}</td>
                                    <td>{{ $item->kategori->name ?? '-' }}</td>
                                    <td>{{ $item->stok }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('buku.detail', $item->id) }}"
                                                class="btn btn-sm btn-outline-warning" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('buku.qr_code', $item->id) }}"
                                                class="btn btn-sm btn-outline-info" title="Lihat QR Code">
                                                <i class="fas fa-qrcode"></i>
                                            </a>


                                            <a href="{{ route('buku.edit4', $item->id) }}"
                                                class="btn btn-sm btn-outline-success" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('buku.delete4', $item->id) }}" method="POST"
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
                                    <td colspan="10" class="text-muted text-center py-3">
                                        <i class="fas fa-info-circle me-2"></i>Tidak ada data ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4 d-flex justify-content-end">
                    {{ $buku->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Import --}}
    <div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('buku.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="fas fa-file-import me-2"></i>Import Excel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="excelFile" class="form-label">Pilih File Excel</label>
                            <input type="file" name="file" class="form-control" id="excelFile" required
                                accept=".xls,.xlsx">
                            <div class="form-text">Format file harus .xls atau .xlsx</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload me-1"></i>Upload
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Script Pencarian Otomatis --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.getElementById('filterForm');
            const searchInput = document.querySelector('input[name="search"]');
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
