<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\VisiController;
use App\Http\Controllers\SejarahController;
use App\Http\Controllers\StrukturController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\AntrianController;
use App\Http\Controllers\MasukController;
use App\Http\Controllers\DaftarController;
use App\Http\Controllers\DaftarAntrianController;
use App\Http\Controllers\LihatAntrianController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SimulasiController;
use App\Http\Controllers\MachineLearningController;
use App\Http\Controllers\PredicitionController;

Route::get('/', function () {
    return view('home');
})->name('home');

// View
Route::get('/layanan', [LayananController::class, 'index'])->name('layanan');
Route::get('/visi', [VisiController::class, 'index'])->name('visi');
Route::get('/sejarah', [SejarahController::class, 'index'])->name('sejarah');
Route::get('/struktur', [StrukturController::class, 'index'])->name('struktur');
Route::get('/dokter', [DokterController::class, 'index'])->name('dokter');
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');
Route::get('/antrian', [AntrianController::class, 'index'])->name('antrian');

//Ajuan
Route::post('/contact', [KontakController::class, 'store'])->name('contact.store');

// Lihat Antrian
Route::middleware('auth')->get('/lihat-antrian', [LihatAntrianController::class, 'index'])->name('lihat-antrian');
Route::get('/get-all-antrian', [LihatAntrianController::class, 'getAllAntrian'])->name('get-all-antrian');
Route::get('/get-wait-list', [LihatAntrianController::class, 'getWaitList'])->name('get-wait-list');

//Profile
Route::get('/profile', [ProfileController::class, 'show'])->middleware('auth:web')->name('profile.show');
Route::get('/editprofile', [ProfileController::class, 'edit'])->name('editprofile');
Route::put('/updateprofile', [ProfileController::class, 'update'])->name('updateprofile');

// Login Pengunjung
Route::get('/masuk', [MasukController::class, 'tampilkanFormMasuk'])->name('login');
Route::post('/masuk', [MasukController::class, 'prosesMasuk'])->name('login.post');
Route::get('/daftar', [DaftarController::class, 'tampilkanFormDaftar'])->name('daftar');
Route::post('/daftar', [DaftarController::class, 'prosesPendaftaran'])->name('daftar.post');
Route::post('/logout', [MasukController::class, 'logout'])->name('logout');

// Daftar Antrian
Route::middleware('auth')->get('/daftar-antrian', [DaftarAntrianController::class, 'tampilkanFormDaftar'])->name('daftarantrian');
Route::post('/proses-daftar', [DaftarAntrianController::class, 'prosesDaftar'])->name('proses.daftar');

// Login Admin
Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.post');

// Simulasi Nomor Antrian dan Prediksi
Route::get('/generate-nomor-antrian', [SimulasiController::class, 'generateNomorAntrian'])->name('generate-nomor-antrian');
Route::get('/tampilkan-antrian', [SimulasiController::class, 'tampilkanDataAntrian'])->name('tampilkan-antrian');
Route::get('/update-waktu-antrian', [SimulasiController::class, 'updateWaktuAntrian'])->name('update-waktu-antrian');
Route::get('/ekspor-data-antrian', [SimulasiController::class, 'eksporDataAntrianKeCsv'])->name('ekspor-data-antrian');
Route::get('/tampilkan-latihan', [SimulasiController::class, 'showTrainForm']);
Route::post('/train-model', [DaftarAntrianController::class, 'trainModel']);
Route::post('/predict', [DaftarAntrianController::class, 'predict']);

// Sistem Antrian
Route::middleware('auth:admin')->group(function () {
    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    Route::get('/secure/daftar-pengguna', [AdminAuthController::class, 'daftarPengguna'])->name('admin.daftar-pengguna');
    Route::get('/secure/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/secure/pengaturan-antrian', [AdminAuthController::class, 'index'])->name('pengaturan-antrian.index');
    Route::put('/secure/pengaturan-antrian/update', [AdminAuthController::class, 'update'])->name('pengaturan-antrian.update');
    Route::post('/secure/pindah-antrian', [AdminAuthController::class, 'pindahkanNomorAntrian'])->name('admin.pindahkanNomorAntrian');
    Route::post('/secure/pindahkan-ke-daftar-tunggu', [AdminAuthController::class, 'pindahkanKeDaftarTunggu'])->name('admin.pindahkanKeDaftarTunggu');
    Route::post('/secure/panggil-kembali', [AdminAuthController::class, 'panggilKembali'])->name('admin.panggilKembali');
    Route::post('/antrian/berikan-prioritas', [AdminAuthController::class, 'berikanPrioritas'])->name('antrian.berikanPrioritas');
    Route::get('/secure/prioritas', [AdminAuthController::class, 'showPrioritasPage'])->name('antrian.showPrioritasPage');
    Route::post('/secure/update-status-pembayaran', [AdminAuthController::class, 'updateStatusPembayaran'])->name('admin.updateStatusPembayaran');
    Route::get('/secure/detail-pengguna/{id}', [AdminAuthController:: class, 'showUserDetail'])->name('admin.user-detail');
    Route::get('/secure/riwayat-antrian', [AdminAuthController::class, 'indexRiwayatAntrian'])->name('admin.riwayat-antrian');
    Route::get('/secure/kontak-index', [AdminAuthController::class, 'showKontakPage'])->name('admin.contacts.index');
    Route::post('/secure/pindah-ke-riwayat', [AdminAuthController::class, 'pindahKeRiwayat'])->name('pindah.ke.riwayat');
    // Poli Umum
    Route::get('/secure/poli-umum', [AdminAuthController::class, 'showPoliUmumPage'])->name('admin.poli-umum');
    Route::post('/secure/poli-umum/start-queue', [AdminAuthController::class, 'startQueuePoliUmum'])->name('admin.startQueuePoliUmum');
    Route::post('/secure/poli-umum/selesai-antrian', [AdminAuthController::class, 'selesaikanAntrianPoliUmum'])->name('admin.selesaikanAntrianPoliUmum');
    // Poli Gigi
    Route::get('/secure/poli-gigi', [AdminAuthController::class, 'showGigiUmumPage'])->name('admin.poli-gigi');
    Route::post('/secure/poli-gigi/start-queue', [AdminAuthController::class, 'startQueuePoliGigi'])->name('admin.startQueuePoliGigi');
    Route::post('/secure/poli-gigi/selesai-antrian', [AdminAuthController::class, 'selesaikanAntrianPoliGigi'])->name('admin.selesaikanAntrianPoliGigi');
    // Poli Kia
    Route::get('/secure/poli-kia', [AdminAuthController::class, 'showKiaUmumPage'])->name('admin.poli-kia');
    Route::post('/secure/poli-kia/start-queue', [AdminAuthController::class, 'startQueuePoliKia'])->name('admin.startQueuePoliKia');
    Route::post('/secure/poli-kia/selesai-antrian', [AdminAuthController::class, 'selesaikanAntrianPoliKia'])->name('admin.selesaikanAntrianPoliKia');
    // Poli Anak
    Route::get('/secure/poli-anak', [AdminAuthController::class, 'showAnakUmumPage'])->name('admin.poli-anak');
    Route::post('/secure/poli-anak/start-queue', [AdminAuthController::class, 'startQueuePoliAnak'])->name('admin.startQueuePoliAnak');
    Route::post('/secure/poli-anak/selesai-antrian', [AdminAuthController::class, 'selesaikanAntrianPoliAnak'])->name('admin.selesaikanAntrianPoliAnak');
    // Laboraturium
    Route::get('/secure/lab', [AdminAuthController::class, 'showLabUmumPage'])->name('admin.lab');
    Route::post('/secure/lab/start-queue', [AdminAuthController::class, 'startQueueLab'])->name('admin.startQueueLab');
    Route::post('/secure/lab/selesai-antrian', [AdminAuthController::class, 'selesaikanAntrianLab'])->name('admin.selesaikanAntrianLab');
    // Apotik
    Route::get('/secure/apotik', [AdminAuthController::class, 'showApotikUmumPage'])->name('admin.apotik');
    Route::post('/secure/apotik/start-queue', [AdminAuthController::class, 'startQueueApotik'])->name('admin.startQueueApotik');
    Route::post('/secure/apotik/selesai-antrian', [AdminAuthController::class, 'selesaikanAntrianApotik'])->name('admin.selesaikanAntrianApotik');
});
