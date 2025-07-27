<?php

use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\BukuUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PeminjamanUserController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\PengembalianUserController;
use App\Http\Controllers\PengunjungController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CekSudahAnggota;



Route::get('/', function () {
    return view('welcome');
});
Route::get('/', [WelcomeController::class, 'index']);

// Halaman dashboard Admin
Route::middleware(['auth', 'admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard/index', [DashboardController::class, 'index'])->name('dashboard');

// Data Anggota
Route::get('/anggota', [AnggotaController::class, 'tampil1'])->name('dataanggota.tampil1');
Route::get('/anggota/tambah', [AnggotaController::class, 'tambah1'])->name('dataanggota.tambah1');
Route::post('/anggota/tambah', [AnggotaController::class, 'submit1'])->name('dataanggota.submit1');
Route::get('/anggota/edit/{id}', [AnggotaController::class, 'edit1'])->name('dataanggota.edit1');
Route::put('/anggota/update/{id}', [AnggotaController::class, 'update1'])->name('dataanggota.update1');
Route::delete('/anggota/hapus/{id}', [AnggotaController::class, 'delete1'])->name('dataanggota.delete1');
Route::get('/anggota/detail/{id}', [AnggotaController::class, 'show'])->name('dataanggota.show1');
Route::post('/anggota/import', [AnggotaController::class, 'importExcel'])->name('anggota.import');



// Buku
Route::get('/buku', [BukuController::class, 'tampil5'])->name('buku.tampil5');
    Route::get('/buku/tambah', [BukuController::class, 'tambah5'])->name('buku.tambah5');
    Route::post('/buku/tambah', [BukuController::class, 'submit4'])->name('buku.submit4');
    Route::get('/buku/edit/{id}', [BukuController::class, 'edit4'])->name('buku.edit4');
    Route::put('/buku/update/{id}', [BukuController::class, 'update4'])->name('buku.update4');
    Route::delete('/buku/hapus/{id}', [BukuController::class, 'delete4'])->name('buku.delete4');
    Route::post('/buku/import', [BukuController::class, 'import'])->name('buku.import');

    // Jenis
    Route::get('/jenis', [JenisController::class, 'tampil3'])->name('jenis.tampil3');
    Route::get('/jenis/tambah', [JenisController::class, 'tambah2'])->name('jenis.tambah2');
    Route::post('/jenis/tambah', [JenisController::class, 'submit2'])->name('jenis.submit2');
    Route::get('/jenis/edit/{id}', [JenisController::class, 'edit2'])->name('jenis.edit2');
    Route::put('/jenis/update/{id}', [JenisController::class, 'update2'])->name('jenis.update2');
    Route::delete('/jenis/hapus/{id}', [JenisController::class, 'delete2'])->name('jenis.delete2');

    // Kategori
    Route::get('/kategori', [KategoriController::class, 'tampil4'])->name('kategori.tampil4');
    Route::get('/kategori/tambah', [KategoriController::class, 'tambah3'])->name('kategori.tambah3');
    Route::post('/kategori/tambah', [KategoriController::class, 'submit3'])->name('kategori.submit3');
    Route::get('/kategori/edit/{id}', [KategoriController::class, 'edit3'])->name('kategori.edit3');
    Route::post('/kategori/update/{id}', [KategoriController::class, 'update3'])->name('kategori.update3');
    Route::delete('/kategori/hapus/{id}', [KategoriController::class, 'delete3'])->name('kategori.delete3');

    // Penerbit
    Route::get('/penerbit', [PenerbitController::class, 'tampil6'])->name('penerbit.tampil6');
    Route::get('/penerbit/tambah', [PenerbitController::class, 'tambah6'])->name('penerbit.tambah6');
    Route::post('/penerbit/tambah', [PenerbitController::class, 'submit5'])->name('penerbit.submit5');
    Route::get('/penerbit/edit/{id}', [PenerbitController::class, 'edit5'])->name('penerbit.edit5');
    Route::put('/penerbit/update/{id}', [PenerbitController::class, 'update5'])->name('penerbit.update5');
    Route::delete('/penerbit/hapus/{id}', [PenerbitController::class, 'delete5'])->name('penerbit.delete5');

    // Peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'tampil9'])->name('peminjaman.tampil9');
    Route::get('/peminjaman/tambah', [PeminjamanController::class, 'tambah9'])->name('peminjaman.tambah9');
    Route::post('/peminjaman/tambah', [PeminjamanController::class, 'submit8'])->name('peminjaman.submit8');
    Route::get('/peminjaman/edit/{id}', [PeminjamanController::class, 'edit8'])->name('peminjaman.edit8');
    Route::put('/peminjaman/update/{id}', [PeminjamanController::class, 'update8'])->name('peminjaman.update8');
    Route::delete('/peminjaman/hapus/{id}', [PeminjamanController::class, 'delete8'])->name('peminjaman.delete8');
    Route::get('/peminjaman/riwayat', [PeminjamanController::class, 'riwayat'])->name('peminjaman.riwayat');
    Route::get('/riwayat/export', [PeminjamanController::class, 'export'])->name('riwayat.export');

    // Pengembalian
    Route::get('/pengembalian', [PengembalianController::class, 'tampil8'])->name('pengembalian.tampil8');
    Route::get('/pengembalian/tambah', [PengembalianController::class, 'tambah8'])->name('pengembalian.tambah8');
    Route::post('/pengembalian/tambah', [PengembalianController::class, 'submit7'])->name('pengembalian.submit7');
    Route::get('/pengembalian/edit/{id}', [PengembalianController::class, 'edit7'])->name('pengembalian.edit7');
    Route::put('/pengembalian/update/{id}', [PengembalianController::class, 'update7'])->name('pengembalian.update7');
    Route::delete('/pengembalian/hapus/{id}', [PengembalianController::class, 'delete7'])->name('pengembalian.delete7');

    // Pengunjung
    Route::get('/pengunjung', [PengunjungController::class, 'tampil7'])->name('pengunjung.tampil7');
    Route::get('/pengunjung/export', [PengunjungController::class, 'exportPerBulan'])->name('pengunjung.export.bulan');
    Route::get('/pengunjung/edit/{id}', [PengunjungController::class, 'edit6'])->name('pengunjung.edit6');
    Route::put('/pengunjung/update/{id}', [PengunjungController::class, 'update6'])->name('pengunjung.update6');
    Route::delete('/pengunjung/hapus/{id}', [PengunjungController::class, 'delete6'])->name('pengunjung.delete6');
    Route::get('/pengunjung/success', [PengunjungController::class, 'success'])->name('pengunjung.success');

    //profile
    Route::get('/admin/profil', [AdminProfileController::class, 'index'])->name('admin.profil');
    Route::post('/admin/profil/reset-password', [AdminProfileController::class, 'resetPassword'])->name('admin.reset_password');
    Route::post('/admin/profil/update-email', [AdminProfileController::class, 'updateEmail'])->name('admin.update_email');
 });


// Halaman Yang Tidka Perlu Login

// Pendaftaran anggota
Route::post('/daftar-anggota', [AnggotaController::class, 'daftarSubmit'])->name('anggota.daftar.submit');
Route::view('/daftar-sukses', 'dataanggota.berhasil')->name('anggota.berhasil');

// Scan QR Code
// Pengunjung
Route::get('/pengunjung/tambah', [PengunjungController::class, 'tambah7'])->name('pengunjung.tambah7');
Route::post('/pengunjung/tambah', [PengunjungController::class, 'submit6'])->name('pengunjung.submit6');
Route::get('/pengunjung/qr', [PengunjungController::class, 'qrCode'])->name('pengunjung.qr');
//Buku
Route::get('/buku/qr/{id}', [BukuController::class, 'printqr'])->name('buku.qr');
Route::get('/buku/detail/{id}', [BukuController::class, 'showDetail'])->name('buku.detail');




Route::prefix('user_dashboard')->middleware(['auth', 'anggota'])->group(function () {
    // Dashboard user
    Route::get('/', [UserController::class, 'index'])->name('user_dashboard.index');

    // Formulir pendaftaran anggota (POST dari tab daftar)
    Route::post('/daftar-anggota', [AnggotaController::class, 'simpanUser'])->name('anggota.daftar.submit');

        // Halaman peminjaman dan pengembalian
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');

        // Tambah peminjaman user
    Route::post('/peminjaman/simpan', [PeminjamanController::class, 'simpanUser'])->name('user.peminjaman.simpan');
    Route::post('/profil/reset-password', [ProfileController::class, 'resetPassword'])->name('profile.resetPassword');
    
});






require __DIR__ . '/auth.php';
