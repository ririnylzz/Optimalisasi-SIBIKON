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
        'target' => 'chart-tkk',
        ],
        [
        'angka' => '1751',
        'label' => 'Tenaga Terampil',
        'icon' => 'tenaga-terampil',
        'target' => 'chart-tkk',
        ],
        [
        'angka' => '747',
        'label' => 'Badan Usaha (NIB)',
        'icon' => 'nib',
        'target' => 'null',
        ],
        [
        'angka' => '172',
        'label' => 'Badan Usaha (SBU)',
        'icon' => 'sbu',
        'target' => 'null'
        ],
        ];
        @endphp

        <div class="mx-auto grid max-w-7xl grid-cols-1 items-center justify-items-center gap-y-14 lg:grid-cols-[1.15fr_0.85fr] lg:gap-x-8">

            {{-- KIRI: STATISTIC CARDS --}}
            <div class="grid w-full max-w-[760px] grid-cols-1 gap-x-8 gap-y-14 sm:grid-cols-2">
                @foreach ($statistik as $item)
                <div class="group relative min-h-[165px] overflow-hidden rounded-[24px] border border-[#c5cae9]/60 bg-white px-8 py-8 shadow-[0_14px_35px_rgba(33,50,94,0.08)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_20px_45px_rgba(33,50,94,0.14)]">

                    {{-- Garis Atas --}}
                    <span class="absolute left-0 top-0 h-1.5 w-full bg-[#21325e]"></span>

                    <div class="flex items-center gap-5">

                        {{-- Icon Box --}}
                        <div class="flex h-24 w-24 shrink-0 items-center justify-center rounded-2xl bg-[#c5cae9]/30 text-[#3a4fac] transition group-hover:bg-[#f7e578]/70">

                            {{-- Tenaga Ahli --}}
                            @if ($item['icon'] === 'tenaga-ahli')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none"
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
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none"
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

                            {{-- Badan Usaha NIB --}}
                            @elseif ($item['icon'] === 'nib')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none"
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

                            {{-- Badan Usaha SBU --}}
                            @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none"
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

                        </div>

                        {{-- Text --}}
                        <div>
                            <h3 class="text-5xl font-extrabold leading-none text-[#21325e]">
                                {{ $item['angka'] }}
                            </h3>

                            <p class="mt-3 text-base font-semibold leading-snug text-[#21325e]/70">
                                {{ $item['label'] }}
                            </p>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>

            {{-- KANAN: TITLE --}}
            <div class="w-full max-w-[560px] text-center">
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

{{-- GIS SECTION --}}
<section class="bg-[#FFFFFF] px-4 py-20 md:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <div class="mb-12 text-center">
            <p class="mb-4 text-xs font-bold uppercase tracking-[0.45em] text-[#7282cc]">
                GIS BUJK
            </p>

            <h2 class="text-4xl font-extrabold leading-tight text-[#21325e] md:text-5xl">
                Peta Sebaran BUJK Kalimantan Timur
            </h2>

            <span class="mx-auto mt-6 block h-1.5 w-48 rounded-full bg-[#f1d00a]"></span>

            <p class="mx-auto mt-6 max-w-3xl text-base leading-8 text-slate-600">
                Visualisasi sebaran Badan Usaha Jasa Konstruksi berdasarkan wilayah kabupaten/kota di Kalimantan Timur.
            </p>
        </div>

        <div class="overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-[0_18px_45px_rgba(15,23,42,0.08)]">
            <div class="border-b border-slate-200 bg-white px-6 py-5">
                <h3 class="text-xl font-extrabold text-[#21325e]">
                    Peta Sebaran BUJK
                </h3>
                <p class="mt-1 text-sm text-slate-500">
                    Klik wilayah untuk melihat detail jumlah BUJK.
                </p>
            </div>

            <div class="relative">
                <div id="bujkPublicMap" class="h-[520px] w-full"></div>

                <div class="absolute bottom-4 left-4 z-[500] rounded-2xl bg-white/95 p-4 text-xs shadow-lg">
                    <p class="mb-2 font-bold text-slate-800">Legenda Jumlah BUJK</p>
                    <div class="space-y-1 text-slate-600">
                        <div>
                            <span class="mr-2 inline-block h-3 w-3 rounded-sm" style="background-color:#F3F4F6;"></span>
                            0 data
                        </div>
                        <div>
                            <span class="mr-2 inline-block h-3 w-3 rounded-sm" style="background-color:#BFE6F3;"></span>
                            1 - 100
                        </div>
                        <div>
                            <span class="mr-2 inline-block h-3 w-3 rounded-sm" style="background-color:#2596BE;"></span>
                            101 - 250
                        </div>
                        <div>
                            <span class="mr-2 inline-block h-3 w-3 rounded-sm" style="background-color:#91C42B;"></span>
                            251 - 500
                        </div>
                        <div>
                            <span class="mr-2 inline-block h-3 w-3 rounded-sm" style="background-color:#FCCC01;"></span>
                            501 - 1000
                        </div>
                        <div>
                            <span class="mr-2 inline-block h-3 w-3 rounded-sm" style="background-color:#B88700;"></span>
                            &gt; 1000
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    const gisBujk = @json($gisBujk ?? []);

    const gisBujkMap = {};
    gisBujk.forEach((item) => {
        gisBujkMap[normalizeRegionName(item.kabupaten)] = item;
    });

    function normalizeRegionName(name) {
        return String(name || '')
            .toLowerCase()
            .replace(/^kabupaten\s+/i, '')
            .replace(/^kota\s+/i, 'kota ')
            .trim();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const button = document.getElementById('toggle-layanan');
        const extraCards = document.querySelectorAll('.layanan-extra');

        if (button && extraCards.length) {
            button.addEventListener('click', function() {
                const isHidden = extraCards[0].classList.contains('hidden');

                extraCards.forEach(function(card) {
                    card.classList.toggle('hidden');
                });

                button.textContent = isHidden ? 'Tampilkan Lebih Sedikit' : 'Lihat Selengkapnya';
            });
        }

        initBujkPublicMap();
    });

    function getColor(total) {
        total = Number(total) || 0;

        if (total > 1000) return '#B88700'; // kuning tua
        if (total > 500) return '#FCCC01'; // kuning logo
        if (total > 250) return '#91C42B'; // hijau logo
        if (total > 100) return '#2596BE'; // biru logo
        if (total > 0) return '#BFE6F3'; // biru muda

        return '#F3F4F6'; // 0 data
    }

    function getRegionName(feature) {
        const props = feature.properties || {};

        return props.NAMOBJ ||
            props.WADMKK ||
            props.nama ||
            props.name ||
            props['Nama Objek'] ||
            '';
    }

    function initBujkPublicMap() {
        const mapEl = document.getElementById('bujkPublicMap');
        if (!mapEl) return;

        const map = L.map('bujkPublicMap', {
            scrollWheelZoom: false
        }).setView([-0.5, 116.5], 6);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        fetch('/geojson/kaltim-kabupaten-kota.geojson')
            .then(response => response.json())
            .then(geojson => {
                const layer = L.geoJSON(geojson, {
                    style: function(feature) {
                        const regionName = getRegionName(feature);
                        const data = gisBujkMap[normalizeRegionName(regionName)];
                        const total = data ? Number(data.total) : 0;

                        return {
                            color: '#21325E',
                            weight: 1.5,
                            fillColor: getColor(total),
                            fillOpacity: 0.85
                        };
                    },
                    onEachFeature: function(feature, layer) {
                        const regionName = getRegionName(feature);
                        const data = gisBujkMap[normalizeRegionName(regionName)];
                        const total = data ? Number(data.total) : 0;

                        layer.bindPopup(`
                            <div style="min-width:220px">
                                <h3 style="font-weight:700;margin-bottom:6px;color:#21325E">${regionName}</h3>
                                <p style="margin:0">
                                    Total BUJK:
                                    <strong style="color:#2596BE">${total.toLocaleString('id-ID')}</strong>
                                </p>
                            </div>
                        `);

                        layer.on({
                            mouseover: function(e) {
                                e.target.setStyle({
                                    weight: 3,
                                    fillOpacity: 0.95
                                });
                            },
                            mouseout: function(e) {
                                e.target.setStyle({
                                    weight: 1,
                                    fillOpacity: 0.8
                                });
                            }
                        });
                    }
                }).addTo(map);

                map.fitBounds(layer.getBounds());
            })
            .catch(error => {
                console.error('Gagal memuat GeoJSON:', error);
            });
    }

    // SLIDER LOGO HERO
    const heroLogos = document.querySelectorAll('.hero-logo');
    let currentLogo = 0;

    setInterval(() => {
        heroLogos[currentLogo].classList.remove('opacity-100');
        heroLogos[currentLogo].classList.add('opacity-0');

        currentLogo = (currentLogo + 1) % heroLogos.length;

        heroLogos[currentLogo].classList.remove('opacity-0');
        heroLogos[currentLogo].classList.add('opacity-100');
    }, 7000);
</script>
@endpush