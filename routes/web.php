<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\TimeLineController;
use App\Models\Anggota;
use App\Models\Timeline;
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

// route timeline
Route::group(['prefix' => 'admin'], function() {    
    Route::get('/timeline', [TimeLineController::class, 'index'])->name('view-timeLine');    
    Route::post('/timeline/update/{id}', [TimeLineController::class, 'update'])->name('timeline-update');
    Route::get('/pendaftaran', [AnggotaController::class, 'index_pendaftaran'])->name('admin-pendaftaran');    
    Route::get('/pendaftaran/detail/{id}', [AnggotaController::class, 'detail_pendaftaran'])->name('admin-pendaftaran-detail');
    Route::post('/pendaftaran/terima/{id}', [AnggotaController::class, 'approve_pendaftaran'])->name('pendaftaran-terima');
});

Route::get('/anggota/aktivasi/{token}/{email}', [AnggotaController::class, 'aktivasi'])->name('anggota-aktivasi');

Route::group(['prefix' => 'pengurus'], function() {
    Route::get('/pendaftaran', [AnggotaController::class, 'pendaftaran'])->name('view-pendaftaran');
    Route::post('/store-pendaftaran', [AnggotaController::class, 'create_pendaftaran'])->name('store-pendaftaran');
});