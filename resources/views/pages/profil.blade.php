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
                    <!-- <div class="w-14 h-14 rounded-2xl bg-yellow-400 flex items-center justify-center shadow-lg shadow-yellow-400/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6M9 10h.01M15 10h.01" />
                            </svg>
                        </div> -->

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

                    <div class="relative">
                        <button type="button"
                            class="nav-dropdown-btn flex items-center gap-1 text-white hover:text-yellow-400 transition"
                            data-dropdown="dropdown-profil">
                            Profil
                        </button>

                        <div id="dropdown-fungsi"
                            class="nav-dropdown hidden absolute left-0 top-full z-50 mt-4 w-64 border-t-4 border-yellow-400 bg-white shadow-xl">
                            <a href="#" class="block px-6 py-4 border-b hover:bg-gray-100">Pengaturan</a>
                            <a href="#" class="block px-6 py-4 border-b hover:bg-gray-100">Pemberdayaan</a>
                            <a href="#" class="block px-6 py-4 hover:bg-gray-100">Pengawasan</a>
                        </div>
                    </div>

                    <a href="#"
                        class="{{ request()->routeIs('berita') ? 'text-yellow-400' : 'text-white' }} hover:text-yellow-400 transition">
                        Berita
                    </a>

                    <div class="relative">
                        <button type="button"
                            class="nav-dropdown-btn flex items-center gap-1 text-white hover:text-yellow-400 transition"
                            data-dropdown="dropdown-fungsi">
                            Fungsi
                        </button>

                        <div id="dropdown-fungsi"
                            class="nav-dropdown hidden absolute left-0 top-full z-50 mt-4 w-64 border-t-4 border-yellow-400 bg-white shadow-xl">
                            <a href="#" class="block px-6 py-4 border-b hover:bg-gray-100">Pengaturan</a>
                            <a href="#" class="block px-6 py-4 border-b hover:bg-gray-100">Pemberdayaan</a>
                            <a href="#" class="block px-6 py-4 hover:bg-gray-100">Pengawasan</a>
                        </div>
                    </div>

                    <a href="#"
                        class="{{ request()->routeIs('kontak') ? 'text-yellow-400' : 'text-white' }} hover:text-yellow-400 transition">
                        Kontak
                    </a>

                </nav>

                <!-- login button -->
                <div class="hidden md:block">
                    <a href="#" class="inline-flex items-center rounded-2xl bg-yellow-400 px-7 py-3 font-bold text-slate-900 hover:bg-yellow-300 transition shadow-lg shadow-yellow-400/20">
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
                    <a href="{{ route('profil') }}">Profil</a>
                    <a href="#">Berita</a>
                    <a href="#">Fungsi</a>
                    <a href="#">Kontak</a>
                    <a href="#" class="inline-flex w-fit items-center rounded-xl bg-yellow-400 px-6 py-3 font-bold text-slate-900">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </header>


    <!-- tentang kami -->
    <section id="tentang-kami" class="bg-white py-20 lg:py-28">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-14 items-stretch">
                <!-- <div class="mb-12 text-center">
                    <h2 class="text-4xl font-extrabold text-[#143B5D] sm:text-5xl">
                        Tentang Kami
                    </h2>
                    <div class="mx-auto mt-3 h-1 w-10 rounded-full bg-yellow-400"></div>
                </div> -->

                <!-- LEFT CONTENT -->
                <div class="bg-[#F8F8F6] rounded-[28px] p-8 sm:p-10 lg:p-12 flex flex-col justify-between min-h-[520px]">
                    <div>
                        <p class="text-sm font-semibold text-slate-500">
                            Tentang Kami
                        </p>

                        <h2 class="mt-4 text-4xl sm:text-5xl font-bold leading-tight text-[#143B5D] max-w-xl">
                            BIKON
                        </h2>

                        <p class="mt-6 text-base sm:text-lg leading-8 text-slate-600 max-w-2xl">
                            Bina Konstruksi adalah salah satu bidang pada Dinas Pekerjaan Umum Penataan Ruang dan Perumahan Rakyat Provinsi Kalimantan Timur yang memiliki tugas, melaksanakan penyiapan bahan perumusan kebijakan, koordinasi, pembinaan, bimbingan, pengendalian, serta pengembangan teknis di bina konstruksi. Sesuai Peraturan Menteri Dalam Negeri Nomor 106 Tahun 2017, Bidang Bina Konstruksi dibagi menjadi 3 (tiga) Seksi.
                        </p>

                        <div class="about-hidden hidden">
                            <p class="mt-6 text-base sm:text-lg leading-8 text-slate-600 max-w-2xl">
                                Peraturan Daerah Nomor 9 Tahun 2016 bahwa Dinas Pekerjaan Umum, Penataan Ruang dan Perumahan Rakyat Tipe A menyelenggarakan urusan pemerintahan Bidang Pekerjaan Umum, Penataan Ruang, dan urusan pemerintahan Bidang Perumahan dan Kawasan Pemukiman. Sub urusan Jasa Konstruksi adalah salah satu sub urusan pada urusan pemerintahan bidang pekerjaan umum.
                            </p>

                            <p class="mt-6 text-base sm:text-lg leading-8 text-slate-600 max-w-2xl">
                                Peraturan Gubernur Nomor 43 Tahun 2023, Bidang Bina Konstruksi mempunyai tugas melaksanakan penyiapan bahan perumusan kebijakan, koordinasi, pembinaan, bimbingan, pengendalian serta pengembangan teknis di bidang bina konstruksi.
                            </p>
                        </div>

                        <div class="mt-8">
                            <button id="toggle-about" type="button"
                                class="inline-flex items-center justify-center rounded-xl bg-yellow-400 px-6 py-3 text-sm font-bold uppercase tracking-wide text-slate-900 transition hover:bg-yellow-300">
                                Baca Selengkapnya
                            </button>
                        </div>

                    </div>
                </div>

                <!-- RIGHT VISUAL -->
                <div class="relative min-h-[520px] rounded-[28px] overflow-hidden">

                    <img
                        src="{{ asset('images/gedung-dinas-PUPR.jpg') }}"
                        alt="Gedung Dinas PUPR"
                        class="absolute inset-0 h-full w-full object-cover">

                    <!-- overlay biar teks tetap jelas -->
                    <div class="absolute inset-0 bg-[#143B5D]/30"></div>

                    <!-- tombol play kuning -->
                    <div class="absolute top-6 right-6 w-16 h-16 bg-yellow-400 flex items-center justify-center shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-slate-900" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M8 5v14l11-7z" />
                        </svg>
                    </div>

                    <!-- label bawah -->
                    <div class="absolute bottom-6 left-6 right-6 text-white">
                        <p class="text-lg font-semibold">
                            Dinas PUPR Provinsi Kalimantan Timur
                        </p>
                        <p class="text-sm text-white/80">
                            Bidang Bina Konstruksi
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FUNGSI BIKON -->
    <section id="fungsi-bikon" class="bg-white pt-10 pb-20 lg:pt-12 lg:pb-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">

            <!-- Heading -->
            <div class="mb-12 text-center">
                <div class="mx-auto mb-3 h-1 w-10 rounded-full bg-yellow-400"></div>
                <h2 class="text-4xl font-extrabold text-[#143B5D] sm:text-5xl">
                    Fungsi BIKON
                </h2>
            </div>

            <!-- Cards -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

                <!-- CARD 1 -->
                <div class="rounded-[22px] border border-slate-200 bg-white p-5 shadow-sm">
                    <button type="button" class="accordion-toggle w-full text-left" data-target="fungsi-card-1">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-start gap-4">
                                <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-full bg-slate-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#1E2E5A]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 3.75h7.5L19.5 8.75V20.25a.75.75 0 0 1-.75.75H7a2.25 2.25 0 0 1-2.25-2.25V6A2.25 2.25 0 0 1 7 3.75Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 3.75v4.5h4.5" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 10.5h6" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 14.25h6" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18h3.75" />
                                    </svg>
                                </div>

                                <div class="pt-2">
                                    <h3 class="text-2xl font-bold leading-none text-[#143B5D]">
                                        Pengaturan
                                    </h3>
                                    <p class="mt-4 max-w-[220px] text-base leading-8 text-slate-600">
                                        Penetapan kebijakan dan standar dalam bina konstruksi.
                                    </p>
                                </div>
                            </div>

                            <span class="mt-2 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#143B5D]">
                                <svg class="arrow h-4 w-4 rotate-180 text-white transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 15l-7-7-7 7" />
                                </svg>
                            </span>
                        </div>

                    </button>

                    <div id="fungsi-card-1" class="accordion-content pt-5">
                        <ul class="list-disc space-y-2 pl-5 text-slate-600 leading-8">
                            <li>Penyiapan bahan perumusan kebijakan.</li>
                            <li>Penyusunan norma, standar, prosedur, dan kriteria.</li>
                            <li>Penyebarluasan peraturan serta penjaminan mutu pelaksanaan pembinaan jasa konstruksi.</li>
                        </ul>
                    </div>
                </div>

                <!-- CARD 2 -->
                <div class="rounded-[22px] border border-slate-200 bg-white p-5 shadow-sm">
                    <button type="button" class="accordion-toggle w-full text-left" data-target="fungsi-card-2">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-start gap-4">
                                <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-full bg-slate-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#1E2E5A]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 4.5h3A2.25 2.25 0 0 1 15.75 6.75v1.5h-7.5v-1.5A2.25 2.25 0 0 1 10.5 4.5Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 8.25h9A2.25 2.25 0 0 1 18 10.5v7.5a2.25 2.25 0 0 1-2.25 2.25h-9A2.25 2.25 0 0 1 4.5 18v-7.5a2.25 2.25 0 0 1 2.25-2.25Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 12h3.75" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15.75h2.25" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 15l4.5 4.5" />
                                        <circle cx="15" cy="15" r="3.25" />
                                    </svg>
                                </div>

                                <div class="pt-2">
                                    <h3 class="text-2xl font-bold leading-none text-[#143B5D]">
                                        Pengawasan
                                    </h3>
                                    <p class="mt-4 max-w-[220px] text-base leading-8 text-slate-600">
                                        Pengendalian dan evaluasi pelaksanaan konstruksi.
                                    </p>
                                </div>
                            </div>

                            <span class="mt-2 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#143B5D]">
                                <svg class="arrow h-4 w-4 text-white transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 15l-7-7-7 7" />
                                </svg>
                            </span>
                        </div>

                    </button>

                    <div id="fungsi-card-2" class="accordion-content hidden pt-5">
                        <ul class="list-disc space-y-2 pl-5 text-slate-600 leading-8">
                            <li>Monitoring pelaksanaan kegiatan konstruksi.</li>
                            <li>Evaluasi penerapan kebijakan dan program bina konstruksi.</li>
                            <li>Pengendalian mutu pekerjaan dan penyelenggaraan jasa konstruksi.</li>
                        </ul>
                    </div>
                </div>

                <!-- CARD 3 -->
                <div class="rounded-[22px] border border-slate-200 bg-white p-5 shadow-sm">
                    <button type="button" class="accordion-toggle w-full text-left" data-target="fungsi-card-3">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-start gap-4">
                                <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-full bg-slate-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#1E2E5A]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75a5.25 5.25 0 0 0-9 0" />
                                        <circle cx="12" cy="11.25" r="3.75" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 18.75a4.5 4.5 0 0 1 3.188-4.299" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.75 18.75a4.5 4.5 0 0 0-3.188-4.299" />
                                        <circle cx="6.75" cy="12" r="2.25" />
                                        <circle cx="17.25" cy="12" r="2.25" />
                                    </svg>
                                </div>

                                <div class="pt-2">
                                    <h3 class="text-2xl font-bold leading-none text-[#143B5D]">
                                        Pemberdayaan
                                    </h3>
                                    <p class="mt-4 max-w-[220px] text-base leading-8 text-slate-600">
                                        Penguatan kapasitas dan kualitas SDM konstruksi.
                                    </p>
                                </div>
                            </div>

                            <span class="mt-2 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#143B5D]">
                                <svg class="arrow h-4 w-4 text-white transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 15l-7-7-7 7" />
                                </svg>
                            </span>
                        </div>

                    </button>

                    <div id="fungsi-card-3" class="accordion-content hidden pt-5">
                        <ul class="list-disc space-y-2 pl-5 text-slate-600 leading-8">
                            <li>Peningkatan kapasitas sumber daya manusia jasa konstruksi.</li>
                            <li>Pembinaan pelaku usaha dan tenaga kerja konstruksi.</li>
                            <li>Pengembangan sektor konstruksi yang profesional dan berkelanjutan.</li>
                        </ul>
                    </div>
                </div>

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
                    <a href="https://www.bing.com/ck/a?!&&p=432aa34da289f4702a813e1aa85ccc9e1cb0d8849fae8f8a60e03e2485946ddfJmltdHM9MTc3NjcyOTYwMA&ptn=3&ver=2&hsh=4&fclid=275d2fe7-a8fe-689e-13aa-3cb9a9a869a4&psq=facebook+bikon+kaltim&u=a1aHR0cHM6Ly93d3cuZmFjZWJvb2suY29tLzEwMDA3NTcyNTE0NjUwNi8" class="flex h-14 w-14 items-center justify-center rounded-xl bg-white/10 transition hover:bg-white/20" aria-label="Facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M13.5 9H16V6h-2.5C10.9 6 9 7.9 9 10.5V12H7v3h2v6h3v-6h3l.5-3H12v-1.5c0-.9.6-1.5 1.5-1.5Z" />
                        </svg>
                    </a>

                    <a href="https://www.instagram.com/bikon_dpuprperakaltim?igsh=MTZsaXhsOHpjbHJrZQ==" class="flex h-14 w-14 items-center justify-center rounded-xl bg-white/10 transition hover:bg-white/20" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7.75 3h8.5A4.75 4.75 0 0 1 21 7.75v8.5A4.75 4.75 0 0 1 16.25 21h-8.5A4.75 4.75 0 0 1 3 16.25v-8.5A4.75 4.75 0 0 1 7.75 3Zm0 1.5A3.25 3.25 0 0 0 4.5 7.75v8.5a3.25 3.25 0 0 0 3.25 3.25h8.5a3.25 3.25 0 0 0 3.25-3.25v-8.5a3.25 3.25 0 0 0-3.25-3.25h-8.5ZM12 8a4 4 0 1 1 0 8 4 4 0 0 1 0-8Zm0 1.5A2.5 2.5 0 1 0 12 14.5 2.5 2.5 0 0 0 12 9.5Zm4.25-2a1 1 0 1 1 0 2 1 1 0 0 1 0-2Z" />
                        </svg>
                    </a>

                    <a href="https://www.youtube.com/channel/UC65XnBeabEu-xkIYGuRNv6Q" class="flex h-14 w-14 items-center justify-center rounded-xl bg-white/10 transition hover:bg-white/20" aria-label="YouTube">
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

                <!-- <div class="mt-8 inline-block rounded-xl bg-red-600 px-5 py-4 text-white shadow-lg">
                    <div class="space-y-1 text-sm font-semibold leading-6">
                        <div class="flex items-center justify-between gap-8">
                            <span>Online</span>
                            <span>5</span>
                        </div>
                        <div class="flex items-center justify-between gap-8">
                            <span>Vis. today</span>
                            <span>31</span>
                        </div>
                        <div class="flex items-center justify-between gap-8">
                            <span>Visits</span>
                            <span>82 943</span>
                        </div>
                        <div class="flex items-center justify-between gap-8">
                            <span>Pag. today</span>
                            <span>76</span>
                        </div>
                    </div>
                </div> -->
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

                <div class="flex items-center gap-8 text-base text-white/70">
                    <!-- <a href="#" class="transition hover:text-white">Kebijakan Privasi</a>
                    <a href="#" class="transition hover:text-white">Syarat & Ketentuan</a> -->
                </div>
            </div>
        </div>
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggles = document.querySelectorAll('#fungsi-bikon .accordion-toggle');

        toggles.forEach((btn) => {
            btn.addEventListener('click', function() {
                const target = document.getElementById(this.dataset.target);
                const arrow = this.querySelector('.arrow');
                const isHidden = target.classList.contains('hidden');

                document.querySelectorAll('#fungsi-bikon .accordion-content').forEach((item) => {
                    item.classList.add('hidden');
                });

                document.querySelectorAll('#fungsi-bikon .arrow').forEach((item) => {
                    item.classList.remove('rotate-180');
                });

                if (isHidden) {
                    target.classList.remove('hidden');
                    arrow.classList.add('rotate-180');
                }
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.nav-dropdown-btn');

        buttons.forEach((button) => {
            button.addEventListener('click', function(e) {
                e.stopPropagation();

                const dropdownId = this.dataset.dropdown;
                const dropdown = document.getElementById(dropdownId);
                const arrow = this.querySelector('.dropdown-arrow');

                document.querySelectorAll('.nav-dropdown').forEach((item) => {
                    if (item !== dropdown) {
                        item.classList.add('hidden');
                    }
                });

                document.querySelectorAll('.dropdown-arrow').forEach((item) => {
                    if (item !== arrow) {
                        item.classList.remove('rotate-180');
                    }
                });

                dropdown.classList.toggle('hidden');
                arrow.classList.toggle('rotate-180');
            });
        });

        document.querySelectorAll('.nav-dropdown').forEach((dropdown) => {
            dropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });

        document.addEventListener('click', function() {
            document.querySelectorAll('.nav-dropdown').forEach((item) => {
                item.classList.add('hidden');
            });

            document.querySelectorAll('.dropdown-arrow').forEach((item) => {
                item.classList.remove('rotate-180');
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('toggle-about');
        const hiddenItems = document.querySelectorAll('.about-hidden');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                const isHidden = Array.from(hiddenItems).some(item => item.classList.contains('hidden'));

                if (isHidden) {
                    hiddenItems.forEach(item => item.classList.remove('hidden'));
                    toggleBtn.textContent = 'Tampilkan Lebih Sedikit';
                } else {
                    hiddenItems.forEach(item => item.classList.add('hidden'));
                    toggleBtn.textContent = 'Baca Selengkapnya';
                }
            });
        }
    });
</script>