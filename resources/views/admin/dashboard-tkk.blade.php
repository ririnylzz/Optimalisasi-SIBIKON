@extends('layouts.admin')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Dashboard Tenaga Kerja Konstruksi')

@section('content')
<div class="space-y-6">
    {{-- Filter --}}
    <div class="sibikon-card overflow-hidden rounded-[24px] border border-slate-200 bg-white">
        <div class="border-b border-slate-100 bg-gradient-to-r from-slate-50 to-blue-50/60 px-6 py-4">
            <h3 class="text-lg font-extrabold text-slate-900">Filter Dashboard TKK</h3>
            <p class="text-sm text-slate-500">Gunakan filter untuk melihat data tenaga kerja konstruksi berdasarkan wilayah dan jenjang.</p>
        </div>

        <div class="grid grid-cols-1 gap-4 p-6 xl:grid-cols-12">
            <div class="xl:col-span-4">
                <label class="mb-2 block text-xs font-extrabold uppercase tracking-[0.16em] text-slate-500">Filter Kabupaten</label>
                <select class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#3A4FAC] focus:ring-4 focus:ring-[#3A4FAC]/10">
                    <option>Semua Kabupaten</option>
                    @foreach ($kabupatenOptions as $kabupaten)
                        <option>{{ $kabupaten }}</option>
                    @endforeach
                </select>
            </div>

            <div class="xl:col-span-4">
                <label class="mb-2 block text-xs font-extrabold uppercase tracking-[0.16em] text-slate-500">Mode Tampilan Data</label>
                <select class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#3A4FAC] focus:ring-4 focus:ring-[#3A4FAC]/10">
                    <option>TKK Ahli (Semua SKK)</option>
                    <option>TKK Aktif</option>
                    <option>SKK Kadaluarsa Tahun Ini</option>
                    <option>Distribusi Kabupaten</option>
                </select>
            </div>

            <div class="xl:col-span-3">
                <label class="mb-2 block text-xs font-extrabold uppercase tracking-[0.16em] text-slate-500">Pilih Jenjang</label>
                <div class="flex flex-wrap gap-2">
                    @foreach ([7, 8, 9] as $jenjang)
                        <label class="inline-flex cursor-pointer items-center gap-2 rounded-2xl border border-[#3A4FAC]/15 bg-[#3A4FAC]/10 px-4 py-3 text-sm font-extrabold text-[#142B67] transition hover:bg-[#3A4FAC]/15">
                            <input type="checkbox" checked class="h-4 w-4 rounded border-slate-300 text-[#3A4FAC] focus:ring-[#3A4FAC]">
                            {{ $jenjang }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex items-end xl:col-span-1">
                <button class="w-full rounded-2xl bg-gradient-to-br from-[#142B67] via-[#1E3A7A] to-[#2F49A8] px-5 py-3 text-sm font-extrabold text-white shadow-[0_12px_30px_rgba(20,43,103,0.18)] transition hover:-translate-y-0.5 hover:shadow-[0_16px_36px_rgba(20,43,103,0.24)]">
                    Terapkan
                </button>
            </div>
        </div>
    </div>

    {{-- Charts Row 1 --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
        <x-dashboard-chart-card title="Status Sertifikasi" canvas="statusSertifikasiChart" height="h-[340px]" />
        <x-dashboard-chart-card title="Distribusi Jenjang" canvas="distribusiJenjangChart" height="h-[340px]" />
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
            <p class="text-sm text-slate-500">Contoh tampilan data TKK. Nanti bagian ini bisa disambungkan ke database.</p>
        </div>

        <div class="grid grid-cols-1 gap-3 border-b border-slate-100 bg-white p-4 md:grid-cols-3">
            <input type="text" placeholder="Cari Nama..." class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm outline-none transition focus:border-[#3A4FAC] focus:bg-white focus:ring-4 focus:ring-[#3A4FAC]/10">
            <input type="text" placeholder="Cari Kabupaten..." class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm outline-none transition focus:border-[#3A4FAC] focus:bg-white focus:ring-4 focus:ring-[#3A4FAC]/10">
            <input type="text" placeholder="Cari Jabatan..." class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm outline-none transition focus:border-[#3A4FAC] focus:bg-white focus:ring-4 focus:ring-[#3A4FAC]/10">
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-[0.14em] text-slate-500">Nama</th>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-[0.14em] text-slate-500">Kabupaten</th>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-[0.14em] text-slate-500">Jabatan Kerja</th>
                        <th class="px-6 py-4 text-center text-xs font-extrabold uppercase tracking-[0.14em] text-slate-500">Jenjang</th>
                        <th class="px-6 py-4 text-center text-xs font-extrabold uppercase tracking-[0.14em] text-slate-500">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 bg-white">
                    @foreach ($tkkRows as $row)
                        <tr class="transition hover:bg-blue-50/40">
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-slate-700">{{ $row['nama'] }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">{{ $row['kabupaten'] }}</td>
                            <td class="min-w-[360px] px-6 py-4 text-sm text-slate-600">{{ $row['jabatan'] }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-extrabold text-[#142B67]">{{ $row['jenjang'] }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                <span class="inline-flex rounded-full bg-[#142B67]/10 px-3 py-1 text-xs font-extrabold uppercase tracking-wide text-[#142B67]">
                                    {{ $row['status'] }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex flex-col gap-3 border-t border-slate-100 bg-white px-6 py-4 text-sm sm:flex-row sm:items-center sm:justify-between">
            <p class="font-semibold text-slate-600">
                Hal: <span class="font-extrabold text-slate-900">1 - {{ min(10, $totalTkk ?? 0) }}</span> dari <span class="font-extrabold text-slate-900">{{ $totalTkk ?? 0 }}</span>
            </p>

            <div class="flex gap-2">
                <button class="rounded-xl border border-slate-200 bg-slate-100 px-4 py-2 text-sm font-bold text-slate-400">Prev</button>
                <button class="rounded-xl border border-[#142B67] bg-[#142B67] px-4 py-2 text-sm font-bold text-white">Next</button>
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
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            color: textColor,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 14,
                            font: { size: 12 }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percent = total ? ((context.raw / total) * 100).toFixed(1) : 0;
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
</script>
@endpush