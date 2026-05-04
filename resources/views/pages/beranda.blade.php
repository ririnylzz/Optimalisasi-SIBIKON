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

                    <div class="relative group">
                        <button type="button"
                            class="{{ request()->routeIs('profil') ? 'text-yellow-400' : 'text-white' }} flex items-center gap-1 hover:text-yellow-400 transition">
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
                            class="{{ request()->routeIs('fungsi') ? 'text-yellow-400' : 'text-white' }} flex items-center gap-1 hover:text-yellow-400 transition">
                            Fungsi
                            <svg class="w-4 h-4 transition group-hover:rotate-180" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div class="absolute left-0 top-full z-50 mt-4 hidden w-64 border-t-4 border-yellow-400 bg-white shadow-xl group-hover:block">
                            <a href="#" class="block px-6 py-4 font-bold text-slate-800 border-b border-slate-200 hover:bg-slate-100">
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
                    <a href="#">Fungsi</a>
                    <a href="{{ route('kontak') }}">Kontak</a>
                    <a href="{{ route('login') }}" class="inline-flex w-fit items-center rounded-xl bg-yellow-400 px-6 py-3 font-bold text-slate-900">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- hero -->
    <section class="relative isolate min-h-[calc(100vh-132px)] overflow-hidden">
        <!-- background image -->
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
            style="background-image: url('{{ asset('images/gedung-dinas-PUPR.jpg') }}');">
        </div>

        <!-- dark overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#0E224A]/90 via-[#1A3568]/72 to-[#243B78]/35"></div>

        <!-- soft white mist -->
        <div class="absolute inset-0 bg-white/10 backdrop-blur-[2px]"></div>

        <!-- decorative accent -->
        <div class="absolute -left-24 top-20 h-72 w-72 rounded-full bg-yellow-300/10 blur-3xl"></div>
        <div class="absolute right-0 bottom-0 h-80 w-80 rounded-full bg-blue-200/10 blur-3xl"></div>

        <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 lg:pt-24 pb-24">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="max-w-3xl">

                    <h2 class="mt-6 text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-[1.02] tracking-tight text-white">
                        Dinas Pekerjaan Umum Penataan Ruang Dan
                        <span class="block text-yellow-300">Perumahan Rakyat</span>
                    </h2>

                    <p class="mt-8 max-w-2xl text-lg sm:text-xl text-slate-200 leading-relaxed">
                        Platform digital terpadu untuk pengelolaan, pembinaan, dan pengawasan jasa konstruksi
                        di seluruh Indonesia secara lebih modern, terstruktur, dan profesional.
                    </p>
    </section>

    <!-- LAYANAN -->
    <section id="layanan" class="bg-[#F3F5FC] py-20 lg:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">

            <!-- Heading -->
            <div class="mb-14 text-center">
                <h2 class="text-4xl font-extrabold text-[#111827] sm:text-5xl">
                    Layanan
                </h2>
                <div class="mx-auto mt-4 h-1.5 w-44 rounded-full bg-[#0B5CAD]"></div>
            </div>

            <!-- Cards -->
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">

                <!-- 1 -->
                <div class="rounded-[32px] bg-white p-5 text-center shadow-xl shadow-slate-300/40">
                    <img src="{{ asset('images/layanan-1.png') }}" alt="Pengguna Jasa"
                        class="mx-auto h-44 w-44 object-contain">
                    <h3 class="mt-6 text-xl font-medium text-slate-900">
                        Pengguna Jasa
                    </h3>
                </div>

                <!-- 2 -->
                <div class="rounded-[32px] bg-white p-5 text-center shadow-xl shadow-slate-300/40">
                    <img src="{{ asset('images/layanan-2.png') }}" alt="Perguruan Tinggi / Pakar"
                        class="mx-auto h-44 w-44 object-contain">
                    <h3 class="mt-6 text-xl font-medium text-slate-900">
                        Perguruan Tinggi / Pakar
                    </h3>
                </div>

                <!-- 3 -->
                <div class="rounded-[32px] bg-white p-5 text-center shadow-xl shadow-slate-300/40">
                    <img src="{{ asset('images/layanan-3.png') }}" alt="Lembaga Pendidikan dan Pelatihan Kerja Konstruksi"
                        class="mx-auto h-44 w-44 object-contain">
                    <h3 class="mt-6 text-xl font-medium text-slate-900">
                        Lembaga Pendidikan dan Pelatihan Kerja Konstruksi
                    </h3>
                </div>

                <!-- 4 -->
                <div class="layanan-hidden hidden xrounded-[32px] bg-white p-5 text-center shadow-xl shadow-slate-300/40">
                    <img src="{{ asset('images/layanan-4.png') }}" alt="Pemerhati Konstruksi"
                        class="mx-auto h-44 w-44 object-contain">
                    <h3 class="mt-6 text-xl font-medium text-slate-900">
                        Pemerhati Konstruksi
                    </h3>
                </div>

                <!-- hidden items -->
                <div class="layanan-hidden hidden rounded-[32px] bg-white p-5 text-center shadow-xl shadow-slate-300/40">
                    <img src="{{ asset('images/layanan-5.png') }}" alt="Asosiasi Perusahaan"
                        class="mx-auto h-44 w-44 object-contain">
                    <h3 class="mt-6 text-xl font-medium text-slate-900">
                        Asosiasi Perusahaan
                    </h3>
                </div>

                <div class="layanan-hidden hidden rounded-[32px] bg-white p-5 text-center shadow-xl shadow-slate-300/40">
                    <img src="{{ asset('images/layanan-6.png') }}" alt="Asosiasi Profesi"
                        class="mx-auto h-44 w-44 object-contain">
                    <h3 class="mt-6 text-xl font-medium text-slate-900">
                        Asosiasi Profesi
                    </h3>
                </div>

                <div class="layanan-hidden hidden rounded-[32px] bg-white p-5 text-center shadow-xl shadow-slate-300/40">
                    <img src="{{ asset('images/layanan-7.png') }}" alt="Lembaga Sertifikasi Jasa Konstruksi"
                        class="mx-auto h-44 w-44 object-contain">
                    <h3 class="mt-6 text-xl font-medium text-slate-900">
                        Lembaga Sertifikasi Jasa Konstruksi
                    </h3>
                </div>

                <div class="layanan-hidden hidden rounded-[32px] bg-white p-5 text-center shadow-xl shadow-slate-300/40">
                    <img src="{{ asset('images/layanan-8.png') }}" alt="Pemanfaat Produk Jasa Konstruksi"
                        class="mx-auto h-44 w-44 object-contain">
                    <h3 class="mt-6 text-xl font-medium text-slate-900">
                        Pemanfaat Produk Jasa Konstruksi
                    </h3>
                </div>

                <div class="layanan-hidden hidden rounded-[32px] bg-white p-5 text-center shadow-xl shadow-slate-300/40">
                    <img src="{{ asset('images/layanan-9.png') }}" alt="Penyedia Jasa"
                        class="mx-auto h-44 w-44 object-contain">
                    <h3 class="mt-6 text-xl font-medium text-slate-900">
                        Penyedia Jasa
                    </h3>
                </div>

                <div class="layanan-hidden hidden rounded-[32px] bg-white p-5 text-center shadow-xl shadow-slate-300/40">
                    <img src="{{ asset('images/layanan-10.png') }}" alt="Tenaga Kerja Konstruksi"
                        class="mx-auto h-44 w-44 object-contain">
                    <h3 class="mt-6 text-xl font-medium text-slate-900">
                        Tenaga Kerja Konstruksi
                    </h3>
                </div>

                <div class="layanan-hidden hidden rounded-[32px] bg-white p-5 text-center shadow-xl shadow-slate-300/40">
                    <img src="{{ asset('images/layanan-11.png') }}" alt="Pelaku Rantai Pasok"
                        class="mx-auto h-44 w-44 object-contain">
                    <h3 class="mt-6 text-xl font-medium text-slate-900">
                        Pelaku Rantai Pasok
                    </h3>
                </div>
            </div>

            <!-- Button -->
            <div class="mt-12 text-center">
                <button id="toggle-layanan" type="button"
                    class="inline-flex items-center justify-center rounded-full bg-[#143B5D] px-8 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-[#0F2E49]">
                    Lihat Selengkapnya
                </button>
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
        const toggleBtn = document.getElementById('toggle-layanan');
        const hiddenItems = document.querySelectorAll('.layanan-hidden');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                const isHidden = Array.from(hiddenItems).some(item => item.classList.contains('hidden'));

                if (isHidden) {
                    hiddenItems.forEach(item => item.classList.remove('hidden'));
                    toggleBtn.textContent = 'Tampilkan Lebih Sedikit';
                } else {
                    hiddenItems.forEach(item => item.classList.add('hidden'));
                    toggleBtn.textContent = 'Lihat Selengkapnya';
                }
            });
        }
    });
</script>