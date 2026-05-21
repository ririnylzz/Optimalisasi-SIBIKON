@extends('layouts.admin')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Dashboard Tenaga Kerja Konstruksi')

@section('content')
<div class="space-y-6">
    {{-- Filter --}}
    <div class="sibikon-card overflow-hidden rounded-[24px] border border-slate-200 bg-white">
        <div class="border-b border-slate-100 bg-gradient-to-r from-slate-50 to-blue-50/60 px-6 py-4">
            <h3 class="text-lg font-extrabold text-slate-900">Filter Dashboard TKK</h3>
            <p class="text-sm text-slate-500">
                Gunakan filter untuk melihat data tenaga kerja konstruksi berdasarkan wilayah dan jenjang.
            </p>
        </div>

        <form method="GET"
            action="{{ route('admin.tenaga-kerja-konstruksi') }}"
            class="flex flex-wrap items-end gap-5 p-6"
        >
            {{-- Kabupaten --}}
            <div class="min-w-[220px] flex-1">
                <label class="mb-2 block text-xs font-bold uppercase tracking-[0.18em] text-slate-500">
                    Filter Kabupaten
                </label>

                <select
                    name="kabupaten"
                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 transition focus:border-[#3A4FAC] focus:ring-4 focus:ring-[#3A4FAC]/10"
                >
                    <option value="semua">Semua Kabupaten</option>

                    @foreach ($kabupatenOptions as $kabupaten)
                        <option
                            value="{{ $kabupaten }}"
                            {{ $selectedKabupaten === $kabupaten ? 'selected' : '' }}
                        >
                            {{ $kabupaten }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Mode --}}
            <div class="min-w-[260px] flex-1">
                <label class="mb-2 block text-xs font-bold uppercase tracking-[0.18em] text-slate-500">
                    Mode Tampilan Data
                </label>

                <select
                    name="mode"
                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 transition focus:border-[#3A4FAC] focus:ring-4 focus:ring-[#3A4FAC]/10"
                >
                    <option value="semua_skk" {{ $selectedMode === 'semua_skk' ? 'selected' : '' }}>
                        TKK Ahli (Semua SKK)
                    </option>

                    <option value="aktif" {{ $selectedMode === 'aktif' ? 'selected' : '' }}>
                        TKK Aktif
                    </option>

                    <option value="kadaluarsa_tahun_ini" {{ $selectedMode === 'kadaluarsa_tahun_ini' ? 'selected' : '' }}>
                        SKK Kadaluarsa Tahun Ini
                    </option>
                </select>
            </div>

            {{-- Jenjang --}}
            <div class="min-w-[240px]">
                <label class="mb-2 block text-xs font-bold uppercase tracking-[0.18em] text-slate-500">
                    Pilih Jenjang
                </label>

                <div class="flex flex-wrap gap-2">
                    @foreach ([7, 8, 9] as $jenjang)
                        <label class="inline-flex items-center gap-2 rounded-2xl border border-[#3A4FAC]/15 bg-[#EEF2FF] px-4 py-3 text-sm font-semibold text-[#142B67] transition hover:bg-[#E0E7FF]">
                            <input
                                type="checkbox"
                                name="jenjang[]"
                                value="{{ $jenjang }}"
                                {{ in_array((string) $jenjang, $selectedJenjang) ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-slate-300 text-[#3A4FAC] focus:ring-[#3A4FAC]"
                            >

                            {{ $jenjang }}
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Button --}}
            <div>
                <button
                    type="submit"
                    class="rounded-2xl bg-gradient-to-br from-[#142B67] via-[#1E3A7A] to-[#2F49A8] px-6 py-3 text-sm font-bold text-white shadow-[0_12px_30px_rgba(20,43,103,0.18)] transition hover:-translate-y-0.5 hover:shadow-[0_16px_36px_rgba(20,43,103,0.24)]"
                >
                    Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    {{-- Charts Row 1 --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
        <x-dashboard-chart-card title="Status Sertifikasi" canvas="statusSertifikasiChart" height="h-[290px]" />
        <x-dashboard-chart-card title="Distribusi Jenjang" canvas="distribusiJenjangChart" height="h-[290px]" />
    </div>

    {{-- Charts Row 2 --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
        <x-dashboard-chart-card title="Top 5 Asosiasi Jenjang 7-9" canvas="topAsosiasiChart" height="h-[340px]" />
        <x-dashboard-chart-card title="Top 5 Klasifikasi" canvas="topKlasifikasiChart" height="h-[340px]" />
    </div>

    {{-- Charts Row 3 --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
        <x-dashboard-chart-card title="Perbandingan TKK Kab/Kota" canvas="perbandinganKabupatenChart" height="h-[360px]" />

        <div class="sibikon-card overflow-hidden rounded-[20px] transition duration-300 hover:-translate-y-0.5 hover:shadow-[0_18px_40px_rgba(20,43,103,0.10)]">
            <div class="border-b border-slate-100 bg-white px-4 py-3">
                <h3 class="text-base font-extrabold text-slate-900">Proyeksi Kadaluarsa</h3>
            </div>

            <div class="relative overflow-hidden bg-white p-4">
                <img
                    src="{{ asset('images/logo-sibikon.png') }}"
                    alt="Logo Sibikon"
                    class="pointer-events-none absolute left-1/2 top-1/2 z-0 w-56 -translate-x-1/2 -translate-y-1/2 opacity-[0.08]"
                >

                <div class="relative z-10 h-[360px]">
                    <canvas id="proyeksiKadaluarsaChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="sibikon-card overflow-hidden rounded-[24px] border border-slate-200 bg-white">
        <div class="border-b border-slate-100 bg-gradient-to-r from-slate-50 to-blue-50/60 px-6 py-4">
            <h3 class="text-lg font-extrabold text-slate-900">Data Tenaga Kerja Konstruksi</h3>
        </div>

        <form
            method="GET"
            action="{{ route('admin.tenaga-kerja-konstruksi') }}"
            class="flex flex-col gap-3 border-b border-slate-100 bg-white p-4 md:flex-row"
        >
            {{-- Biar filter atas tidak hilang --}}
            <input type="hidden" name="kabupaten" value="{{ $selectedKabupaten }}">
            <input type="hidden" name="mode" value="{{ $selectedMode }}">

            @foreach ($selectedJenjang as $jenjang)
                <input type="hidden" name="jenjang[]" value="{{ $jenjang }}">
            @endforeach

            {{-- Search Input --}}
            <div class="flex-1">
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Cari data tenaga kerja..."
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-[#3A4FAC] focus:bg-white focus:ring-4 focus:ring-[#3A4FAC]/10"
                >
            </div>

            {{-- Search Category --}}
            <div class="md:w-[240px]">
                <select
                    id="searchCategory"
                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#3A4FAC] focus:ring-4 focus:ring-[#3A4FAC]/10"
                >
                    <option value="nama" {{ request('search_by') == 'nama' ? 'selected' : '' }}>
                        Cari Berdasarkan Nama
                    </option>

                    <option value="kabupaten" {{ request('search_by') == 'kabupaten' ? 'selected' : '' }}>
                        Cari Berdasarkan Kabupaten
                    </option>

                    <option value="jabatan" {{ request('search_by') == 'jabatan' ? 'selected' : '' }}>
                        Cari Berdasarkan Jabatan
                    </option>
                </select>
            </div>
        </form>

        <div class="overflow-x-auto min-h-[440px]">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-[11px] font-extrabold uppercase tracking-[0.08em] text-slate-500">
                            Nama
                        </th>

                        <th class="px-4 py-2 text-left text-[11px] font-extrabold uppercase tracking-[0.08em] text-slate-500">
                            Kabupaten
                        </th>

                        <th class="px-4 py-2 text-left text-[11px] font-extrabold uppercase tracking-[0.08em] text-slate-500">
                            Jabatan Kerja
                        </th>

                        <th class="px-4 py-2 text-center text-[11px] font-extrabold uppercase tracking-[0.08em] text-slate-500">
                            Jenjang
                        </th>

                        <th class="px-4 py-2 text-center text-[11px] font-extrabold uppercase tracking-[0.08em] text-slate-500">
                            Status
                        </th>
                    </tr>
                </thead>

                <tbody id="tkkTableBody" class="divide-y divide-slate-100 bg-white">
                    @foreach ($tkkRows as $row)
                        @php
                            $statusRaw = $row['status'] ?? '-';
                            $statusText = ucfirst(strtolower($statusRaw));
                        @endphp

                        <tr
                            class="transition hover:bg-blue-50/30"
                            data-nama="{{ strtolower($row['nama'] ?? '') }}"
                            data-kabupaten="{{ strtolower($row['kabupaten'] ?? '') }}"
                            data-jabatan="{{ strtolower($row['jabatan'] ?? '') }}"
                        >
                            <td class="whitespace-nowrap px-4 py-2 text-[13px] font-semibold text-slate-700">
                                {{ $row['nama'] }}
                            </td>

                            <td class="whitespace-nowrap px-4 py-2 text-[13px] text-slate-600">
                                {{ $row['kabupaten'] }}
                            </td>

                            <td class="min-w-[260px] px-4 py-2 text-[13px] text-slate-600">
                                {{ $row['jabatan'] }}
                            </td>

                            <td class="whitespace-nowrap px-4 py-2 text-center text-[13px] font-extrabold text-[#142B67]">
                                {{ $row['jenjang'] }}
                            </td>

                            <td class="whitespace-nowrap px-4 py-2 text-center">
                                <span class="
                                    inline-flex rounded-full px-2.5 py-0.5 text-[11px] font-bold tracking-[0.06em]
                                    {{ strtolower($statusRaw) === 'aktif'
                                        ? 'bg-emerald-100 text-emerald-700'
                                        : 'bg-red-100 text-red-700' }}
                                ">
                                    {{ $statusText }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex flex-col gap-3 border-t border-slate-100 bg-white px-6 py-4 text-sm sm:flex-row sm:items-center sm:justify-between">
           <p id="tableInfo" class="font-semibold text-slate-600">
                Hal:
                <span class="font-extrabold text-slate-900">
                    1 - {{ min(10, $totalTkk ?? 0) }}
                </span>
                dari
                <span class="font-extrabold text-slate-900">
                    {{ $totalTkk ?? 0 }}
                </span>
            </p>

            <div class="flex items-center gap-2">

                <button
                    id="prevBtn"
                    type="button"
                    onclick="fetchSearchData(currentPage - 1)"
                    class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-bold text-slate-600 transition hover:bg-slate-100 disabled:cursor-not-allowed disabled:opacity-40"
                >
                    Prev
                </button>

                <div id="paginationNumbers" class="flex items-center gap-1">
                </div>

                <button
                    id="nextBtn"
                    type="button"
                    onclick="fetchSearchData(currentPage + 1)"
                    class="rounded-xl border border-[#142B67] bg-[#142B67] px-3 py-2 text-sm font-bold text-white transition hover:bg-[#1d3b8f] disabled:cursor-not-allowed disabled:opacity-40"
                >
                    Next
                </button>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const gridColor = 'rgba(148, 163, 184, 0.16)';
    const textColor = '#475569';

    const sibikonAccent = [
        '#142B67',
        '#FACC15',
        '#F97316',
        '#C0267B',
        '#22C55E',
        '#06B6D4'
    ];

    const bluePalette = [
        '#173A73',
        '#2F67A0',
        '#5B9BC8',
        '#90C4DF',
        '#B8DDED'
    ];

    const statusPalette = [
        '#142B67',
        '#FACC15'
    ];

    function formatNumber(value) {
        return new Intl.NumberFormat('id-ID').format(value);
    }

    function formatStatusText(status) {
        if (!status) {
            return '-';
        }

        const normalized = String(status).toLowerCase();

        return normalized.charAt(0).toUpperCase() + normalized.slice(1);
    }

    function escapeHtml(value) {
        return String(value ?? '-')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function truncateLabel(label, max = 18) {
        if (!label) return '';
        return label.length > max ? label.substring(0, max) + '…' : label;
    }

    function tooltipLabel() {
        return {
            callbacks: {
                label: function(context) {
                    return formatNumber(context.raw);
                }
            }
        };
    }

    function resolveColors(labels, colors) {
        if (Array.isArray(colors) && colors.length === labels.length) {
            return colors;
        }

        return labels.map((_, i) => colors[i % colors.length]);
    }

    function barChart(id, labels, values, horizontal = false, colors = bluePalette) {
        const el = document.getElementById(id);
        if (!el) return;

        new Chart(el, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    data: values,
                    backgroundColor: resolveColors(labels, colors),
                    borderRadius: 8,
                    maxBarThickness: 36
                }]
            },
            options: {
                indexAxis: horizontal ? 'y' : 'x',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: tooltipLabel()
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            color: textColor,
                            font: { size: 11 },
                            maxRotation: 0,
                            minRotation: 0,
                            callback: function(value) {
                                if (horizontal) return formatNumber(value);

                                const label = this.getLabelForValue(value);
                                return truncateLabel(label, 11);
                            }
                        },
                        grid: { color: gridColor }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: textColor,
                            font: { size: 11 },
                            callback: function(value) {
                                if (horizontal) {
                                    const label = this.getLabelForValue(value);
                                    return truncateLabel(label, 24);
                                }

                                return formatNumber(value);
                            }
                        },
                        grid: { color: gridColor }
                    }
                }
            }
        });
    }

    function pieChart(id, labels, values) {

        const el = document.getElementById(id);
        if (!el) return;

        new Chart(el, {
            type: 'pie',
            data: {
                labels,
                datasets: [{
                    data: values,
                    backgroundColor: sibikonAccent,
                    borderWidth: 0,
                    hoverOffset: 6,
                    radius: '78%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,

                layout: {
                    padding: 10
                },

                plugins: {

                    legend: {
                        position: 'right',

                        labels: {

                            color: textColor,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 14,

                            font: {
                                size: 12,
                                weight: '600'
                            },

                            generateLabels(chart) {

                                const data = chart.data;

                                return data.labels.map((label, i) => {

                                    const value = data.datasets[0].data[i];

                                    return {
                                        text: `${label} : ${formatNumber(value)}`,
                                        fillStyle: data.datasets[0].backgroundColor[i],
                                        strokeStyle: data.datasets[0].backgroundColor[i],
                                        lineWidth: 0,
                                        hidden: false,
                                        index: i,
                                        pointStyle: 'circle'
                                    };
                                });
                            }
                        }
                    },

                    tooltip: {
                        callbacks: {
                            label: function(context) {

                                const total = context.dataset.data.reduce((a, b) => a + b, 0);

                                const percent = total
                                    ? ((context.raw / total) * 100).toFixed(1)
                                    : 0;

                                return `${context.label}: ${formatNumber(context.raw)} (${percent}%)`;
                            }
                        }
                    }
                }
            }
        });
    }

    function lineChart(id, labels, values) {
        const el = document.getElementById(id);
        if (!el) return;

        new Chart(el, {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    data: values,
                    borderColor: '#2F67A0',
                    backgroundColor: 'rgba(47, 103, 160, 0.10)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#142B67',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: tooltipLabel()
                },
                scales: {
                    x: {
                        ticks: {
                            color: textColor,
                            font: { size: 11 }
                        },
                        grid: { color: gridColor }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: textColor,
                            font: { size: 11 },
                            callback: value => formatNumber(value)
                        },
                        grid: { color: gridColor }
                    }
                }
            }
        });
    }

    function hexToRgb(hex) {
        const cleanHex = hex.replace('#', '');
        const bigint = parseInt(cleanHex, 16);

        return {
            r: (bigint >> 16) & 255,
            g: (bigint >> 8) & 255,
            b: bigint & 255
        };
    }

    function interpolateColor(color1, color2, factor) {
        const c1 = hexToRgb(color1);
        const c2 = hexToRgb(color2);

        const r = Math.round(c1.r + (c2.r - c1.r) * factor);
        const g = Math.round(c1.g + (c2.g - c1.g) * factor);
        const b = Math.round(c1.b + (c2.b - c1.b) * factor);

        return `rgb(${r}, ${g}, ${b})`;
    }

    function buildKabupatenColors(values) {
        const maxValue = Math.max(...values);
        const minValue = Math.min(...values);

        const darkest = '#173A73';
        const lightest = '#D9E8F4';

        return values.map((value) => {
            if (maxValue === minValue) return darkest;

            const normalized = (maxValue - value) / (maxValue - minValue);
            return interpolateColor(darkest, lightest, normalized);
        });
    }

    pieChart(
        'statusSertifikasiChart',
        @json(collect($statusSertifikasi)->pluck('label')),
        @json(collect($statusSertifikasi)->pluck('value'))
    );

    barChart(
        'distribusiJenjangChart',
        @json(collect($distribusiJenjang)->pluck('label')),
        @json(collect($distribusiJenjang)->pluck('value')),
        false,
        bluePalette
    );

    barChart(
        'topAsosiasiChart',
        @json(collect($topAsosiasi)->pluck('label')),
        @json(collect($topAsosiasi)->pluck('value')),
        true,
        bluePalette
    );

    barChart(
        'topKlasifikasiChart',
        @json(collect($topKlasifikasi)->pluck('label')),
        @json(collect($topKlasifikasi)->pluck('value')),
        true,
        bluePalette
    );

    const perbandinganKabupatenLabels = @json(collect($perbandinganKabupaten)->pluck('label'));
    const perbandinganKabupatenValues = @json(collect($perbandinganKabupaten)->pluck('value'));
    const perbandinganKabupatenColors = bluePalette;
    
    barChart(
        'perbandinganKabupatenChart',
        perbandinganKabupatenLabels,
        perbandinganKabupatenValues,
        true,
        perbandinganKabupatenColors
    );

    lineChart(
        'proyeksiKadaluarsaChart',
        @json(collect($proyeksiKadaluarsa)->pluck('label')),
        @json(collect($proyeksiKadaluarsa)->pluck('value'))
    );

    // ======================
    // AJAX LIVE SEARCH
    // ======================

    const searchInput = document.getElementById('searchInput');
    const searchCategory = document.getElementById('searchCategory');
    const tableBody = document.getElementById('tkkTableBody');
    const tableInfo = document.getElementById('tableInfo');

    var currentPage = 1;
    var debounceTimer;

    async function fetchSearchData(page = 1) {

        const keyword = searchInput.value;
        const category = searchCategory.value;

        currentPage = page;

        try {

            const response = await fetch(
                `/admin/tenaga-kerja-konstruksi/search?keyword=${encodeURIComponent(keyword)}&category=${category}&page=${page}`
            );

            const result = await response.json();

            renderTable(result.data);

            updatePagination(
                result.total,
                result.current_page,
                result.last_page
            );

        } catch (error) {
            console.error('Search error:', error);
        }
    }

    function renderTable(rows) {

        if (rows.length === 0) {

            tableBody.innerHTML = `
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-sm text-slate-400">
                        Data tidak ditemukan
                    </td>
                </tr>
            `;

            return;
        }

        let html = '';

        rows.forEach((row) => {

            const rawStatus = row.status ?? '-';
            const statusText = formatStatusText(rawStatus);

            const statusClass =
                String(rawStatus).toLowerCase() === 'aktif'
                    ? 'bg-emerald-100 text-emerald-700'
                    : 'bg-red-100 text-red-700';

            html += `
                <tr class="transition hover:bg-blue-50/30">

                    <td class="whitespace-nowrap px-4 py-2 text-[13px] font-semibold text-slate-700">
                        ${escapeHtml(row.nama)}
                    </td>

                    <td class="whitespace-nowrap px-4 py-2 text-[13px] text-slate-600">
                        ${escapeHtml(row.kabupaten)}
                    </td>

                    <td class="min-w-[260px] px-4 py-2 text-[13px] text-slate-600">
                        ${escapeHtml(row.jabatan)}
                    </td>

                    <td class="whitespace-nowrap px-4 py-2 text-center text-[13px] font-extrabold text-[#142B67]">
                        ${escapeHtml(row.jenjang)}
                    </td>

                    <td class="whitespace-nowrap px-4 py-2 text-center">
                        <span class="inline-flex rounded-full px-2.5 py-0.5 text-[11px] font-bold tracking-[0.06em] ${statusClass}">
                            ${escapeHtml(statusText)}
                        </span>
                    </td>
                </tr>
            `;
        });

        tableBody.innerHTML = html;

        const total = rows.length;

        tableInfo.innerHTML = `
            Hal:
            <span class="font-extrabold text-slate-900">
                ${total > 0 ? `1 - ${total}` : '0'}
            </span>
            dari
            <span class="font-extrabold text-slate-900">
                ${total}
            </span>
        `;
    }

    searchInput.addEventListener('input', () => {

        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(() => {
            fetchSearchData(1);
        }, 300);
    });

    function updatePagination(total, currentPage, lastPage) {

        const start = total === 0
            ? 0
            : ((currentPage - 1) * 10) + 1;

        const end = Math.min(currentPage * 10, total);

        tableInfo.innerHTML = `
            Hal:
            <span class="font-extrabold text-slate-900">
                ${start} - ${end}
            </span>
            dari
            <span class="font-extrabold text-slate-900">
                ${total}
            </span>
        `;

        document.getElementById('prevBtn').disabled = currentPage <= 1;

        document.getElementById('nextBtn').disabled = currentPage >= lastPage;

        const paginationNumbers = document.getElementById('paginationNumbers');

        let paginationHtml = '';

        function createPageButton(page) {

            return `
                <button
                    onclick="fetchSearchData(${page})"
                    class="
                        min-w-[36px]
                        rounded-xl
                        px-3
                        py-2
                        text-sm
                        font-bold
                        transition
                        ${
                            page === currentPage
                                ? 'bg-[#142B67] text-white'
                                : 'border border-slate-200 bg-white text-slate-600 hover:bg-slate-100'
                        }
                    "
                >
                    ${page}
                </button>
            `;
        }

        if (lastPage <= 7) {

            for (let i = 1; i <= lastPage; i++) {
                paginationHtml += createPageButton(i);
            }

        } else {

            if (currentPage <= 3) {

                for (let i = 1; i <= 3; i++) {
                    paginationHtml += createPageButton(i);
                }

                paginationHtml += `
                    <span class="px-1 text-slate-400">...</span>
                `;

                for (let i = lastPage - 2; i <= lastPage; i++) {
                    paginationHtml += createPageButton(i);
                }

            } else if (currentPage > 3 && currentPage < lastPage - 2) {

                paginationHtml += createPageButton(1);

                paginationHtml += `
                    <span class="px-1 text-slate-400">...</span>
                `;

                for (let i = currentPage - 1; i <= currentPage + 1; i++) {
                    paginationHtml += createPageButton(i);
                }

                paginationHtml += `
                    <span class="px-1 text-slate-400">...</span>
                `;

                paginationHtml += createPageButton(lastPage);

            } else {

                paginationHtml += createPageButton(1);

                paginationHtml += `
                    <span class="px-1 text-slate-400">...</span>
                `;

                for (let i = lastPage - 2; i <= lastPage; i++) {
                    paginationHtml += createPageButton(i);
                }
            }
        }

        paginationNumbers.innerHTML = paginationHtml;
    }

    searchCategory.addEventListener('change', function () {
        fetchSearchData(1);
    });

    updatePagination(
        {{ $totalTkk ?? 0 }},
        1,
        {{ ceil(($totalTkk ?? 0) / 10) }}
    );
</script>
@endpush