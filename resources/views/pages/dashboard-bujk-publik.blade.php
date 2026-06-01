@extends('layouts.app')

@section('page-title', 'Dashboard BUJK')
@section('page-subtitle', 'Dashboard Badan Usaha Jasa Konstruksi')

@section('content')
@php
$latestDataDate = $latestDataDate ?? null;
$latestDataDateLabel = null;

if (!blank($latestDataDate)) {
try {
$latestDataDateLabel = \Illuminate\Support\Carbon::parse($latestDataDate)
->locale('id')
->translatedFormat('d F Y');
} catch (\Throwable $exception) {
$latestDataDateLabel = $latestDataDate;
}
}
@endphp

<div class="mx-auto max-w-6xl space-y-6">

    {{-- Header --}}
    <div class="mt-10 rounded-[22px] bg-gradient-to-r from-[#142B67] via-[#1E3A7A] to-[#2F49A8] px-6 py-5 text-white shadow-lg">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-blue-100/70">
                    Sistem Informasi Bina Konstruksi Provinsi Kalimantan Timur
                </p>

                <h1 class="mt-2 text-2xl font-black">
                    Dashboard Badan Usaha Jasa Konstruksi
                </h1>

                @if($latestDataDateLabel)
                <div class="mt-4">
                    <span class="inline-flex items-center rounded-full border border-blue-200/30 bg-white/10 px-4 py-2 text-xs font-semibold text-blue-50 backdrop-blur">
                        Data terbaru per {{ \Carbon\Carbon::parse($latestDataDate)->translatedFormat('d F Y') }}
                    </span>
                </div>
                @endif
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="rounded-2xl bg-white/10 px-4 py-3 backdrop-blur">
                    <p class="text-[11px] uppercase tracking-[0.15em] text-blue-100/70">
                        Total BUJK
                    </p>

                    <h3 class="mt-1 text-2xl font-black text-[#FACC15]">
                        {{ number_format($totalBujk ?? 0, 0, ',', '.') }}
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
            title="Distribusi Jenis Usaha"
            canvas="jenisUsahaChart"
            height="h-[260px]" />

        <x-dashboard-chart-card
            title="Perbandingan BUJK Kab/Kota"
            canvas="kabupatenChart"
            height="h-[320px]" />

        <x-dashboard-chart-card
            title="Kelengkapan Kontak"
            canvas="kontakChart"
            height="h-[260px]" />

        {{-- Data Terbaru --}}
        <div class="mb-9 sibikon-card overflow-hidden rounded-[20px] border border-slate-200 bg-white">
            <div class="border-b border-slate-100 px-4 py-3">
                <h3 class="text-sm font-extrabold text-slate-900">
                    Data BUJK Terbaru
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
                                Jenis
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-black uppercase tracking-wider text-slate-500">
                                Kab/Kota
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse (($latestBujk ?? []) as $item)
                        <tr>
                            <td class="px-4 py-3 text-sm font-bold text-slate-800">
                                {{ $item['nama'] ?: '-' }}
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
                                Data BUJK belum tersedia.
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

    const statusPalette = [
        '#173A73',
        '#FACC15',
        '#5B9BC8'
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

    function doughnutChart(id, labels, values, colors = statusPalette) {
        const el = document.getElementById(id);

        if (!el) {
            return;
        }

        new Chart(el, {
            type: 'doughnut',
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
                cutout: '62%',
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
                            }
                        }
                    },
                    tooltip: tooltipLabel()
                }
            }
        });
    }

    barChart(
        'jenisUsahaChart',
        @json(collect($jenisUsahaSummary ?? []) -> pluck('label') -> values()),
        @json(collect($jenisUsahaSummary ?? []) -> pluck('value') -> values()),
        false,
        bluePalette
    );

    barChart(
        'kabupatenChart',
        @json(collect($kabupatenSummary ?? []) -> pluck('label') -> values()),
        @json(collect($kabupatenSummary ?? []) -> pluck('value') -> values()),
        true,
        bluePalette
    );

    doughnutChart(
        'kontakChart',
        @json(collect($kontakSummary ?? []) -> pluck('label') -> values()),
        @json(collect($kontakSummary ?? []) -> pluck('value') -> values()),
        statusPalette
    );
</script>
@endpush