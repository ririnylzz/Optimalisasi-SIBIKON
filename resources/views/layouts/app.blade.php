<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIBIKON</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="font-sans bg-white">
    <!-- Navbar -->
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
                        <p class="text-sm text-white/70">Sistem Bina Konstruksi Provinsi Kalimantan Timur</p>
                    </div>
                </div>

                <!-- menu desktop -->
                <nav class="hidden md:flex items-center gap-10 font-semibold text-white">

                    <a href="{{ route('beranda') }}"
                        class="{{ request()->routeIs('beranda') ? 'text-yellow-400' : 'text-white' }} hover:text-yellow-400 transition">
                        Beranda
                    </a>

                    <div class="relative group nav-dropdown">
                        <button type="button"
                            class="nav-dropdown-button {{ request()->routeIs('tentang-kami', 'struktur', 'sop-renja') ? 'text-yellow-400' : 'text-white' }} flex items-center gap-1 hover:text-yellow-400 transition">
                            Profil
                            <svg class="nav-dropdown-icon w-4 h-4 transition group-hover:rotate-180" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div class="nav-dropdown-menu absolute left-0 top-full z-50 hidden w-72 pt-4 group-hover:block">
                            <div class="border-t-4 border-yellow-400 bg-white shadow-xl">
                                <a href="{{ route('tentang-kami') }}"
                                    class="block px-6 py-4 font-bold text-slate-800 border-b border-slate-200 hover:bg-slate-100">
                                    Tentang Kami
                                </a>

                                <a href="{{ route('struktur') }}"
                                    class="block px-6 py-4 font-bold text-slate-800 border-b border-slate-200 hover:bg-slate-100">
                                    Struktur Organisasi
                                </a>

                                <a href="{{ route('sop-renja') }}"
                                    class="block px-6 py-4 font-bold text-slate-800 hover:bg-slate-100">
                                    SOP & Renja
                                </a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('berita') }}"
                        class="{{ request()->routeIs('berita', 'berita.detail') ? 'text-yellow-400' : 'text-white' }} hover:text-yellow-400 transition">
                        Berita
                    </a>

                    <div class="relative group nav-dropdown">
                        <button type="button"
                            class="nav-dropdown-button {{ request()->routeIs(
            'rakor',
            'sosialisasi',
            'forum',
            'rantai-pasok',
            'tabel-tkk',
            'pelatihan-ahli',
            'pelatihan-sertifikasi-ahli',
            'tertib-usaha'
        ) ? 'text-yellow-400' : 'text-white' }} flex items-center gap-1 hover:text-yellow-400 transition">
                            Fungsi
                            <svg class="nav-dropdown-icon w-4 h-4 transition group-hover:rotate-180" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div class="nav-dropdown-menu absolute left-0 top-full z-50 hidden w-72 pt-4 group-hover:block">
                            <div class="border-t-4 border-yellow-400 bg-white shadow-xl">

                                <a href="{{ route('rakor') }}"
                                    class="block px-6 py-4 font-bold text-slate-800 border-b border-slate-200 hover:bg-slate-100">
                                    Pengaturan
                                </a>

                                <a href="{{ route('tabel-tkk') }}"
                                    class="block px-6 py-4 font-bold text-slate-800 border-b border-slate-200 hover:bg-slate-100">
                                    Pemberdayaan
                                </a>

                                <a href="{{ route('tertib-usaha') }}"
                                    class="block px-6 py-4 font-bold text-slate-800 hover:bg-slate-100">
                                    Pengawasan
                                </a>

                            </div>
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
                    <a href="#">Fungsi</a>
                    <a href="{{ route('kontak') }}">Kontak</a>
                    <a href="{{ route('login') }}" class="inline-flex w-fit items-center rounded-xl bg-yellow-400 px-6 py-3 font-bold text-slate-900">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="w-full overflow-x-hidden">
        @yield('content')
    </div>

    <!-- Footer -->
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
            const dropdowns = document.querySelectorAll('.nav-dropdown');

            dropdowns.forEach(function(dropdown) {
                const button = dropdown.querySelector('.nav-dropdown-button');
                const menu = dropdown.querySelector('.nav-dropdown-menu');
                const icon = dropdown.querySelector('.nav-dropdown-icon');

                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    event.stopPropagation();

                    dropdowns.forEach(function(item) {
                        if (item !== dropdown) {
                            const otherMenu = item.querySelector('.nav-dropdown-menu');
                            const otherIcon = item.querySelector('.nav-dropdown-icon');

                            otherMenu.classList.add('hidden');
                            otherIcon.classList.remove('rotate-180');
                        }
                    });

                    menu.classList.toggle('hidden');
                    icon.classList.toggle('rotate-180');
                });

                menu.addEventListener('click', function(event) {
                    event.stopPropagation();
                });
            });

            document.addEventListener('click', function() {
                dropdowns.forEach(function(dropdown) {
                    const menu = dropdown.querySelector('.nav-dropdown-menu');
                    const icon = dropdown.querySelector('.nav-dropdown-icon');

                    menu.classList.add('hidden');
                    icon.classList.remove('rotate-180');
                });
            });
        });
    </script>

    @stack('scripts')
</body>

</html>