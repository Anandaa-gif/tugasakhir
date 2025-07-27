@extends('layout.tampil')

@section('konten')
    <div class="container py-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0 d-flex align-items-center">
                    <i class="fas fa-users me-2"></i> Data Anggota
                </h4>
            </div>
            <div class="card-body">

                {{-- Filter & Tombol Aksi --}}
                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="d-flex flex-column flex-md-row gap-3">

                            <form id="filterForm" action="{{ route('dataanggota.tampil1') }}" method="GET"
                                class="d-flex flex-column flex-md-row gap-3 w-100 align-items-start align-items-md-center">

                                <div class="input-group" style="width: 200px;">
                                    <span class="input-group-text bg-white"><i class="fas fa-filter"></i></span>
                                    <select id="filterKelas" name="kelas" class="form-select">
                                        <option value="">Cari Kelas</option>
                                        @foreach ($kelasList as $kelas)
                                            <option value="{{ $kelas }}"
                                                {{ request('kelas') == $kelas ? 'selected' : '' }}>
                                                {{ $kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="flex-grow-1">
                                    <input type="text" name="search" class="form-control" placeholder="Cari nama / NIS "
                                        value="{{ request('search') }}">
                                </div>
                            </form>
                        </div>

                    </div>

                    <div class="col-md-4 mt-3 mt-md-0">
                        <div class="d-flex justify-content-md-end gap-2">
                            {{-- Tambah & Import --}}
                            <a href="{{ route('dataanggota.tambah1') }}" class="btn btn-success" title="Tambah Anggota">
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
                @if (request('search') || request('kelas'))
                    <div class="alert alert-light mb-3">
                        <i class="fas fa-info-circle me-2"></i>
                        Menampilkan {{ $anggota->total() }} hasil
                        @if (request('search'))
                            untuk pencarian: <strong>"{{ request('search') }}"</strong>
                        @endif
                        @if (request('kelas'))
                            di kelas: <strong>{{ request('kelas') }}</strong>
                        @endif
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
                                <th>NIS/NIP</th>
                                <th>Nama</th>
                                <th>Nomor Anggota</th>
                                <th>Jenis</th>
                                <th>Kelas</th>
                                <th>Alamat</th>
                                <th>No HP</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($anggota as $index => $item)
                                <tr>
                                    <td>{{ $anggota->firstItem() + $index }}</td>
                                    <td>{{ $item->nis }}</td>
                                    <td>{{ $item->namalengkap }}</td>
                                    <td>{{ $item->nomor_anggota }}</td>
                                    <td>{{ ucfirst($item->jenis) }}</td>
                                    <td>{{ $item->jenis == 'Siswa' ? $item->kelas : '-' }}</td>
                                    <td>{{ $item->alamat ?? '-' }}</td>
                                    <td>{{ $item->no_hp ?? '-' }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('dataanggota.show1', $item->id) }}"
                                                class="btn btn-sm btn-outline-warning" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('dataanggota.edit1', $item->id) }}"
                                                class="btn btn-sm btn-outline-success" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('dataanggota.delete1', $item->id) }}" method="POST"
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
                                    <td colspan="9" class="text-muted text-center py-3">
                                        <i class="fas fa-info-circle me-2"></i>Tidak ada data ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4 d-flex justify-content-end">
                    {{ $anggota->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Import --}}
    <div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('anggota.import') }}" method="POST" enctype="multipart/form-data">
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

    {{-- Script Filter Otomatis --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.getElementById('filterForm');
            const filterKelas = document.getElementById('filterKelas');
            const searchInput = document.querySelector('input[name="search"]');
            let timeout = null;

            // Submit saat dropdown kelas diganti
            filterKelas.addEventListener('change', function() {
                filterForm.submit();
            });

            // Submit otomatis saat user selesai mengetik
            searchInput.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    filterForm.submit();
                }, 500);
            });
        });
    </script>
@endsection
