@extends('layout.tampil')

@section('konten')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Profile Header -->
            <div class="text-center mb-5">
                <div class="bg-primary bg-opacity-10 d-inline-flex p-3 rounded-circle mb-3">
                    <i class="bi bi-person-gear text-primary fs-1"></i>
                </div>
                <h1 class="h3 fw-bold text-dark mb-1">PROFILE ADMIN</h1>
                <p class="text-muted">Kelola informasi akun Anda</p>
            </div>

            <!-- Profile Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                            <i class="bi bi-person-badge text-primary fs-4"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-1 fw-semibold">{{ $admin->name }}</h5>
                            <p class="text-muted mb-0">{{ $admin->email }}</p>
                        </div>
                        <span class="badge bg-primary bg-opacity-10 text-primary py-2 px-3">
                            {{ ucfirst($admin->role) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Combined Settings Form -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-semibold text-dark">
                        <i class="bi bi-sliders text-primary me-2"></i>Pengaturan Akun
                    </h5>
                </div>
                <div class="card-body p-4">
                    <!-- Success/Error Messages -->
                    @if(session('success_email'))
                    <div class="alert alert-success alert-dismissible fade show mb-4 border-0 bg-opacity-10">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success_email') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @elseif(session('error_email'))
                    <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 bg-opacity-10">
                        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error_email') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4 border-0 bg-opacity-10">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @elseif(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 bg-opacity-10">
                        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <!-- Email Update Form -->
                    <div class="mb-4 pb-4 border-bottom">
                        <h6 class="fw-semibold mb-3 text-dark d-flex align-items-center">
                            <i class="bi bi-envelope text-primary me-2"></i>Ubah Email
                        </h6>
                        <form action="{{ route('admin.update_email') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label text-muted small">Alamat Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="bi bi-at text-muted"></i>
                                    </span>
                                    <input type="email" class="form-control border-start-0" name="email" 
                                           value="{{ old('email', $admin->email) }}" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-outline-primary px-4">
                                <i class="bi bi-save me-1"></i> Simpan Perubahan
                            </button>
                        </form>
                    </div>

                    <!-- Password Update Form -->
                    <div>
                        <h6 class="fw-semibold mb-3 text-dark d-flex align-items-center">
                            <i class="bi bi-shield-lock text-primary me-2"></i>Ubah Password
                        </h6>
                        <form action="{{ route('admin.reset_password') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label text-muted small">Password Saat Ini</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="bi bi-lock text-muted"></i>
                                    </span>
                                    <input type="password" class="form-control border-start-0" name="current_password" required>
                                </div>
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label text-muted small">Password Baru</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="bi bi-key text-muted"></i>
                                        </span>
                                        <input type="password" class="form-control border-start-0" name="new_password" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small">Konfirmasi Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="bi bi-key-fill text-muted"></i>
                                        </span>
                                        <input type="password" class="form-control border-start-0" name="new_password_confirmation" required>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-arrow-repeat me-1"></i> Perbarui Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection