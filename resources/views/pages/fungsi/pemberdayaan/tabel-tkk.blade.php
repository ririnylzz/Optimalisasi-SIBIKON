<div class="min-h-screen bg-white text-slate-900 relative overflow-hidden">
    <!-- top bar -->
    <div class="relative z-30 border-b border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-4 text-sm lg:text-base font-semibold text-[#1E3A5F]">
        </div>
    </div>

    <!-- navbar -->
    <header class="relative z-30 border-b border-white/10 bg-[#243B78]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-5">
                <!-- logo -->
                <div class="flex items-center gap-4">
                    <div>
                        <h1 class="text-3xl font-extrabold leading-none text-white tracking-tight">SIBIKON</h1>
                        <p class="text-sm text-white/70">Sistem Bina Konstruksi Indonesia</p>
                    </div>
                </div>

                <!-- menu desktop -->
                <nav class="hidden md:flex items-center gap-10 font-semibold text-white">
                    <a href="{{ route('beranda') }}"
                        class="{{ request()->routeIs('beranda') ? 'text-yellow-400' : 'text-white' }} hover:text-yellow-400 transition">
                        Beranda
                    </a>

                    <div class="relative group">
                        <button type="button"
                            class="{{ request()->routeIs('tentang-kami') || request()->routeIs('struktur') || request()->routeIs('sop-renja') ? 'text-yellow-400' : 'text-white' }} flex items-center gap-1 hover:text-yellow-400 transition">
                            Profil
                            <svg class="w-4 h-4 transition group-hover:rotate-180" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div class="absolute left-0 top-full z-50 mt-4 hidden w-72 border-t-4 border-yellow-400 bg-white shadow-xl group-hover:block">
                            <a href="{{ route('tentang-kami') }}" class="block px-6 py-4 font-bold text-slate-800 border-b border-slate-200 hover:bg-slate-100">
                                Tentang Kami
                            </a>
                            <a href="{{ route('struktur') }}" class="block px-6 py-4 font-bold text-slate-800 border-b border-slate-200 hover:bg-slate-100">
                                Struktur Organisasi
                            </a>
                            <a href="{{ route('sop-renja') }}" class="block px-6 py-4 font-bold text-slate-800 hover:bg-slate-100">
                                SOP & Renja
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('berita') }}"
                        class="{{ request()->routeIs('berita') ? 'text-yellow-400' : 'text-white' }} hover:text-yellow-400 transition">
                        Berita
                    </a>

                    <div class="relative group">
                        <button type="button"
                            class="{{ request()->routeIs('pengaturan') || request()->routeIs('pemberdayaan') || request()->routeIs('pengawasan') ? 'text-yellow-400' : 'text-white' }} flex items-center gap-1 hover:text-yellow-400 transition">
                            Fungsi
                            <svg class="w-4 h-4 transition group-hover:rotate-180" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div class="absolute left-0 top-full z-50 mt-4 hidden w-64 border-t-4 border-yellow-400 bg-white shadow-xl group-hover:block">
                            <a href="{{ route('rakor') }}" class="block px-6 py-4 font-bold text-slate-800 border-b border-slate-200 hover:bg-slate-100">
                                Pengaturan
                            </a>
                            <a href="#" class="block px-6 py-4 font-bold text-slate-800 border-b border-slate-200 hover:bg-slate-100">
                                Pemberdayaan
                            </a>
                            <a href="#" class="block px-6 py-4 font-bold text-slate-800 hover:bg-slate-100">
                                Pengawasan
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('kontak') }}"
                        class="{{ request()->routeIs('kontak') ? 'text-yellow-400' : 'text-white' }} hover:text-yellow-400 transition">
                        Kontak
                    </a>
                </nav>

                <!-- login button -->
                <div class="hidden md:block">
                    <a href="{{ route('login') }}" class="inline-flex items-center rounded-2xl bg-yellow-400 px-7 py-3 font-bold text-slate-900 hover:bg-yellow-300 transition shadow-lg shadow-yellow-400/20">
                        Login
                    </a>
                </div>

                <!-- mobile toggle -->
                <button id="menu-toggle" class="md:hidden inline-flex items-center justify-center w-11 h-11 rounded-lg border border-white/20 bg-white/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- mobile menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-5">
                <div class="flex flex-col gap-4 font-medium text-white/90">
                    <a href="{{ route('beranda') }}">Beranda</a>
                    <a href="{{ route('tentang-kami') }}">Profil</a>
                    <a href="{{ route('berita') }}">Berita</a>
                    <a href="#}">Fungsi</a>
                    <a href="{{ route('kontak') }}">Kontak</a>
                    <a href="{{ route('login') }}" class="inline-flex w-fit items-center rounded-xl bg-yellow-400 px-6 py-3 font-bold text-slate-900">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- HALAMAN PEMBERDAYAAN -->
    <section class="bg-white py-16 lg:py-20">
        <div class="mx-auto max-w-[1540px] px-6 sm:px-8 lg:px-12 xl:px-16 2xl:px-20">

            <!-- Heading -->
            <div class="mb-10 text-center">
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">
                    Masyarakat Konstruksi
                </p>

                <h1 class="mt-3 text-3xl font-extrabold uppercase tracking-tight text-[#111827] sm:text-4xl">
                    TENAGA KERJA KONSTRUKSI
                </h1>

                <div class="mx-auto mt-4 h-1.5 w-40 rounded-full bg-yellow-400"></div>
            </div>

            <!-- Grid Kategori + Tabel -->
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-[240px_minmax(0,1fr)] items-stretch">

                <!-- SIDEBAR KATEGORI -->
                <aside class="h-full">
                    <div class="h-full rounded-[26px] bg-[#243B78] p-8 shadow-sm">
                        <h2 class="mb-8 text-2xl font-extrabold text-[#F8F8F6]">
                            Kategori
                        </h2>

                        <nav class="space-y-7 text-base font-semibold">
                            <a href="{{ route('tabel-tkk') }}"
                                class="category-link block text-[#F8F8F6] transition hover:text-yellow-500"
                                data-category="tabel-tkk">
                                Tenaga Kerja Konstruksi
                            </a>

                            <a href="{{ route('pelatihan-ahli') }}"
                                class="category-link block text-[#F8F8F6] transition hover:text-yellow-500"
                                data-category="pelatihan-ahli">
                                Pelatihan dan Sertifikasi Ahli
                            </a>
                        </nav>
                    </div>
                </aside>

                <!-- CONTENT / TABLE -->
                <main class="min-w-0">
                    <div class="w-full h-full overflow-hidden rounded-[24px] border border-slate-200 bg-white p-5 shadow-xl shadow-slate-200/70">

                        <!-- Controls -->
                        <div class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <span>Show</span>

                                <select id="entries-select"
                                    class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:border-[#243B78] focus:outline-none">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>

                                <span>entries</span>
                            </div>

                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <label for="table-search">Search:</label>
                                <input id="table-search" type="text"
                                    class="w-full rounded-lg border border-slate-200 px-4 py-2 text-sm focus:border-[#243B78] focus:outline-none sm:w-64">
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="w-full overflow-x-auto">
                            <table class="w-full min-w-[1180px] border-collapse text-left text-sm">
                                <thead>
                                    <tr class="border-y border-slate-200 bg-slate-50 text-[11px] uppercase tracking-wide text-slate-700">
                                        <th class="w-14 border-r border-slate-200 px-4 py-4 font-extrabold">No.</th>
                                        <th class="min-w-[280px] border-r border-slate-200 px-4 py-4 font-extrabold">Nama Tenaga Kerja</th>
                                        <th class="min-w-[150px] border-r border-slate-200 px-4 py-4 font-extrabold">Pendidikan</th>
                                        <th class="min-w-[300px] border-r border-slate-200 px-4 py-4 font-extrabold">Keahlian</th>
                                    </tr>
                                </thead>

                                <tbody id="kegiatan-table" class="divide-y divide-slate-200 text-slate-700">
                                    <tr class="table-row hover:bg-slate-50"
                                        data-category="tabel-tkk">
                                        <td class="border-r border-slate-200 px-4 py-5 align-top font-semibold">1.</td>
                                        <td class="border-r border-slate-200 px-4 py-5 align-top">
                                            M. Ali Wardana, S.T
                                        </td>
                                        <td class="border-r border-slate-200 px-4 py-5 align-top">
                                            Teknik Sipil
                                        </td>
                                        <td class="border-r border-slate-200 px-4 py-5 align-top leading-relaxed">
                                            Ahli Muda Teknik Jembatan
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Footer table -->
                        <div class="mt-5 flex flex-col gap-4 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between">
                            <p id="table-info">
                                Showing 1 to 3 of 3 entries
                            </p>

                            <div class="inline-flex items-center overflow-hidden rounded-lg border border-slate-200">
                                <button type="button" class="bg-slate-100 px-4 py-2 text-slate-500">
                                    Previous
                                </button>
                                <button type="button" class="bg-yellow-400 px-4 py-2 font-bold text-slate-900">
                                    1
                                </button>
                                <button type="button" class="bg-white px-4 py-2 text-slate-500">
                                    Next
                                </button>
                            </div>
                        </div>

                    </div>
                </main>
            </div>
        </div>
    </section>
</div>

<footer class="bg-[#223B78] text-white">
    <div class="mx-auto max-w-7xl px-6 py-14 lg:px-8">
        <div class="grid grid-cols-1 gap-12 lg:grid-cols-4">

            <!-- Kolom 1 -->
            <div>
                <div class="mb-6 flex items-center gap-4">
                    <div>
                        <h3 class="text-2xl font-extrabold leading-none">SIBIKON</h3>
                        <p class="mt-1 text-lg text-white/75">Sistem Bina Konstruksi</p>
                    </div>
                </div>

                <p class="max-w-md text-lg leading-9 text-white/80">
                    Bidang Bina Konstruksi Dinas Pekerjaan Umum Penataan Ruang dan Perumahan Rakyat Provinsi Kalimantan Timur.
                </p>

                <div class="mt-8 flex items-center gap-6">
                    <a href="#" class="flex h-14 w-14 items-center justify-center rounded-xl bg-white/10 transition hover:bg-white/20" aria-label="Facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M13.5 9H16V6h-2.5C10.9 6 9 7.9 9 10.5V12H7v3h2v6h3v-6h3l.5-3H12v-1.5c0-.9.6-1.5 1.5-1.5Z" />
                        </svg>
                    </a>

                    <a href="#" class="flex h-14 w-14 items-center justify-center rounded-xl bg-white/10 transition hover:bg-white/20" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7.75 3h8.5A4.75 4.75 0 0 1 21 7.75v8.5A4.75 4.75 0 0 1 16.25 21h-8.5A4.75 4.75 0 0 1 3 16.25v-8.5A4.75 4.75 0 0 1 7.75 3Zm0 1.5A3.25 3.25 0 0 0 4.5 7.75v8.5a3.25 3.25 0 0 0 3.25 3.25h8.5a3.25 3.25 0 0 0 3.25-3.25v-8.5a3.25 3.25 0 0 0-3.25-3.25h-8.5ZM12 8a4 4 0 1 1 0 8 4 4 0 0 1 0-8Zm0 1.5A2.5 2.5 0 1 0 12 14.5 2.5 2.5 0 0 0 12 9.5Zm4.25-2a1 1 0 1 1 0 2 1 1 0 0 1 0-2Z" />
                        </svg>
                    </a>

                    <a href="#" class="flex h-14 w-14 items-center justify-center rounded-xl bg-white/10 transition hover:bg-white/20" aria-label="YouTube">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M21.6 7.2a2.99 2.99 0 0 0-2.1-2.1C17.7 4.5 12 4.5 12 4.5s-5.7 0-7.5.6A2.99 2.99 0 0 0 2.4 7.2 31.1 31.1 0 0 0 1.8 12a31.1 31.1 0 0 0 .6 4.8 2.99 2.99 0 0 0 2.1 2.1c1.8.6 7.5.6 7.5.6s5.7 0 7.5-.6a2.99 2.99 0 0 0 2.1-2.1 31.1 31.1 0 0 0 .6-4.8 31.1 31.1 0 0 0-.6-4.8ZM10 15.5v-7l6 3.5-6 3.5Z" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Kolom 2 -->
            <div>
                <h4 class="text-2xl font-bold">Jam Pelayanan</h4>
                <ul class="mt-8 space-y-5 text-lg text-white/80">
                    <li class="flex flex-col gap-1">
                        <span class="font-medium text-white">Senin - Kamis</span>
                        <span>09:00 - 15:00 WITA</span>
                    </li>
                    <li class="flex flex-col gap-1">
                        <span class="font-medium text-white">Jum'at</span>
                        <span>09:00 - 10:30 WITA</span>
                    </li>
                </ul>
            </div>

            <!-- Kolom 3 -->
            <div>
                <h4 class="text-2xl font-bold">Statistik Pengunjung</h4>
            </div>

            <!-- Kolom 4 -->
            <div>
                <h4 class="text-2xl font-bold">Link Terkait</h4>

                <ul class="mt-8 divide-y divide-white/10 text-lg text-white/80">
                    <li class="py-4">
                        <a href="https://www.kaltimprov.go.id/" class="flex items-center gap-3 transition hover:text-white">
                            <span class="text-white/60">›</span>
                            <span>Website Provinsi Kalimantan Timur</span>
                        </a>
                    </li>
                    <li class="py-4">
                        <a href="https://dpupr.kaltimprov.go.id/" class="flex items-center gap-3 transition hover:text-white">
                            <span class="text-white/60">›</span>
                            <span>Website Dinas PUPRPERA Prov. Kaltim</span>
                        </a>
                    </li>
                    <li class="py-4">
                        <a href="https://perizinan.pu.go.id/portal/" class="flex items-center gap-3 transition hover:text-white">
                            <span class="text-white/60">›</span>
                            <span>Portal Perizinan PU</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-12 border-t border-white/10 pt-8">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <p class="text-base text-white/70">
                    Copyright © 2026, Developed by Bina Konstruksi DPUPRPERA Prov. Kaltim
                </p>
            </div>
        </div>
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categoryLinks = document.querySelectorAll('.category-link');
        const rows = document.querySelectorAll('.table-row');
        const searchInput = document.getElementById('table-search');
        const tableInfo = document.getElementById('table-info');

        let activeCategory = 'rakor';

        function updateTable() {
            const keyword = searchInput.value.toLowerCase();
            let visibleRows = [];

            rows.forEach((row) => {
                const rowCategory = row.dataset.category;
                const rowText = row.textContent.toLowerCase();

                const matchCategory = rowCategory === activeCategory;
                const matchSearch = rowText.includes(keyword);

                if (matchCategory && matchSearch) {
                    row.classList.remove('hidden');
                    visibleRows.push(row);
                } else {
                    row.classList.add('hidden');
                }
            });

            visibleRows.forEach((row, index) => {
                row.querySelector('td').textContent = `${index + 1}.`;
            });

            tableInfo.textContent = visibleRows.length > 0 ?
                `Showing 1 to ${visibleRows.length} of ${visibleRows.length} entries` :
                'Showing 0 to 0 of 0 entries';
        }

        categoryLinks.forEach((link) => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                activeCategory = this.dataset.category;

                categoryLinks.forEach((item) => {
                    item.classList.remove('text-yellow-500');
                    item.classList.add('text-[#21325e]');
                });

                this.classList.remove('text-[#21325e]');
                this.classList.add('text-yellow-500');

                updateTable();
            });
        });

        if (searchInput) {
            searchInput.addEventListener('keyup', updateTable);
        }

        updateTable();
    });
</script>