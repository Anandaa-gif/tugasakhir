@extends('user_dashboard.layout')

@section('content')
    <div class="tab-content" id="myTabContent">
        <!-- Dashboard -->
        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
            <div class="text-center py-5">
                <h1 class="display-5 fw-bold text-primary">Selamat Datang di Perpustakaan SMPN 3 BESUKI
                </h1>
                <p class="lead text-secondary">Jelajahi koleksi buku kami dan nikmati pengalaman membaca yang luar
                    biasa.</p>
            </div>

            <!-- Informasi Perpustakaan -->
            <div class="container mb-5">
                <h3 class="text-primary mb-4">Informasi Perpustakaan Perpustakaan SMPN 3 BESUKI</h3>
                <p class="text-secondary">
                    Perpustakaan SMPN 3 BESUKImenyediakan koleksi buku akademik dan non-akademik untuk
                    mendukung proses belajar-mengajar. Kami berkomitmen untuk memberikan layanan terbaik bagi
                    mahasiswa, dosen, dan masyarakat umum.
                    <br><strong>Lokasi:</strong> Gedung Pusat Layanan Akademik Lt. 1<br>

                </p>
            </div>

            <!-- Card Buku Terbaru -->
            <div class="container mb-5">
                <h4 class="text-primary mb-4">Buku Terbaru</h4>
                <div class="row">
                    @forelse ($bukus->take(4) as $buku)
                        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                            <div class="card shadow-sm h-100">
                                @if ($buku->foto)
                                    <img src="{{ asset('storage/' . $buku->foto) }}" class="card-img-top"
                                        alt="Foto {{ $buku->judul_buku }}" style="height: 220px; object-fit: cover;">
                                @else
                                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center"
                                        style="height: 220px;">
                                        <span>Tidak ada foto</span>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h6 class="card-title text-primary">{{ $buku->judul_buku }}</h6>
                                    <p class="mb-1"><strong>Penulis:</strong> {{ $buku->penulis }}</p>
                                    <p><strong>Tahun:</strong> {{ $buku->tahun_terbit }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center text-muted">Tidak ada buku terbaru saat ini.</div>
                    @endforelse
                </div>
                <div class="text-end mt-3">
                    <a class="btn btn-outline-primary" href="#buku"
                        onclick="document.getElementById('buku-tab').click();">Lihat Semua Buku</a>
                </div>
            </div>

            <!-- Tentang Kami -->
            <div class="container mb-5">
                <div class="row align-items-center">
                    <!-- Gambar -->
                    <div class="col-md-6 mb-4 mb-md-0">
                        <div class="rounded shadow overflow-hidden">
                            <img src="{{ asset('storage/images/d.jpg') }}" alt="Perpustakaan" class="img-fluid">

                        </div>
                    </div>

                    <!-- Konten Teks -->
                    <div class="col-md-6 ps-md-5">
                        <h4 class="text-uppercase text-primary mb-2">About Us</h4>
                        <h2 class="fw-bold text-dark mb-3">Visi dan Misi Perpustakaan SMPN 3 Besuki</h2>
                        <p class="text-secondary">Perpustakaan SMP Negeri 3 Besuki merupakan pusat informasi dan
                            sumber belajar yang mendukung pembelajaran, membangun budaya literasi, serta
                            meningkatkan minat baca dan kreativitas siswa. Tujuannya adalah menyediakan layanan dan
                            koleksi pustaka yang relevan sebagai sarana pembelajaran mandiri dan pengembangan ilmu
                            pengetahuan.
                        </p>

                        <!-- Visi -->
                        <div class="bg-light rounded p-3 mb-3 shadow-sm">
                            <h5 class="text-primary fw-semibold"><i class="fas fa-graduation-cap me-2 text-info"></i>VISI
                            </h5>
                            <p class="mb-0">Menjadi pusat sumber belajar yang unggul, inovatif, dan inspiratif dalam
                                mendukung terwujudnya generasi cerdas, literat, dan berkarakter.</p>
                        </div>

                        <!-- Misi -->
                        <div class="bg-light rounded p-3 shadow-sm">
                            <h5 class="text-primary fw-semibold"><i class="fas fa-bookmark me-2 text-info"></i>MISI
                            </h5>
                            <ul class="mb-0 ps-3">
                                <li>Menyediakan koleksi bahan pustaka yang relevan, berkualitas, dan sesuai dengan kebutuhan
                                    kurikulum serta minat baca siswa.</li>
                                <li>Meningkatkan literasi informasi dan budaya baca melalui layanan dan program perpustakaan
                                    yang kreatif dan edukatif.</li>
                                <li>Menyelenggarakan layanan perpustakaan berbasis teknologi informasi untuk mendukung
                                    pembelajaran digital dan kemudahan akses informasi.</li>
                                <li>Menumbuhkan karakter siswa melalui penyediaan bacaan yang membangun nilai moral, etika,
                                    dan wawasan kebangsaan.</li>
                                <li>Menjalin kerja sama dengan berbagai pihak dalam rangka pengembangan koleksi, peningkatan
                                    layanan, dan pelatihan literasi informasi.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <!-- Daftar Anggota -->
        <div class="tab-pane fade" id="daftar" role="tabpanel" aria-labelledby="daftar-tab">
            <div class="container py-5">

                @if (!$anggota)
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h4 class="text-primary fw-bold mb-4 text-center">Formulir Pendaftaran Anggota</h4>

                                    <form action="{{ route('anggota.daftar.submit') }}" method="POST"
                                        class="needs-validation" novalidate>
                                        @csrf

                                        {{-- NIS otomatis diisi dari email user --}}
                                        <input type="hidden" name="nis" value="{{ Auth::user()->email }}">

                                        <div class="mb-3">
                                            <label for="jenis" class="form-label">Jenis Anggota</label>
                                            <select name="jenis" id="jenis" class="form-select"
                                                onchange="toggleKelas()" required>
                                                <option value="">-- Pilih Jenis --</option>
                                                <option value="Siswa" {{ old('jenis') == 'Siswa' ? 'selected' : '' }}>Siswa
                                                </option>
                                                <option value="Guru" {{ old('jenis') == 'Guru' ? 'selected' : '' }}>Guru
                                                </option>
                                                <option value="Karyawan"
                                                    {{ old('jenis') == 'Karyawan' ? 'selected' : '' }}>Karyawan</option>
                                            </select>
                                        </div>

                                        <div class="mb-3 {{ old('jenis') == 'Siswa' ? '' : 'd-none' }}" id="kelasRow">
                                            <label for="kelas" class="form-label">Kelas (khusus Siswa)</label>
                                            <select name="kelas" id="kelas" class="form-select">
                                                <option value="">-- Pilih Kelas --</option>
                                                @foreach (['7A', '7B', '8A', '8B', '9A', '9B'] as $kelas)
                                                    <option value="{{ $kelas }}"
                                                        {{ old('kelas') == $kelas ? 'selected' : '' }}>
                                                        {{ $kelas }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="namalengkap" class="form-label">Nama Lengkap</label>
                                            <input type="text" name="namalengkap" id="namalengkap" class="form-control"
                                                value="{{ old('namalengkap') }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea name="alamat" id="alamat" class="form-control" rows="2" required>{{ old('alamat') }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="no_hp" class="form-label">No HP</label>
                                            <input type="text" name="no_hp" id="no_hp" class="form-control"
                                                value="{{ old('no_hp') }}" required>
                                        </div>

                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary w-100">Daftar Sekarang</button>
                                        </div>
                                    </form>

                                    @if (session('success'))
                                        <div class="alert alert-success mt-3">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    @if ($errors->any())
                                        <div class="alert alert-danger mt-3">
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $err)
                                                    <li>{{ $err }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Sudah menjadi anggota --}}
                    <div class="alert alert-info text-center">
                        <h5 class="fw-bold text-primary">Anda sudah terdaftar sebagai anggota.</h5>
                        <p class="mb-0">Silakan gunakan fitur peminjaman, pengembalian, dan cek profil Anda di tab lain.
                        </p>
                    </div>
                @endif
            </div>
        </div>




        <!-- Buku -->
        <div class="tab-pane fade" id="buku" role="tabpanel" aria-labelledby="buku-tab">
            <h3 class="mb-4 text-primary fw-bold">Semua Buku</h3>
            <div class="row">
                @forelse ($bukus as $buku)
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                        <div class="card shadow-sm h-100" data-bs-toggle="modal"
                            data-bs-target="#bookDetailModal{{ $buku->id }}">
                            @if ($buku->foto)
                                <img src="{{ asset('storage/' . $buku->foto) }}" class="card-img-top"
                                    alt="Foto {{ $buku->judul_buku }}" style="height: 220px; object-fit: cover;"
                                    data-bs-toggle="modal" data-bs-target="#bookDetailModal{{ $buku->id }}">
                            @else
                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center"
                                    style="height: 220px;">
                                    <span class="text-center">Tidak ada foto</span>
                                </div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title text-primary">{{ $buku->judul_buku }}</h5>
                                <p class="card-text mb-1"><strong>Penulis:</strong> {{ $buku->penulis }}</p>
                                <p class="card-text"><strong>Tahun:</strong> {{ $buku->tahun_terbit }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">Tidak ada buku tersedia saat ini.</div>
                @endforelse
            </div>

            <!-- Modal Detail Buku -->
            @foreach ($bukus as $buku)
                <!-- Modal Detail Buku -->
                <div class="modal fade" id="bookDetailModal{{ $buku->id }}" tabindex="-1"
                    aria-labelledby="bookDetailModalLabel{{ $buku->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <!-- Header Modal -->
                            <div class="modal-header">
                                <h5 class="modal-title" id="bookDetailModalLabel{{ $buku->id }}">Detail Buku</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <!-- Body Modal -->
                            <div class="modal-body">
                                <!-- Foto Buku -->
                                <div class="text-center mb-3">
                                    @if ($buku->foto)
                                        <img src="{{ asset('storage/' . $buku->foto) }}"
                                            alt="Foto {{ $buku->judul_buku }}" class="img-fluid rounded"
                                            style="max-height: 200px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center"
                                            style="height: 200px; width: 100%;">
                                            <span>Tidak ada foto</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Detail Informasi Buku -->
                                <h5 class="text-primary">{{ $buku->judul_buku }}</h5>
                                <p><strong>Penulis:</strong> {{ $buku->penulis }}</p>
                                <p><strong>Penerbit:</strong> {{ optional($buku->penerbit)->name ?? 'Tidak tersedia' }}</p>
                                <p><strong>Tahun:</strong> {{ $buku->tahun_terbit }}</p>
                                <p><strong>Jenis:</strong> {{ optional($buku->jenis)->name ?? 'Tidak tersedia' }}</p>
                                <p><strong>Kategori:</strong> {{ optional($buku->kategori)->name ?? 'Tidak tersedia' }}</p>
                                <p><strong>Sinopsis:</strong> {{ $buku->sinopsis ?? 'Tidak tersedia' }}</p>
                            </div>

                            <!-- Footer Modal -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>


        <!-- Peminjaman -->
        <div class="tab-pane fade" id="peminjaman" role="tabpanel" aria-labelledby="peminjaman-tab">
            <h3 class="mb-2 text-primary fw-bold">Data Peminjaman</h3>

            <!-- Tombol Tambah -->
            <div class="text-end">
                <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#modalPeminjaman">
                    <i class="bi bi-plus-circle"></i> Tambah Peminjaman
                </button>
            </div>

            <!-- Modal Tambah Peminjaman -->
            <div class="modal fade" id="modalPeminjaman" tabindex="-1" aria-labelledby="modalPeminjamanLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <form action="{{ route('user.peminjaman.simpan') }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Form Tambah Peminjaman</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="tanggal_pinjam">Tanggal Pinjam</label>
                                    <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="form-control"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_kembali">Tanggal Kembali</label>
                                    <input type="date" name="tanggal_kembali" id="tanggal_kembali"
                                        class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="buku_id_1" class="form-label">Pilih Buku 1</label>
                                    <select name="buku_id[]" id="buku_id_1" class="form-select" required>
                                        <option value="">-- Pilih Buku --</option>
                                        @foreach ($bukus as $buku)
                                            <option value="{{ $buku->id }}">{{ $buku->judul_buku }} -
                                                {{ $buku->penulis }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="buku_id_2" class="form-label">Pilih Buku 2 (opsional)</label>
                                    <select name="buku_id[]" id="buku_id_2" class="form-select">
                                        <option value="">-- Pilih Buku --</option>
                                        @foreach ($bukus as $buku)
                                            <option value="{{ $buku->id }}">{{ $buku->judul_buku }} -
                                                {{ $buku->penulis }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabel Peminjaman -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped shadow-sm align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="text-center">No</th>
                            <th scope="col">NIS</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Judul Buku</th>
                            <th scope="col" class="text-center">Tanggal Pinjam</th>
                            <th scope="col" class="text-center">Tanggal Kembali</th>
                            <th scope="col" class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjamans as $index => $pinjam)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $pinjam->anggota->nis ?? '-' }}</td>
                                <td>{{ $pinjam->anggota->namalengkap ?? '-' }}</td>
                                <td>{{ $pinjam->buku->judul_buku ?? '-' }}</td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->translatedFormat('d F Y') }}
                                </td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($pinjam->tanggal_kembali)->translatedFormat('d F Y') }}
                                </td>
                                <td class="text-center">
                                    @if ($pinjam->status === 'dikembalikan')
                                        <span class="badge bg-success">Sudah Dikembalikan</span>
                                    @elseif ($pinjam->status === 'dipinjam')
                                        @php
                                            $terlambat = \Carbon\Carbon::now()->gt(
                                                \Carbon\Carbon::parse($pinjam->tanggal_kembali),
                                            );
                                        @endphp
                                        <span class="badge {{ $terlambat ? 'bg-danger' : 'bg-warning text-dark' }}">
                                            {{ $terlambat ? 'Terlambat' : 'Belum Dikembalikan' }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Tidak ada data peminjaman.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>


        <!-- Pengembalian -->
        <div class="tab-pane fade" id="pengembalian" role="tabpanel" aria-labelledby="pengembalian-tab">
            <h3 class="mb-4 text-primary fw-bold">Pengembalian Buku</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped shadow-sm align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama</th>
                            <th>Judul Buku</th>
                            <th class="text-center">Tanggal Pinjam</th>
                            <th class="text-center">Tanggal Harus Kembali</th>
                            <th class="text-center">Tanggal Kembali</th>
                            <th class="text-center">Denda</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengembalians as $index => $item)
                            @php
                                $peminjaman = $item->peminjaman;
                                $anggota = $peminjaman->anggota ?? null;
                                $buku = $peminjaman->buku ?? null;
                                $tanggalPinjam = \Carbon\Carbon::parse($peminjaman->tanggal_pinjam);
                                $tanggalHarusKembali = \Carbon\Carbon::parse($peminjaman->tanggal_kembali);
                                $tanggalKembali = \Carbon\Carbon::parse($item->tanggal_kembali);
                            @endphp

                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $anggota->namalengkap ?? '-' }}</td>
                                <td>{{ $buku->judul_buku ?? '-' }}</td>
                                <td class="text-center">{{ $tanggalPinjam->translatedFormat('d F Y') }}</td>
                                <td class="text-center">{{ $tanggalHarusKembali->translatedFormat('d F Y') }}</td>
                                <td class="text-center">{{ $tanggalKembali->translatedFormat('d F Y') }}</td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $item->jumlah_denda > 0 ? 'danger' : 'success' }}">
                                        Rp{{ number_format($item->jumlah_denda, 0, ',', '.') }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <span class="badge bg-{{ $item->keterlambatan === 'Telat' ? 'danger' : 'success' }}">
                                        {{ $item->keterlambatan ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Tidak ada data pengembalian.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tambahkan tab pane ini ke dalam div tab-content yang sudah ada -->
        <div class="tab-pane fade {{ isset($tab) && $tab == 'profil' ? 'show active' : '' }}" id="profil"
            role="tabpanel" aria-labelledby="profil-tab">
            <div class="container py-4">
                <div class="row g-4">
                    <!-- Left Column: Profile Card -->
                    <div class="col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body text-center p-4 d-flex flex-column">
                                @if (!empty($anggota?->foto))
                                    <div class="mx-auto mb-3 rounded-circle overflow-hidden"
                                        style="width: 150px; height: 150px;">
                                        <img src="{{ asset('storage/' . $anggota->foto) }}"
                                            class="img-fluid h-100 w-100 object-fit-cover" alt="Foto Profil">
                                    </div>
                                @else
                                    <div class="mx-auto mb-3 rounded-circle bg-primary bg-gradient text-white d-flex align-items-center justify-content-center"
                                        style="width: 150px; height: 150px;">
                                        <i class="fas fa-user fa-3x"></i>
                                    </div>
                                @endif

                                <h3 class="fw-bold text-dark mb-1">{{ $anggota->namalengkap ?? 'Nama Anggota' }}</h3>
                                <div class="d-flex justify-content-center align-items-center mb-3">
                                    <span class="badge bg-secondary me-2">NIS/NIP</span>
                                    <span class="text-muted">{{ $anggota->nis ?? '-' }}</span>
                                </div>

                                <div class="bg-light rounded-3 p-3 mt-auto w-100">
                                    <div class="d-flex justify-content-between align-items-center py-2 mb-2">
                                        <span class="text-muted small">Status</span>
                                        <span class="badge bg-success">Aktif</span>
                                    </div>
                                    <button class="btn btn-primary w-100 mt-2" data-bs-toggle="modal"
                                        data-bs-target="#resetPasswordModal">
                                        <i class="fas fa-key me-2"></i>Reset Password
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Detail Information -->
                    <div class="col-lg-8">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-white border-bottom-0 pb-0">
                                <h4 class="card-title m-0 text-primary fw-bold">
                                    <i class="fas fa-info-circle me-2"></i>Detail Informasi
                                </h4>
                            </div>
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tbody class="border-0">
                                            <tr class="border-bottom">
                                                <th width="30%" class="ps-0 py-3 text-muted">Nomor Anggota</th>
                                                <td class="pe-0 py-3">{{ $anggota->nomor_anggota ?? '-' }}</td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <th class="ps-0 py-3 text-muted">Jenis Anggota</th>
                                                <td class="pe-0 py-3">
                                                    <span class="badge bg-primary">{{ $anggota->jenis ?? '-' }}</span>
                                                </td>
                                            </tr>
                                            @if ($anggota?->jenis === 'Siswa')
                                                <tr class="border-bottom">
                                                    <th class="ps-0 py-3 text-muted">Kelas</th>
                                                    <td class="pe-0 py-3">{{ $anggota->kelas ?? '-' }}</td>
                                                </tr>
                                            @elseif ($anggota?->jenis === 'Guru')
                                                <tr class="border-bottom">
                                                    <th class="ps-0 py-3 text-muted">Mata Pelajaran</th>
                                                    <td class="pe-0 py-3">{{ $anggota->mata_pelajaran ?? '-' }}</td>
                                                </tr>
                                            @endif
                                            <tr class="border-bottom">
                                                <th class="ps-0 py-3 text-muted">Alamat</th>
                                                <td class="pe-0 py-3">
                                                    <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                                    {{ $anggota->alamat ?? '-' }}
                                                </td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <th class="ps-0 py-3 text-muted">Email</th>
                                                <td class="pe-0 py-3">
                                                    <i class="fas fa-envelope text-primary me-2"></i>
                                                    {{ $anggota->email ?? '-' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="ps-0 py-3 text-muted">Kontak</th>
                                                <td class="pe-0 py-3">
                                                    <i class="fas fa-phone text-success me-2"></i>
                                                    {{ $anggota->no_hp ?? '-' }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Password Reset Modal -->
        <div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="resetPasswordModalLabel">
                            Reset Password
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-4">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @elseif (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show mb-4">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('profile.resetPassword') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="current_password" class="form-label fw-medium">Password Lama</label>
                                <input type="password" class="form-control" id="current_password"
                                    name="current_password" required>
                            </div>

                            <div class="mb-3">
                                <label for="new_password" class="form-label fw-medium">Password Baru</label>
                                <input type="password" class="form-control" id="new_password" name="new_password"
                                    required>
                                <small class="text-muted">Minimal 8 karakter, kombinasi huruf dan angka</small>
                            </div>

                            <div class="mb-4">
                                <label for="new_password_confirmation" class="form-label fw-medium">Konfirmasi Password
                                    Baru</label>
                                <input type="password" class="form-control" id="new_password_confirmation"
                                    name="new_password_confirmation" required>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary fw-bold">
                                    Ubah Password
                                </button>
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        @section('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // --- Aktifkan tab berdasarkan hash di URL ---
                    const hash = window.location.hash;
                    if (hash) {
                        const triggerEl = document.querySelector(`a[href="${hash}"]`);
                        if (triggerEl) {
                            new bootstrap.Tab(triggerEl).show();
                        }
                    }

                    // --- Tampilkan modal peminjaman jika ada error validasi dari Laravel ---
                    @if ($errors->any())
                        const modalEl = document.getElementById('modalPeminjaman');
                        if (modalEl) {
                            const myModal = new bootstrap.Modal(modalEl);
                            myModal.show();
                        }
                    @endif

                    // --- Fungsi toggle field kelas berdasarkan jenis anggota ---
                    function toggleKelas() {
                        const jenis = document.getElementById('jenis')?.value;
                        const kelasRow = document.getElementById('kelasRow');
                        if (!jenis || !kelasRow) return;

                        if (jenis === 'Siswa') {
                            kelasRow.classList.remove('d-none');
                        } else {
                            kelasRow.classList.add('d-none');
                        }
                    }

                    // Jalankan toggle saat halaman pertama kali dimuat
                    toggleKelas();

                    const jenisSelect = document.getElementById('jenis');
                    if (jenisSelect) {
                        jenisSelect.addEventListener('change', toggleKelas);
                    }

                    // --- Validasi: Cegah pemilihan buku yang sama di dua select ---
                    const bukuSelects = document.querySelectorAll(
                        'select[name="buku_id[]"], select[name="buku_id_1"], select[name="buku_id_2"]'
                    );

                    bukuSelects.forEach((select) => {
                        select.addEventListener('change', () => {
                            const selectedValues = Array.from(bukuSelects)
                                .map(s => s.value)
                                .filter(Boolean); // Ambil yang tidak kosong

                            const uniqueValues = new Set(selectedValues);

                            // Jika ada duplikasi
                            if (selectedValues.length !== uniqueValues.size) {
                                alert('Buku tidak boleh dipilih dua kali.');
                                select.value = '';

                                // Jika menggunakan Select2, reset tampilannya
                                if ($(select).hasClass('select2-hidden-accessible')) {
                                    $(select).trigger('change.select2');
                                }
                            }
                        });
                    });
                });
                // Toggle password visibility
                document.querySelectorAll('.toggle-password').forEach(function(button) {
                    button.addEventListener('click', function() {
                        const input = this.parentNode.querySelector('input');
                        const icon = this.querySelector('i');

                        if (input.type === 'password') {
                            input.type = 'text';
                            icon.classList.remove('fa-eye');
                            icon.classList.add('fa-eye-slash');
                        } else {
                            input.type = 'password';
                            icon.classList.remove('fa-eye-slash');
                            icon.classList.add('fa-eye');
                        }
                    });
                });

                // Clear form and errors when modal is closed
                $('#resetPasswordModal').on('hidden.bs.modal', function() {
                    $(this).find('form')[0].reset();
                    $(this).find('.alert').alert('close');
                });
            </script>
        @endsection
    @endsection
