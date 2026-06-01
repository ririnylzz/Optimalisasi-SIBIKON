
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
│  │  │  │  ├─ PelatihanTkkController.php
│  │  │  │  └─ RantaiPasokController.php
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
│  │  ├─ RantaiPasok.php
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
│  │  ├─ 2026_05_20_062541_create_pelatihan_tkk_table.php
│  │  ├─ 2026_05_21_060746_add_new_form_columns_to_pelatihan_tkk_table.php
│  │  ├─ 2026_05_25_001808_add_contact_columns_to_rantai_pasok_table.php
│  │  ├─ 2026_05_25_071218_create_pelatihan_tkk_peserta_table.php
│  │  ├─ 2026_05_26_004346_add_nik_and_telepon_to_users_table.php
│  │  ├─ 2026_05_26_010525_add_provinsi_to_pelatihan_tkk_peserta_table.php
│  │  └─ 2026_06_01_045132_add_is_deleted_to_rantai_pasok_table.php
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
│     │  ├─ placeholder.blade.php
│     │  ├─ rantai-pasok
│     │  │  ├─ index.blade.php
│     │  │  └─ partials
│     │  │     └─ table.blade.php
│     │  └─ tkk-data.blade.php
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
│  │  │  ├─ rantai_pasok_dummy.csv
│  │  │  └─ tkk_data.xlsx
│  │  ├─ private
│  │  │  ├─ bujk
│  │  │  │  └─ latest-data-date.txt
│  │  │  └─ tkk
│  │  │     └─ latest-data-date.txt
│  │  └─ public
│  ├─ framework
│  │  ├─ cache
│  │  │  └─ data
│  │  │     └─ 17
│  │  │        └─ ac
│  │  │           └─ 17ac641564bfe2eb176a10406a8490f0e2bc08e2
│  │  ├─ sessions
│  │  │  └─ jtyL7XKFmmylm7NhyUl2YKhRlLQNzQeGb2mfb8bt
│  │  ├─ testing
│  │  └─ views
│  │     ├─ 0021ae69827c21473f5d26bf4bc9e713.php
│  │     ├─ 0629f9175574b317013375b2d2202006.php
│  │     ├─ 085da4ff683f1718bdd7c5366ec8fda4.php
│  │     ├─ 0e5436eabc5fdb9c39b9da90104b472b.php
│  │     ├─ 10be9791d51511d266e5d751628ad7e5.php
│  │     ├─ 145840fee083c8eebba63a65ddf69777.php
│  │     ├─ 151e28a0c1dcfc2f65a0c75279a6d7c7.php
│  │     ├─ 156e474ee2ffe88eb36e4e9b903aea31.php
│  │     ├─ 1e39d3d4bbee8490b4dc3e3c23aa861b.php
│  │     ├─ 212d2643a9577c6861e5fd8b3d0d9147.php
│  │     ├─ 2130da2ea878ef953331caa1c73f782f.php
│  │     ├─ 24746329176886758bcf34f223ce4bc7.php
│  │     ├─ 266ec2a5953a996c248b326b5b3726c9.php
│  │     ├─ 26b0b1f68234489109094909f7eab0fd.php
│  │     ├─ 26be0db4eb47158f259fdbad66176fdb.php
│  │     ├─ 2e6b6c1ad7ff6d071af9b173e78b92bd.php
│  │     ├─ 2ee35005321d3e5f07388dc8bb6b6697.php
│  │     ├─ 2ff031ee636993a7b7bea36d8023eb18.php
│  │     ├─ 33a69ad861bd4963881a8515f512ba6f.php
│  │     ├─ 3503f29695a5395f8446afe4ff037aa8.php
│  │     ├─ 36fbf176aa24b358f1c382862625cfde.php
│  │     ├─ 39c54b8bb51eb62d7e080e268674cdc0.php
│  │     ├─ 3a103ad09bdd56bc18de399b3f93f0cd.php
│  │     ├─ 3c27990ce378551cbb3bfe469b3e6ade.php
│  │     ├─ 3fd498130ddb509e63c8bb8b61d18cca.php
│  │     ├─ 40a79a229747a08f50def5375954af67.php
│  │     ├─ 423cdc138621083748391b67a7809c74.php
│  │     ├─ 43bea8d76053989a215e099d9ae47391.php
│  │     ├─ 45a6e8547c5bdc1095d694873cd56f66.php
│  │     ├─ 4b054ad4cecb0924f285bf4c102a6b64.php
│  │     ├─ 4c483eb8c231c6201da4fca86359d3a4.php
│  │     ├─ 4dee1c02cc560c0c60fa16fbcda3b784.php
│  │     ├─ 502c08399ff490c460fce38b10973517.php
│  │     ├─ 51a3b08c327adfc50a1dd9e7aa5fb643.php
│  │     ├─ 51cd845f446752dafe3ad15b96125bb7.php
│  │     ├─ 523dfd42abadc0c4532bb61037aecd76.php
│  │     ├─ 52afdbbf9f712bb40ba063819f020ab4.php
│  │     ├─ 5659dfc7b45dcaa6e0149afe34ad58b2.php
│  │     ├─ 568ff530236c926b66f325034a031fe2.php
│  │     ├─ 64201025f008e1556735cc7cf291eb1b.php
│  │     ├─ 67ff661f13d0067a900510d532ce870d.php
│  │     ├─ 6f46a8bdad97a7367c7adf3c8becbe6a.php
│  │     ├─ 71bfaba899c27c70e7a7f839f5b6a7d4.php
│  │     ├─ 756ec64a602d80f09c607cdcd97436ac.php
│  │     ├─ 7d2609c4f3d1f70a49b34af5ae5e9227.php
│  │     ├─ 82f874c7f7b912504cfdefcbba0497f3.php
│  │     ├─ 89732885253f59eaa66ba9f64c847276.php
│  │     ├─ 8b7fe62e07ef77b6f5863723df0cf2a7.php
│  │     ├─ 98e9485c238dadc603061ab01d908d38.php
│  │     ├─ 9a46eb299241f5bfd8ce5f3fd5787498.php
│  │     ├─ 9ada882d0e2a00d6f087e7e2413fa37c.php
│  │     ├─ 9ee1f594419b5152ab1e38f54cb12324.php
│  │     ├─ a37b8c6bc31c255b7f2fc3d55433abb6.php
│  │     ├─ a3e6d5a4b5d1b590f79bc7a747b5be9c.php
│  │     ├─ a420cae43e4314ae828a091a0b8d51ca.php
│  │     ├─ a8365fcf0e95aacd40d2e150294bc8b6.php
│  │     ├─ a9dcdde068894a7dd6c2e633733e1c14.php
│  │     ├─ aff79c8aa739a82e9b0e82abadcbe214.php
│  │     ├─ b09631cc40fec155cbd6fe962d6335cb.php
│  │     ├─ b8b2e1121f0e22d5ac9fcbbf6e223e5c.php
│  │     ├─ bfccf226d6efb4714f2d15ba53c8085c.php
│  │     ├─ c02bbf5a5aa7b1e320433682f2929800.php
│  │     ├─ c56e602126d0d0d74648ccf12526dabc.php
│  │     ├─ c5bd53970249912dac89eff7b87dc588.php
│  │     ├─ ca5e193876058217d792cfc77e0cbe97.php
│  │     ├─ d121be29b396c13724e0f49115ac398c.php
│  │     ├─ d1cd00aab2a75c4d922134d157c12c9e.php
│  │     ├─ d2ef25df0c36ebb60ce39e48388a15d4.php
│  │     ├─ d417fb981bb43c1c5c76c298e68e5781.php
│  │     ├─ e21c4f1d804a9025bd70626353c98654.php
│  │     ├─ e25b0135aa736f1f99ae839abc45e5e9.php
│  │     ├─ e56b5263ea506d2b481d909c94a7d397.php
│  │     ├─ e8d094c9d75734358decb3373f0a1382.php
│  │     ├─ eaff4365b6bcc51dd40087cd4edfa6fe.php
│  │     ├─ eb90f3149ce67c8f897087de8ce8fae7.php
│  │     ├─ ecd1a1c166bfb435c343b65871d8107d.php
│  │     ├─ f124f4245b86202975999b048745a4d8.php
│  │     ├─ f6a36d80d87267be4d1ad5123acca7c3.php
│  │     └─ fe2449103478614c102965b23e19f888.php
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