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
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            --border-radius: 12px;
        }

        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            line-height: 1.6;
        }

        /* Navbar Styles */
        .main-navbar {
            background: linear-gradient(135deg, var(--primary) 0%, #2a5298 100%);
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .nav-tabs {
            background: transparent;
            border: none;
            gap: 12px;
            padding: 0 15px;
        }

        .nav-tabs .nav-link {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            font-weight: 600;
            padding: 12px 20px;
            border-radius: var(--border-radius);
            transition: all 0.3s ease;
            border: none;
            display: flex;
            align-items: center;
        }

        .nav-tabs .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .nav-tabs .nav-link.active {
            background-color: var(--accent);
            color: var(--text-dark);
            box-shadow: var(--shadow);
        }

        .nav-tabs .nav-link i {
            margin-right: 10px;
        }

        /* Sidebar Styles */
        .sidebar {
            background: var(--primary);
            position: fixed;
            top: 0;
            left: -250px;
            height: 100%;
            width: 250px;
            padding: 20px;
            z-index: 1050;
            transition: left 0.3s ease;
            color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            overflow-y: auto;
        }

        .sidebar.open {
            left: 0;
        }

        .sidebar .nav-link {
            color: white;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 8px;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Hamburger Menu */
        .hamburger {
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1100;
            background: var(--primary);
            border: none;
            color: white;
            font-size: 1.5rem;
            padding: 10px;
            border-radius: 8px;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            display: block; /* Default: visible */
        }

        .hamburger:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Hide hamburger when sidebar is open */
        .sidebar.open ~ .hamburger {
            display: none;
        }

        /* Main Content Styles */
        .main-content {
            padding: 50px 20px;
            max-width: 1400px;
            margin: 0 auto;
            min-height: calc(100vh - 200px);
        }

        .card {
            border: none;
            border-radius: var(--border-radius);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: white;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow);
        }

        .card-header {
            background-color: var(--primary);
            color: white;
            font-weight: 600;
            padding: 15px 20px;
        }

        .card-body {
            padding: 20px;
        }

        /* Footer Styles */
        .main-footer {
            background: linear-gradient(135deg, var(--primary) 0%, #2a5298 100%);
            color: white;
            padding: 60px 0 30px;
            font-size: 0.95rem;
        }

        .footer-logo img {
            height: 60px;
            border-radius: 8px;
            box-shadow: var(--shadow);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            padding-top: 25px;
            margin-top: 30px;
        }

        .footer-bottom span {
            font-size: 1rem;
            font-weight: 500;
        }

        .social-links a {
            transition: color 0.3s ease;
        }

        .social-links a:hover {
            color: var(--accent);
        }

        /* Typography Enhancements */
        h5 {
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        p, a {
            font-size: 0.95rem;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .main-content {
                padding: 70px 15px 30px; /* Add padding-top for hamburger menu */
            }

            .nav-tabs {
                flex-wrap: nowrap;
                overflow-x: auto;
                white-space: nowrap;
                padding-bottom: 10px;
                -webkit-overflow-scrolling: touch;
            }

            .nav-tabs .nav-link {
                padding: 10px 14px;
                font-size: 0.85rem;
            }

            .nav-tabs .nav-link i {
                margin-right: 6px;
            }

            .main-footer {
                padding: 40px 0 20px;
            }

            .footer-logo img {
                height: 50px;
            }
        }

        @media (max-width: 576px) {
            .main-navbar .d-flex {
                flex-direction: column;
                align-items: flex-start;
            }

            .nav-tabs {
                justify-content: flex-start;
            }
        }
    </style>
    <!-- jQuery (dibutuhkan oleh Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>
    <!-- NAVBAR - DESKTOP ONLY -->
    <div class="container-fluid py-3 border-bottom main-navbar d-none d-md-flex">
        <div class="d-flex justify-content-between align-items-center flex-wrap w-100">
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <img src="{{ asset('storage/images/smp3.png') }}" alt="Logo SMP" style="height: 50px;">
                <div class="ms-3">
                    <h5 class="mb-0 fw-bold text-white">SMP Negeri 3 Besuki</h5>
                    <small class="text-white">Perpustakaan Digital</small>
                </div>
            </div>
            <ul class="nav nav-tabs justify-content-end pt-3 pt-md-0" id="myTab" role="tablist">
                <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#dashboard"><i class="fas fa-home"></i> Dashboard</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#daftar"><i class="fas fa-user-plus"></i> Daftar</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#buku"><i class="fas fa-book"></i> Buku</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#peminjaman"><i class="fas fa-book-reader"></i> Peminjaman</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#pengembalian"><i class="fas fa-exchange-alt"></i> Pengembalian</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#profil"><i class="fas fa-user-circle"></i> Profil</button></li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-white" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </li>
            </ul>
        </div>
    </div>

    <!-- HAMBURGER MENU - MOBILE ONLY -->
    <button class="hamburger d-md-none" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <!-- SIDEBAR - MOBILE ONLY -->
    <div class="sidebar d-md-none" id="mobileSidebar">
        <div class="d-flex align-items-center mb-4">
            <img src="{{ asset('storage/images/smp3.png') }}" alt="Logo" style="height: 50px;" class="me-2">
            <div>
                <h5 class="mb-0">SMPN 3 Besuki</h5>
                <small>Perpustakaan</small>
            </div>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#dashboard"><i class="fas fa-home me-2"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#daftar"><i class="fas fa-user-plus me-2"></i> Daftar</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#buku"><i class="fas fa-book me-2"></i> Buku</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#peminjaman"><i class="fas fa-book-reader me-2"></i> Peminjaman</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#pengembalian"><i class="fas fa-exchange-alt me-2"></i> Pengembalian</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#profil"><i class="fas fa-user-circle me-2"></i> Profil</a></li>
            <li class="nav-item">
                <a href="#" class="nav-link text-danger" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
                <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </li>
        </ul>
    </div>

    <!-- Main Content Section -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer Section -->
    <footer class="main-footer">
        <div class="container">
            <div class="row text-start text-md-left">
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold text-white">Perpustakaan SMPN 3 Besuki</h5>
                    <p class="text-light mb-1">Jl. Gn. Ringgit, Besuki, Kec. Besuki, Kabupaten Situbondo, Jawa Timur.</p>
                    <p class="text-light mb-1"><i class="fas fa-phone-alt me-2"></i>08883077077</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold text-white">Ikuti Kami</h5>
                    <p class="text-light mb-2">Kunjungi media sosial kami untuk informasi terbaru:</p>
                    <a href="https://www.instagram.com/smpn_3_besuki" class="text-decoration-none me-2"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-decoration-none"><i class="fab fa-twitter fa-lg"></i></a>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center footer-bottom">
                <div class="d-flex align-items-center footer-logo">
                    <img src="{{ asset('storage/images/smp3.png') }}" alt="Logo SMP" style="height: 50px;" class="me-3">
                    <span class="fw-semibold">PERPUSTAKAAN<br><small>SMPN 3 Besuki</small></span>
                </div>
                <div class="text-light small text-end">
                    © 2025 SMPN 3 Besuki
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('mobileSidebar');
            sidebar.classList.toggle('open');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('mobileSidebar');
            const hamburger = document.querySelector('.hamburger');
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickOnHamburger = hamburger && hamburger.contains(event.target);

            if (!isClickInsideSidebar && !isClickOnHamburger && sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
            }
        });

        // Initialize Select2 (if needed)
        $(document).ready(function() {
            $('.select2').select2();
        });

        function toggleKelas() {
            const jenis = document.getElementById('jenis').value;
            const kelasRow = document.getElementById('kelasRow');
            if (jenis === 'Siswa') {
                kelasRow.classList.remove('d-none');
            } else {
                kelasRow.classList.add('d-none');
                document.getElementById('kelas').value = '';
            }
        }
    </script>
</body>
</html>