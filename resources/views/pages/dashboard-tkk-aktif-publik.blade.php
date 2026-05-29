@extends('layouts.app')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Dashboard TKK Aktif')

@section('content')
<div class="mx-auto max-w-6xl space-y-4">

    {{-- Header --}}
    <div class="mt-10 rounded-[22px] bg-gradient-to-r from-[#142B67] via-[#1E3A7A] to-[#2F49A8] px-6 py-5 text-white shadow-lg">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-blue-100/70">
                    Sistem Informasi Bina Konstruksi
                </p>

                <h1 class="mt-2 text-2xl font-black">
                    Dashboard TKK Aktif
                </h1>

                <p class="mt-2 max-w-2xl text-sm text-blue-100/80">
                    Visualisasi data tenaga kerja konstruksi dengan status sertifikat aktif di Kalimantan Timur.
                </p>
            </div>

            <div class="flex gap-3">

                <div class="rounded-2xl bg-white/10 px-4 py-3 backdrop-blur">
                    <p class="text-[11px] uppercase tracking-[0.15em] text-blue-100/70">
                        Total TKK Aktif
                    </p>

                    <h3 class="mt-1 text-2xl font-black text-[#FACC15]">
                        {{ number_format($totalTkkAktif ?? 0, 0, ',', '.') }}
                    </h3>
                </div>

                <div class="rounded-2xl bg-white/10 px-4 py-3 backdrop-blur">
                    <p class="text-[11px] uppercase tracking-[0.15em] text-blue-100/70">
                        Akan Kadaluarsa
                    </p>

                    <h3 class="mt-1 text-2xl font-black text-[#FACC15]">
                        {{ number_format($totalAkanKadaluarsa ?? 0, 0, ',', '.') }}
                    </h3>
                </div>

            </div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 gap-9 xl:grid-cols-2">

        <x-dashboard-chart-card
            title="Distribusi Masa Berlaku"
            canvas="masaBerlakuChart"
            height="h-[240px]"
        />

        <x-dashboard-chart-card
            title="Top 5 Kabupaten/Kota TKK Aktif"
            canvas="kabupatenAktifChart"
            height="h-[240px]"
        />

        <x-dashboard-chart-card
            title="Top 5 Jenjang Sertifikat Aktif"
            canvas="jenjangAktifChart"
            height="h-[240px]"
        />

        <x-dashboard-chart-card
            title="Perbandingan Status Sertifikat"
            canvas="statusSertifikatChart"
            height="h-[240px]"
        />

        <div class="mb-9 sibikon-card overflow-hidden rounded-[20px] border border-slate-200 bg-white xl:col-span-2">
            <div class="border-b border-slate-100 px-4 py-3">
                <h3 class="text-sm font-extrabold text-slate-900">
                    Tren Kadaluarsa Sertifikat
                </h3>
            </div>

            <div class="relative overflow-hidden p-4">

                <img
                    src="{{ asset('images/logo-sibikon.png') }}"
                    alt="Logo Sibikon"
                    class="pointer-events-none absolute left-1/2 top-1/2 w-36 -translate-x-1/2 -translate-y-1/2 opacity-[0.05]"
                >

                <div class="relative z-10 h-[300px]">
                    <canvas id="trenKadaluarsaChart"></canvas>
                </div>

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
        '#142B67',
        '#2F49A8',
        '#5B7BE0',
        '#90A8F8',
        '#C7D2FE'
    ];

    const statusPalette = [
        '#16A34A',
        '#EAB308',
        '#F97316',
        '#DC2626'
    ];

    function formatNumber(value) {
        return new Intl.NumberFormat('id-ID').format(value);
    }

    function truncateLabel(label, max = 18) {
        if (!label) return '';

        return label.length > max
            ? label.substring(0, max) + '…'
            : label;
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

                            callback: function(value) {

                                if (horizontal) {
                                    return formatNumber(value);
                                }

                                const label = this.getLabelForValue(value);

                                return truncateLabel(label, 11);
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

                            callback: function(value) {

                                if (horizontal) {
                                    const label = this.getLabelForValue(value);

                                    return truncateLabel(label, 22);
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

    function doughnutChart(id, labels, values, colors) {

        const el = document.getElementById(id);

        if (!el) return;

        new Chart(el, {
            type: 'doughnut',

            data: {
                labels,

                datasets: [{
                    data: values,
                    backgroundColor: colors,
                    borderWidth: 0
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        position: 'bottom'
                    },

                    tooltip: tooltipLabel()
                },

                cutout: '68%'
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
                    borderColor: '#2F49A8',
                    backgroundColor: 'rgba(47, 73, 168, 0.10)',
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
                    legend: {
                        display: false
                    },

                    tooltip: tooltipLabel()
                },

                scales: {
                    x: {
                        ticks: {
                            color: textColor
                        },

                        grid: {
                            color: gridColor
                        }
                    },

                    y: {
                        beginAtZero: true,

                        ticks: {
                            color: textColor,

                            callback: value => formatNumber(value)
                        },

                        grid: {
                            color: gridColor
                        }
                    }
                }
            }
        });
    }

    // Distribusi Masa Berlaku
    doughnutChart(
        'masaBerlakuChart',
        @json(collect($distribusiMasaBerlaku ?? [])->pluck('label')->values()),
        @json(collect($distribusiMasaBerlaku ?? [])->pluck('value')->values()),
        statusPalette
    );

    // Kabupaten Aktif
    barChart(
        'kabupatenAktifChart',
        @json(collect($topKabupatenAktif ?? [])->pluck('label')->values()),
        @json(collect($topKabupatenAktif ?? [])->pluck('value')->values()),
        true,
        bluePalette
    );

    // Jenjang Aktif
    barChart(
        'jenjangAktifChart',
        @json(collect($topJenjangAktif ?? [])->pluck('label')->values()),
        @json(collect($topJenjangAktif ?? [])->pluck('value')->values()),
        true,
        bluePalette
    );

    // Status Sertifikat
    doughnutChart(
        'statusSertifikatChart',
        @json(collect($perbandinganStatus ?? [])->pluck('label')->values()),
        @json(collect($perbandinganStatus ?? [])->pluck('value')->values()),
        ['#16A34A', '#DC2626']
    );

    // Tren Kadaluarsa
    lineChart(
        'trenKadaluarsaChart',
        @json(collect($trenKadaluarsa ?? [])->pluck('label')->values()),
        @json(collect($trenKadaluarsa ?? [])->pluck('value')->values())
    );
</script>
@endpush