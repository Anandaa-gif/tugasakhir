@extends('layout.tampil')

@section('konten')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-primary text-white rounded-top">
                        <h4 class="mb-0 d-flex align-items-center">
                            <i class="fas fa-building me-2"></i> Manajemen Penerbit
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <!-- Tombol Tambah -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-semibold text-muted mb-0">Daftar Penerbit</h5>
                            <a href="{{ route('penerbit.tambah6') }}" class="btn btn-success d-inline-flex align-items-center gap-2">
                                <i class="fas fa-plus"></i> Tambah Penerbit
                            </a>
                        </div>

                        <!-- Notifikasi -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Tabel -->
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Penerbit</th>
                                        <th>Nama Penerbit</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($penerbit as $index => $item)
                                        <tr>
                                            <td>{{ $penerbit->firstItem() + $index }}</td>
                                            <td>{{ $item->kode_penerbit }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                                    <a href="{{ route('penerbit.edit5', $item->id) }}"
                                                        class="btn btn-sm btn-outline-success" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('penerbit.delete5', $item->id) }}" method="POST"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
                                            <td colspan="4" class="text-muted text-center py-3">
                                                <i class="fas fa-info-circle me-2"></i>Belum ada data penerbit.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if (method_exists($penerbit, 'links'))
                            <div class="d-flex justify-content-end mt-3">
                                {{ $penerbit->links() }}
                            </div>
                        @endif
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
