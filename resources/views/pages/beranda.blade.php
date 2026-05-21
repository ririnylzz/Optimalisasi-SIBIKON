@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
@endpush

@section('content')
{{-- HERO SECTION --}}
<section class="relative min-h-[500px] overflow-hidden bg-[#243B78]">

    {{-- Background Gambar Gedung --}}
    <img
        src="{{ asset('images/gedung-dinas-PUPR.jpg') }}"
        alt="Gedung Dinas PUPRPERA Kalimantan Timur"
        class="absolute inset-0 h-full w-full object-cover">

    {{-- Overlay --}}
    <div class="absolute inset-0 bg-[#16294a]/75"></div>

    {{-- Konten Hero --}}
    <div class="relative z-10 mx-auto flex min-h-[500px] max-w-7xl items-center px-6 py-16 lg:px-8">
        <div class="grid w-full grid-cols-1 items-center gap-10 lg:grid-cols-2">

            {{-- Teks --}}
            <div>
                <h1 class="max-w-2xl text-4xl font-extrabold leading-tight text-white md:text-5xl lg:text-6xl">
                    Dinas Pekerjaan<br>
                    Umum Penataan<br>
                    Ruang Dan<br>
                    <span class="text-yellow-400">Perumahan Rakyat</span>
                </h1>

                <p class="mt-8 max-w-2xl text-lg leading-8 text-white/85 md:text-xl">
                    Platform digital terpadu untuk pengelolaan, pembinaan, dan
                    pengawasan jasa konstruksi di seluruh Indonesia secara lebih
                    modern, terstruktur, dan profesional.
                </p>
            </div>

            {{-- Logo Hero Slider --}}
            <div class="hidden justify-center lg:flex">
                <div class="relative h-[360px] w-[360px]">

                    {{-- Logo 1 --}}
                    <img
                        src="{{ asset('images/logo-sibikon.png') }}"
                        alt="Logo SIBIKON"
                        class="hero-logo absolute inset-0 m-auto w-[330px] max-w-full drop-shadow-2xl opacity-100">

                    {{-- Logo 2 --}}
                    <img
                        src="{{ asset('images/logo-kaltim.png') }}"
                        alt="Logo Kalimantan Timur"
                        class="hero-logo absolute inset-0 m-auto w-[250px] scale-110 max-w-full drop-shadow-2xl opacity-0">

                </div>
            </div>

        </div>
    </div>
</section>

{{-- LAYANAN SECTION --}}
<section class="px-4 py-20 md:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">

        {{-- Judul --}}
        <div class="mb-16 text-center">
            <h2 class="text-5xl font-extrabold text-[#143B5D] md:text-6xl">
                Layanan
            </h2>

            <span class="mx-auto mt-6 block h-1.5 w-48 rounded-full bg-[#f1d00a]"></span>
        </div>

        @php
        $layanan = [
        [
        'title' => 'Pengguna Jasa',
        'image' => 'images/layanan-1.png',
        ],
        [
        'title' => 'Perguruan Tinggi / Pakar',
        'image' => 'images/layanan-2.png',
        ],
        [
        'title' => 'Lembaga Pendidikan dan Pelatihan Kerja Konstruksi',
        'image' => 'images/layanan-3.png',
        ],
        [
        'title' => 'Pemerhati Konstruksi',
        'image' => 'images/layanan-4.png',
        ],
        [
        'title' => 'Asosiasi Perusahaan',
        'image' => 'images/layanan-5.png',
        'route' => 'asosiasi-perusahaan',
        ],
        [
        'title' => 'Asosiasi Profesi',
        'image' => 'images/layanan-6.png',
        'route' => 'asosiasi-profesi',
        ],
        [
        'title' => 'Lembaga Sertifikasi Jasa Konstruksi',
        'image' => 'images/layanan-7.png',
        ],
        [
        'title' => 'Pemanfaat Produk Jasa Konstruksi',
        'image' => 'images/layanan-8.png',
        ],
        [
        'title' => 'Penyedia Jasa',
        'image' => 'images/layanan-9.png',
        'route' => 'penyedia-jasa',
        ],
        [
        'title' => 'Tenaga Kerja Konstruksi',
        'image' => 'images/layanan-10.png',
        'route' => 'tabel-tkk',
        ],
        [
        'title' => 'Pelaku Rantai Pasok',
        'image' => 'images/layanan-11.png',
        ],
        ];
        @endphp

        {{-- Grid Layanan --}}
        <div id="layanan-grid" class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($layanan as $index => $item)
            <div class="layanan-card {{ $index >= 3 ? 'layanan-extra hidden' : '' }}">

                <a href="{{ isset($item['route']) ? route($item['route']) : '#' }}" class="block">
                    <div class="flex h-[260px] flex-col items-center justify-between rounded-[26px] bg-white px-6 py-7 text-center shadow-[0_10px_24px_rgba(15,23,42,0.08)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_16px_30px_rgba(15,23,42,0.12)]">

                        {{-- Area Gambar --}}
                        <div class="flex h-[145px] w-full items-center justify-center">
                            <img
                                src="{{ asset($item['image']) }}"
                                alt="{{ $item['title'] }}"
                                class="h-[145px] w-[145px] object-cover">
                        </div>

                        {{-- Area Judul --}}
                        <div class="flex h-[70px] w-full items-center justify-center">
                            <h3 class="text-lg font-extrabold leading-snug text-[#163B5C] md:text-xl">
                                {{ $item['title'] }}
                            </h3>
                        </div>

                    </div>
                </a>

            </div>
            @endforeach
        </div>

        {{-- Tombol --}}
        <div class="mt-16 flex justify-center">
            <button id="toggle-layanan" type="button"
                class="inline-flex items-center justify-center rounded-full bg-[#143B5D] px-8 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-[#0F2E49]">
                Lihat Selengkapnya
            </button>
        </div>
    </div>

    </div>
</section>

{{-- STATISTIK SECTION --}}
<section class="bg-white px-4 py-20 md:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">

        @php
        $statistik = [
        [
        'angka' => '890',
        'label' => 'Tenaga Ahli',
        'icon' => 'tenaga-ahli',
        'url' => route('dashboard.tenaga-kerja')
        ],
        [
        'angka' => '1751',
        'label' => 'Tenaga Terampil',
        'icon' => 'tenaga-terampil',
        'url' => route('dashboard.tenaga-kerja')
        ],
        [
        'angka' => '747',
        'label' => 'BUJK',
        'icon' => 'nib',
        'url' => route('dashboard.bujk.publik')
        ],
        [
        'angka' => '172',
        'label' => 'SBU',
        'icon' => 'sbu',
        'url' => route('dashboard.sbu.publik')
        ],
        ];
        @endphp

        <div class="mx-auto grid max-w-7xl grid-cols-1 items-center gap-y-14 lg:grid-cols-[1.15fr_0.85fr] lg:gap-x-10">

            {{-- KIRI: STATISTIC CARDS --}}
            <div class="grid w-full grid-cols-1 gap-8 sm:grid-cols-2">

                @foreach ($statistik as $item)
                <div class="group relative overflow-hidden rounded-[24px] border border-[#c5cae9]/60 bg-white px-7 py-7 shadow-[0_14px_35px_rgba(33,50,94,0.08)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_20px_45px_rgba(33,50,94,0.14)]">

                    {{-- Top Accent --}}
                    <span class="absolute left-0 top-0 h-1.5 w-full bg-[#21325e]"></span>

                    <div class="flex items-center gap-5">

                        {{-- Icon --}}
                        <a href="{{ $item['url'] }}"
                            class="flex h-20 w-20 shrink-0 items-center justify-center rounded-2xl bg-[#eef2ff] text-[#21325e] transition duration-300 hover:scale-105 hover:bg-[#f7e578] hover:text-black hover:shadow-lg">

                            {{-- Tenaga Ahli --}}
                            @if ($item['icon'] === 'tenaga-ahli')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6 10a6 6 0 0112 0" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 10h16" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 10V8M16 10V8" />
                                <circle cx="12" cy="14" r="3" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M5.5 21a6.5 6.5 0 0113 0" />
                            </svg>

                            {{-- Tenaga Terampil --}}
                            @elseif ($item['icon'] === 'tenaga-terampil')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14 5l5 5" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 20l7.5-7.5" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13 4l7 7-3 3-7-7 3-3z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M5 6l4 4" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 7l3-3" />
                            </svg>

                            {{-- NIB --}}
                            @elseif ($item['icon'] === 'nib')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7 3h7l5 5v13H7V3z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14 3v5h5" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10 13h6M10 17h6M10 9h1" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 7v14h12" />
                            </svg>

                            {{-- SBU --}}
                            @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7 4h10a2 2 0 012 2v9a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 8h6M9 11h6" />
                                <circle cx="12" cy="15" r="2" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.5 17l-1 3 2.5-1.3L14.5 20l-1-3" />
                            </svg>
                            @endif
                        </a>

                        {{-- Text --}}
                        <div>
                            <h3 class="text-4xl font-extrabold leading-none text-[#21325e]">
                                {{ $item['angka'] }}
                            </h3>

                            <p class="mt-2 text-sm font-semibold leading-snug text-[#21325e]/70">
                                {{ $item['label'] }}
                            </p>
                        </div>

                    </div>
                </div>
                @endforeach

            </div>

            {{-- KANAN: TITLE --}}
            <div class="w-full max-w-[560px] text-center lg:text-center">
                <p class="mb-5 text-xs font-bold uppercase tracking-[0.45em] text-[#7282cc]">
                    Statistik
                </p>

                <h2 class="text-4xl font-extrabold leading-tight text-[#21325e] md:text-5xl lg:text-6xl">
                    Data Jasa Konstruksi
                </h2>

                <span class="mx-auto mt-6 block h-1.5 w-48 rounded-full bg-[#f1d00a]"></span>
            </div>

        </div>
    </div>
</section>

@include('pages.gis-map')

@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

<style>
    .hero-logo {
        transition: opacity 1s ease-in-out;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const button = document.getElementById('toggle-layanan');
        const extraCards = document.querySelectorAll('.layanan-extra');

        if (!button || !extraCards.length) return;

        button.addEventListener('click', function() {
            const isHidden = extraCards[0].classList.contains('hidden');

            extraCards.forEach(function(card) {
                card.classList.toggle('hidden');
            });

            button.textContent = isHidden ? 'Tampilkan Lebih Sedikit' : 'Lihat Selengkapnya';
        });
    });
</script>
@endpush