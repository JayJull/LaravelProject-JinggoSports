<?php

use App\Http\Controllers\AlatController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BuatAkunController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SwitchRoleController;
use App\Http\Controllers\TimeLineController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/',[TimeLineController::class, 'timeline'])->name('landing-page');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/postlogin', [LoginController::class, 'postlogin'])->name('postlogin');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// *** DASHBOARD ***//
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// *** SWITCH ROLE ***//
Route::middleware(['auth'])->group(function () {
    Route::get('/switch-role/{role}', SwitchRoleController::class)->name('switch.role');
});

// *** MENDAFTAR ***//
Route::get('/pendaftaran/form', [AnggotaController::class, 'pendaftaran'])->name('view-pendaftaran');
Route::post('/store-pendaftaran', [AnggotaController::class, 'create_pendaftaran'])->name('store-pendaftaran');

Route::get('/pendaftaran', [AnggotaController::class, 'pendaftaran'])->name('view-pendaftaran');
Route::post('/store-pendaftaran', [AnggotaController::class, 'create_pendaftaran'])->name('store-pendaftaran');


//*** PENDAFTARAN *** /
Route::group(['middleware' => ['can:manage_pendaftar']], function () {
    Route::get('/pendaftaran', [AnggotaController::class, 'index_pendaftaran'])->name('admin-pendaftaran');
    Route::get('/pendaftaran/diterima', [AnggotaController::class, 'index_pendaftaran_diterima'])->name('admin-pendaftaran-terima');
    Route::get('/pendaftaran/ditolak', [AnggotaController::class, 'index_pendaftaran_ditolak'])->name('admin-pendaftaran-tolak');
    Route::get('/pendaftaran/detail/{id}', [AnggotaController::class, 'detail_pendaftaran'])->name('admin-pendaftaran-detail');
    Route::post('/pendaftaran/terima/{id}', [AnggotaController::class, 'approve_pendaftaran'])->name('pendaftaran-terima');
    Route::post('/pendaftaran/tolak/{id}', [AnggotaController::class, 'decline_pendaftaran'])->name('tolak-pendaftaran');
});


// *** PASSWORD ***//
Route::get('/anggota/aktivasi/{token}/{email}', [AnggotaController::class, 'aktivasi'])->name('anggota-aktivasi');
Route::post('/set-password', [AnggotaController::class, 'setpass'])->name('set-pass');



// *** TIMELINE ***//
Route::group(['middleware' => ['can:manage_timeline']], function () {
    Route::get('/timeline', [TimeLineController::class, 'index'])->name('view-timeLine');
    Route::post('/timeline/update/{id}', [TimeLineController::class, 'update'])->name('timeline-update');
});



Route::get('/divisi', [DivisiController::class, 'index'])->name('divisi')->middleware('role_or_permission:pengurus|anggota|manage_divisi');
Route::get('/divisi/{id}/anggota',[ DivisiController::class, 'viewAnggota'])->name('view-anggota');

// *** DIVISI *** //
Route::group(['middleware' => ['can:manage_divisi']], function () {
    Route::get('/divisi/create', [DivisiController::class, 'create'])->name('create-divisi');
    Route::post('/divisi/simpan', [DivisiController::class, 'store'])->name('simpan-divisi');
    Route::get('/divisi/edit/{id}', [DivisiController::class, 'edit'])->name('edit-divisi');
    Route::post('/divisi/update/{id}', [DivisiController::class, 'update'])->name('update-divisi');
    Route::delete('/divisi/delete/{id}', [DivisiController::class, 'destroy'])->name('delete-divisi');
});


// *** JADWAL *** //
Route::group(['middleware' => ['can:manage_jadwal']], function () {
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal');
    Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('create-jadwal');
    Route::post('/jadwal/simpan', [JadwalController::class, 'store'])->name('simpan-jadwal');
    Route::get('/jadwal/edit/{id}', [JadwalController::class, 'edit'])->name('edit-jadwal');
    Route::post('/jadwal/update/{id}', [JadwalController::class, 'update'])->name('update-jadwal');
    Route::delete('/jadwal/delete/{id}', [JadwalController::class, 'destroy'])->name('delete-jadwal');
});


// *** ALAT *** //
Route::group(['middleware'=> ['can:manage_alat']], function () {
    Route::get('/alat', [AlatController::class, 'index'])->name('alat');
    Route::get('/alat/create', [AlatController::class, 'create'])->name('create-alat');
    Route::post('/alat/simpan', [AlatController::class, 'store'])->name('simpan-alat');
    Route::get('/alat/edit/{id}', [AlatController::class, 'edit'])->name('edit-alat');
    Route::post('/alat/update/{id}', [AlatController::class, 'update'])->name('update-alat');
    Route::delete('/alat/delete/{id}', [AlatController::class, 'destroy'])->name('delete-alat');
});


// *** PEMINJAMAN *** //
Route::group(['middleware'=> ['can:transaksi']], function () {
    Route::get('/pinjam', [PeminjamanController::class, 'index'])->name('peminjaman');
    Route::get('/pinjam/create', [PeminjamanController::class, 'create'])->name('create-pinjam');
    Route::post('/pinjam/simpan', [PeminjamanController::class, 'store'])->name('simpan-pinjam');

    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian');
    Route::get('/pengembalian/create/{id}', [PengembalianController::class, 'create'])->name('create-kembali');
    Route::post('/pengebalian/simpan', [PengembalianController::class, 'store'])->name('simpan-kembali');
    Route::delete('/pengembalian/delete/{id}', [PengembalianController::class, 'destroy'])->name('delete-pengembalian');
});


// *** BUAT AKUN *** //
Route::group(['middleware'=> ['can:manage_pengurus']], function () {
    Route::get('/pengurus', [BuatAkunController::class, 'index'])->name('pengurus');
    Route::get('/pengurus/create', [BuatAkunController::class, 'create'])->name('create-pengurus');
    Route::get('/pengurus/detail/{id}', [BuatAkunController::class, 'detail'])->name('detail-pengurus');
    Route::put('/pengurus/update/{id}', [BuatAkunController::class, 'update'])->name('update-pengurus');
    Route::get('/pengurus/delete/{id}', [BuatAkunController::class, 'destroy'])->name('delete-pengurus');
});


// *** PRESENSI *** //
Route::group(['middleware'=> ['can:presensi']], function () {
    Route::get('/presensi', [PresensiController::class, 'index'])->name('view-presensi');
    Route::post('presensi/store',[PresensiController::class, 'inputPresensi'])->name('store-presensi');
    Route::post('/scan-result', [PresensiController::class, 'Scanner'])->name('scan-result');
    Route::get('/scan-qr', function () {
        return view('content.presensi.scan'); // Halaman untuk memindai QR atau Barcode
    })->name('scan-qr');
});
Route::group(['middleware'=> ['can:manage_presensi']], function () {
    Route::get('/data/presensi', [PresensiController::class, 'view'])->name('data-presensi');
    Route::get('aktifasi/presensi',[PresensiController::class, 'activatePresensiView'])->name('aktif-presensi');
    Route::post('/updateStatus', [PresensiController::class, 'toggleStatus'])->name('update-status');
    Route::post('/activate/{id}', [PresensiController::class, 'activate'])->name('aktivasi');
    Route::get('/cetak/presensi', [PresensiController::class, 'cetak_presensi'])->name('cetak-presensi');
});


// *** PROFILE *** //
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::put('/profile', [ProfileController::class, 'update'])->name('update-profile');
Route::post('/profile/update', [ProfileController::class, 'updateGambar'])->name('gambar-profile');
Route::post('/profile/delete', [ProfileController::class, 'deleteGambar'])->name('delete-profile');

