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
use App\Models\Timeline;
use Carbon\Carbon;
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

// Route::get('/', function () {
//     return view('home.main');
// });
// Route::get('/login', function () {
//     return view('auth.login');
// });

Route::get('/', function () {
    // $cek = timeLine::first();
    // $pembukaan = Carbon::parse($cek->waktu_mulai)->format('Y-m-d');
    // $penutupan = Carbon::parse($cek->waktu_berakhir)->format('Y-m-d');
    // $status = $cek->status;

    $currentDate = Carbon::now()->format('Y-m-d');
    $gelombang1 = Timeline::find(1);
    $pembukaan1 = $gelombang1->waktu_mulai;
    $penutupan1 = $gelombang1->waktu_berakhir;
    $status1 = $gelombang1->status;
    $gelombang2 = timeLine::find(2);
    $pembukaan2 = $gelombang2->waktu_mulai;
    $penutupan2 = $gelombang2->waktu_berakhir;
    $status2 = $gelombang2->status;

    return view('home.main', compact('pembukaan1','pembukaan2','penutupan1','penutupan2','status1','status2','currentDate','gelombang1', 'gelombang2'));
})->name('home');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/postlogin', [LoginController::class, 'postlogin'])->name('postlogin');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// *** SWITCH ROLE ***//
Route::middleware(['auth'])->group(function () {
    Route::get('/switch-role/{role}', SwitchRoleController::class)->name('switch.role');
});


// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('role:pengurus');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/divisi', [DivisiController::class, 'index'])->name('divisi')->middleware('role_or_permission:pengurus|anggota|manage_divisi');


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


//*** PENDAFTARAN *** //
Route::group(['middleware' => ['can:manage_pendaftar']], function () {
    Route::get('/pendaftaran', [AnggotaController::class, 'index'])->name('pendaftaran');
    Route::get('/pendaftaran/detail/{id}', [AnggotaController::class, 'detail'])->name('detail-pendaftaran');

    // UPDATE STATUS
    Route::post('/pendaftaran/diterima/{id}', [AnggotaController::class, 'updateterima'])->name('terima-pendaftaran');
    Route::post('/pendaftaran/ditolak/{id}', [AnggotaController::class, 'updatetolak'])->name('tolak-pendaftaran');
    // VIEW ANGGOTA
    Route::get('/pendaftaran/diterima', [AnggotaController::class, 'terima'])->name('detail-terima');
    Route::get('/pendaftaran/ditolak', [AnggotaController::class, 'tolak'])->name('detail-tolak');

    // memang di komen //
    // Route::get('/pendaftaran/edit/{id}', [PendaftaranController::class, 'edit'])->name('edit-pendaftaran');
    // Route::post('/pendaftaran/update/{id}', [PendaftaranController::class, 'update'])->name('update-pendaftaran');
});


// *** ALAT *** //
Route::group(['middleware'=> ['can:transaksi']], function () {
    Route::get('/alat', [AlatController::class, 'index'])->name('alat');
    Route::get('/alat/create', [AlatController::class, 'create'])->name('create-alat');
    Route::post('/alat/simpan', [AlatController::class, 'store'])->name('simpan-alat');
    Route::get('/alat/edit/{id}', [AlatController::class, 'edit'])->name('edit-alat');
    Route::post('/alat/update/{id}', [AlatController::class, 'update'])->name('update-alat');
    Route::delete('/alat/delete/{id}', [AlatController::class, 'destroy'])->name('delete-alat');

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


// *** PROFILE *** //
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::put('/profile', [ProfileController::class, 'update'])->name('update-profile');
Route::post('/profile/update', [ProfileController::class, 'updateGambar'])->name('gambar-profile');
Route::post('/profile/delete', [ProfileController::class, 'deleteGambar'])->name('delete-profile');


// *** MENDAFTAR *** //
// Route::get('/pendaftaran1/create', [HomeController::class, 'formDaftar1'])->name('create-pendaftaran1');
// Route::get('/pendaftaran2/create', [HomeController::class, 'formDaftar2'])->name('create-pendaftaran2');
// Route::post('/pendaftaran/simpan', [PendaftaranController::class, 'store'])->name('store-pendaftaran');
// Route::get('registered/akun/{token}', [PendaftaranController::class, 'view'])->name('form');
Route::post('/verifikasi/{token}', [LoginController::class, 'verifikasi'])->name('verifikasi');


// *** PRESENSI *** //
Route::get('/presensi', [PresensiController::class, 'index'])->name(    'view-presensi');
Route::post('presensi/store',[PresensiController::class, 'index'])->name('store-presensi');
Route::get('/data/presensi', [PresensiController::class, 'view'])->name('data-presensi');
Route::get('aktifasi/presensi',[PresensiController::class, 'activatePresensiView'])->name('aktif-presensi');
Route::post('/toggle-status', [PresensiController::class, 'toggleStatus'])->name('toggle-status');
Route::get('/get-status', [PresensiController::class, 'getStatus'])->name('get-status');




// *** TIMELINE *** //
Route::get('view/timeline',[TimeLineController::class, 'timeLine'])->name('view-timeLine');
Route::post('create/timeline1',[TimeLineController::class, 'activasiPendaftaran1'])->name('aktivasi-timeLine1');
Route::post('create/timeline2',[TimeLineController::class, 'activasiPendaftaran2'])->name('aktivasi-timeLine2');


Route::get('/divisi/{id}/anggota',[ DivisiController::class, 'viewAnggota'])->name('view-anggota');
