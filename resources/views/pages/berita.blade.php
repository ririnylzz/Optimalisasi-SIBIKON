@extends('layouts.app')

@section('content')
<section class="bg-white py-14 px-6">
    <div class="max-w-6xl mx-auto">

        {{-- Headline --}}
        <div class="mb-16">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-3xl md:text-4xl font-extrabold text-[#21325e]">
                    Headline News
                </h1>

                <select class="border border-[#21325e] text-[#21325e] text-sm rounded-full px-4 py-2 focus:outline-none">
                    <option>Kategori</option>
                    <option>Berita</option>
                    <option>Bikon Nasional</option>
                </select>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Berita Utama --}}
                <div class="lg:col-span-2">
                    <a href="{{ route('detail-berita') }}" class="block overflow-hidden rounded-lg mb-5">
                        <img
                            src="{{ asset('images/berita-utama.jpg') }}"
                            alt="Headline News"
                            class="w-full h-[360px] object-cover transition duration-300 hover:scale-105">
                    </a>

                    <a href="{{ route('detail-berita') }}" class="block group">
                        <h2 class="text-xl font-extrabold text-[#21325e] mb-2 leading-snug transition group-hover:text-[#3a4fac]">
                            Bidang Bina Konstruksi Lakukan Rapat Persiapan Pelatihan dan Sertifikasi Tahun 2026 Bersama Perguruan Tingggi
                        </h2>
                    </a>

                    <div class="flex items-center gap-4 text-xs text-gray-500 mb-3">
                        <span>Admin SIBIKON</span>
                        <span>Februari 11, 2026</span>
                    </div>

                    <p class="text-sm text-gray-600 leading-relaxed">
                        Bidang Bina Konstruksi Dinas PUPR & PERA Provinsi Kaltim melakukan Rapat Koordinasi Perguruan Tinggi Se-Kalimantan Timur, yang dipimpin langsung Kepala Bidang Bidang Bina Konstruksi Sidiq Pranoto Sulistyo, ST., M.Ling, di dampingi Kepala Seksi Pemberdayaan dan Informasi Jasa Konstruksi, Marini, ST, MM.
                    </p>
                </div>

                {{-- Berita Samping --}}
                <div class="space-y-5">

                    {{-- BERITA 1 --}}
                    <div class="grid grid-cols-2 gap-4">
                        <img src="{{ asset('images/berita-1.png') }}"
                            class="w-full h-28 object-cover rounded-md">

                        <div>
                            <p class="text-xs text-[#7282cc] font-semibold mb-1">
                                Berita Populer
                            </p>

                            <h3 class="text-sm font-extrabold text-[#21325e] mb-2">
                                Pembukaan Serentak Kelas Pelatihan Tenaga Kerja Konstruksi Ahli
                            </h3>

                            <div class="text-[10px] text-gray-500">
                                Admin SIBIKON • April 09, 2026
                            </div>
                        </div>
                    </div>

                    {{-- BERITA 2 --}}
                    <div class="grid grid-cols-2 gap-4">
                        <img src="{{ asset('images/berita-2.png') }}"
                            class="w-full h-28 object-cover rounded-md">

                        <div>
                            <p class="text-xs text-[#7282cc] font-semibold mb-1">
                                Berita Populer
                            </p>

                            <h3 class="text-sm font-extrabold text-[#21325e] mb-2">
                                Dari Jawa Ke Kepulauan Riau, BIKON Singgah Untuk Bertukar
                            </h3>

                            <div class="text-[10px] text-gray-500">
                                Admin SIBIKON • April 10, 2026
                            </div>
                        </div>
                    </div>

                    {{-- BERITA 3 --}}
                    <div class="grid grid-cols-2 gap-4">
                        <img src="{{ asset('images/berita-3.png') }}"
                            class="w-full h-28 object-cover rounded-md">

                        <div>
                            <p class="text-xs text-[#7282cc] font-semibold mb-1">
                                Berita Populer
                            </p>

                            <h3 class="text-sm font-extrabold text-[#21325e] mb-2">
                                Pelatihan Dan Sertifikasi Penilai Ahli Kegagalan Bangunan dan TKK
                            </h3>

                            <div class="text-[10px] text-gray-500">
                                Admin SIBIKON • April 12, 2026
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Grid Berita --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">

            {{-- BERITA 1 --}}
            <article class="flex flex-col h-full">
                <img src="{{ asset('images/beritagrid-1.png') }}"
                    class="w-full h-52 object-cover rounded-lg mb-4">

                <h3 class="text-lg font-extrabold text-[#21325e] mb-2 leading-snug">
                    Bidang Bina Konstruksi Lakukan Rapat Persiapan Pelatihan dan Sertifikasi Tahun 2026 Bersama Perguruan Tingggi.
                </h3>

                <div class="text-xs text-gray-500 mb-3">
                    Admin SIBIKON • Februari 11, 2026
                </div>

                <p class="text-sm text-gray-600 flex-grow">
                    Bidang Bina Konstruksi Dinas PUPR & PERA Provinsi Kaltim melakukan Rapat Koordinasi Perguruan Tinggi Se-Kalimantan Timur, yang dipimpin langsung Kepala Bidang Bidang Bina Konstruksi Sidiq Pranoto Sulistyo, ST., M.Ling,
                </p>
            </article>

            {{-- BERITA 2 --}}
            <article class="flex flex-col h-full">
                <img src="{{ asset('images/beritagrid-2.png') }}"
                    class="w-full h-52 object-cover rounded-lg mb-4">

                <h3 class="text-lg font-extrabold text-[#21325e] mb-2 leading-snug">
                    Mahasiswa Kaltim Goes To IKN, Wujudkan Kualitas Mendukung IKN Sebagai Simbol Peradaban Baru Menuju Kaltim Generasi Emas.
                </h3>

                <div class="text-xs text-gray-500 mb-3">
                    Admin SIBIKON • Desember 24, 2025
                </div>

                <p class="text-sm text-gray-600 flex-grow">
                    Dinas Pekerjaan Umum Penataan Ruang dan Perumahan Rakyat (PUPR & PERA) Provinsi Kalimantan Timur dalam hal ini Bidang Bina Konstruksi bekerja sama dengan Persatuan Insinyur Indonesia (PII) Kalimantan Timur
                </p>
            </article>

            {{-- BERITA 3 --}}
            <article class="flex flex-col h-full">
                <img src="{{ asset('images/beritagrid-3.png') }}"
                    class="w-full h-52 object-cover rounded-lg mb-4">

                <h3 class="text-lg font-extrabold text-[#21325e] mb-2 leading-snug">
                    Provinsi Kalimantan Timur Kembali Raih Terbaik 1 Kategori Sub Urusan Jasa Konstruksi Berkinerja Terbaik Sutami Awards
                </h3>

                <div class="text-xs text-gray-500 mb-3">
                    Admin SIBIKON • Desember 11, 2025
                </div>

                <p class="text-sm text-gray-600 flex-grow">
                    Jakarta (1/12), Provinsi Kalimantan Timur melalui Dinas PUPR dan PERA meraih peringkat Terbaik 1 dalam penghargaan Sutami Awards kategori Pemerintah Daerah Provinsi dengan Kinerja Terbaik
                </p>
            </article>

            {{-- BERITA 4 --}}
            <article class="flex flex-col h-full">
                <img src="{{ asset('images/beritagrid-4.png') }}"
                    class="w-full h-52 object-cover rounded-lg mb-4">

                <h3 class="text-lg font-extrabold text-[#21325e] mb-2 leading-snug">
                    Pembukaan Serentak 28 Kelas Pelatihan dan Sertifikasi Tenaga Kerja Konstruksi (TKK) Ahli Tahap I Tahun 2025
                </h3>

                <div class="text-xs text-gray-500 mb-3">
                    Admin SIBIKON • September 21, 2025
                </div>

                <p class="text-sm text-gray-600 flex-grow">
                    Bertempat di Aula Olah Bebaya, Kantor Gubernur Kaltim. Evaluasi dilakukan untuk meningkatkan kualitas program ke depan.
                </p>
            </article>

            {{-- BERITA 5 --}}
            <article class="flex flex-col h-full">
                <img src="{{ asset('images/beritagrid-5.png') }}"
                    class="w-full h-52 object-cover rounded-lg mb-4">

                <h3 class="text-lg font-extrabold text-[#21325e] mb-2 leading-snug">
                    Dinas PUPR & PERA Provinsi Kalimantan Timur Gelar Konsultasi dan Sharing Informasi
                </h3>

                <div class="text-xs text-gray-500 mb-3">
                    Admin SIBIKON • September 17, 2025
                </div>

                <p class="text-sm text-gray-600 flex-grow">
                    Kegiatan bersama Dinas PUPR Provinsi Kalimantan Barat dalam rangka peningkatan kualitas informasi jasa konstruksi.
                </p>
            </article>

            {{-- BERITA 6 --}}
            <article class="flex flex-col h-full">
                <img src="{{ asset('images/beritagrid-6.png') }}"
                    class="w-full h-52 object-cover rounded-lg mb-4">

                <h3 class="text-lg font-extrabold text-[#21325e] mb-2 leading-snug">
                    Bidang Bina Konstruksi Selenggarakan Pembekalan Teknis SBU
                </h3>

                <div class="text-xs text-gray-500 mb-3">
                    Admin SIBIKON • September 8, 2025
                </div>

                <p class="text-sm text-gray-600 flex-grow">
                    Pembekalan dengan tema digitalisasi SBU untuk mempermudah pengguna dalam proses sertifikasi.
                </p>
            </article>
        </div>
    </div>
    </div>
</section>
@endsection

@push('scripts')
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
@endpush