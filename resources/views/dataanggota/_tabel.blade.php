{{-- _tabel.blade.php --}}
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
                    <td>{{ Str::limit($item->alamat ?? '-', 50) }}</td>
                    <td>{{ $item->no_hp ?? '-' }}</td>
                    <td>
                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                            <a href="{{ route('dataanggota.show1', $item->id) }}" class="btn btn-sm btn-outline-warning" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('dataanggota.edit1', $item->id) }}" class="btn btn-sm btn-outline-success" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            {{-- Modal Hapus --}}
                            <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            Yakin ingin menghapus data <strong>{{ $item->namalengkap }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <form action="{{ route('dataanggota.delete1', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
