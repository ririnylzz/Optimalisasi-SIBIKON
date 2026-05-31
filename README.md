
```
Optimalisasi-SIBIKON
├─ 'datetime'
├─ 'hashed'
├─ .editorconfig
├─ .npmrc
├─ app
│  ├─ Console
│  │  └─ Commands
│  │     ├─ ImportBujkSbuExcel.php
│  │     └─ ImportTkk.php
│  ├─ Http
│  │  ├─ Controllers
│  │  │  ├─ Admin
│  │  │  │  ├─ BujkController.php
│  │  │  │  ├─ DashboardController.php
│  │  │  │  └─ PelatihanTkkController.php
│  │  │  ├─ Auth
│  │  │  │  ├─ AuthController.php
│  │  │  │  └─ RegisterController.php
│  │  │  ├─ Controller.php
│  │  │  ├─ GisController.php
│  │  │  ├─ KegiatanController.php
│  │  │  ├─ Layanan
│  │  │  │  ├─ AsosiasiPerusahaanController.php
│  │  │  │  ├─ AsosiasiProfesiController.php
│  │  │  │  └─ PenyediaJasaController.php
│  │  │  └─ PublicDashboardController.php
│  │  └─ Requests
│  │     └─ Admin
│  │        └─ Bujk
│  │           ├─ BujkFormRequest.php
│  │           └─ BujkImportRequest.php
│  ├─ Models
│  │  ├─ Bujk.php
│  │  ├─ PelatihanTkk.php
│  │  ├─ PelatihanTkkPeserta.php
│  │  ├─ Tkk.php
│  │  └─ User.php
│  ├─ Providers
│  │  └─ AppServiceProvider.php
│  ├─ Services
│  │  └─ Bujk
│  │     └─ BujkImportService.php
│  └─ Support
│     ├─ BujkDataNormalizer.php
│     └─ SimpleSpreadsheetReader.php
├─ artisan
├─ bootstrap
│  ├─ app.php
│  ├─ cache
│  │  ├─ packages.php
│  │  └─ services.php
│  └─ providers.php
├─ composer.json
├─ composer.lock
├─ config
│  ├─ app.php
│  ├─ auth.php
│  ├─ bujk.php
│  ├─ cache.php
│  ├─ database.php
│  ├─ filesystems.php
│  ├─ logging.php
│  ├─ mail.php
│  ├─ queue.php
│  ├─ services.php
│  └─ session.php
├─ database
│  ├─ database.sqlite
│  ├─ factories
│  │  └─ UserFactory.php
│  ├─ migrations
│  │  ├─ 0001_01_01_000000_create_users_table.php
│  │  ├─ 0001_01_01_000001_create_cache_table.php
│  │  ├─ 0001_01_01_000002_create_jobs_table.php
│  │  ├─ 2026_04_22_123008_create_bujk_table.php
│  │  ├─ 2026_04_27_034140_create_bujk_sbu_table.php
│  │  ├─ 2026_04_27_065022_add_snapshot_columns_to_bujk_sbu_table.php
│  │  ├─ 2026_04_27_073535_alter_bujk_location_columns_to_text.php
│  │  ├─ 2026_04_30_074425_create_tkk_table.php
│  │  ├─ 2026_05_11_053457_rebuild_bujk_columns_and_drop_bujk_sbu_table.php
│  │  ├─ 2026_05_11_072308_add_website_to_bujk_table.php
│  │  ├─ 2026_05_20_035355_create_rantai_pasok_table.php
│  │  ├─ 2026_05_20_062541_create_pelatihan_tkk_table.php
│  │  ├─ 2026_05_21_060746_add_new_form_columns_to_pelatihan_tkk_table.php
│  │  ├─ 2026_05_25_071218_create_pelatihan_tkk_peserta_table.php
│  │  ├─ 2026_05_26_004346_add_nik_and_telepon_to_users_table.php
│  │  └─ 2026_05_26_010525_add_provinsi_to_pelatihan_tkk_peserta_table.php
│  └─ seeders
│     └─ DatabaseSeeder.php
├─ lang
│  ├─ id
│  │  ├─ actions.php
│  │  ├─ auth.php
│  │  ├─ http-statuses.php
│  │  ├─ pagination.php
│  │  ├─ passwords.php
│  │  └─ validation.php
│  └─ id.json
├─ package-lock.json
├─ package.json
├─ phpunit.xml
├─ postcss.config.js
├─ public
│  ├─ .htaccess
│  ├─ favicon.ico
│  ├─ files
│  │  ├─ renja.pdf
│  │  └─ sop-bikon.pdf
│  ├─ geojson
│  │  └─ kaltim-kabupaten-kota.geojson
│  ├─ images
│  │  ├─ berita-1.png
│  │  ├─ berita-2.png
│  │  ├─ berita-3.png
│  │  ├─ berita-utama.jpg
│  │  ├─ beritagrid-1.png
│  │  ├─ beritagrid-2.png
│  │  ├─ beritagrid-3.png
│  │  ├─ beritagrid-4.png
│  │  ├─ beritagrid-5.png
│  │  ├─ beritagrid-6.png
│  │  ├─ gedung-dinas-PUPR.jpg
│  │  ├─ layanan-1.png
│  │  ├─ layanan-10.png
│  │  ├─ layanan-11.png
│  │  ├─ layanan-2.png
│  │  ├─ layanan-3.png
│  │  ├─ layanan-4.png
│  │  ├─ layanan-5.png
│  │  ├─ layanan-6.png
│  │  ├─ layanan-7.png
│  │  ├─ layanan-8.png
│  │  ├─ layanan-9.png
│  │  ├─ logo-berakhlak.png
│  │  ├─ logo-dinas.png
│  │  ├─ logo-gubernur.png
│  │  ├─ logo-kaltim.png
│  │  ├─ logo-sibikon.png
│  │  ├─ poster-pelatihan.jpg
│  │  └─ struktur.png
│  ├─ index.php
│  └─ robots.txt
├─ README.md
├─ resources
│  ├─ css
│  │  └─ app.css
│  ├─ js
│  │  └─ app.js
│  └─ views
│     ├─ admin
│     │  ├─ bujk
│     │  │  ├─ index.blade.php
│     │  │  └─ partials
│     │  │     └─ table.blade.php
│     │  ├─ dashboard-tkk.blade.php
│     │  ├─ dashboard.blade.php
│     │  ├─ partials
│     │  │  ├─ sidebar-desktop-menu.blade.php
│     │  │  └─ sidebar-mobile-menu.blade.php
│     │  ├─ pelatihan-sertifikasi
│     │  │  ├─ index.blade.php
│     │  │  ├─ partials
│     │  │  │  ├─ form-fields.blade.php
│     │  │  │  └─ peserta-form-fields.blade.php
│     │  │  └─ show.blade.php
│     │  ├─ pelatihan-tkk
│     │  │  └─ index.blade.php
│     │  └─ placeholder.blade.php
│     ├─ components
│     │  └─ dashboard-chart-card.blade.php
│     ├─ layouts
│     │  ├─ admin.blade.php
│     │  └─ app.blade.php
│     ├─ pages
│     │  ├─ beranda.blade.php
│     │  ├─ berita.blade.php
│     │  ├─ dashboard-bujk-publik.blade.php
│     │  ├─ dashboard-sbu-publik.blade.php
│     │  ├─ dashboard-tkk-aktif-publik.blade.php
│     │  ├─ dashboard-tkk-publik.blade.php
│     │  ├─ detail-berita.blade.php
│     │  ├─ fungsi
│     │  │  ├─ pemberdayaan
│     │  │  │  ├─ pelatihan-ahli.blade.php
│     │  │  │  └─ tabel-tkk.blade.php
│     │  │  ├─ pengaturan
│     │  │  │  ├─ daftar-sosil.blade.php
│     │  │  │  ├─ forum.blade.php
│     │  │  │  ├─ rakor.blade.php
│     │  │  │  ├─ rantai-pasok.blade.php
│     │  │  │  └─ sosialisasi.blade.php
│     │  │  └─ pengawasan
│     │  │     ├─ tertib-pemanfaatan.blade.php
│     │  │     ├─ tertib-penyelenggaraan.blade.php
│     │  │     └─ tertib-usaha.blade.php
│     │  ├─ gis-map.blade.php
│     │  ├─ kontak.blade.php
│     │  ├─ layanan
│     │  │  ├─ asosiasi-perusahaan.blade.php
│     │  │  ├─ asosiasi-profesi.blade.php
│     │  │  └─ penyedia-jasa.blade.php
│     │  ├─ login.blade.php
│     │  ├─ profil
│     │  │  ├─ sop-renja.blade.php
│     │  │  ├─ struktur.blade.php
│     │  │  └─ tentang-kami.blade.php
│     │  └─ regist.blade.php
│     └─ welcome.blade.php
├─ routes
│  ├─ console.php
│  └─ web.php
├─ storage
│  ├─ app
│  │  ├─ imports
│  │  │  ├─ Data BUJK dan SBU Kaltim (2Sept25).xlsx
│  │  │  └─ tkk_data.xlsx
│  │  ├─ private
│  │  │  └─ bujk
│  │  │     └─ latest-data-date.txt
│  │  └─ public
│  ├─ framework
│  │  ├─ cache
│  │  │  └─ data
│  │  ├─ sessions
│  │  │  └─ bMnPn3il7EkeYaafxQYkAFteHKG6WYbeQgXUYeDd
│  │  ├─ testing
│  │  └─ views
│  │     ├─ 151e28a0c1dcfc2f65a0c75279a6d7c7.php
│  │     ├─ 212d2643a9577c6861e5fd8b3d0d9147.php
│  │     ├─ 26b0b1f68234489109094909f7eab0fd.php
│  │     ├─ 3a103ad09bdd56bc18de399b3f93f0cd.php
│  │     ├─ 3c27990ce378551cbb3bfe469b3e6ade.php
│  │     ├─ 51a3b08c327adfc50a1dd9e7aa5fb643.php
│  │     ├─ 52afdbbf9f712bb40ba063819f020ab4.php
│  │     ├─ 64201025f008e1556735cc7cf291eb1b.php
│  │     ├─ 71bfaba899c27c70e7a7f839f5b6a7d4.php
│  │     ├─ aff79c8aa739a82e9b0e82abadcbe214.php
│  │     ├─ bfccf226d6efb4714f2d15ba53c8085c.php
│  │     ├─ e21c4f1d804a9025bd70626353c98654.php
│  │     └─ e25b0135aa736f1f99ae839abc45e5e9.php
│  └─ logs
├─ tailwind.config.js
├─ tests
│  ├─ Feature
│  │  └─ ExampleTest.php
│  ├─ TestCase.php
│  └─ Unit
│     └─ ExampleTest.php
└─ vite.config.js

```