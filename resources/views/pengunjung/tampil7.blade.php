@extends('layout.tampil')

@section('konten')
    <div class="container py-5 px-3">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header bg-gradient-primary text-white rounded-top">
                <h4 class="mb-0"><i class="fas fa-address-book me-2"></i>Data Pengunjung</h4>
            </div>
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                    {{-- Kiri: Form Pilih Bulan --}}
                    <form action="{{ route('pengunjung.export.bulan') }}" method="GET"
                        class="d-flex flex-wrap align-items-center gap-2">
                        <label for="bulan" class="me-2 fw-semibold">Pilih Bulan:</label>
                        <select name="bulan" id="bulan" class="form-select" style="width: auto;" required>
                            <option value="" disabled selected>-- Pilih Bulan --</option>
                            @foreach (range(1, 12) as $bln)
                                <option value="{{ $bln }}">
                                    {{ \Carbon\Carbon::create()->month($bln)->locale('id')->translatedFormat('F') }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-outline-primary d-flex align-items-center gap-1">
                            <i class="fas fa-file-excel"></i> <span>Unduh Excel</span>
                        </button>
                    </form>

                    {{-- Kanan: Tombol Aksi --}}
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('pengunjung.qr') }}"
                            class="btn btn-outline-info transition-all d-flex align-items-center gap-2">
                            <i class="fas fa-qrcode"></i> <span>Lihat QR Code</span>
                        </a>
                        <a href="{{ route('pengunjung.tambah7') }}"
                            class="btn btn-success transition-all d-flex align-items-center gap-2">
                            <i class="fas fa-plus"></i> <span>Tambah Pengunjung</span>
                        </a>
                    </div>
                </div>



                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Tipe</th>
                                <th>Kelas</th>
                                <th>Tujuan</th>
                                <th>Alamat</th>
                                <th>Tanggal</th>
                                <th>Kesan & Pesan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengunjung as $no => $peng)
                                <tr>
                                    <td>{{ $pengunjung->firstItem() + $no }}</td>
                                    <td>{{ $peng->name }}</td>
                                    <td>{{ ucfirst($peng->type) }}</td>
                                    <td>
                                        @if ($peng->type === 'siswa')
                                            {{ $peng->kelas ?? '-' }}
                                        @else
                                            <em class="text-muted">-</em>
                                        @endif
                                    </td>
                                    <td>{{ $peng->tujuan }}</td>
                                    <td>
                                        @if ($peng->type === 'tamu')
                                            {{ $peng->alamat ?? '-' }}
                                        @else
                                            <em class="text-muted">Tidak Diisi</em>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($peng->waktu_kunjung)->format('d-m-Y') }}</td>
                                    <td>
                                        @if ($peng->type === 'tamu')
                                            {{ $peng->kesan_pesan ?? '-' }}
                                        @else
                                            <em class="text-muted">Tidak Diisi</em>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                                            <a href="{{ route('pengunjung.edit6', $peng->id) }}"
                                                class="btn btn-sm btn-outline-success" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('pengunjung.delete6', $peng->id) }}" method="POST"
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
                                    <td colspan="9" class="text-muted text-center py-4">
                                        <i class="fas fa-info-circle me-2"></i>Belum ada data pengunjung.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4 d-flex justify-content-end">
                    {{ $pengunjung->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #007bff, #0056b3);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }

        .transition-all {
            transition: all 0.2s ease-in-out;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
        }

        .card {
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
        }
    </style>
@endsection
