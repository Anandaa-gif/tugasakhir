@extends('layout.tampil')

@section('konten')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0 rounded-3 text-center">
                    <div class="card-header bg-gradient-primary text-white rounded-top-3">
                        <h4 class="mb-0 fw-semibold"><i class="fas fa-history me-2"></i>Riwayat Peminjaman</h4>
                    </div>
                    <div class="card-body p-4">

                        {{-- Filter dan Download --}}
                        <form action="{{ route('riwayat.export') }}" method="GET"
                            class="row g-2 mb-4 justify-content-center">
                            <div class="col-md-3">
                                <select name="bulan" class="form-select" required>
                                    @foreach (range(1, 12) as $bln)
                                        <option value="{{ $bln }}">
                                            {{ \Carbon\Carbon::create()->month($bln)->locale('id')->translatedFormat('F') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="tahun" class="form-select" required>
                                    @for ($y = now()->year; $y >= 2020; $y--)
                                        <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                                            {{ $y }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-file-excel"></i> <span>Unduh Excel</span>
                                </button>
                            </div>
                        </form>

                        {{-- Tabel Riwayat --}}
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Judul Buku</th>
                                        <th>Tgl Pinjam</th>
                                        <th>Tgl Harus Kembali</th>
                                        <th>Tgl Kembali</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($riwayat as $index => $item)
                                        <tr>
                                            <td>{{ $riwayat->firstItem() + $index }}</td>
                                            <td>{{ $item->anggota->namalengkap ?? ($item->anggota->nama ?? '-') }}</td>
                                            <td>{{ $item->buku->judul_buku ?? '-' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y') }}</td>
                                            <td>
                                                {{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') : '-' }}
                                            </td>
                                            <td>
                                                {{ optional($item->pengembalian)->tanggal_kembali
                                                    ? \Carbon\Carbon::parse($item->pengembalian->tanggal_kembali)->format('d-m-Y')
                                                    : '-' }}
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $item->status == 'dipinjam' ? 'warning text-dark' : 'success' }}">
                                                    {{ ucfirst($item->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-3">
                                                <i class="fas fa-info-circle me-2"></i>Belum ada data peminjaman dan
                                                pengembalian.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        @if ($riwayat->hasPages())
                            <div class="d-flex justify-content-end mt-3">
                                {{ $riwayat->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Style tambahan --}}
    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #007bff, #0056b3);
        }

        .card {
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .table th,
        .table td {
            vertical-align: middle !important;
            text-align: center !important;
        }

        .badge {
            font-size: 0.85rem;
            padding: 0.4em 0.7em;
        }
    </style>
@endsection
