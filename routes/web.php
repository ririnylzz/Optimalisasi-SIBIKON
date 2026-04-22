<?php

use Illuminate\Support\Facades\Route;
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
    // Submenu Masyarakat Jasa Konstruksi
    Route::view('/pengguna-jasa', 'admin.placeholder', ['title' => 'Pengguna Jasa'])->name('pengguna-jasa');
    Route::view('/asosiasi-perusahaan', 'admin.placeholder', ['title' => 'Asosiasi Perusahaan'])->name('asosiasi-perusahaan');
    Route::view('/asosiasi-profesi', 'admin.placeholder', ['title' => 'Asosiasi Profesi'])->name('asosiasi-profesi');
    Route::view('/lsp', 'admin.placeholder', ['title' => 'LSP'])->name('lsp');
    Route::view('/perguruan-tinggi', 'admin.placeholder', ['title' => 'Perguruan Tinggi / Pakar'])->name('perguruan-tinggi');
    Route::view('/lppkk', 'admin.placeholder', ['title' => 'LPPKK'])->name('lppkk');
    Route::view('/pemerhati-konstruksi', 'admin.placeholder', ['title' => 'Pemerhati Konstruksi'])->name('pemerhati-konstruksi');
    Route::view('/pemanfaat-produk', 'admin.placeholder', ['title' => 'Pemanfaat Produk'])->name('pemanfaat-produk');
    Route::view('/rantai-pasok', 'admin.placeholder', ['title' => 'Rantai Pasok'])->name('rantai-pasok');
    Route::get('/bujk', function () {
        $bujkRows = [
            [
                'nib' => '0103220011328',
                'nama_bujk' => 'SAMAR TEKNIK CONSULT',
                'jenis_usaha' => 'Konsultan Konstruksi',
                'alamat' => 'Jl. K.H. Harun Nafsi, Gg. Karya Bersama, Blok B2',
                'npwp' => '63.301.706.6-741.000',
                'kontak' => '082354509917 / cv.samarteknikconsult@gmail.com',
            ],
            [
                'nib' => '9120010011394',
                'nama_bujk' => 'ALIF KARYA KONSULINDO',
                'jenis_usaha' => 'Konsultan Konstruksi',
                'alamat' => 'Jln. Pertamina Km 0 Gang Masjid No.18',
                'npwp' => '70.199.832.0-724.000',
                'kontak' => '08115830622 / alifkaryakonsulindo@gmail.com',
            ],
            [
                'nib' => '9120101981171',
                'nama_bujk' => 'ANINDYA CONSULTANT',
                'jenis_usaha' => 'Konsultan Konstruksi',
                'alamat' => 'Jl. Gemini No. 74',
                'npwp' => '76.015.781.8-722.000',
                'kontak' => '085280466662 / anindyaconsultant@yahoo.com',
            ],
            [
                'nib' => '0201000952418',
                'nama_bujk' => 'SINGA CONSULTANT',
                'jenis_usaha' => 'Konsultan Konstruksi',
                'alamat' => 'Jalan Jakarta 1 Perumahan Daksa Blok B2 No.12',
                'npwp' => '95.950.658.5-741.000',
                'kontak' => '082152395652 / singaconsultant@gmail.com',
            ],
        ];

        return view('admin.bujk.index', compact('bujkRows'));
    })->name('bujk');

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