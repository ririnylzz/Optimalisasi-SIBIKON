<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIBIKON</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo-sibikon.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-sibikon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-sibikon.png') }}">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="font-sans bg-white">
    <!-- Navbar -->
    <header class="fixed left-0 top-0 z-[999] w-full border-b border-white/10 bg-[#142B67] shadow-[0_8px_24px_rgba(15,23,42,0.14)]">

        {{-- Top Bar Logo Instansi --}}
        <div class="hidden bg-white md:block">
            <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-4">
                    <img
                        src="{{ asset('images/logo-dinas.png') }}"
                        alt="Dinas PUPRPERA Provinsi Kalimantan Timur"
                        class="h-12 w-auto object-contain">

                    <img
                        src="{{ asset('images/logo-gubernur.png') }}"
                        alt="Logo Gubernur Kalimantan Timur"
                        class="h-12 w-auto object-contain">
                </div>

                <img
                    src="{{ asset('images/logo-berakhlak.png') }}"
                    alt="BerAKHLAK"
                    class="h-11 w-auto object-contain">
            </div>
        </div>

        {{-- Main Navbar --}}
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-5">

                {{-- Logo --}}
                <a href="{{ route('beranda') }}" class="flex items-center gap-4">
                    <div>
                        <h1 class="text-3xl font-extrabold leading-none tracking-tight text-white">
                            SIBIKON
                        </h1>
                        <p class="text-sm text-white/70">
                            Sistem Informasi Bina Konstruksi Provinsi Kalimantan Timur
                        </p>
                    </div>
                </a>

                {{-- Menu Desktop --}}
                <nav class="hidden items-center gap-10 font-semibold text-white md:flex">

                    <a href="{{ route('beranda') }}"
                        class="{{ request()->routeIs('beranda') ? 'text-yellow-400' : 'text-white' }} transition hover:text-yellow-400">
                        Beranda
                    </a>

                    {{-- Profil --}}
                    <div class="relative group nav-dropdown">
                        <button type="button"
                            class="nav-dropdown-button {{ request()->routeIs('tentang-kami', 'struktur', 'sop-renja') ? 'text-yellow-400' : 'text-white' }} flex items-center gap-1 transition hover:text-yellow-400">
                            Profil
                            <svg class="nav-dropdown-icon h-4 w-4 transition group-hover:rotate-180" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div class="nav-dropdown-menu absolute left-0 top-full z-50 hidden w-72 pt-4 group-hover:block">
                            <div class="border-t-4 border-yellow-400 bg-white shadow-xl">
                                <a href="{{ route('tentang-kami') }}"
                                    class="block border-b border-slate-200 px-6 py-4 font-bold text-slate-800 hover:bg-slate-100">
                                    Tentang Kami
                                </a>

                                <a href="{{ route('struktur') }}"
                                    class="block border-b border-slate-200 px-6 py-4 font-bold text-slate-800 hover:bg-slate-100">
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
                        class="{{ request()->routeIs('berita', 'berita.detail') ? 'text-yellow-400' : 'text-white' }} transition hover:text-yellow-400">
                        Berita
                    </a>

                    {{-- Fungsi --}}
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
                        ) ? 'text-yellow-400' : 'text-white' }} flex items-center gap-1 transition hover:text-yellow-400">
                            Fungsi
                            <svg class="nav-dropdown-icon h-4 w-4 transition group-hover:rotate-180" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div class="nav-dropdown-menu absolute left-0 top-full z-50 hidden w-72 pt-4 group-hover:block">
                            <div class="border-t-4 border-yellow-400 bg-white shadow-xl">
                                <a href="{{ route('rakor') }}"
                                    class="block border-b border-slate-200 px-6 py-4 font-bold text-slate-800 hover:bg-slate-100">
                                    Pengaturan
                                </a>

                                <a href="{{ route('tabel-tkk') }}"
                                    class="block border-b border-slate-200 px-6 py-4 font-bold text-slate-800 hover:bg-slate-100">
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
                        class="{{ request()->routeIs('kontak') ? 'text-yellow-400' : 'text-white' }} transition hover:text-yellow-400">
                        Kontak
                    </a>
                </nav>

                {{-- Login Button --}}
                <div class="hidden md:block">
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center rounded-2xl bg-yellow-400 px-7 py-3 font-bold text-slate-900 shadow-lg shadow-yellow-400/20 transition hover:bg-yellow-300">
                        Login
                    </a>
                </div>

                {{-- Mobile Toggle --}}
                <button id="mobile-menu-button"
                    class="inline-flex h-12 w-12 items-center justify-center rounded-xl border border-white/20 bg-white/10 text-white md:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="absolute left-0 top-full hidden w-full border-t border-white/10 bg-[#21325e] shadow-xl md:hidden">
            <ul class="flex flex-col gap-2 px-6 py-6">

                <li>
                    <a href="{{ route('beranda') }}"
                        class="{{ request()->routeIs('beranda') ? 'text-yellow-400' : 'text-white' }} block py-2 font-semibold hover:text-yellow-400">
                        Beranda
                    </a>
                </li>

                {{-- Mobile Profil --}}
                <li>
                    <button type="button"
                        class="mobile-dropdown-button flex w-full items-center justify-between py-2 font-semibold text-white hover:text-yellow-400"
                        data-target="mobile-profil-dropdown">
                        Profil
                        <svg class="mobile-dropdown-icon h-4 w-4 transition" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <ul id="mobile-profil-dropdown" class="hidden space-y-2 pl-4 pt-2">
                        <li>
                            <a href="{{ route('tentang-kami') }}" class="block py-1 text-sm font-semibold text-white/80 hover:text-yellow-400">
                                Tentang Kami
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('struktur') }}" class="block py-1 text-sm font-semibold text-white/80 hover:text-yellow-400">
                                Struktur Organisasi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('sop-renja') }}" class="block py-1 text-sm font-semibold text-white/80 hover:text-yellow-400">
                                SOP & Renja
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('berita') }}"
                        class="{{ request()->routeIs('berita', 'berita.detail') ? 'text-yellow-400' : 'text-white' }} block py-2 font-semibold hover:text-yellow-400">
                        Berita
                    </a>
                </li>

                {{-- Mobile Fungsi --}}
                <li>
                    <button type="button"
                        class="mobile-dropdown-button flex w-full items-center justify-between py-2 font-semibold text-white hover:text-yellow-400"
                        data-target="mobile-fungsi-dropdown">
                        Fungsi
                        <svg class="mobile-dropdown-icon h-4 w-4 transition" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <ul id="mobile-fungsi-dropdown" class="hidden space-y-2 pl-4 pt-2">
                        <li>
                            <a href="{{ route('rakor') }}" class="block py-1 text-sm font-semibold text-white/80 hover:text-yellow-400">
                                Pengaturan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('tabel-tkk') }}" class="block py-1 text-sm font-semibold text-white/80 hover:text-yellow-400">
                                Pemberdayaan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('tertib-usaha') }}" class="block py-1 text-sm font-semibold text-white/80 hover:text-yellow-400">
                                Pengawasan
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('kontak') }}"
                        class="{{ request()->routeIs('kontak') ? 'text-yellow-400' : 'text-white' }} block py-2 font-semibold hover:text-yellow-400">
                        Kontak
                    </a>
                </li>

                <li class="pt-3">
                    <a href="{{ route('login') }}"
                        class="inline-flex w-full items-center justify-center rounded-xl bg-yellow-400 px-6 py-3 font-bold text-slate-900 transition hover:bg-yellow-300">
                        Login
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <div class="w-full overflow-x-hidden pt-[90px] md:pt-[160px]">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="relative overflow-hidden bg-[#142B67] text-white">
        {{-- Logo SIBIKON samar seperti sidebar admin --}}
        <div class="pointer-events-none absolute bottom-0 right-0 opacity-[0.14]">
            <img
                src="{{ asset('images/logo-sibikon.png') }}"
                alt="Decorative Logo"
                class="w-[2600px] translate-x-20 translate-y-20 md:w-[340px] lg:w-[420px]">
        </div>

        {{-- Aksen gradasi halus --}}
        <div class="pointer-events-none absolute inset-0 bg-gradient-to-br from-white/[0.03] via-transparent to-black/[0.08]"></div>

        <div class="relative z-10 mx-auto max-w-7xl px-6 py-10 lg:px-8">
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-4">

                {{-- Kolom 1 --}}
                <div>
                    <div class="mb-6 flex items-center gap-4">
                        <div class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-white/10 ring-1 ring-white/10">
                            <img
                                src="{{ asset('images/logo-sibikon.png') }}"
                                alt="Logo SIBIKON"
                                class="h-14 w-14 object-contain">
                        </div>

                        <div>
                            <h3 class="text-2xl font-extrabold leading-none tracking-tight text-white">
                                SIBIKON
                            </h3>
                            <p class="mt-1 text-base text-white/70">
                                Sistem Informasi Bina Konstruksi
                            </p>
                        </div>
                    </div>

                    <p class="max-w-md text-base leading-7 text-white/75">
                        Bidang Bina Konstruksi Dinas Pekerjaan Umum Penataan Ruang dan Perumahan Rakyat Provinsi Kalimantan Timur.
                    </p>

                    <div class="mt-5 flex items-center gap-4">
                        <a href="https://www.bing.com/ck/a?!&&p=432aa34da289f4702a813e1aa85ccc9e1cb0d8849fae8f8a60e03e2485946ddfJmltdHM9MTc3NjcyOTYwMA&ptn=3&ver=2&hsh=4&fclid=275d2fe7-a8fe-689e-13aa-3cb9a9a869a4&psq=facebook+bikon+kaltim&u=a1aHR0cHM6Ly93d3cuZmFjZWJvb2suY29tLzEwMDA3NTcyNTE0NjUwNi8"
                            class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/10 ring-1 ring-white/10 transition hover:bg-white/15"
                            aria-label="Facebook">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M13.5 9H16V6h-2.5C10.9 6 9 7.9 9 10.5V12H7v3h2v6h3v-6h3l.5-3H12v-1.5c0-.9.6-1.5 1.5-1.5Z" />
                            </svg>
                        </a>

                        <a href="https://www.instagram.com/bikon_dpuprperakaltim?igsh=MTZsaXhsOHpjbHJrZQ=="
                            class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/10 ring-1 ring-white/10 transition hover:bg-white/15"
                            aria-label="Instagram">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M7.75 3h8.5A4.75 4.75 0 0 1 21 7.75v8.5A4.75 4.75 0 0 1 16.25 21h-8.5A4.75 4.75 0 0 1 3 16.25v-8.5A4.75 4.75 0 0 1 7.75 3Zm0 1.5A3.25 3.25 0 0 0 4.5 7.75v8.5a3.25 3.25 0 0 0 3.25 3.25h8.5a3.25 3.25 0 0 0 3.25-3.25v-8.5a3.25 3.25 0 0 0-3.25-3.25h-8.5ZM12 8a4 4 0 1 1 0 8 4 4 0 0 1 0-8Zm0 1.5A2.5 2.5 0 1 0 12 14.5 2.5 2.5 0 0 0 12 9.5Zm4.25-2a1 1 0 1 1 0 2 1 1 0 0 1 0-2Z" />
                            </svg>
                        </a>

                        <a href="https://www.youtube.com/channel/UC65XnBeabEu-xkIYGuRNv6Q"
                            class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/10 ring-1 ring-white/10 transition hover:bg-white/15"
                            aria-label="YouTube">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M21.6 7.2a2.99 2.99 0 0 0-2.1-2.1C17.7 4.5 12 4.5 12 4.5s-5.7 0-7.5.6A2.99 2.99 0 0 0 2.4 7.2 31.1 31.1 0 0 0 1.8 12a31.1 31.1 0 0 0 .6 4.8 2.99 2.99 0 0 0 2.1 2.1c1.8.6 7.5.6 7.5.6s5.7 0 7.5-.6a2.99 2.99 0 0 0 2.1-2.1 31.1 31.1 0 0 0 .6-4.8 31.1 31.1 0 0 0-.6-4.8ZM10 15.5v-7l6 3.5-6 3.5Z" />
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Kolom 2 --}}
                <div>
                    <h4 class="text-xl font-extrabold text-white">
                        Jam Pelayanan
                    </h4>

                    <ul class="mt-5 space-y-4 text-base text-white/75">
                        <li class="flex flex-col gap-2">
                            <span class="font-bold text-white">Senin - Kamis</span>
                            <span>09:00 - 15:00 WITA</span>
                        </li>

                        <li class="flex flex-col gap-2">
                            <span class="font-bold text-white">Jum'at</span>
                            <span>09:00 - 10:30 WITA</span>
                        </li>
                    </ul>
                </div>

                {{-- Kolom 3 --}}
                <div>
                    <h4 class="text-xl font-extrabold text-white">
                        Statistik Pengunjung
                    </h4>

                    <div class="mt-5 space-y-4 text-base text-white/75">
                        <div class="flex items-center justify-between gap-6 border-b border-white/10 pb-3">
                            <span>Online</span>
                            <span class="font-bold text-white">0</span>
                        </div>

                        <div class="flex items-center justify-between gap-6 border-b border-white/10 pb-3">
                            <span>Hari Ini</span>
                            <span class="font-bold text-white">0</span>
                        </div>

                        <div class="flex items-center justify-between gap-6 border-b border-white/10 pb-3">
                            <span>Total</span>
                            <span class="font-bold text-white">0</span>
                        </div>
                    </div>
                </div>

                {{-- Kolom 4 --}}
                <div>
                    <h4 class="text-xl font-extrabold text-white">
                        Link Terkait
                    </h4>

                    <ul class="mt-5 divide-y divide-white/10 text-base text-white/75">
                        <li class="py-3">
                            <a href="https://www.kaltimprov.go.id/"
                                class="flex items-start gap-4 transition hover:text-white">
                                <span class="mt-1 text-white/60">›</span>
                                <span>Website Provinsi Kalimantan Timur</span>
                            </a>
                        </li>

                        <li class="py-3">
                            <a href="https://dpupr.kaltimprov.go.id/"
                                class="flex items-start gap-4 transition hover:text-white">
                                <span class="mt-1 text-white/60">›</span>
                                <span>Website Dinas PUPRPERA Prov. Kaltim</span>
                            </a>
                        </li>

                        <li class="py-3">
                            <a href="https://perizinan.pu.go.id/portal/"
                                class="flex items-start gap-4 transition hover:text-white">
                                <span class="mt-1 text-white/60">›</span>
                                <span>Portal Perizinan PU</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Copyright --}}
            <div class="mt-8 border-t border-white/10 pt-8">
                <a
                    href="https://linktr.ee/dev_optimalisasi_sibikon"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="text-sm text-white/65 hover:text-white"
                >
                    Copyright © 2026, Developed by Project PKL Sistem Informasi 23 Universitas Mulawarman Tahun 2026. All rights reserved.
                </a>
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

    <script>
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        // Toggle menu utama mobile
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });

        // Dropdown mobile
        const mobileDropdownButtons = document.querySelectorAll('.mobile-dropdown-button');

        mobileDropdownButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.dataset.target;
                const dropdown = document.getElementById(targetId);
                const icon = this.querySelector('.mobile-dropdown-icon');

                dropdown.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
            });
        });

        // Tutup menu jika klik luar
        document.addEventListener('click', function(e) {
            if (
                !mobileMenu.contains(e.target) &&
                !mobileMenuButton.contains(e.target)
            ) {
                mobileMenu.classList.add('hidden');

                document.querySelectorAll('[id^="mobile-"][id$="-dropdown"]').forEach(dropdown => {
                    dropdown.classList.add('hidden');
                });

                document.querySelectorAll('.mobile-dropdown-icon').forEach(icon => {
                    icon.classList.remove('rotate-180');
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>