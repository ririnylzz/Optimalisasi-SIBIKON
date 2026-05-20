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
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    const gisSummary = @json($gisSummary ?? []);
    const bujkData = @json($bujkData ?? []);

    const regionDataMap = {};
    gisSummary.forEach((item) => {
        regionDataMap[normalizeRegionName(item.kabupaten)] = item;
    });

    const regionLayerMap = {};
    let bujkMap = null;
    let geojsonLayer = null;
    let activeRegionName = null;
    let currentMapItems = [];

    function isDetailZoom() {
        return bujkMap && bujkMap.getZoom() >= 9;
    }

    function getFillOpacityByZoom(total) {
        total = Number(total) || 0;

        // Saat zoom dekat, heatmap dibuat hampir hilang agar nama jalan terlihat
        if (isDetailZoom()) {
            return 0.08;
        }

        // Saat zoom normal, heatmap tetap terlihat
        return total > 0 ? 0.78 : 0.28;
    }

    function normalizeRegionName(name) {
        return String(name || '')
            .toLowerCase()
            .replace(/^kabupaten\s+/i, '')
            .replace(/^kab\.\s+/i, '')
            .replace(/^kota\s+/i, '')
            .replace(/\s+/g, ' ')
            .trim();
    }

    function normalizeText(value) {
        return String(value || '')
            .toLowerCase()
            .trim();
    }

    document.addEventListener('DOMContentLoaded', function() {
        initLayananToggle();
        initBujkPublicMap();
        initBujkFilters();
        renderBujkCards([]);
    });

    function initLayananToggle() {
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
    }

    function initBujkFilters() {
        const searchInput = document.getElementById('bujkSearchInput');
        const kabupatenFilter = document.getElementById('bujkKabupatenFilter');
        const resetButton = document.getElementById('bujkResetFilter');

        [searchInput, kabupatenFilter].forEach((el) => {
            if (!el) return;
            el.addEventListener('input', applyBujkFilters);
            el.addEventListener('change', applyBujkFilters);
        });

        if (resetButton) {
            resetButton.addEventListener('click', function() {
                if (searchInput) searchInput.value = '';
                if (kabupatenFilter) kabupatenFilter.value = '';

                activeRegionName = null;
                renderBujkCards([]);
                updateMapByFilteredData(bujkData);

                if (geojsonLayer && bujkMap) {
                    bujkMap.fitBounds(geojsonLayer.getBounds());
                }
            });
        }
    }

    function applyBujkFilters() {
        const searchValue = normalizeText(document.getElementById('bujkSearchInput')?.value);
        const kabupatenValue = normalizeText(document.getElementById('bujkKabupatenFilter')?.value);

        const hasFilter = searchValue || kabupatenValue;

        if (!hasFilter) {
            activeRegionName = null;
            renderBujkCards([]);
            updateMapByFilteredData(bujkData);
            return;
        }

        const filtered = bujkData.filter((item) => {
            const nama = normalizeText(item.nama_bu);
            const kabupaten = normalizeText(item.kabupaten);

            const matchSearch = !searchValue || nama.includes(searchValue);
            const matchKabupaten = !kabupatenValue || kabupaten === kabupatenValue;

            return matchSearch && matchKabupaten;
        });

        renderBujkCards(filtered);
        updateMapByFilteredData(filtered);

        setTimeout(() => {
            if (bujkMap) {
                bujkMap.invalidateSize();
            }
        }, 100);
    }

    function renderBujkCards(items) {
        const list = document.getElementById('bujkCardList');
        const count = document.getElementById('bujkResultCount');

        if (count) {
            count.textContent = `${items.length.toLocaleString('id-ID')} data`;
        }

        if (!list) return;

        if (!items.length) {
            list.innerHTML = `
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-5 text-center text-sm text-slate-500">
                    Belum ada data yang ditampilkan. Gunakan pencarian atau filter untuk melihat informasi BUJK.
                </div>
            `;
            return;
        }

        list.innerHTML = items.slice(0, 100).map((item) => {
            return `
                <button
                    type="button"
                    class="bujk-card w-full rounded-2xl border border-slate-200 bg-white p-4 text-left shadow-sm transition hover:-translate-y-0.5 hover:border-[#2596BE] hover:shadow-md"
                    data-region="${escapeHtml(item.kabupaten || '')}">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h5 class="text-sm font-extrabold leading-snug text-[#21325e]">
                                ${escapeHtml(item.nama_bu || '-')}
                            </h5>
                            <p class="mt-1 text-xs font-semibold text-[#2596BE]">
                                ${escapeHtml(item.jenis_usaha || '-')}
                            </p>
                        </div>

                        <span class="shrink-0 rounded-full bg-[#91C42B]/15 px-2.5 py-1 text-[11px] font-bold text-[#4F7D13]">
                            ${escapeHtml(item.kabupaten || '-')}
                        </span>
                    </div>

                    <div class="mt-3 space-y-2 text-xs text-slate-600">
                        <p>
                            <span class="font-bold text-slate-700">Alamat:</span>
                            ${escapeHtml(item.alamat || '-')}
                        </p>
                        <p>
                            <span class="font-bold text-slate-700">Telepon:</span>
                            ${escapeHtml(item.telepon || '-')}
                        </p>
                        <p>
                            <span class="font-bold text-slate-700">Email:</span>
                            ${escapeHtml(item.email || '-')}
                        </p>
                    </div>
                </button>
            `;
        }).join('');

        if (items.length > 100) {
            list.innerHTML += `
                <div class="rounded-2xl bg-[#fccc01]/20 p-4 text-center text-xs font-bold text-[#21325e]">
                    Menampilkan 100 dari ${items.length.toLocaleString('id-ID')} data. Gunakan search/filter untuk mempersempit hasil.
                </div>
            `;
        }

        document.querySelectorAll('.bujk-card').forEach((card) => {
            card.addEventListener('click', function() {
                const region = this.dataset.region;
                focusRegion(region);
            });
        });
    }

    function updateMapByFilteredData(items) {
        if (!geojsonLayer) return;

        currentMapItems = items;

        const countMap = {};

        items.forEach((item) => {
            const key = normalizeRegionName(item.kabupaten);
            countMap[key] = (countMap[key] || 0) + 1;
        });

        Object.entries(regionLayerMap).forEach(([key, layer]) => {
            const originalData = regionDataMap[key];
            const originalTotal = originalData ? Number(originalData.total) : 0;
            const filteredTotal = countMap[key] || 0;
            const total = items.length ? filteredTotal : originalTotal;
            const isActive = activeRegionName && key === normalizeRegionName(activeRegionName);

            layer.setStyle({
                color: isActive ? '#FCCC01' : '#21325E',
                weight: isActive ? 4 : 1.5,
                fillColor: getColor(total),
                fillOpacity: getFillOpacityByZoom(total)
            });
        });
    }

    function focusRegion(regionName) {
        const key = normalizeRegionName(regionName);
        const layer = regionLayerMap[key];

        if (!layer || !bujkMap) return;

        activeRegionName = regionName;

        bujkMap.fitBounds(layer.getBounds(), {
            padding: [40, 40],
            maxZoom: 9
        });

        updateMapByFilteredData(
            bujkData.filter((item) => normalizeRegionName(item.kabupaten) === key)
        );

        const totalInRegion = bujkData.filter((item) => {
            return normalizeRegionName(item.kabupaten) === key;
        }).length;

        layer.bindTooltip(
            `${regionName}: ${totalInRegion.toLocaleString('id-ID')} BUJK`, {
                sticky: true,
                direction: 'top'
            }
        ).openTooltip();
    }

    function getColor(total) {
        total = Number(total) || 0;

        if (total > 1000) return '#B88700';
        if (total > 500) return '#FCCC01';
        if (total > 250) return '#91C42B';
        if (total > 100) return '#2596BE';
        if (total > 0) return '#BFE6F3';

        return '#F3F4F6';
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

        bujkMap = L.map('bujkPublicMap', {
            scrollWheelZoom: true,
            zoomControl: true,
            doubleClickZoom: true,
            dragging: true
        }).setView([-0.5, 116.5], 6);

        bujkMap.on('zoomend', function() {
            updateMapByFilteredData(currentMapItems.length ? currentMapItems : bujkData);
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(bujkMap);

        fetch('/geojson/kaltim-kabupaten-kota.geojson')
            .then(response => response.json())
            .then(geojson => {
                geojsonLayer = L.geoJSON(geojson, {
                    style: function(feature) {
                        const regionName = getRegionName(feature);
                        const data = regionDataMap[normalizeRegionName(regionName)];
                        const total = data ? Number(data.total) : 0;

                        return {
                            color: '#21325E',
                            weight: 1.5,
                            fillColor: getColor(total),
                            fillOpacity: getFillOpacityByZoom(total)
                        };
                    },
                    onEachFeature: function(feature, layer) {
                        const regionName = getRegionName(feature);
                        const key = normalizeRegionName(regionName);

                        regionLayerMap[key] = layer;

                        const data = regionDataMap[key];
                        const total = data ? Number(data.total) : 0;

                        layer.bindTooltip(
                            `${regionName}: ${total.toLocaleString('id-ID')} BUJK`, {
                                sticky: true,
                                direction: 'top'
                            }
                        );

                        layer.on({
                            click: function() {
                                const kabupatenFilter = document.getElementById('bujkKabupatenFilter');

                                if (kabupatenFilter) {
                                    kabupatenFilter.value = regionName;
                                }

                                activeRegionName = regionName;
                                applyBujkFilters();

                                bujkMap.fitBounds(layer.getBounds(), {
                                    padding: [40, 40],
                                    maxZoom: 9
                                });
                            },
                            mouseover: function(e) {
                                e.target.setStyle({
                                    weight: 3,
                                    fillOpacity: isDetailZoom() ? 0.18 : 0.9
                                });
                            },
                            mouseout: function(e) {
                                if (normalizeRegionName(activeRegionName) !== key) {
                                    const data = regionDataMap[key];
                                    const total = data ? Number(data.total) : 0;

                                    e.target.setStyle({
                                        weight: 1.5,
                                        fillOpacity: getFillOpacityByZoom(total)
                                    });
                                }
                            }
                        });
                    }
                }).addTo(bujkMap);

                bujkMap.fitBounds(geojsonLayer.getBounds());
                setTimeout(() => {
                    if (bujkMap) {
                        bujkMap.invalidateSize();
                    }
                }, 100);
                updateMapByFilteredData(bujkData);
            })
            .catch(error => {
                console.error('Gagal memuat GeoJSON:', error);
            });
    }

    function escapeHtml(value) {
        return String(value || '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }
</script>
@endpush