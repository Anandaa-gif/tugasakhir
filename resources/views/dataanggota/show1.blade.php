<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
        }

        .card {
            border-radius: 12px;
        }

        .card-header {
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            background: linear-gradient(to right, #0d6efd, #0a58ca);
        }

        .list-group-item strong {
            display: inline-block;
            width: 160px;
            color: #343a40;
        }

        .btn-back {
            background-color: #0d6efd;
            color: white;
            border: none;
        }

        .btn-back:hover {
            background-color: #0a58ca;
        }

        .table th,
        .table td {
            vertical-align: middle !important;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-9">
                <div class="card shadow-sm mb-4">
                    <div class="card-header text-white text-center">
                        <h3 class="mb-0">Detail Anggota</h3>
                    </div>
                    <div class="card-body">
                        <!-- Informasi Anggota -->
                        <ul class="list-group list-group-flush mb-4">
                            <li class="list-group-item">
                                <strong>{{ $anggota->jenis === 'Siswa' ? 'NIS' : 'NIP' }}:</strong>
                                {{ $anggota->nis ?? '-' }}
                            </li>
                            <li class="list-group-item"><strong>Nama Lengkap:</strong> {{ $anggota->namalengkap }}</li>
                            <li class="list-group-item"><strong>Nomor Anggota:</strong> {{ $anggota->nomor_anggota }}
                            </li>
                            <li class="list-group-item"><strong>Jenis:</strong> {{ $anggota->jenis }}</li>
                            @if ($anggota->jenis === 'Siswa')
                                <li class="list-group-item"><strong>Kelas:</strong> {{ $anggota->kelas ?? '-' }}</li>
                            @endif
                            <li class="list-group-item"><strong>Alamat:</strong> {{ $anggota->alamat }}</li>
                            <li class="list-group-item"><strong>No HP:</strong> {{ $anggota->no_hp }}</li>
                        </ul>

                        <!-- Riwayat Pengembalian -->
                        <h4 class="mt-4 mb-3">Riwayat Pengembalian</h4>
                        @if ($riwayatPengembalian->isEmpty())
                            <p class="text-muted">Belum ada riwayat pengembalian.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle text-center">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Judul Buku</th>
                                            <th>Tanggal Pinjam</th>
                                            <th>Tanggal Kembali</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($riwayatPengembalian as $index => $peminjaman)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td class="text-start">
                                                    {{ $peminjaman->buku->judul_buku ?? '-' }}
                                                </td>
                                                <td>
                                                    {{ $peminjaman->tanggal_pinjam
                                                        ? \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->translatedFormat('d F Y')
                                                        : '-' }}
                                                </td>
                                                <td>
                                                    @if ($peminjaman->pengembalian && $peminjaman->pengembalian->tanggal_kembali)
                                                        {{ \Carbon\Carbon::parse($peminjaman->pengembalian->tanggal_kembali)->translatedFormat('d F Y') }}
                                                    @else
                                                        <span class="text-warning">Belum dikembalikan</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($peminjaman->pengembalian)
                                                        <span class="badge bg-success">Sudah Kembali</span>
                                                    @else
                                                        @php
                                                            $batas = \Carbon\Carbon::parse(
                                                                $peminjaman->tanggal_pinjam,
                                                            )->addDays(7);
                                                        @endphp
                                                        @if (now()->gt($batas))
                                                            <span class="badge bg-danger">Terlambat</span>
                                                        @else
                                                            <span class="badge bg-warning text-dark">Dipinjam</span>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        <!-- Tombol Kembali -->
                        <div class="d-grid mt-4">
                            <a href="{{ route('dataanggota.tampil1') }}" class="btn btn-back btn-lg">
                                ← Kembali ke Daftar Anggota
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
