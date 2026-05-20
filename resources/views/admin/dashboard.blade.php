@extends('layouts.admin')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Dashboard Badan Usaha Jasa Konstruksi')

@section('content')
<div class="space-y-6">
    {{-- Placeholder GIS --}}
    <div class="sibikon-card overflow-hidden rounded-[24px]">
        <div class="border-b border-slate-200 bg-slate-100 px-6 py-4">
            <h3 class="text-xl font-extrabold text-slate-900">Peta Sebaran BUJK</h3>
            <p class="text-sm text-slate-500">Area ini disiapkan untuk integrasi GIS / Leaflet.</p>
        </div>

        <div class="relative flex min-h-[320px] items-center justify-center bg-[#EAF0F8]">
            <div class="text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-white shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#3A4FAC]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                </div>

                <h4 class="mt-4 text-xl font-extrabold text-slate-900">Area GIS</h4>
                <p class="mt-1 text-sm text-slate-500">Nanti bagian ini bisa diganti dengan peta interaktif.</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
        @foreach ($kpi as $index => $item)
        <div class="group relative overflow-hidden rounded-[26px] border border-white/10 bg-gradient-to-br from-[#142B67] via-[#1E3A7A] to-[#2F49A8] p-6 text-white shadow-[0_18px_45px_rgba(20,43,103,0.16)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_24px_60px_rgba(20,43,103,0.22)]">
            <div class="absolute -right-12 -top-12 h-36 w-36 rounded-full bg-white/10 transition duration-300 group-hover:scale-125"></div>
            <div class="absolute -bottom-14 left-8 h-32 w-32 rounded-full {{ $index === 0 ? 'bg-[#FACC15]/20' : 'bg-[#22C55E]/20' }} blur-2xl"></div>

            <div class="relative z-10 flex items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/12 ring-1 ring-white/15">
                        @if($item['label'] === 'BUJK')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#FACC15]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 21V5a2 2 0 012-2h8a2 2 0 012 2v16M4 21h16M8 7h2m-2 4h2m-2 4h2m6-8h2m-2 4h2m-2 4h2" />
                        </svg>
                        @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#FACC15]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v14l-3-2-3 2-3-2-3 2V6a2 2 0 012-2z" />
                        </svg>
                        @endif
                    </div>

                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.22em] text-blue-100/65">
                            {{ $item['label'] }}
                        </p>
                        <h3 class="mt-1 text-lg font-extrabold text-white">
                            {{ $item['title'] }}
                        </h3>
                    </div>
                </div>

                <div class="text-right">
                    <p class="text-3xl font-black tracking-tight text-[#FACC15] md:text-4xl">
                        {{ $item['value'] }}
                    </p>
                    <p class="mt-1 text-xs font-medium text-blue-100/70">
                        total data
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    {{-- Row 1 --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <x-dashboard-chart-card title="Asosiasi BUJK" canvas="associationChart" height="h-[280px]" />
        <x-dashboard-chart-card title="Jenis Usaha Berdasarkan BUJK" canvas="jenisBujkChart" height="h-[280px]" />
        <x-dashboard-chart-card title="Jenis Usaha Berdasarkan SBU" canvas="jenisSbuChart" height="h-[280px]" />
    </div>

    {{-- Row 2 --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
        <x-dashboard-chart-card title="Pelaksana Sertifikasi SBU" canvas="pelaksanaChart" height="h-[320px]" />
        <x-dashboard-chart-card title="KBLI SBU" canvas="kbliChart" height="h-[320px]" />
    </div>

    {{-- Row 3 --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <x-dashboard-chart-card title="Kualifikasi SBU" canvas="qualificationChart" height="h-[300px]" />
        <x-dashboard-chart-card title="Sub Klasifikasi SBU" canvas="subKlasifikasiChart" height="h-[300px]" />
        <x-dashboard-chart-card title="Sifat Berdasarkan SBU" canvas="sifatChart" height="h-[300px]" />
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const gridColor = 'rgba(148, 163, 184, 0.16)';
    const textColor = '#475569';

    const sibikonAccent = ['#142B67', '#FACC15', '#F97316', '#C0267B', '#22C55E', '#06B6D4'];

    const bluePalette = [
        '#173A73',
        '#2F67A0',
        '#5B9BC8',
        '#90C4DF',
        '#B8DDED'
    ];

    function formatNumber(value) {
        return new Intl.NumberFormat('id-ID').format(value);
    }

    function barChart(id, labels, values, horizontal = false) {
        const el = document.getElementById(id);
        if (!el) return;

        new Chart(el, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    data: values,
                    backgroundColor: labels.map((_, i) => bluePalette[i % bluePalette.length]),
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
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return formatNumber(context.raw);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: textColor,
                            font: {
                                size: 11
                            },
                            maxRotation: 0,
                            minRotation: 0,
                            callback: function(value) {
                                if (horizontal) return formatNumber(value);

                                const label = this.getLabelForValue(value);
                                return label.length > 9 ? label.substring(0, 9) + '…' : label;
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
                                return horizontal ? this.getLabelForValue(value) : formatNumber(value);
                            }
                        },
                        grid: {
                            color: horizontal ? gridColor : gridColor
                        }
                    }
                }
            }
        });
    }

    function pieChart(id, labels, values) {
        const el = document.getElementById(id);
        if (!el) return;

        new Chart(el, {
            type: 'pie', // 🔥 ini kuncinya
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
                            font: {
                                size: 12
                            }
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

    barChart(
        'associationChart',
        @json(collect($association) -> pluck('label')),
        @json(collect($association) -> pluck('value')),
        true
    );

    pieChart(
        'jenisBujkChart',
        @json(collect($jenisBujk) -> pluck('label')),
        @json(collect($jenisBujk) -> pluck('value'))
    );

    pieChart(
        'jenisSbuChart',
        @json(collect($jenisSbu) -> pluck('label')),
        @json(collect($jenisSbu) -> pluck('value'))
    );

    barChart(
        'pelaksanaChart',
        @json(collect($pelaksanaSbu) -> pluck('label')),
        @json(collect($pelaksanaSbu) -> pluck('value')),
        false
    );

    barChart(
        'kbliChart',
        @json(collect($kbliSbu) -> pluck('label')),
        @json(collect($kbliSbu) -> pluck('value')),
        false
    );

    pieChart(
        'qualificationChart',
        @json(collect($kualifikasiSbu) -> pluck('label')),
        @json(collect($kualifikasiSbu) -> pluck('value'))
    );

    barChart(
        'subKlasifikasiChart',
        @json(collect($subKlasifikasiSbu) -> pluck('label')),
        @json(collect($subKlasifikasiSbu) -> pluck('value')),
        false
    );

    barChart(
        'sifatChart',
        @json(collect($sifatSbu) -> pluck('label')),
        @json(collect($sifatSbu) -> pluck('value')),
        false
    );

</script>
@endpush