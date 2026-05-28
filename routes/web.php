<?php

use App\Http\Controllers\Admin\BujkController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PelatihanTkkController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\GisController;
use App\Http\Controllers\Layanan\AsosiasiPerusahaanController;
use App\Http\Controllers\Layanan\AsosiasiProfesiController;
use App\Http\Controllers\Layanan\PenyediaJasaController;
use App\Http\Controllers\PublicDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', [
        'page' => 'beranda',
    ]);
})->name('beranda');

Route::get('/gis-data/{category}', [GisController::class, 'data'])
    ->name('gis.data');

Route::get('/profil/tentang-kami', function () {
    return view('welcome', [
        'page' => 'tentang-kami',
    ]);
})->name('tentang-kami');

Route::get('/profil/struktur', function () {
    return view('welcome', [
        'page' => 'struktur',
    ]);
})->name('struktur');

Route::get('/profil/sop-renja', function () {
    return view('welcome', [
        'page' => 'sop-renja',
    ]);
})->name('sop-renja');

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/registrasi', function () {
    return view('welcome', [
        'page' => 'regist',
    ]);
})->name('register');

Route::post('/registrasi', [RegisterController::class, 'store'])
    ->name('register.store');

Route::get('/kontak', function () {
    return view('welcome', [
        'page' => 'kontak',
    ]);
})->name('kontak');

Route::get('/berita', function () {
    return view('welcome', [
        'page' => 'berita',
    ]);
})->name('berita');

Route::get('/detail-berita', function () {
    return view('welcome', [
        'page' => 'detail-berita',
    ]);
})->name('detail-berita');

Route::get('/fungsi/pengaturan/rakor', function () {
    return view('welcome', [
        'page' => 'rakor',
    ]);
})->name('rakor');

Route::get('/fungsi/pengaturan/sosialisasi', function () {
    return view('welcome', [
        'page' => 'sosialisasi',
    ]);
})->name('sosialisasi');

Route::get('/fungsi/pengaturan/forum', function () {
    return view('welcome', [
        'page' => 'forum',
    ]);
})->name('forum');

Route::get('/fungsi/pengaturan/rantai-pasok', function () {
    return view('welcome', [
        'page' => 'rantai-pasok',
    ]);
})->name('rantai-pasok');

Route::get('/fungsi/pengaturan/daftar-sosil', function () {
    return view('welcome', [
        'page' => 'daftar-sosil',
    ]);
})->name('daftar-sosil');

Route::get('/fungsi/pemberdayaan/tabel-tkk', function () {
    return view('welcome', [
        'page' => 'tabel-tkk',
    ]);
})->name('tabel-tkk');

Route::get('/fungsi/pemberdayaan/pelatihan-ahli', function () {
    return view('welcome', [
        'page' => 'pelatihan-ahli',
    ]);
})->name('pelatihan-ahli');

Route::get('/fungsi/pengawasan/tertib-usaha', function () {
    return view('welcome', [
        'page' => 'tertib-usaha',
    ]);
})->name('tertib-usaha');

Route::get('/fungsi/pengawasan/tertib-penyelenggaraan', function () {
    return view('welcome', [
        'page' => 'tertib-penyelenggaraan',
    ]);
})->name('tertib-penyelenggaraan');

Route::get('/fungsi/pengawasan/tertib-pemanfaatan', function () {
    return view('welcome', [
        'page' => 'tertib-pemanfaatan',
    ]);
})->name('tertib-pemanfaatan');

Route::get('/layanan/asosiasi-perusahaan', [AsosiasiPerusahaanController::class, 'index'])
    ->name('asosiasi-perusahaan');

Route::get('/layanan/asosiasi-profesi', [AsosiasiProfesiController::class, 'index'])
    ->name('asosiasi-profesi');

Route::get('/layanan/penyedia-jasa/data', [PenyediaJasaController::class, 'data'])
    ->name('penyedia-jasa.data');

Route::get('/layanan/penyedia-jasa', [PenyediaJasaController::class, 'index'])
    ->name('penyedia-jasa');

Route::get('/dashboard/tenaga-kerja-konstruksi', [PublicDashboardController::class, 'tenagaKerja'])
    ->name('dashboard.tenaga-kerja');

Route::get('/dashboard/bujk', [PublicDashboardController::class, 'bujk'])
    ->name('dashboard.bujk.publik');

Route::get('/dashboard/sbu', [PublicDashboardController::class, 'sbu'])
    ->name('dashboard.sbu.publik');

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::view('/pengaturan', 'admin.placeholder', [
            'title' => 'Pengaturan Akun',
        ])->name('pengaturan');

        Route::view('/pengguna', 'admin.placeholder', [
            'title' => 'Pengguna',
        ])->name('pengguna');

        Route::view('/jabatan-kerja', 'admin.placeholder', [
            'title' => 'Jabatan Kerja',
        ])->name('jabatan-kerja');

        Route::view('/prodi-pendidikan', 'admin.placeholder', [
            'title' => 'Prodi Pendidikan',
        ])->name('prodi-pendidikan');

        Route::view('/pegawai', 'admin.placeholder', [
            'title' => 'Pegawai',
        ])->name('pegawai');

        Route::view('/pengguna-jasa', 'admin.placeholder', [
            'title' => 'Pengguna Jasa',
        ])->name('pengguna-jasa');

        Route::view('/asosiasi-perusahaan', 'admin.placeholder', [
            'title' => 'Asosiasi Perusahaan',
        ])->name('asosiasi-perusahaan');

        Route::view('/asosiasi-profesi', 'admin.placeholder', [
            'title' => 'Asosiasi Profesi',
        ])->name('asosiasi-profesi');

        Route::view('/lsp', 'admin.placeholder', [
            'title' => 'LSP',
        ])->name('lsp');

        Route::view('/perguruan-tinggi', 'admin.placeholder', [
            'title' => 'Perguruan Tinggi / Pakar',
        ])->name('perguruan-tinggi');

        Route::view('/lppkk', 'admin.placeholder', [
            'title' => 'LPPKK',
        ])->name('lppkk');

        Route::view('/pemerhati-konstruksi', 'admin.placeholder', [
            'title' => 'Pemerhati Konstruksi',
        ])->name('pemerhati-konstruksi');

        Route::view('/pemanfaat-produk', 'admin.placeholder', [
            'title' => 'Pemanfaat Produk',
        ])->name('pemanfaat-produk');

        Route::view('/rantai-pasok', 'admin.placeholder', [
            'title' => 'Rantai Pasok',
        ])->name('rantai-pasok');

        Route::get('/bujk', [BujkController::class, 'index'])
            ->name('bujk');

        Route::post('/bujk', [BujkController::class, 'store'])
            ->name('bujk.store');

        Route::post('/bujk/import', [BujkController::class, 'import'])
            ->name('bujk.import');

        Route::delete('/bujk/bulk-destroy', [BujkController::class, 'bulkDestroy'])
            ->name('bujk.bulk-destroy');

        Route::delete('/bujk/destroy-all', [BujkController::class, 'destroyAll'])
            ->name('bujk.destroy-all');

        Route::get('/bujk/regions/provinces', [BujkController::class, 'provinceOptions'])
            ->name('bujk.regions.provinces');

        Route::get('/bujk/regions/regencies', [BujkController::class, 'regencyOptions'])
            ->name('bujk.regions.regencies');
        Route::get('/bujk/regions/provinces', [BujkController::class, 'provinceOptions'])
            ->name('bujk.regions.provinces');

        Route::get('/bujk/regions/regencies', [BujkController::class, 'regencyOptions'])
            ->name('bujk.regions.regencies');

        Route::put('/bujk/{bujk}', [BujkController::class, 'update'])
            ->whereNumber('bujk')
            ->name('bujk.update');

        Route::delete('/bujk/{bujk}', [BujkController::class, 'destroy'])
            ->whereNumber('bujk')
            ->name('bujk.destroy');

        Route::view('/paket-konstruksi', 'admin.placeholder', [
            'title' => 'Paket Konstruksi',
        ])->name('paket-konstruksi');

        Route::view('/kotak-saran', 'admin.placeholder', [
            'title' => 'Kotak Saran',
        ])->name('kotak-saran');

        Route::view('/file-upload', 'admin.placeholder', [
            'title' => 'File Upload',
        ])->name('file-upload');

        Route::view('/buku-tamu', 'admin.placeholder', [
            'title' => 'Buku Tamu',
        ])->name('buku-tamu');

        Route::view('/kategori', 'admin.placeholder', [
            'title' => 'Kategori',
        ])->name('kategori');

        Route::view('/berita', 'admin.placeholder', [
            'title' => 'Berita',
        ])->name('berita');

        Route::view('/acara-kegiatan', 'admin.placeholder', [
            'title' => 'Acara / Kegiatan',
        ])->name('acara-kegiatan');

        Route::view('/peraturan', 'admin.placeholder', [
            'title' => 'Peraturan',
        ])->name('peraturan');

        Route::get('/tenaga-kerja-konstruksi', [DashboardController::class, 'tkk'])
            ->name('tenaga-kerja-konstruksi');

        Route::get('/tenaga-kerja-konstruksi/search', [DashboardController::class, 'searchTkk'])
            ->name('tenaga-kerja-konstruksi.search');

        Route::get('/pelatihan-sertifikasi', [PelatihanTkkController::class, 'index'])
            ->name('pelatihan-sertifikasi.index');

        Route::post('/pelatihan-sertifikasi', [PelatihanTkkController::class, 'store'])
            ->name('pelatihan-sertifikasi.store');

        Route::get('/pelatihan-sertifikasi/{pelatihan}', [PelatihanTkkController::class, 'show'])
            ->whereNumber('pelatihan')
            ->name('pelatihan-sertifikasi.show');

        Route::put('/pelatihan-sertifikasi/{pelatihan}', [PelatihanTkkController::class, 'update'])
            ->whereNumber('pelatihan')
            ->name('pelatihan-sertifikasi.update');

        Route::delete('/pelatihan-sertifikasi/{pelatihan}', [PelatihanTkkController::class, 'destroy'])
            ->whereNumber('pelatihan')
            ->name('pelatihan-sertifikasi.destroy');

        Route::post('/pelatihan-sertifikasi/{pelatihan}/peserta', [PelatihanTkkController::class, 'storePeserta'])
            ->whereNumber('pelatihan')
            ->name('pelatihan-sertifikasi.peserta.store');

        Route::put('/pelatihan-sertifikasi/{pelatihan}/peserta/{peserta}', [PelatihanTkkController::class, 'updatePeserta'])
            ->whereNumber('pelatihan')
            ->whereNumber('peserta')
            ->name('pelatihan-sertifikasi.peserta.update');

        Route::delete('/pelatihan-sertifikasi/{pelatihan}/peserta/bulk-destroy', [PelatihanTkkController::class, 'bulkDestroyPeserta'])
            ->whereNumber('pelatihan')
            ->name('pelatihan-sertifikasi.peserta.bulk-destroy');

        Route::delete('/pelatihan-sertifikasi/{pelatihan}/peserta/destroy-all', [PelatihanTkkController::class, 'destroyAllPeserta'])
            ->whereNumber('pelatihan')
            ->name('pelatihan-sertifikasi.peserta.destroy-all');

        Route::delete('/pelatihan-sertifikasi/{pelatihan}/peserta/{peserta}', [PelatihanTkkController::class, 'destroyPeserta'])
            ->whereNumber('pelatihan')
            ->whereNumber('peserta')
            ->name('pelatihan-sertifikasi.peserta.destroy');

        Route::view('/tertib-usaha', 'admin.placeholder', [
            'title' => 'Tertib Usaha',
        ])->name('tertib-usaha');

        Route::view('/tertib-penyelenggaraan', 'admin.placeholder', [
            'title' => 'Tertib Penyelenggaraan',
        ])->name('tertib-penyelenggaraan');

        Route::view('/tertib-pemanfaatan', 'admin.placeholder', [
            'title' => 'Tertib Pemanfaatan',
        ])->name('tertib-pemanfaatan');

        Route::view('/surat-menyurat', 'admin.placeholder', [
            'title' => 'Surat Menyurat',
        ])->name('surat-menyurat');

        Route::view('/arsip', 'admin.placeholder', [
            'title' => 'Arsip',
        ])->name('arsip');

        Route::view('/penandatangan-dokumen', 'admin.placeholder', [
            'title' => 'Penandatangan Dokumen',
        ])->name('penandatangan-dokumen');

        Route::view('/anggaran-perjadin', 'admin.placeholder', [
            'title' => 'Anggaran Perjadin',
        ])->name('anggaran-perjadin');

        Route::view('/perjadin', 'admin.placeholder', [
            'title' => 'Perjadin',
        ])->name('perjadin');
    });