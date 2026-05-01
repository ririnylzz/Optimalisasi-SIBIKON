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
                            <a href="{{ route('profil') }}" class="block px-6 py-4 font-bold text-slate-800 border-b border-slate-200 hover:bg-slate-100">
                                Tentang Kami
                            </a>
                            <a href="{{ route('struktur') }}" class="block px-6 py-4 font-bold text-slate-800 border-b border-slate-200 hover:bg-slate-100">
                                Struktur Organisasi
                            </a>
                            <a href="#" class="block px-6 py-4 font-bold text-slate-800 hover:bg-slate-100">
                                SOP & Renja
                            </a>
                        </div>
                    </div>

                    <a href="#"
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
                    <a href="{{ route('profil') }}">Profil</a>
                    <a href="#">Berita</a>
                    <a href="#">Fungsi</a>
                    <a href="{{ route('kontak') }}">Kontak</a>
                    <a href="{{ route('login') }}" class="inline-flex w-fit items-center rounded-xl bg-yellow-400 px-6 py-3 font-bold text-slate-900">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </header>


    <section class="bg-white py-16 px-6">
        <div class="max-w-6xl mx-auto">

            {{-- Header --}}
            <div class="text-center mb-12">
                <span class="inline-block bg-[#f1d00a]/60 text-[#21325e] text-xs font-semibold px-4 py-2 rounded-full mb-4">
                    Hubungi Kami
                </span>

                <h1 class="text-3xl md:text-4xl font-extrabold text-[#21325e] mb-3">
                    Kontak & Lokasi
                </h1>

                <p class="text-[#7282cc] text-sm">
                    Silakan hubungi kami untuk informasi lebih lanjut mengenai layanan SIBIKON
                </p>
            </div>

            {{-- Kontak dan Peta --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-stretch mb-16">

                {{-- Peta --}}
                <div class="h-96 rounded-2xl bg-[#c5cae9]/50 flex items-center justify-center">
                    <div class="text-center text-[#21325e]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 11.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 9c0 7.5-7.5 12-7.5 12S4.5 16.5 4.5 9a7.5 7.5 0 1115 0z" />
                        </svg>
                        <p class="text-xl font-semibold">Peta Lokasi</p>
                    </div>
                </div>

                {{-- Informasi Kontak --}}
                <div class="h-96 flex flex-col justify-center">
                    <h2 class="text-3xl font-extrabold text-[#21325e] mb-10">
                        Informasi Kontak
                    </h2>

                    <div class="space-y-8">

                        {{-- Alamat --}}
                        <div class="flex gap-5 items-start">
                            <div class="w-16 h-16 rounded-xl bg-[#21325e] text-white flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none"
                                    viewBox="0 0 24 24" stroke="#f1d00a" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 11.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 9c0 7.5-7.5 12-7.5 12S4.5 16.5 4.5 9a7.5 7.5 0 1115 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-[#21325e] text-2xl mb-1">Alamat</h3>
                                <p class="text-lg text-[#21325e]/70 leading-relaxed">
                                    Jalan. Tengkawang No.1, Samarinda
                                </p>
                            </div>
                        </div>

                        {{-- Telepon --}}
                        <div class="flex gap-5 items-start">
                            <div class="w-16 h-16 rounded-xl bg-[#21325e] text-white flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none"
                                    viewBox="0 0 24 24" stroke="#f1d00a" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 5a2 2 0 012-2h3.28a2 2 0 011.94 1.515l.57 2.28a2 2 0 01-.45 1.91l-1.27 1.27a16 16 0 006.36 6.36l1.27-1.27a2 2 0 011.91-.45l2.28.57A2 2 0 0121 15.72V19a2 2 0 01-2 2h-1C9.163 21 3 14.837 3 7V5z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-[#21325e] text-2xl mb-1">Telepon</h3>
                                <p class="text-lg text-[#21325e]/70">(+0541) ......</p>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="flex gap-5 items-start">
                            <div class="w-16 h-16 rounded-xl bg-[#21325e] text-white flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none"
                                    viewBox="0 0 24 24" stroke="#f1d00a" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-[#21325e] text-2xl mb-1">Email</h3>
                                <p class="text-lg text-[#21325e]/70">bikon.kaltim@gmail.com</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            {{-- Form Kotak Saran --}}
            <div class="w-full bg-white rounded-[28px] shadow-xl border border-[#c5cae9]/50 p-8 md:p-10">
                <h2 class="text-2xl font-extrabold text-[#21325e] mb-4">
                    Kotak saran
                </h2>
                
                <p class="text-m text-[#21325e]/70 mb-8">
                    Berikan Masukan dan Saran Anda terkait Kegiatan yang dilaksanakan oleh Bidang Bina Konstruksi Dinas Pekerjaan Umum Penataan Ruang dan Perumahaan Rakyat Provinsi Kalimantan Timur.
                </p>

                <form action="#" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-base font-bold text-[#21325e] mb-3">
                                Nama Lengkap
                            </label>
                            <input
                                type="text"
                                name="nama"
                                placeholder="Masukkan nama lengkap"
                                class="w-full h-14 rounded-lg border border-[#c5cae9] px-5 text-base focus:outline-none focus:border-[#3a4fac] focus:ring-4 focus:ring-[#7282cc]/20">
                        </div>

                        <div>
                            <label class="block text-base font-bold text-[#21325e] mb-3">
                                Email
                            </label>
                            <input
                                type="email"
                                name="email"
                                placeholder="nama@email.com"
                                class="w-full h-14 rounded-lg border border-[#c5cae9] px-5 text-base focus:outline-none focus:border-[#3a4fac] focus:ring-4 focus:ring-[#7282cc]/20">
                        </div>
                    </div>

                    <div>
                        <label class="block text-base font-bold text-[#21325e] mb-3">
                            Subjek
                        </label>
                        <input
                            type="text"
                            name="subjek"
                            placeholder="Subjek pesan"
                            class="w-full h-14 rounded-lg border border-[#c5cae9] px-5 text-base focus:outline-none focus:border-[#3a4fac] focus:ring-4 focus:ring-[#7282cc]/20">
                    </div>

                    <div>
                        <label class="block text-base font-bold text-[#21325e] mb-3">
                            Pesan
                        </label>
                        <textarea
                            name="pesan"
                            rows="6"
                            placeholder="Tulis pesan Anda di sini..."
                            class="w-full rounded-lg border border-[#c5cae9] px-5 py-4 text-base resize-none focus:outline-none focus:border-[#3a4fac] focus:ring-4 focus:ring-[#7282cc]/20"></textarea>
                    </div>

                    <button
                        type="submit"
                        class="w-full h-14 rounded-lg bg-[#21325e] text-white text-lg font-bold flex items-center justify-center gap-3 hover:bg-[#3a4fac] transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.768 59.768 0 013.27 20.876L6 12zm0 0h7.5" />
                        </svg>
                        Kirim Pesan
                    </button>
                </form>
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