<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

```
Optimalisasi-SIBIKON
├─ .editorconfig
├─ .npmrc
├─ app
│  ├─ Console
│  │  └─ Commands
│  │     └─ ImportBujkSbuExcel.php
│  ├─ Http
│  │  ├─ Controllers
│  │  │  ├─ Admin
│  │  │  │  ├─ BujkController.php
│  │  │  │  └─ DashboardController.php
│  │  │  └─ Controller.php
│  │  └─ Requests
│  │     └─ Admin
│  │        └─ Bujk
│  │           ├─ BujkFormRequest.php
│  │           └─ BujkImportRequest.php
│  ├─ Models
│  │  ├─ Bujk.php
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
│  │  └─ 2026_04_27_073535_alter_bujk_location_columns_to_text.php
│  └─ seeders
│     └─ DatabaseSeeder.php
├─ package-lock.json
├─ package.json
├─ phpunit.xml
├─ postcss.config.js
├─ public
│  ├─ .htaccess
│  ├─ favicon.ico
│  ├─ images
│  │  ├─ gedung-dinas-PUPR.jpg
│  │  └─ logo-sibikon.png
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
│     │  └─ placeholder.blade.php
│     ├─ components
│     │  └─ dashboard-chart-card.blade.php
│     ├─ layouts
│     │  └─ admin.blade.php
│     └─ welcome.blade.php
├─ routes
│  ├─ console.php
│  └─ web.php
├─ storage
│  ├─ app
│  │  ├─ imports
│  │  │  ├─ Data BUJK dan SBU Kaltim (2Sept25).xlsx
│  │  │  └─ data BUJK dan SBU KALTIM 2025 (19Juni2025).xlsx
│  │  ├─ private
│  │  └─ public
│  ├─ framework
│  │  ├─ cache
│  │  │  └─ data
│  │  │     ├─ 12
│  │  │     │  └─ de
│  │  │     │     └─ 12de811a5766d0010da619619bcf79af556dd131
│  │  │     └─ 17
│  │  │        └─ ac
│  │  │           └─ 17ac641564bfe2eb176a10406a8490f0e2bc08e2
│  │  ├─ sessions
│  │  │  └─ hjjjwil2WxGWs126pceYfbnG05qRAQeNHSjaBjgv
│  │  ├─ testing
│  │  └─ views
│  │     ├─ 10be9791d51511d266e5d751628ad7e5.php
│  │     ├─ 145840fee083c8eebba63a65ddf69777.php
│  │     ├─ 151e28a0c1dcfc2f65a0c75279a6d7c7.php
│  │     ├─ 156e474ee2ffe88eb36e4e9b903aea31.php
│  │     ├─ 1e39d3d4bbee8490b4dc3e3c23aa861b.php
│  │     ├─ 212d2643a9577c6861e5fd8b3d0d9147.php
│  │     ├─ 2130da2ea878ef953331caa1c73f782f.php
│  │     ├─ 24746329176886758bcf34f223ce4bc7.php
│  │     ├─ 26be0db4eb47158f259fdbad66176fdb.php
│  │     ├─ 2e6b6c1ad7ff6d071af9b173e78b92bd.php
│  │     ├─ 2ff031ee636993a7b7bea36d8023eb18.php
│  │     ├─ 33a69ad861bd4963881a8515f512ba6f.php
│  │     ├─ 3503f29695a5395f8446afe4ff037aa8.php
│  │     ├─ 36fbf176aa24b358f1c382862625cfde.php
│  │     ├─ 39c54b8bb51eb62d7e080e268674cdc0.php
│  │     ├─ 3c27990ce378551cbb3bfe469b3e6ade.php
│  │     ├─ 3fd498130ddb509e63c8bb8b61d18cca.php
│  │     ├─ 40a79a229747a08f50def5375954af67.php
│  │     ├─ 423cdc138621083748391b67a7809c74.php
│  │     ├─ 43bea8d76053989a215e099d9ae47391.php
│  │     ├─ 45a6e8547c5bdc1095d694873cd56f66.php
│  │     ├─ 4b054ad4cecb0924f285bf4c102a6b64.php
│  │     ├─ 4dee1c02cc560c0c60fa16fbcda3b784.php
│  │     ├─ 523dfd42abadc0c4532bb61037aecd76.php
│  │     ├─ 5659dfc7b45dcaa6e0149afe34ad58b2.php
│  │     ├─ 568ff530236c926b66f325034a031fe2.php
│  │     ├─ 5ea343be162095cae340d797ab811dc7.php
│  │     ├─ 64201025f008e1556735cc7cf291eb1b.php
│  │     ├─ 67ff661f13d0067a900510d532ce870d.php
│  │     ├─ 82f874c7f7b912504cfdefcbba0497f3.php
│  │     ├─ 89732885253f59eaa66ba9f64c847276.php
│  │     ├─ 8b7fe62e07ef77b6f5863723df0cf2a7.php
│  │     ├─ 98e9485c238dadc603061ab01d908d38.php
│  │     ├─ 9a46eb299241f5bfd8ce5f3fd5787498.php
│  │     ├─ 9ada882d0e2a00d6f087e7e2413fa37c.php
│  │     ├─ 9ee1f594419b5152ab1e38f54cb12324.php
│  │     ├─ a420cae43e4314ae828a091a0b8d51ca.php
│  │     ├─ a9dcdde068894a7dd6c2e633733e1c14.php
│  │     ├─ b09631cc40fec155cbd6fe962d6335cb.php
│  │     ├─ b8b2e1121f0e22d5ac9fcbbf6e223e5c.php
│  │     ├─ bfccf226d6efb4714f2d15ba53c8085c.php
│  │     ├─ c56e602126d0d0d74648ccf12526dabc.php
│  │     ├─ c5bd53970249912dac89eff7b87dc588.php
│  │     ├─ d121be29b396c13724e0f49115ac398c.php
│  │     ├─ d1cd00aab2a75c4d922134d157c12c9e.php
│  │     ├─ d2ef25df0c36ebb60ce39e48388a15d4.php
│  │     ├─ d417fb981bb43c1c5c76c298e68e5781.php
│  │     ├─ e21c4f1d804a9025bd70626353c98654.php
│  │     ├─ e56b5263ea506d2b481d909c94a7d397.php
│  │     ├─ eaff4365b6bcc51dd40087cd4edfa6fe.php
│  │     ├─ eb90f3149ce67c8f897087de8ce8fae7.php
│  │     ├─ f124f4245b86202975999b048745a4d8.php
│  │     └─ f6a36d80d87267be4d1ad5123acca7c3.php
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
```
Optimalisasi-SIBIKON
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
│  │  │  │  └─ DashboardController.php
│  │  │  └─ Controller.php
│  │  └─ Requests
│  │     └─ Admin
│  │        └─ Bujk
│  │           ├─ BujkFormRequest.php
│  │           └─ BujkImportRequest.php
│  ├─ Models
│  │  ├─ Bujk.php
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
│  │  └─ 2026_05_11_072308_add_website_to_bujk_table.php
│  └─ seeders
│     └─ DatabaseSeeder.php
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
│     │  └─ placeholder.blade.php
│     ├─ components
│     │  └─ dashboard-chart-card.blade.php
│     ├─ layouts
│     │  ├─ admin.blade.php
│     │  └─ app.blade.php
│     ├─ pages
│     │  ├─ beranda.blade.php
│     │  ├─ berita.blade.php
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
│  │  │  ├─ data BUJK dan SBU KALTIM 2025 (19Juni2025).xlsx
│  │  │  └─ tkk_data.xlsx
│  │  ├─ private
│  │  └─ public
│  ├─ framework
│  │  ├─ cache
│  │  │  └─ data
│  │  │     ├─ 12
│  │  │     │  └─ de
│  │  │     │     └─ 12de811a5766d0010da619619bcf79af556dd131
│  │  │     └─ 17
│  │  │        └─ ac
│  │  │           └─ 17ac641564bfe2eb176a10406a8490f0e2bc08e2
│  │  ├─ sessions
│  │  │  ├─ 57H8pxap4AcBtkhmv7kJDBwXWacKTev9sCw5hdIM
│  │  │  ├─ 66NgkU58IvqLkp0SYHDxY5zYMHY45dloBew4vCJT
│  │  │  ├─ cx4tnx4R8MCdlceczcBzA2YSiM81XYkRmuVX2Itx
│  │  │  ├─ SeAvwPGSS478wZGAM12ZCbqNXjHn5NZvk59JKcT0
│  │  │  ├─ tAscC1OYixvIVEz8nG1Cwc9GyxR8tIkqQB4K4RS1
│  │  │  ├─ vJjkCj5Vh7jN4n5LuxZ7bE1isJNh8OqE5rcwqzdt
│  │  │  └─ Z1lXDmT02UIstf8H0RJW6EHhWAdgZywQ5v4Bwt9E
│  │  ├─ testing
│  │  └─ views
│  │     ├─ 10be9791d51511d266e5d751628ad7e5.php
│  │     ├─ 145840fee083c8eebba63a65ddf69777.php
│  │     ├─ 151e28a0c1dcfc2f65a0c75279a6d7c7.php
│  │     ├─ 156e474ee2ffe88eb36e4e9b903aea31.php
│  │     ├─ 1e39d3d4bbee8490b4dc3e3c23aa861b.php
│  │     ├─ 212d2643a9577c6861e5fd8b3d0d9147.php
│  │     ├─ 2130da2ea878ef953331caa1c73f782f.php
│  │     ├─ 24746329176886758bcf34f223ce4bc7.php
│  │     ├─ 26be0db4eb47158f259fdbad66176fdb.php
│  │     ├─ 2e6b6c1ad7ff6d071af9b173e78b92bd.php
│  │     ├─ 2ff031ee636993a7b7bea36d8023eb18.php
│  │     ├─ 33a69ad861bd4963881a8515f512ba6f.php
│  │     ├─ 3503f29695a5395f8446afe4ff037aa8.php
│  │     ├─ 36fbf176aa24b358f1c382862625cfde.php
│  │     ├─ 39c54b8bb51eb62d7e080e268674cdc0.php
│  │     ├─ 3c27990ce378551cbb3bfe469b3e6ade.php
│  │     ├─ 3fd498130ddb509e63c8bb8b61d18cca.php
│  │     ├─ 40a79a229747a08f50def5375954af67.php
│  │     ├─ 423cdc138621083748391b67a7809c74.php
│  │     ├─ 43bea8d76053989a215e099d9ae47391.php
│  │     ├─ 45a6e8547c5bdc1095d694873cd56f66.php
│  │     ├─ 4b054ad4cecb0924f285bf4c102a6b64.php
│  │     ├─ 4dee1c02cc560c0c60fa16fbcda3b784.php
│  │     ├─ 51a3b08c327adfc50a1dd9e7aa5fb643.php
│  │     ├─ 523dfd42abadc0c4532bb61037aecd76.php
│  │     ├─ 52afdbbf9f712bb40ba063819f020ab4.php
│  │     ├─ 5659dfc7b45dcaa6e0149afe34ad58b2.php
│  │     ├─ 568ff530236c926b66f325034a031fe2.php
│  │     ├─ 5ea343be162095cae340d797ab811dc7.php
│  │     ├─ 64201025f008e1556735cc7cf291eb1b.php
│  │     ├─ 67ff661f13d0067a900510d532ce870d.php
│  │     ├─ 71bfaba899c27c70e7a7f839f5b6a7d4.php
│  │     ├─ 82f874c7f7b912504cfdefcbba0497f3.php
│  │     ├─ 89732885253f59eaa66ba9f64c847276.php
│  │     ├─ 8b7fe62e07ef77b6f5863723df0cf2a7.php
│  │     ├─ 98e9485c238dadc603061ab01d908d38.php
│  │     ├─ 9a46eb299241f5bfd8ce5f3fd5787498.php
│  │     ├─ 9ada882d0e2a00d6f087e7e2413fa37c.php
│  │     ├─ 9ee1f594419b5152ab1e38f54cb12324.php
│  │     ├─ a420cae43e4314ae828a091a0b8d51ca.php
│  │     ├─ a9dcdde068894a7dd6c2e633733e1c14.php
│  │     ├─ aff79c8aa739a82e9b0e82abadcbe214.php
│  │     ├─ b09631cc40fec155cbd6fe962d6335cb.php
│  │     ├─ b8b2e1121f0e22d5ac9fcbbf6e223e5c.php
│  │     ├─ bfccf226d6efb4714f2d15ba53c8085c.php
│  │     ├─ c02bbf5a5aa7b1e320433682f2929800.php
│  │     ├─ c56e602126d0d0d74648ccf12526dabc.php
│  │     ├─ c5bd53970249912dac89eff7b87dc588.php
│  │     ├─ d121be29b396c13724e0f49115ac398c.php
│  │     ├─ d1cd00aab2a75c4d922134d157c12c9e.php
│  │     ├─ d2ef25df0c36ebb60ce39e48388a15d4.php
│  │     ├─ d417fb981bb43c1c5c76c298e68e5781.php
│  │     ├─ e21c4f1d804a9025bd70626353c98654.php
│  │     ├─ e25b0135aa736f1f99ae839abc45e5e9.php
│  │     ├─ e56b5263ea506d2b481d909c94a7d397.php
│  │     ├─ eaff4365b6bcc51dd40087cd4edfa6fe.php
│  │     ├─ eb90f3149ce67c8f897087de8ce8fae7.php
│  │     ├─ f124f4245b86202975999b048745a4d8.php
│  │     └─ f6a36d80d87267be4d1ad5123acca7c3.php
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
```
Optimalisasi-SIBIKON
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
│  │  │  │  └─ DashboardController.php
│  │  │  ├─ Auth
│  │  │  │  └─ AuthController.php
│  │  │  └─ Controller.php
│  │  └─ Requests
│  │     └─ Admin
│  │        └─ Bujk
│  │           ├─ BujkFormRequest.php
│  │           └─ BujkImportRequest.php
│  ├─ Models
│  │  ├─ Bujk.php
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
│  │  └─ 2026_05_11_072308_add_website_to_bujk_table.php
│  └─ seeders
│     └─ DatabaseSeeder.php
├─ database_sibikon.sql
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
│     │  └─ placeholder.blade.php
│     ├─ components
│     │  └─ dashboard-chart-card.blade.php
│     ├─ layouts
│     │  ├─ admin.blade.php
│     │  └─ app.blade.php
│     ├─ pages
│     │  ├─ beranda.blade.php
│     │  ├─ berita.blade.php
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
│  │  │     └─ 17
│  │  │        └─ ac
│  │  │           └─ 17ac641564bfe2eb176a10406a8490f0e2bc08e2
│  │  ├─ sessions
│  │  │  ├─ 0mvRubasaSapxJEX9med7YKuz8Jme4Gl0dZgtUUa
│  │  │  ├─ mIU8BFYecimr7HLACGS43ddBtA1A7RsmknUp49aM
│  │  │  ├─ sI1OKVsZv0xqqIRhqXKdSCLPOvF3jOyWY5JNcZqI
│  │  │  └─ Y5JxvJ8LT77efbmEikkX9mpQyLqLR0bn2g95ipif
│  │  ├─ testing
│  │  └─ views
│  │     ├─ 10be9791d51511d266e5d751628ad7e5.php
│  │     ├─ 151e28a0c1dcfc2f65a0c75279a6d7c7.php
│  │     ├─ 156e474ee2ffe88eb36e4e9b903aea31.php
│  │     ├─ 1e39d3d4bbee8490b4dc3e3c23aa861b.php
│  │     ├─ 212d2643a9577c6861e5fd8b3d0d9147.php
│  │     ├─ 26be0db4eb47158f259fdbad66176fdb.php
│  │     ├─ 2e6b6c1ad7ff6d071af9b173e78b92bd.php
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
│  │     ├─ 4dee1c02cc560c0c60fa16fbcda3b784.php
│  │     ├─ 51a3b08c327adfc50a1dd9e7aa5fb643.php
│  │     ├─ 523dfd42abadc0c4532bb61037aecd76.php
│  │     ├─ 52afdbbf9f712bb40ba063819f020ab4.php
│  │     ├─ 5659dfc7b45dcaa6e0149afe34ad58b2.php
│  │     ├─ 64201025f008e1556735cc7cf291eb1b.php
│  │     ├─ 67ff661f13d0067a900510d532ce870d.php
│  │     ├─ 71bfaba899c27c70e7a7f839f5b6a7d4.php
│  │     ├─ 82f874c7f7b912504cfdefcbba0497f3.php
│  │     ├─ 89732885253f59eaa66ba9f64c847276.php
│  │     ├─ 8b7fe62e07ef77b6f5863723df0cf2a7.php
│  │     ├─ 98e9485c238dadc603061ab01d908d38.php
│  │     ├─ 9a46eb299241f5bfd8ce5f3fd5787498.php
│  │     ├─ 9ada882d0e2a00d6f087e7e2413fa37c.php
│  │     ├─ 9ee1f594419b5152ab1e38f54cb12324.php
│  │     ├─ a420cae43e4314ae828a091a0b8d51ca.php
│  │     ├─ a9dcdde068894a7dd6c2e633733e1c14.php
│  │     ├─ b09631cc40fec155cbd6fe962d6335cb.php
│  │     ├─ b8b2e1121f0e22d5ac9fcbbf6e223e5c.php
│  │     ├─ bfccf226d6efb4714f2d15ba53c8085c.php
│  │     ├─ c56e602126d0d0d74648ccf12526dabc.php
│  │     ├─ c5bd53970249912dac89eff7b87dc588.php
│  │     ├─ d121be29b396c13724e0f49115ac398c.php
│  │     ├─ d1cd00aab2a75c4d922134d157c12c9e.php
│  │     ├─ d2ef25df0c36ebb60ce39e48388a15d4.php
│  │     ├─ d417fb981bb43c1c5c76c298e68e5781.php
│  │     ├─ e21c4f1d804a9025bd70626353c98654.php
│  │     ├─ e25b0135aa736f1f99ae839abc45e5e9.php
│  │     ├─ e56b5263ea506d2b481d909c94a7d397.php
│  │     ├─ eaff4365b6bcc51dd40087cd4edfa6fe.php
│  │     ├─ eb90f3149ce67c8f897087de8ce8fae7.php
│  │     ├─ f124f4245b86202975999b048745a4d8.php
│  │     └─ f6a36d80d87267be4d1ad5123acca7c3.php
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