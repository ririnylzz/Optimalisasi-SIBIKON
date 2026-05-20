@extends('layouts.app')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Dashboard Badan Usaha Jasa Konstruksi')

@section('content')
<div class="mx-auto mt-8 max-w-7xl space-y-8 px-4 pb-10 sm:px-6 lg:px-8">

    {{-- KPI CARD --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        @foreach ($kpi as $index => $item)
        <div class="group relative overflow-hidden rounded-[24px] border border-white/10 bg-gradient-to-br from-[#142B67] via-[#1E3A7A] to-[#2F49A8] px-6 py-5 text-white shadow-[0_14px_36px_rgba(20,43,103,0.14)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_20px_48px_rgba(20,43,103,0.20)]">

            <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-white/10 transition duration-300 group-hover:scale-125"></div>

            <div class="absolute -bottom-12 left-6 h-28 w-28 rounded-full {{ $index === 0 ? 'bg-[#FACC15]/20' : 'bg-[#22C55E]/20' }} blur-2xl"></div>

            <div class="relative z-10 flex items-center justify-between gap-5">

                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/12 ring-1 ring-white/15">

                        @if($item['label'] === 'BUJK')
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 text-[#FACC15]"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M4 21V5a2 2 0 012-2h8a2 2 0 012 2v16M4 21h16M8 7h2m-2 4h2m-2 4h2m6-8h2m-2 4h2m-2 4h2" />
                        </svg>

                        @else
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 text-[#FACC15]"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v14l-3-2-3 2-3-2-3 2V6a2 2 0 012-2z" />
                        </svg>
                        @endif
                    </div>

                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-blue-100/65">
                            {{ $item['label'] }}
                        </p>

                        <h3 class="mt-1 text-base font-extrabold text-white">
                            {{ $item['title'] }}
                        </h3>
                    </div>
                </div>

                <div class="text-right">
                    <p class="text-3xl font-black tracking-tight text-[#FACC15]">
                        {{ $item['value'] }}
                    </p>

                    <p class="mt-1 text-[11px] font-medium text-blue-100/70">
                        total data
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ROW 1 --}}
    <div class="grid grid-cols-1 gap-8 xl:grid-cols-3">
        <x-dashboard-chart-card
            title="Asosiasi BUJK"
            canvas="associationChart"
            height="h-[250px]"
        />

        <x-dashboard-chart-card
            title="Jenis Usaha Berdasarkan BUJK"
            canvas="jenisBujkChart"
            height="h-[250px]"
        />

        <x-dashboard-chart-card
            title="Jenis Usaha Berdasarkan SBU"
            canvas="jenisSbuChart"
            height="h-[250px]"
        />
    </div>

    {{-- ROW 2 --}}
    <div class="grid grid-cols-1 gap-8 xl:grid-cols-2">
        <x-dashboard-chart-card
            title="Pelaksana Sertifikasi SBU"
            canvas="pelaksanaChart"
            height="h-[290px]"
        />

        <x-dashboard-chart-card
            title="KBLI SBU"
            canvas="kbliChart"
            height="h-[290px]"
        />
    </div>

    {{-- ROW 3 --}}
    <div class="mb-10 grid grid-cols-1 gap-8 xl:grid-cols-3">
        <x-dashboard-chart-card
            title="Kualifikasi SBU"
            canvas="qualificationChart"
            height="h-[260px]"
        />

        <x-dashboard-chart-card
            title="Sub Klasifikasi SBU"
            canvas="subKlasifikasiChart"
            height="h-[260px]"
        />

        <x-dashboard-chart-card
            title="Sifat Berdasarkan SBU"
            canvas="sifatChart"
            height="h-[260px]"
        />
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