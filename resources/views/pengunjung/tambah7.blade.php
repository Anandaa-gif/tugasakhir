<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pengunjung | Perpustakaan Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --secondary: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
        }

        body {
            font-family: 'Poppins', system-ui, -apple-system, sans-serif;
            background-color: #f5f7ff;
            color: var(--dark);
            min-height: 100vh;
        }

        .library-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 3rem 0;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(67, 97, 238, 0.15);
        }

        .library-header::before {
            content: "";
            position: absolute;
            top: -50px;
            right: -50px;
            width: 250px;
            height: 250px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .form-container {
            margin-top: -50px;
            position: relative;
            z-index: 10;
        }

        .registration-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .registration-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 1.5rem;
            border-bottom: none;
        }

        .form-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .form-label i {
            margin-right: 10px;
            color: var(--primary);
            width: 20px;
            text-align: center;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15);
        }

        .input-group-text {
            background-color: var(--light);
            border-radius: 10px 0 0 10px !important;
        }

        .btn-register {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }

        .invalid-feedback {
            margin-top: 0.25rem;
            font-size: 0.85rem;
        }

        @media (max-width: 768px) {
            .library-header {
                padding: 2rem 0;
            }

            .form-container {
                margin-top: -30px;
            }

            .form-icon {
                width: 40px;
                height: 40px;
                margin-right: 0.75rem;
            }
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <header class="library-header text-center">
        <div class="container">
            <div class="d-flex justify-content-center align-items-center mb-3">
                <div class="form-icon">
                    <i class="fas fa-book-open fs-4"></i>
                </div>
                <h1 class="mb-0 fw-bold">Perpustakaan Digital</h1>
            </div>
            <p class="lead opacity-85">Sistem Manajemen Pengunjung</p>
        </div>
    </header>

    <!-- Registration Form -->
    <div class="container form-container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="registration-card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="form-icon">
                                <i class="fas fa-user-plus fs-4"></i>
                            </div>
                            <div>
                                <h3 class="mb-0">Formulir Pendaftaran</h3>
                                <p class="mb-0 opacity-85">Pengunjung Perpustakaan</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm mb-4"
                                role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle me-3 fs-4"></i>
                                    <div>
                                        <h6 class="mb-1 fw-bold">Terdapat Kesalahan</h6>
                                        <ul class="mb-0 ps-3">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('pengunjung.submit6') }}" method="POST" class="needs-validation"
                            novalidate>
                            @csrf

                            <!-- Nama Lengkap -->
                            <div class="mb-4">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user"></i> Nama Lengkap
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" name="name" id="name"
                                        class="form-control form-control-lg @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Jenis Pengunjung -->
                            <div class="mb-4">
                                <label for="type" class="form-label">
                                    <i class="fas fa-users"></i> Jenis Pengunjung
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                    <select name="type" id="type"
                                        class="form-select form-select-lg @error('type') is-invalid @enderror"
                                        onchange="toggleFields()" required>
                                        <option value="">-- Pilih Jenis Pengunjung --</option>
                                        <option value="siswa" {{ old('type') == 'siswa' ? 'selected' : '' }}>Siswa
                                        </option>
                                        <option value="guru" {{ old('type') == 'guru' ? 'selected' : '' }}>Guru
                                        </option>
                                        <option value="tamu" {{ old('type') == 'tamu' ? 'selected' : '' }}>Tamu
                                        </option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kelas (hanya siswa) -->
                            <div class="mb-4 {{ old('type') == 'siswa' ? '' : 'd-none' }}" id="kelasField">
                                <label for="kelas" class="form-label">
                                    <i class="fas fa-graduation-cap"></i> Kelas
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-school"></i></span>
                                    <select name="kelas" id="kelas"
                                        class="form-select form-select-lg @error('kelas') is-invalid @enderror">
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach (['7A', '7B', '7C', '7D', '8A', '8B', '8C', '8D', '9A', '9B', '9C', '9D'] as $kelas)
                                            <option value="{{ $kelas }}"
                                                {{ old('kelas') == $kelas ? 'selected' : '' }}>{{ $kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kelas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Tujuan -->
                            <div class="mb-4">
                                <label for="tujuan" class="form-label">
                                    <i class="fas fa-bullseye"></i> Tujuan Kunjungan
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-flag"></i></span>
                                    <input type="text" name="tujuan" id="tujuan"
                                        class="form-control form-control-lg @error('tujuan') is-invalid @enderror"
                                        value="{{ old('tujuan') }}" placeholder="Masukkan tujuan kunjungan" required>
                                    @error('tujuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Tanggal Kunjungan -->
                            <div class="mb-4">
                                <label for="waktu_kunjung" class="form-label">
                                    <i class="far fa-calendar-alt"></i> Tanggal Kunjungan
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                    <input type="date" name="waktu_kunjung" id="waktu_kunjung"
                                        class="form-control form-control-lg @error('waktu_kunjung') is-invalid @enderror"
                                        value="{{ old('waktu_kunjung', now()->toDateString()) }}" required>
                                    @error('waktu_kunjung')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Alamat (hanya tamu) -->
                            <div class="mb-4 {{ old('type') == 'tamu' ? '' : 'd-none' }}" id="alamatField">
                                <label for="alamat" class="form-label">
                                    <i class="fas fa-map-marker-alt"></i> Alamat
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-home"></i></span>
                                    <input type="text" name="alamat" id="alamat"
                                        class="form-control form-control-lg @error('alamat') is-invalid @enderror"
                                        value="{{ old('alamat') }}" placeholder="Masukkan alamat lengkap">
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kesan & Pesan (hanya tamu) -->
                            <div class="mb-4 {{ old('type') == 'tamu' ? '' : 'd-none' }}" id="kesanPesanField">
                                <label for="kesan_pesan" class="form-label">
                                    <i class="far fa-comment-dots"></i> Kesan & Pesan
                                </label>
                                <textarea name="kesan_pesan" id="kesan_pesan"
                                    class="form-control form-control-lg @error('kesan_pesan') is-invalid @enderror" rows="3"
                                    placeholder="Masukkan kesan dan pesan">{{ old('kesan_pesan') }}</textarea>
                                @error('kesan_pesan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-register btn-lg py-3">
                                    <i class="fas fa-user-plus me-2"></i> Daftarkan Pengunjung
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleFields() {
            const type = document.getElementById('type').value;

            // Toggle Kelas Field
            const kelasField = document.getElementById('kelasField');
            kelasField.classList.toggle('d-none', type !== 'siswa');

            // Toggle Alamat & KesanPesan Fields
            const alamatField = document.getElementById('alamatField');
            const kesanField = document.getElementById('kesanPesanField');

            alamatField.classList.toggle('d-none', type !== 'tamu');
            kesanField.classList.toggle('d-none', type !== 'tamu');

            // Reset optional fields when hidden
            if (type !== 'tamu') {
                document.getElementById('alamat').value = '';
                document.getElementById('kesan_pesan').value = '';
            }

            if (type !== 'siswa') {
                document.getElementById('kelas').value = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleFields();
            document.getElementById('type').addEventListener('change', toggleFields);

            // Form validation
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        });
    </script>
</body>

</html>
