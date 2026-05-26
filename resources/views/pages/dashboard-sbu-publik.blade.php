@extends('layouts.app')

@section('page-title', 'Dashboard SBU')
@section('page-subtitle', 'Dashboard Sertifikat Badan Usaha')

@section('content')
<div class="mx-auto max-w-6xl space-y-6">

    {{-- Header --}}
    <div class="mt-10 rounded-[22px] bg-gradient-to-r from-[#142B67] via-[#1E3A7A] to-[#2F49A8] px-6 py-5 text-white shadow-lg">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-blue-100/70">
                    Sistem Informasi Bina Konstruksi
                </p>

                <h1 class="mt-2 text-2xl font-black">
                    Dashboard Sertifikat Badan Usaha
                </h1>

                <p class="mt-2 max-w-2xl text-sm text-blue-100/80">
                    Visualisasi data sertifikat badan usaha berdasarkan jenis usaha, wilayah, pelaksana sertifikasi, dan KBLI.
                </p>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="rounded-2xl bg-white/10 px-4 py-3 backdrop-blur">
                    <p class="text-[11px] uppercase tracking-[0.15em] text-blue-100/70">
                        Total SBU
                    </p>

                    <h3 class="mt-1 text-2xl font-black text-[#FACC15]">
                        {{ number_format($totalSbu ?? 0, 0, ',', '.') }}
                    </h3>
                </div>

                <div class="rounded-2xl bg-white/10 px-4 py-3 backdrop-blur">
                    <p class="text-[11px] uppercase tracking-[0.15em] text-blue-100/70">
                        Wilayah
                    </p>

                    <h3 class="mt-1 text-2xl font-black text-[#FACC15]">
                        {{ number_format($totalWilayah ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>
    </div>

    {{-- KPI --}}
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
        @foreach (($kpi ?? []) as $item)
            <div class="rounded-[20px] border border-slate-200 bg-white px-5 py-5 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-[0.16em] text-slate-500">
                    {{ $item['label'] }}
                </p>

                <h2 class="mt-3 text-3xl font-black text-[#142B67]">
                    {{ number_format($item['value'] ?? 0, 0, ',', '.') }}
                </h2>

                <p class="mt-2 text-sm text-slate-500">
                    {{ $item['caption'] }}
                </p>
            </div>
        @endforeach
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 gap-9 xl:grid-cols-2">

        <x-dashboard-chart-card
            title="Jenis Usaha Berdasarkan SBU"
            canvas="jenisUsahaSbuChart"
            height="h-[260px]"
        />

        <x-dashboard-chart-card
            title="Perbandingan SBU Kab/Kota"
            canvas="kabupatenSbuChart"
            height="h-[320px]"
        />

        <x-dashboard-chart-card
            title="Top 5 Pelaksana Sertifikasi SBU"
            canvas="pelaksanaSbuChart"
            height="h-[260px]"
        />

        <x-dashboard-chart-card
            title="Top 5 KBLI SBU"
            canvas="kbliSbuChart"
            height="h-[260px]"
        />

        <x-dashboard-chart-card
            title="Top 5 Asosiasi SBU"
            canvas="asosiasiSbuChart"
            height="h-[260px]"
        />

        {{-- Data Terbaru --}}
        <div class="mb-9 sibikon-card overflow-hidden rounded-[20px] border border-slate-200 bg-white">
            <div class="border-b border-slate-100 px-4 py-3">
                <h3 class="text-sm font-extrabold text-slate-900">
                    Data SBU Terbaru
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-black uppercase tracking-wider text-slate-500">
                                Nama BUJK
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-black uppercase tracking-wider text-slate-500">
                                Jenis Usaha
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-black uppercase tracking-wider text-slate-500">
                                Kab/Kota
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse (($latestSbu ?? []) as $item)
                            <tr>
                                <td class="px-4 py-3 text-sm font-bold text-slate-800">
                                    {{ $item['nama'] ?: '-' }}
                                    <div class="mt-1 text-xs font-medium text-slate-500">
                                        NIB: {{ $item['nib'] ?: '-' }}
                                    </div>
                                </td>

                                <td class="px-4 py-3 text-sm text-slate-600">
                                    {{ $item['jenis_usaha'] ?: '-' }}
                                </td>

                                <td class="px-4 py-3 text-sm text-slate-600">
                                    {{ $item['kabupaten'] ?: '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-10 text-center text-sm font-semibold text-slate-500">
                                    Data SBU belum tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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

    const bluePalette = [
        '#173A73',
        '#2F67A0',
        '#5B9BC8',
        '#90C4DF',
        '#B8DDED',
        '#D9E8F4'
    ];

    const piePalette = [
        '#173A73',
        '#FACC15',
        '#5B9BC8',
        '#90C4DF',
        '#F97316',
        '#22C55E'
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
        if (!Array.isArray(colors) || colors.length === 0) {
            return '#173A73';
        }

        return labels.map((_, i) => colors[i % colors.length]);
    }

    function barChart(id, labels, values, horizontal = false, colors = bluePalette) {
        const el = document.getElementById(id);

        if (!el) {
            return;
        }

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
                    legend: {
                        display: false
                    },
                    tooltip: tooltipLabel()
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            color: textColor,
                            font: {
                                size: 11
                            },
                            maxRotation: 0,
                            minRotation: 0,
                            callback: function(value) {
                                if (horizontal) {
                                    return formatNumber(value);
                                }

                                const label = this.getLabelForValue(value);

                                return truncateLabel(label, 12);
                            }
                        },
                        grid: {
                            color: gridColor
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: textColor,
                            font: {
                                size: 11
                            },
                            callback: function(value) {
                                if (horizontal) {
                                    const label = this.getLabelForValue(value);

                                    return truncateLabel(label, 24);
                                }

                                return formatNumber(value);
                            }
                        },
                        grid: {
                            color: gridColor
                        }
                    }
                }
            }
        });
    }

    function doughnutChart(id, labels, values, colors = piePalette) {
        const el = document.getElementById(id);

        if (!el) {
            return;
        }

        new Chart(el, {
            type: 'pie',
            data: {
                labels,
                datasets: [{
                    data: values,
                    backgroundColor: resolveColors(labels, colors),
                    borderWidth: 0,
                    hoverOffset: 8
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
                            font: {
                                size: 12
                            },
                            generateLabels: function(chart) {
                                const data = chart.data;

                                if (!data.labels.length) {
                                    return [];
                                }

                                return data.labels.map(function(label, index) {
                                    const value = data.datasets[0].data[index];

                                    return {
                                        text: label + ' : ' + formatNumber(value),
                                        fillStyle: data.datasets[0].backgroundColor[index],
                                        strokeStyle: data.datasets[0].backgroundColor[index],
                                        lineWidth: 0,
                                        hidden: false,
                                        index: index,
                                        pointStyle: 'circle',
                                    };
                                });
                            }
                        }
                    },
                    tooltip: tooltipLabel()
                }
            }
        });
    }

    doughnutChart(
        'jenisUsahaSbuChart',
        @json(collect($jenisUsahaSummary ?? [])->pluck('label')->values()),
        @json(collect($jenisUsahaSummary ?? [])->pluck('value')->values()),
        piePalette
    );

    barChart(
        'kabupatenSbuChart',
        @json(collect($kabupatenSummary ?? [])->pluck('label')->values()),
        @json(collect($kabupatenSummary ?? [])->pluck('value')->values()),
        true,
        bluePalette
    );

    barChart(
        'pelaksanaSbuChart',
        @json(collect($pelaksanaSummary ?? [])->pluck('label')->values()),
        @json(collect($pelaksanaSummary ?? [])->pluck('value')->values()),
        true,
        bluePalette
    );

    barChart(
        'kbliSbuChart',
        @json(collect($kbliSummary ?? [])->pluck('label')->values()),
        @json(collect($kbliSummary ?? [])->pluck('value')->values()),
        true,
        bluePalette
    );

    barChart(
        'asosiasiSbuChart',
        @json(collect($asosiasiSummary ?? [])->pluck('label')->values()),
        @json(collect($asosiasiSummary ?? [])->pluck('value')->values()),
        true,
        bluePalette
    );
</script>
@endpush