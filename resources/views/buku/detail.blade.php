<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $buku->judul_buku }} - Detail Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --text-dark: #2b2d42;
            --text-light: #8d99ae;
            --bg-light: #f8f9fa;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: #f5f7ff;
            color: var(--text-dark);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .book-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 4rem 0;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(67, 97, 238, 0.2);
        }

        .book-header::before {
            content: "";
            position: absolute;
            top: -50px;
            right: -50px;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .book-header::after {
            content: "";
            position: absolute;
            bottom: -80px;
            left: -30px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }

        .book-title {
            font-weight: 800;
            font-size: 3rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 2;
        }

        .book-author {
            font-size: 1.2rem;
            opacity: 0.9;
            font-weight: 400;
            position: relative;
            z-index: 2;
        }

        .book-cover {
            width: 100%;
            max-height: 400px;
            object-fit: contain;
            border-radius: 12px;
            box-shadow: 0 15px 30px -10px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            background-color: #fff;
            padding: 1rem;
        }

        .book-cover:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.25);
        }

        .detail-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            background-color: white;
        }

        .detail-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .detail-card .card-header {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            padding: 1rem 1.5rem;
            border-bottom: none;
        }

        .detail-item {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: var(--text-light);
            width: 150px;
            flex-shrink: 0;
        }

        .detail-value {
            font-weight: 500;
            color: var(--text-dark);
        }

        .badge-status {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .loan-history-item {
            transition: all 0.2s ease;
            border-radius: 8px;
        }

        .loan-history-item:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }

        .icon-wrapper {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .page-link {
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .book-title {
                font-size: 2rem;
            }

            .detail-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .detail-label {
                width: 100%;
                margin-bottom: 0.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- Header Buku -->
    <div class="book-header text-center mb-5">
        <div class="container">
            <h1 class="book-title mb-2">{{ $buku->judul_buku }}</h1>
            <p class="book-author">Oleh {{ $buku->penulis }}</p>
        </div>
    </div>

    <!-- Konten Utama -->
    <div class="container mb-5">
        <div class="row g-4">
            <!-- Kolom Kiri - Foto dan Detail Buku -->
            <div class="col-lg-4">
                <!-- Foto Buku -->
                <div class="mb-4 text-center">
                    @if ($buku->foto)
                        <img src="{{ asset('storage/' . $buku->foto) }}" alt="Cover Buku" class="book-cover">
                    @else
                        <div class="book-cover d-flex flex-column align-items-center justify-content-center bg-light">
                            <i class="fas fa-book-open text-muted mb-3" style="font-size: 3rem;"></i>
                            <span class="text-muted">Cover tidak tersedia</span>
                        </div>
                    @endif
                </div>

                <!-- Informasi Buku -->
                <div class="detail-card mb-4">
                    <div class="card-header d-flex align-items-center">
                        <i class="fas fa-info-circle me-2"></i>
                        <span>Informasi Buku</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="detail-item">
                            <span class="detail-label">Kode Buku</span>
                            <span class="detail-value">{{ $buku->kode_buku }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">ISBN</span>
                            <span class="detail-value">{{ $buku->isbn }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Tahun Terbit</span>
                            <span class="detail-value">{{ $buku->tahun_terbit }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Penerbit</span>
                            <span class="detail-value">{{ optional($buku->penerbit)->name ?? '-' }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Kategori</span>
                            <span class="detail-value">{{ optional($buku->kategori)->name ?? '-' }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Jenis</span>
                            <span class="detail-value">{{ optional($buku->jenis)->name ?? '-' }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Status Ketersediaan</span>
                            <span class="badge-status bg-{{ $buku->stok > 0 ? 'success' : 'danger' }}">
                                {{ $buku->stok > 0 ? 'Tersedia (' . $buku->stok . ' eksemplar)' : 'Tidak Tersedia' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan - Peminjaman -->
            <div class="col-lg-8">
                <!-- Status Peminjaman Saat Ini -->
                <div class="detail-card mb-4">
                    <div class="card-header d-flex align-items-center">
                        <i class="fas fa-exchange-alt me-2"></i>
                        <span>Status Peminjaman</span>
                    </div>
                    <div class="card-body">
                        @if ($peminjamanAktif)
                            <div class="alert alert-warning border-0 bg-light-warning rounded-3">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper bg-warning text-white">
                                        <i class="fas fa-exclamation"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Buku Sedang Dipinjam</h5>
                                        <p class="mb-0 text-muted">Buku ini saat ini tidak tersedia untuk dipinjam</p>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6 mb-3">
                                        <div class="p-3 bg-white rounded-2 shadow-sm">
                                            <small class="text-muted d-block">Peminjam</small>
                                            <strong>{{ $peminjamanAktif->anggota->namalengkap }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="p-3 bg-white rounded-2 shadow-sm">
                                            <small class="text-muted d-block">Tanggal Pinjam</small>
                                            <strong>{{ \Carbon\Carbon::parse($peminjamanAktif->tanggal_pinjam)->format('d M Y') }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="p-3 bg-white rounded-2 shadow-sm">
                                            <small class="text-muted d-block">Status</small>
                                            <span class="badge-status bg-warning text-dark">
                                                Dipinjam
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-success border-0 bg-light-success rounded-3">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper bg-success text-white">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Buku Tersedia</h5>
                                        <p class="mb-0">Buku ini saat ini dapat dipinjam</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Riwayat Peminjaman -->
                <div class="detail-card">
                    <div class="card-header d-flex align-items-center">
                        <i class="fas fa-history me-2"></i>
                        <span>Riwayat Peminjaman</span>
                    </div>
                    <div class="card-body">
                        @if ($riwayatPeminjaman->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="rounded-start">Peminjam</th>
                                            <th>Tanggal Pinjam</th>
                                            <th>Tanggal Kembali</th>
                                            <th class="rounded-end">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($riwayatPeminjaman as $peminjaman)
                                            <tr class="loan-history-item">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon-wrapper bg-light-primary text-primary">
                                                            <i class="fas fa-user"></i>
                                                        </div>
                                                        <span>{{ $peminjaman->anggota->namalengkap }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}
                                                </td>
                                                <td>{{ $peminjaman->tanggal_kembali ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') : '-' }}
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge-status bg-{{ $peminjaman->status == 'dipinjam' ? 'warning text-dark' : 'success' }}">
                                                        {{ ucfirst($peminjaman->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center mt-4">
                                {{ $riwayatPeminjaman->links() }}
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-book-open text-muted mb-3" style="font-size: 2rem;"></i>
                                <p class="text-muted mb-0">Belum ada riwayat peminjaman untuk buku ini</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
