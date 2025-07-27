<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="{{ asset('storage/images/smp3.png') }}">
    <title>Perpustakaan SMPN 3 Besuki</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #1a3c7a;
            --secondary: #6c757d;
            --accent: #f8d05d;
            --bg-light: #f9fafb;
            --text-dark: #212529;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* Navbar/Sidebar */
        .navbar-container {
            background: linear-gradient(135deg, var(--primary) 0%, #2a5298 100%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 1001;
        }

        .nav-tabs {
            background: transparent;
            border: none;
            gap: 10px;
            flex-direction: row;
        }

        .nav-tabs .nav-item {
            margin-left: 5px;
        }

        .nav-tabs .nav-link {
            background-color: var(--primary);
            color: white;
            font-weight: 600;
            padding: 10px 18px;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: none;
            font-size: 1rem;
        }

        .nav-tabs .nav-link:hover {
            background-color: #2a5298;
        }

        .nav-tabs .nav-link.active {
            background-color: var(--accent);
            color: var(--text-dark);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* Sidebar Styles for Mobile */
        .sidebar {
            position: fixed;
            top: 0;
            left: -250px;
            width: 250px;
            height: 100%;
            background: var(--primary);
            z-index: 1000;
            transition: left 0.3s ease;
            padding: 20px;
            overflow-y: auto;
        }

        .sidebar.active {
            left: 0;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar a,
        .sidebar button.nav-link {
            display: block;
            width: 100%;
            text-align: left;
            padding: 12px 20px;
            color: white;
            background-color: transparent;
            border: none;
            text-decoration: none;
            font-weight: 600;
            border-radius: 8px;
        }

        .sidebar a:hover,
        .sidebar button.nav-link:hover {
            background-color: #2a5298;
        }

        .sidebar .active {
            background-color: var(--accent);
            color: var(--text-dark);
        }

        .hamburger {
            display: none;
            font-size: 1.5rem;
            background: none;
            border: none;
            color: white;
            padding: 10px;
            cursor: pointer;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .sidebar-overlay.active {
            display: block;
        }

        /* Main Content */
        .tab-content {
            padding: 40px 20px;
            max-width: 1400px;
            margin: 0 auto;
            transition: margin-left 0.3s ease;
        }

        .card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .card-img-top {
            height: 220px;
            object-fit: cover;
            border-bottom: 2px solid var(--accent);
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 600;
        }

        /* Table */
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .table {
            margin-bottom: 0;
        }

        .table th,
        .table td {
            padding: 15px;
            vertical-align: middle;
        }

        .table thead {
            background: var(--primary);
            color: white;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f5f7fa;
        }

        .badge {
            font-size: 0.85rem;
            padding: 8px 12px;
            border-radius: 20px;
        }

        /* Footer */
        footer {
            background: linear-gradient(135deg, var(--primary) 0%, #2a5298 100%);
            color: white;
            padding: 40px 0 20px;
        }

        footer a {
            color: var(--accent);
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: white;
        }

        .footer-logo img {
            height: 50px;
            border-radius: 5px;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding-top: 20px;
        }

        /* Additional Styles */
        h3,
        h4,
        h5 {
            font-weight: 700;
        }

        .btn-outline-primary {
            border-color: var(--primary);
            color: var(--primary);
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary);
            color: white;
        }

        .list-group-item {
            border: none;
            padding: 10px 0;
            font-size: 1rem;
        }

        /* Login Form */
        .login-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .tab-content {
                padding: 30px 15px;
            }

            .card-img-top {
                height: 200px;
            }

            .card-title {
                font-size: 1.1rem;
            }

            .card-body {
                padding: 15px;
            }
        }

        @media (max-width: 768px) {
            .navbar-container .d-flex {
                flex-direction: row;
                align-items: center;
                padding: 10px 15px;
            }

            .hamburger {
                display: block;
            }

            .nav-tabs:not(.sidebar ul) {
                display: none;
            }

            .sidebar {
                display: block;
            }

            .tab-content {
                margin-left: 0;
            }

            .sidebar.active~.tab-content {
                margin-left: 250px;
            }

            .card-img-top {
                height: 180px;
            }

            .card-title {
                font-size: 1rem;
            }

            h1.display-5 {
                font-size: 2rem;
            }

            .lead {
                font-size: 1rem;
            }

            .login-container {
                padding: 15px;
                margin: 15px;
            }

            .container.mb-5 {
                margin-bottom: 3rem !important;
            }

            .row.align-items-center .col-md-6 {
                padding: 0 15px;
            }

            .col-md-6.ps-md-5 {
                padding-left: 15px !important;
            }
        }

        @media (max-width: 576px) {
            .card-img-top {
                height: 150px;
            }

            .card-title {
                font-size: 0.95rem;
            }

            .card-body {
                padding: 10px;
            }

            h1.display-5 {
                font-size: 1.5rem;
            }

            h3,
            h4 {
                font-size: 1.2rem;
            }

            .lead {
                font-size: 0.9rem;
            }

            .footer-logo img {
                height: 40px;
            }

            footer h5 {
                font-size: 1rem;
            }

            footer p,
            footer .text-light {
                font-size: 0.85rem;
            }

            .login-container {
                max-width: 90%;
                padding: 10px;
            }

            .btn-primary {
                padding: 8px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar/Sidebar -->
    <div class="navbar-container py-3">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Logo -->
                <div class="d-flex align-items-center">
                    <button class="hamburger me-3" aria-label="Toggle Sidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <img src="{{ asset('storage/images/smp3.png') }}" alt="Logo SMP" style="height: 50px;"
                        class="me-3">
                    <div>
                        <h5 class="mb-0 fw-bold text-white">SMP Negeri 3 Besuki</h5>
                        <small class="text-white">Perpustakaan Digital</small>
                    </div>
                </div>
                <!-- Navbar Tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" id="dashboard-tab" data-bs-toggle="tab"
                            data-bs-target="#dashboard" type="button" role="tab" aria-controls="dashboard"
                            aria-selected="true">
                            <i class="fas fa-home"></i> Beranda
                        </button>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Sidebar for Mobile -->
        <div class="sidebar" id="sidebar">
            <ul>
                <li>
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#dashboard" type="button">
                        <i class="fas fa-home"></i> Beranda
                    </button>
                </li>
                <li>
                    <a href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                </li>
            </ul>
        </div>
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
    </div>

    <main>
        <div class="tab-content" id="myTabContent">
            <!-- Dashboard -->
            <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                <div class="text-center py-5">
                    <h1 class="display-5 fw-bold text-primary">Selamat Datang di Perpustakaan SMPN 3 BESUKI</h1>
                    <p class="lead text-secondary">Jelajahi koleksi buku kami dan nikmati pengalaman membaca yang luar
                        biasa.</p>
                </div>

                <!-- Informasi Perpustakaan -->
                <div class="container mb-5">
                    <h3 class="text-primary mb-4">Informasi Perpustakaan</h3>
                    <p class="text-secondary">
                        Perpustakaan SMPN 3 BESUKI menyediakan koleksi buku akademik dan non-akademik...
                    </p>
                </div>

                <div class="container py-5">
                    <h4 class="text-primary mb-4">Buku Terbaru</h4>
                    <div class="row g-4" id="latest-books">
                        <!-- Book cards will be inserted here by JavaScript -->
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
                                pengetahuan.</p>

                            <!-- Visi -->
                            <div class="bg-light rounded p-3 mb-3 shadow-sm">
                                <h5 class="text-primary fw-semibold"><i
                                        class="fas fa-graduation-cap me-2 text-info"></i>VISI</h5>
                                <p class="mb-0">Menjadi pusat sumber belajar yang unggul, inovatif, dan inspiratif
                                    dalam mendukung terwujudnya generasi cerdas, literat, dan berkarakter.</p>
                            </div>

                            <!-- Misi -->
                            <div class="bg-light rounded p-3 shadow-sm">
                                <h5 class="text-primary fw-semibold"><i class="fas fa-bookmark me-2 text-info"></i>MISI
                                </h5>
                                <ul class="mb-0 ps-3">
                                    <li>Menyediakan koleksi bahan pustaka yang relevan, berkualitas, dan sesuai dengan
                                        kebutuhan kurikulum serta minat baca siswa.</li>
                                    <li>Meningkatkan literasi informasi dan budaya baca melalui layanan dan program
                                        perpustakaan yang kreatif dan edukatif.</li>
                                    <li>Menyelenggarakan layanan perpustakaan berbasis teknologi informasi untuk
                                        mendukung pembelajaran digital dan kemudahan akses informasi.</li>
                                    <li>Menumbuhkan karakter siswa melalui penyediaan bacaan yang membangun nilai moral,
                                        etika, dan wawasan kebangsaan.</li>
                                    <li>Menjalin kerja sama dengan berbagai pihak dalam rangka pengembangan koleksi,
                                        peningkatan layanan, dan pelatihan literasi informasi.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Login -->
            <div class="tab-pane fade" id="login" role="tabpanel" aria-labelledby="login-tab">
                <div class="container login-container my-5">
                    <h3 class="text-primary mb-4 text-center fw-bold">Login</h3>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" placeholder="Masukkan username"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Masukkan password"
                            required>
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-primary w-100">Login</button>
                    </div>
                    <p class="text-center mt-3">
                        Belum punya akun? <a href="#" class="text-primary">Daftar sekarang</a>
                    </p>
                </div>
            </div>
        </div>
    </main>

    <footer class="pt-5 pb-3 mt-auto">
        <div class="container">
            <div class="row text-start text-md-left">
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold text-white">Perpustakaan SMPN 3 Besuki</h5>
                    <p class="text-light mb-1"> Jl. Gn. Ringgit, Besuki, Kec. Besuki, Kabupaten Situbondo, Jawa Timur.
                    </p>
                    <p class="text-light mb-1"><i class="fas fa-phone-alt me-2"></i>08883077077</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold text-white">Ikuti Kami</h5>
                    <p class="text-light mb-2">Kunjungi media sosial kami untuk informasi terbaru:</p>
                    <a href="https://www.instagram.com/smpn_3_besuki" class="text-decoration-none me-2"><i
                            class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-decoration-none"><i class="fab fa-twitter fa-lg"></i></a>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center footer-bottom">
                <div class="d-flex align-items-center footer-logo">
                    <img src="{{ asset('storage/images/smp3.png') }}" alt="Logo SMP" style="height: 50px;"
                        class="me-3">
                    <span class="fw-semibold">PERPUSTAKAAN<br><small> SMPN 3 Besuki</small></span>
                </div>
                <div class="text-light small text-end">
                    © 2025 SMPN 3 Besuki
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle
        const hamburger = document.querySelector('.hamburger');
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        const tabContent = document.querySelector('.tab-content');

        if (hamburger && sidebar && overlay) {
            console.log('Elements found:', {
                hamburger,
                sidebar,
                overlay
            });
            hamburger.addEventListener('click', () => {
                console.log('Hamburger clicked');
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
                tabContent.classList.toggle('shifted', sidebar.classList.contains('active'));
            });

            overlay.addEventListener('click', () => {
                console.log('Overlay clicked');
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                tabContent.classList.remove('shifted');
            });

            // Close sidebar when a link is clicked
            const sidebarLinks = sidebar.querySelectorAll('a, button');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', () => {
                    console.log('Sidebar link clicked');
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                    tabContent.classList.remove('shifted');
                });
            });
        } else {
            console.error('One or more elements not found:', {
                hamburger,
                sidebar,
                overlay
            });
        }

        // Simulated book data
        const books = [{
                id: 1,
                judul_buku: "Dasar-Dasar Pemrograman",
                penulis: "John Doe",
                penerbit: "Penerbit Informatika",
                tahun_terbit: 2023,
                jenis: "Non-Fiksi",
                kategori: "Teknologi",
                sinopsis: "Buku ini membahas dasar-dasar pemrograman untuk pemula.",
                foto: "{{ asset('storage/images/pemograman.jpg') }}"
            },
            {
                id: 2,
                judul_buku: "Sejarah Indonesia Modern",
                penulis: "Jane Smith",
                penerbit: "Penerbit Sejarah",
                tahun_terbit: 2022,
                jenis: "Non-Fiksi",
                kategori: "Sejarah",
                sinopsis: "Kajian mendalam tentang sejarah Indonesia abad ke-20.",
                foto: "{{ asset('storage/images/inggris.jpg') }}"
            },
            {
                id: 3,
                judul_buku: "Fiksi Fantasi Epik",
                penulis: "Ahmad Yani",
                penerbit: "Penerbit Fantasi",
                tahun_terbit: 2021,
                jenis: "Fiksi",
                kategori: "Novel",
                sinopsis: "Petualangan epik di dunia fantasi penuh keajaiban.",
                foto: "{{ asset('storage/images/ipa.jpg') }}"
            },
            {
                id: 4,
                judul_buku: "Matematika untuk SMA",
                penulis: "Budi Santoso",
                penerbit: "Penerbit Pendidikan",
                tahun_terbit: 2020,
                jenis: "Non-Fiksi",
                kategori: "Pendidikan",
                sinopsis: "Buku pelajaran matematika untuk siswa SMA.",
                foto: "{{ asset('storage/images/mate.png') }}"
            },
            {
                id: 5,
                judul_buku: "Sastra Klasik Indonesia",
                penulis: "Siti Aminah",
                penerbit: "Penerbit Budaya",
                tahun_terbit: 2019,
                jenis: "Fiksi",
                kategori: "Sastra",
                sinopsis: "Kumpulan karya sastra klasik Indonesia.",
                foto: null
            }
        ];

        // Function to generate book card HTML
        function generateBookCard(book) {
            return `
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card shadow-sm h-100" data-bs-toggle="modal" data-bs-target="#bookDetailModal${book.id}">
                        ${book.foto ? 
                            `<img src="${book.foto}" class="card-img-top" alt="Foto ${book.judul_buku}" style="height: 220px; object-fit: cover;">` :
                            `<div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 220px;">
                                            <span class="text-center">Tidak ada foto</span>
                                        </div>`
                        }
                        <div class="card-body">
                            <h5 class="card-title text-primary">${book.judul_buku}</h5>
                            <p class="card-text mb-1"><strong>Penulis:</strong> ${book.penulis}</p>
                            <p class="card-text"><strong>Tahun:</strong> ${book.tahun_terbit}</p>
                        </div>
                    </div>
                </div>
            `;
        }

        // Function to generate book modal HTML
        function generateBookModal(book) {
            return `
                <div class="modal fade" id="bookDetailModal${book.id}" tabindex="-1" aria-labelledby="bookDetailModalLabel${book.id}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="bookDetailModalLabel${book.id}">Detail Buku</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center mb-3">
                                    ${book.foto ? 
                                        `<img src="${book.foto}" alt="Foto ${book.judul_buku}" class="img-fluid rounded" style="max-height: 200px; object-fit: cover;">` :
                                        `<div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px; width: 100%;">
                                                        <span>Tidak ada foto</span>
                                                    </div>`
                                    }
                                </div>
                                <h5 class="text-primary">${book.judul_buku}</h5>
                                <p><strong>Penulis:</strong> ${book.penulis}</p>
                                <p><strong>Penerbit:</strong> ${book.penerbit || 'Tidak tersedia'}</p>
                                <p><strong>Tahun:</strong> ${book.tahun_terbit}</p>
                                <p><strong>Jenis:</strong> ${book.jenis || 'Tidak tersedia'}</p>
                                <p><strong>Kategori:</strong> ${book.kategori || 'Tidak tersedia'}</p>
                                <p><strong>Sinopsis:</strong> ${book.sinopsis || 'Tidak tersedia'}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        // Render latest books (up to 4) in Dashboard
        const latestBooksContainer = document.getElementById('latest-books');
        const latestBooks = books.slice(0, 4);
        latestBooksContainer.innerHTML = latestBooks.map(book => generateBookCard(book)).join('');

        // Append modals to body
        document.body.insertAdjacentHTML('beforeend', books.map(book => generateBookModal(book)).join(''));
    </script>
</body>

</html>
