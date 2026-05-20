@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

<style>
    .leaflet-container {
        font-family: inherit;
    }

    .gis-card-scroll::-webkit-scrollbar {
        width: 6px;
    }

    .gis-card-scroll::-webkit-scrollbar-track {
        background: #e5e7eb;
        border-radius: 999px;
    }

    .gis-card-scroll::-webkit-scrollbar-thumb {
        background: #2596BE;
        border-radius: 999px;
    }
</style>
@endpush

{{-- GIS SECTION --}}
<section class="bg-[#FFFFFF] px-4 py-20 md:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <div class="mb-12 text-center">
            <p class="mb-4 text-xs font-bold uppercase tracking-[0.45em] text-[#7282cc]">
                GIS KONSTRUKSI
            </p>

            <h2 class="text-4xl font-extrabold leading-tight text-[#21325e] md:text-5xl">
                Peta Sebaran Data Konstruksi Kalimantan Timur
            </h2>

            <span class="mx-auto mt-6 block h-1.5 w-48 rounded-full bg-[#f1d00a]"></span>

            <p class="mx-auto mt-6 max-w-3xl text-base leading-8 text-slate-600">
                Visualisasi sebaran data BUJK, Tenaga Kerja Konstruksi, dan Rantai Pasok berdasarkan wilayah kabupaten/kota di Kalimantan Timur.
            </p>
        </div>

        <div class="overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-[0_18px_45px_rgba(15,23,42,0.08)]">

            {{-- HEADER + SEARCH/FILTER --}}
            <div class="border-b border-slate-200 bg-white px-6 py-5">
                <div class="flex flex-col gap-5 xl:flex-row xl:items-end xl:justify-between">
                    <div>
                        <h3 id="gisMapTitle" class="text-xl font-extrabold text-[#21325e]">
                            Peta Sebaran BUJK
                        </h3>

                        <p id="gisMapSubtitle" class="mt-1 text-sm text-slate-500">
                            Pilih kategori data, gunakan pencarian/filter, lalu klik card untuk menuju wilayah terkait.
                        </p>
                    </div>

                    <div class="grid w-full grid-cols-1 gap-3 md:grid-cols-2 xl:w-[820px] xl:grid-cols-[1fr_1.25fr_1fr_1fr_auto]">
                        {{-- KATEGORI --}}
                        <div>
                            <label class="mb-1 block text-[11px] font-bold uppercase tracking-wide text-slate-500">
                                Kategori Data
                            </label>
                            <select
                                id="gisCategoryFilter"
                                class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm outline-none transition focus:border-[#2596BE] focus:ring-2 focus:ring-[#2596BE]/20">
                                <option value="bujk">BUJK</option>
                                <option value="tkk">TKK</option>
                                <option value="rantai-pasok">Rantai Pasok</option>
                            </select>
                        </div>

                        {{-- SEARCH --}}
                        <div>
                            <label id="gisSearchLabel" class="mb-1 block text-[11px] font-bold uppercase tracking-wide text-slate-500">
                                Cari Nama BU
                            </label>
                            <input
                                id="gisSearchInput"
                                type="text"
                                placeholder="Contoh: PT, CV, nama perusahaan..."
                                class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm outline-none transition focus:border-[#2596BE] focus:ring-2 focus:ring-[#2596BE]/20">
                        </div>

                        {{-- KAB/KOTA --}}
                        <div>
                            <label class="mb-1 block text-[11px] font-bold uppercase tracking-wide text-slate-500">
                                Kabupaten/Kota
                            </label>
                            <select
                                id="gisKabupatenFilter"
                                class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm outline-none transition focus:border-[#2596BE] focus:ring-2 focus:ring-[#2596BE]/20">
                                <option value="">Semua Wilayah</option>
                            </select>
                        </div>

                        {{-- FILTER KHUSUS --}}
                        <div id="gisSpecialFilterWrapper" class="hidden">
                            <label id="gisSpecialFilterLabel" class="mb-1 block text-[11px] font-bold uppercase tracking-wide text-slate-500">
                                Filter
                            </label>
                            <select
                                id="gisSpecialFilter"
                                class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm outline-none transition focus:border-[#2596BE] focus:ring-2 focus:ring-[#2596BE]/20">
                                <option value="">Semua</option>
                            </select>
                        </div>

                        {{-- RESET --}}
                        <div class="flex items-end">
                            <button
                                id="gisResetFilter"
                                type="button"
                                class="w-full rounded-xl bg-[#21325e] px-5 py-2.5 text-sm font-bold text-white transition hover:bg-[#3a4fac]">
                                Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- MAP + CARD --}}
            <div class="grid grid-cols-1 gap-0 lg:grid-cols-[1.35fr_0.65fr]">

                {{-- MAP --}}
                <div class="relative h-[640px] overflow-hidden border-b border-slate-200 lg:border-b-0 lg:border-r">
                    <div id="gisPublicMap" class="absolute inset-0 h-full w-full"></div>

                    <div class="absolute bottom-4 left-4 z-[500] rounded-2xl bg-white/95 p-4 text-xs shadow-lg">
                        <p class="mb-2 font-bold text-slate-800">Legenda Jumlah Data</p>

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

                {{-- CARD HASIL DATA --}}
                <div class="h-[640px] overflow-hidden bg-slate-50 p-5">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <h4 id="gisInfoTitle" class="text-base font-extrabold text-[#21325e]">
                                Informasi BUJK
                            </h4>
                            <p id="gisInfoSubtitle" class="mt-1 text-xs text-slate-500">
                                Data akan muncul sesuai hasil pencarian atau filter.
                            </p>
                        </div>

                        <span id="gisResultCount" class="shrink-0 rounded-full bg-[#fccc01]/20 px-3 py-1 text-xs font-bold text-[#21325e]">
                            0 data
                        </span>
                    </div>

                    <div id="gisCardList" class="gis-card-scroll mt-4 h-[555px] space-y-3 overflow-y-auto pr-1">
                        <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-5 text-center text-sm text-slate-500">
                            Cari nama atau pilih filter untuk menampilkan data.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    const GIS_CATEGORY_CONFIG = {
        'bujk': {
            title: 'Peta Sebaran BUJK',
            infoTitle: 'Informasi BUJK',
            searchLabel: 'Cari Nama BU',
            searchPlaceholder: 'Contoh: PT, CV, nama perusahaan...',
            endpoint: '/gis-data/bujk',
            specialFilter: null,
        },
        'tkk': {
            title: 'Peta Sebaran TKK',
            infoTitle: 'Informasi TKK',
            searchLabel: 'Cari Nama TKK',
            searchPlaceholder: 'Contoh: nama tenaga kerja...',
            endpoint: '/gis-data/tkk',
            specialFilter: {
                label: 'Jenjang',
                options: [{
                    value: '',
                    label: 'Semua Jenjang'
                }, ],
            },
        },
        'rantai-pasok': {
            title: 'Peta Sebaran Rantai Pasok',
            infoTitle: 'Informasi Rantai Pasok',
            searchLabel: 'Cari Nama',
            searchPlaceholder: 'Contoh: nama usaha/material...',
            endpoint: '/gis-data/rantai-pasok',
            specialFilter: {
                label: 'Bidang Usaha',
                options: [{
                    value: '',
                    label: 'Semua Bidang Usaha'
                }, ],
            },
        },
    };

    const regionLayerMap = {};
    let gisMap = null;
    let geojsonLayer = null;
    let activeRegionName = null;
    let currentCategory = 'bujk';
    let currentData = [];
    let currentSummary = [];
    let currentMapItems = [];

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

    function isDetailZoom() {
        return gisMap && gisMap.getZoom() >= 11;
    }

    function getFillOpacityByZoom(total) {
        total = Number(total) || 0;

        if (isDetailZoom()) {
            return total > 0 ? 0.18 : 0.05;
        }

        return total > 0 ? 0.65 : 0.22;
    }

    document.addEventListener('DOMContentLoaded', function() {
        initGisMap();
        initGisFilters();
        loadGisCategory('bujk');
    });

    function initGisFilters() {
        const categoryFilter = document.getElementById('gisCategoryFilter');
        const searchInput = document.getElementById('gisSearchInput');
        const kabupatenFilter = document.getElementById('gisKabupatenFilter');
        const specialFilter = document.getElementById('gisSpecialFilter');
        const resetButton = document.getElementById('gisResetFilter');

        if (categoryFilter) {
            categoryFilter.addEventListener('change', function() {
                loadGisCategory(this.value);
            });
        }

        [searchInput, kabupatenFilter, specialFilter].forEach((el) => {
            if (!el) return;
            el.addEventListener('input', applyGisFilters);
            el.addEventListener('change', applyGisFilters);
        });

        if (resetButton) {
            resetButton.addEventListener('click', function() {
                if (searchInput) searchInput.value = '';
                if (kabupatenFilter) kabupatenFilter.value = '';
                if (specialFilter) specialFilter.value = '';

                activeRegionName = null;
                renderGisCards([]);
                updateMapByFilteredData(currentData);

                if (geojsonLayer && gisMap) {
                    gisMap.fitBounds(geojsonLayer.getBounds());
                }

                setTimeout(() => {
                    if (gisMap) gisMap.invalidateSize();
                }, 100);
            });
        }
    }

    function updateGisHeaderByCategory(category) {
        const config = GIS_CATEGORY_CONFIG[category];

        document.getElementById('gisMapTitle').textContent = config.title;
        document.getElementById('gisInfoTitle').textContent = config.infoTitle;
        document.getElementById('gisSearchLabel').textContent = config.searchLabel;
        document.getElementById('gisSearchInput').placeholder = config.searchPlaceholder;

        const wrapper = document.getElementById('gisSpecialFilterWrapper');
        const label = document.getElementById('gisSpecialFilterLabel');
        const select = document.getElementById('gisSpecialFilter');

        select.innerHTML = '';

        if (!config.specialFilter) {
            wrapper.classList.add('hidden');
            select.innerHTML = '<option value="">Semua</option>';
            return;
        }

        wrapper.classList.remove('hidden');
        label.textContent = config.specialFilter.label;

        config.specialFilter.options.forEach((option) => {
            select.innerHTML += `<option value="${option.value}">${option.label}</option>`;
        });
    }

    function loadGisCategory(category) {
        currentCategory = category;
        activeRegionName = null;

        updateGisHeaderByCategory(category);
        renderGisLoading();

        const config = GIS_CATEGORY_CONFIG[category];

        fetch(config.endpoint)
            .then(response => response.json())
            .then(payload => {
                currentData = payload.items || [];
                currentSummary = payload.summary || [];

                if (category === 'rantai-pasok') {
                    updateRantaiPasokBidangUsahaOptions(payload.bidang_usaha_options || []);
                }

                if (category === 'tkk') {
                    updateTkkJenjangOptions(payload.jenjang_options || []);
                }

                fillKabupatenOptions(payload.kabupaten_options || []);
                renderGisCards(currentData);
                updateMapBySummary(currentSummary);
                updateMapByFilteredData(currentData);

                if (geojsonLayer && gisMap) {
                    gisMap.fitBounds(geojsonLayer.getBounds());
                }
            })
            .catch(error => {
                console.error('Gagal memuat data GIS:', error);
                renderGisError();
            });
    }

    function updateRantaiPasokBidangUsahaOptions(options) {
        const select = document.getElementById('gisSpecialFilter');

        if (!select) return;

        select.innerHTML = '<option value="">Semua Bidang Usaha</option>';

        options.forEach((item) => {
            select.innerHTML += `<option value="${escapeHtml(item)}">${escapeHtml(item)}</option>`;
        });
    }

    function updateTkkJenjangOptions(options) {
        const select = document.getElementById('gisSpecialFilter');

        if (!select) return;

        select.innerHTML = '<option value="">Semua Jenjang</option>';

        options.forEach((item) => {
            select.innerHTML += `<option value="${escapeHtml(item)}">${escapeHtml(item)}</option>`;
        });
    }

    function fillKabupatenOptions(options) {
        const select = document.getElementById('gisKabupatenFilter');

        if (!select) return;

        select.innerHTML = '<option value="">Semua Wilayah</option>';

        options.forEach((kabupaten) => {
            select.innerHTML += `<option value="${escapeHtml(kabupaten)}">${escapeHtml(kabupaten)}</option>`;
        });
    }

    function renderGisLoading() {
        const list = document.getElementById('gisCardList');
        const count = document.getElementById('gisResultCount');

        if (count) count.textContent = '0 data';

        if (list) {
            list.innerHTML = `
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-5 text-center text-sm text-slate-500">
                    Memuat data GIS...
                </div>
            `;
        }
    }

    function renderGisError() {
        const list = document.getElementById('gisCardList');
        const count = document.getElementById('gisResultCount');

        if (count) count.textContent = '0 data';

        if (list) {
            list.innerHTML = `
                <div class="rounded-2xl border border-red-200 bg-red-50 p-5 text-center text-sm text-red-600">
                    Data GIS gagal dimuat. Periksa route dan koneksi database.
                </div>
            `;
        }
    }

    function applyGisFilters() {
        const searchValue = normalizeText(document.getElementById('gisSearchInput')?.value);
        const kabupatenValue = normalizeText(document.getElementById('gisKabupatenFilter')?.value);
        const specialValue = normalizeText(document.getElementById('gisSpecialFilter')?.value);


        const filtered = currentData.filter((item) => {
            const nama = normalizeText(item.name);
            const kabupaten = normalizeText(item.kabupaten);
            const jenjang = normalizeText(item.jenjang);
            const bidangUsaha = normalizeText(item.bidang_usaha);

            const matchSearch = !searchValue || nama.includes(searchValue);
            const matchKabupaten = !kabupatenValue || kabupaten === kabupatenValue;

            let matchSpecial = true;

            if (currentCategory === 'tkk') {
                matchSpecial = !specialValue || jenjang === specialValue;
            }

            if (currentCategory === 'rantai-pasok') {
                matchSpecial = !specialValue || bidangUsaha === specialValue;
            }

            return matchSearch && matchKabupaten && matchSpecial;
        });

        renderGisCards(filtered);
        updateMapByFilteredData(filtered);

        setTimeout(() => {
            if (gisMap) gisMap.invalidateSize();
        }, 100);
    }

    function renderGisCards(items) {
        const list = document.getElementById('gisCardList');
        const count = document.getElementById('gisResultCount');

        if (count) {
            count.textContent = `${items.length.toLocaleString('id-ID')} data`;
        }

        if (!list) return;

        if (!items.length) {
            list.innerHTML = `
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-5 text-center text-sm text-slate-500">
                    Belum ada data yang ditampilkan. Gunakan pencarian atau filter untuk melihat informasi.
                </div>
            `;
            return;
        }

        list.innerHTML = items.slice(0, 100).map((item) => {
            if (currentCategory === 'tkk') {
                return renderTkkCard(item);
            }

            if (currentCategory === 'rantai-pasok') {
                return renderRantaiPasokCard(item);
            }

            return renderBujkCard(item);
        }).join('');

        if (items.length > 100) {
            list.innerHTML += `
                <div class="rounded-2xl bg-[#fccc01]/20 p-4 text-center text-xs font-bold text-[#21325e]">
                    Menampilkan 100 dari ${items.length.toLocaleString('id-ID')} data. Gunakan search/filter untuk mempersempit hasil.
                </div>
            `;
        }

        document.querySelectorAll('.gis-data-card').forEach((card) => {
            card.addEventListener('click', function() {
                const region = this.dataset.region;
                focusRegion(region);
            });
        });
    }

    function renderBujkCard(item) {
        return `
            <button type="button" class="gis-data-card w-full rounded-2xl border border-slate-200 bg-white p-4 text-left shadow-sm transition hover:-translate-y-0.5 hover:border-[#2596BE] hover:shadow-md" data-region="${escapeHtml(item.kabupaten || '')}">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h5 class="text-sm font-extrabold leading-snug text-[#21325e]">${escapeHtml(item.name || '-')}</h5>
                        <p class="mt-1 text-xs font-semibold text-[#2596BE]">${escapeHtml(item.jenis_usaha || '-')}</p>
                    </div>
                    <span class="shrink-0 rounded-full bg-[#91C42B]/15 px-2.5 py-1 text-[11px] font-bold text-[#4F7D13]">
                        ${escapeHtml(item.kabupaten || '-')}
                    </span>
                </div>

                <div class="mt-3 space-y-2 text-xs text-slate-600">
                    <p><span class="font-bold text-slate-700">Alamat:</span> ${escapeHtml(item.alamat || '-')}</p>
                    <p><span class="font-bold text-slate-700">Telepon:</span> ${escapeHtml(item.telepon || '-')}</p>
                    <p><span class="font-bold text-slate-700">Email:</span> ${escapeHtml(item.email || '-')}</p>
                </div>
            </button>
        `;
    }

    function renderTkkCard(item) {
        const statusClass = item.status === 'kadaluwarsa' ?
            'bg-red-100 text-red-700' :
            'bg-green-100 text-green-700';

        return `
        <button type="button" class="gis-data-card w-full rounded-2xl border border-slate-200 bg-white p-4 text-left shadow-sm transition hover:-translate-y-0.5 hover:border-[#2596BE] hover:shadow-md" data-region="${escapeHtml(item.kabupaten || '')}">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h5 class="text-sm font-extrabold leading-snug text-[#21325e]">${escapeHtml(item.name || '-')}</h5>
                    <p class="mt-1 text-xs font-semibold text-[#2596BE]">${escapeHtml(item.jabatan_kerja || '-')}</p>
                </div>
                <span class="shrink-0 rounded-full px-2.5 py-1 text-[11px] font-bold ${statusClass}">
                    ${escapeHtml(item.status_label || '-')}
                </span>
            </div>

            <div class="mt-3 space-y-2 text-xs text-slate-600">
                <p><span class="font-bold text-slate-700">Klasifikasi:</span> ${escapeHtml(item.klasifikasi || '-')}</p>
                <p><span class="font-bold text-slate-700">Jenjang:</span> ${escapeHtml(item.jenjang || '-')}</p>
                <p><span class="font-bold text-slate-700">Asosiasi:</span> ${escapeHtml(item.asosiasi || '-')}</p>
                <p><span class="font-bold text-slate-700">Berlaku sampai:</span> ${escapeHtml(item.tanggal_kadaluwarsa_label || 'Tidak ada tanggal')}</p>
                <p><span class="font-bold text-slate-700">Wilayah:</span> ${escapeHtml(item.kabupaten || '-')}</p>
            </div>
        </button>
    `;
    }

    function renderRantaiPasokCard(item) {
        return `
            <button type="button" class="gis-data-card w-full rounded-2xl border border-slate-200 bg-white p-4 text-left shadow-sm transition hover:-translate-y-0.5 hover:border-[#2596BE] hover:shadow-md" data-region="${escapeHtml(item.kabupaten || '')}">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h5 class="text-sm font-extrabold leading-snug text-[#21325e]">${escapeHtml(item.name || '-')}</h5>
                        <p class="mt-1 text-xs font-semibold text-[#2596BE]">${escapeHtml(item.bidang_usaha || '-')}</p>
                    </div>
                    <span class="shrink-0 rounded-full bg-[#91C42B]/15 px-2.5 py-1 text-[11px] font-bold text-[#4F7D13]">
                        ${escapeHtml(item.kabupaten || '-')}
                    </span>
                </div>

                <div class="mt-3 space-y-2 text-xs text-slate-600">
                    <p><span class="font-bold text-slate-700">Alamat:</span> ${escapeHtml(item.alamat || '-')}</p>
                    <p><span class="font-bold text-slate-700">Bidang Usaha:</span> ${escapeHtml(item.bidang_usaha || '-')}</p>
                </div>
            </button>
        `;
    }

    function updateMapBySummary(summary) {
        currentSummary = summary || [];
    }

    function updateMapByFilteredData(items) {
        if (!geojsonLayer) return;

        currentMapItems = items || [];

        const countMap = {};
        currentMapItems.forEach((item) => {
            const key = normalizeRegionName(item.kabupaten);
            countMap[key] = (countMap[key] || 0) + 1;
        });

        const summaryMap = {};
        currentSummary.forEach((item) => {
            summaryMap[normalizeRegionName(item.kabupaten)] = item;
        });

        Object.entries(regionLayerMap).forEach(([key, layer]) => {
            const originalData = summaryMap[key];
            const originalTotal = originalData ? Number(originalData.total) : 0;
            const filteredTotal = countMap[key] || 0;
            const total = currentMapItems.length ? filteredTotal : originalTotal;
            const isActive = activeRegionName && key === normalizeRegionName(activeRegionName);

            layer.setStyle({
                color: isActive ? '#FCCC01' : '#21325E',
                weight: isActive ? 4 : 1.5,
                fillColor: getColor(total),
                fillOpacity: getFillOpacityByZoom(total)
            });

            const regionName = layer.feature ? getRegionName(layer.feature) : '';
            layer.bindTooltip(
                `${regionName}: ${total.toLocaleString('id-ID')} data`, {
                    sticky: true,
                    direction: 'top'
                }
            );
        });
    }

    function focusRegion(regionName) {
        const key = normalizeRegionName(regionName);
        const layer = regionLayerMap[key];

        if (!layer || !gisMap) return;

        activeRegionName = regionName;

        gisMap.fitBounds(layer.getBounds(), {
            padding: [40, 40],
            maxZoom: 8
        });

        updateMapByFilteredData(
            currentData.filter((item) => normalizeRegionName(item.kabupaten) === key)
        );

        layer.openTooltip();
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

    function initGisMap() {
        const mapEl = document.getElementById('gisPublicMap');
        if (!mapEl) return;

        gisMap = L.map('gisPublicMap', {
            scrollWheelZoom: true,
            zoomControl: true,
            doubleClickZoom: true,
            dragging: true
        }).setView([-0.5, 116.5], 6);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(gisMap);

        gisMap.on('zoomend', function() {
            updateMapByFilteredData(currentMapItems.length ? currentMapItems : currentData);
        });

        fetch('/geojson/kaltim-kabupaten-kota.geojson')
            .then(response => response.json())
            .then(geojson => {
                geojsonLayer = L.geoJSON(geojson, {
                    style: function(feature) {
                        return {
                            color: '#21325E',
                            weight: 1.5,
                            fillColor: '#F3F4F6',
                            fillOpacity: 0.28
                        };
                    },
                    onEachFeature: function(feature, layer) {
                        const regionName = getRegionName(feature);
                        const key = normalizeRegionName(regionName);

                        regionLayerMap[key] = layer;

                        layer.bindTooltip(`${regionName}: 0 data`, {
                            sticky: true,
                            direction: 'top'
                        });

                        layer.on({
                            click: function() {
                                const kabupatenFilter = document.getElementById('gisKabupatenFilter');

                                if (kabupatenFilter) {
                                    kabupatenFilter.value = regionName;
                                }

                                activeRegionName = regionName;
                                applyGisFilters();

                                gisMap.fitBounds(layer.getBounds(), {
                                    padding: [40, 40],
                                    maxZoom: 8
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
                                    updateMapByFilteredData(currentMapItems.length ? currentMapItems : currentData);
                                }
                            }
                        });
                    }
                }).addTo(gisMap);

                gisMap.fitBounds(geojsonLayer.getBounds());
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