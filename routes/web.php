<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BujkController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::view('/pengguna', 'admin.placeholder', ['title' => 'Pengguna'])->name('pengguna');
    Route::view('/jabatan-kerja', 'admin.placeholder', ['title' => 'Jabatan Kerja'])->name('jabatan-kerja');
    Route::view('/prodi-pendidikan', 'admin.placeholder', ['title' => 'Prodi Pendidikan'])->name('prodi-pendidikan');
    Route::view('/pegawai', 'admin.placeholder', ['title' => 'Pegawai'])->name('pegawai');
    Route::view('/masyarakat-jasa-konstruksi', 'admin.placeholder', ['title' => 'Masyarakat Jasa Konstruksi'])->name('masyarakat-jasa-konstruksi');

    Route::view('/pengguna-jasa', 'admin.placeholder', ['title' => 'Pengguna Jasa'])->name('pengguna-jasa');
    Route::view('/asosiasi-perusahaan', 'admin.placeholder', ['title' => 'Asosiasi Perusahaan'])->name('asosiasi-perusahaan');
    Route::view('/asosiasi-profesi', 'admin.placeholder', ['title' => 'Asosiasi Profesi'])->name('asosiasi-profesi');
    Route::view('/lsp', 'admin.placeholder', ['title' => 'LSP'])->name('lsp');
    Route::view('/perguruan-tinggi', 'admin.placeholder', ['title' => 'Perguruan Tinggi / Pakar'])->name('perguruan-tinggi');
    Route::view('/lppkk', 'admin.placeholder', ['title' => 'LPPKK'])->name('lppkk');
    Route::view('/pemerhati-konstruksi', 'admin.placeholder', ['title' => 'Pemerhati Konstruksi'])->name('pemerhati-konstruksi');
    Route::view('/pemanfaat-produk', 'admin.placeholder', ['title' => 'Pemanfaat Produk'])->name('pemanfaat-produk');
    Route::view('/rantai-pasok', 'admin.placeholder', ['title' => 'Rantai Pasok'])->name('rantai-pasok');

    Route::get('/bujk', [BujkController::class, 'index'])->name('bujk');
    Route::post('/bujk', [BujkController::class, 'store'])->name('bujk.store');
    Route::put('/bujk/{bujk}', [BujkController::class, 'update'])->name('bujk.update');
    Route::delete('/bujk/{bujk}', [BujkController::class, 'destroy'])->name('bujk.destroy');
    Route::post('/bujk/import', [BujkController::class, 'import'])->name('bujk.import');

    Route::view('/paket-konstruksi', 'admin.placeholder', ['title' => 'Paket Konstruksi'])->name('paket-konstruksi');
    Route::view('/kotak-saran', 'admin.placeholder', ['title' => 'Kotak Saran'])->name('kotak-saran');
    Route::view('/file-upload', 'admin.placeholder', ['title' => 'File Upload'])->name('file-upload');
    Route::view('/buku-tamu', 'admin.placeholder', ['title' => 'Buku Tamu'])->name('buku-tamu');

    Route::view('/kategori', 'admin.placeholder', ['title' => 'Kategori'])->name('kategori');
    Route::view('/berita', 'admin.placeholder', ['title' => 'Berita'])->name('berita');

    Route::view('/acara-kegiatan', 'admin.placeholder', ['title' => 'Acara / Kegiatan'])->name('acara-kegiatan');
    Route::view('/peraturan', 'admin.placeholder', ['title' => 'Peraturan'])->name('peraturan');

    Route::view('/tenaga-kerja-konstruksi', 'admin.placeholder', ['title' => 'Tenaga Kerja Konstruksi'])->name('tenaga-kerja-konstruksi');
    Route::view('/pelatihan-sertifikasi', 'admin.placeholder', ['title' => 'Pelatihan / Sertifikasi'])->name('pelatihan-sertifikasi');

    Route::view('/tertib-usaha', 'admin.placeholder', ['title' => 'Tertib Usaha'])->name('tertib-usaha');
    Route::view('/tertib-penyelenggaraan', 'admin.placeholder', ['title' => 'Tertib Penyelenggaraan'])->name('tertib-penyelenggaraan');
    Route::view('/tertib-pemanfaatan', 'admin.placeholder', ['title' => 'Tertib Pemanfaatan'])->name('tertib-pemanfaatan');

    Route::view('/surat-menyurat', 'admin.placeholder', ['title' => 'Surat Menyurat'])->name('surat-menyurat');
    Route::view('/arsip', 'admin.placeholder', ['title' => 'Arsip'])->name('arsip');

    Route::view('/penandatangan-dokumen', 'admin.placeholder', ['title' => 'Penandatangan Dokumen'])->name('penandatangan-dokumen');
    Route::view('/anggaran-perjadin', 'admin.placeholder', ['title' => 'Anggaran Perjadin'])->name('anggaran-perjadin');
    Route::view('/perjadin', 'admin.placeholder', ['title' => 'Perjadin'])->name('perjadin');
});