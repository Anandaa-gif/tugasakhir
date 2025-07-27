@extends('layout.tampil')

@section('konten')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Edit Data Anggota</h4>

                        <form action="{{ route('dataanggota.update1', $anggota->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- NIS -->
                            <div class="mb-3">
                                <label for="nis" class="form-label">NIS</label>
                                <input type="text" class="form-control @error('nis') is-invalid @enderror" name="nis"
                                    id="nis" value="{{ old('nis', $anggota->nis) }}" required>
                                @error('nis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Jenis Anggota -->
                            <div class="mb-3">
                                <label for="jenis" class="form-label">Jenis Anggota</label>
                                <select name="jenis" id="jenis"
                                    class="form-select @error('jenis') is-invalid @enderror" onchange="toggleKelas()"
                                    required>
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="Siswa" {{ old('jenis', $anggota->jenis) == 'Siswa' ? 'selected' : '' }}>
                                        Siswa</option>
                                    <option value="Guru" {{ old('jenis', $anggota->jenis) == 'Guru' ? 'selected' : '' }}>
                                        Guru</option>
                                    <option value="Karyawan"
                                        {{ old('jenis', $anggota->jenis) == 'Karyawan' ? 'selected' : '' }}>Karyawan
                                    </option>
                                </select>
                                @error('jenis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nama Lengkap -->
                            <div class="mb-3">
                                <label for="namalengkap" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('namalengkap') is-invalid @enderror"
                                    name="namalengkap" id="namalengkap"
                                    value="{{ old('namalengkap', $anggota->namalengkap) }}" required>
                                @error('namalengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nomor Anggota -->
                            <div class="mb-3">
                                <label for="nomor_anggota" class="form-label">Nomor Anggota</label>
                                <input type="text" class="form-control @error('nomor_anggota') is-invalid @enderror"
                                    name="nomor_anggota" id="nomor_anggota"
                                    value="{{ old('nomor_anggota', $anggota->nomor_anggota) }}" required>
                                @error('nomor_anggota')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kelas (hanya untuk Siswa) -->
                            @php $isSiswa = old('jenis', $anggota->jenis) === 'Siswa'; @endphp
                            <div class="mb-3 {{ $isSiswa ? '' : 'd-none' }}" id="kelasRow">
                                <label for="kelas" class="form-label">Kelas</label>
                                <select name="kelas" id="kelas"
                                    class="form-select @error('kelas') is-invalid @enderror">
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach (['7A', '7B', '7C', '7D', '8A', '8B', '8C', '8D', '9A', '9B', '9C', '9D'] as $kelas)
                                        <option value="{{ $kelas }}"
                                            {{ old('kelas', $anggota->kelas) == $kelas ? 'selected' : '' }}>
                                            {{ $kelas }}</option>
                                    @endforeach
                                </select>
                                @error('kelas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Alamat -->
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3">{{ old('alamat', $anggota->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- No HP -->
                            <div class="mb-4">
                                <label for="no_hp" class="form-label">No HP</label>
                                <input type="text" class="form-control @error('no_hp') is-invalid @enderror"
                                    name="no_hp" id="no_hp" value="{{ old('no_hp', $anggota->no_hp) }}">
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tombol -->
                            <div class="text-end">
                                <a href="{{ route('dataanggota.tampil1') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script --}}
    <script>
        function toggleKelas() {
            const jenis = document.getElementById('jenis').value;
            const kelasRow = document.getElementById('kelasRow');
            const kelasInput = document.getElementById('kelas');

            if (jenis === 'Siswa') {
                kelasRow.classList.remove('d-none');
            } else {
                kelasRow.classList.add('d-none');
                kelasInput.value = '';
            }
        }

        window.onload = toggleKelas;
    </script>
@endsection
