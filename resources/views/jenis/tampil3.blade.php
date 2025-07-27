@extends('layout.tampil')

@section('konten')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-primary text-white rounded-top">
                        <h4 class="mb-0"><i class="fas fa-tags me-2"></i>Manajemen Jenis Buku</h4>
                    </div>
                    <div class="card-body p-4">
                        <!-- Tombol Tambah Jenis -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-semibold text-muted mb-0">Daftar Jenis Buku</h5>
                            <a href="{{ route('jenis.tambah2') }}" class="btn btn-success">
                                <i class="fas fa-plus me-2"></i>Tambah Jenis
                            </a>
                        </div>

                        <!-- Pesan sukses -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Tabel -->
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Jenis</th>
                                        <th>Nama Jenis</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($jenis as $index => $j)
                                        <tr>
                                            <td>{{ $jenis->firstItem() + $index }}</td>
                                            <td>{{ $j->kode_jenis }}</td>
                                            <td>{{ $j->name }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                                    <a href="{{ route('jenis.edit2', $j->id) }}"
                                                        class="btn btn-sm btn-outline-success" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('jenis.delete2', $j->id) }}" method="POST"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            title="Hapus">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-muted text-center py-3">
                                                <i class="fas fa-info-circle me-2"></i>Belum ada data jenis buku.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4 d-flex justify-content-end">
                            {{ $jenis->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }

        .btn-outline-success,
        .btn-outline-danger {
            transition: all 0.2s;
        }

        .btn-outline-success:hover,
        .btn-outline-danger:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            border-bottom: none;
        }
    </style>
@endsection
