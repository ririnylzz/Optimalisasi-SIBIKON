@extends('layouts.app')

@section('page-title', 'Dashboard SBU')
@section('page-subtitle', 'Dashboard Sertifikat Badan Usaha')

@section('content')
<div class="mx-auto mt-8 max-w-7xl space-y-8 px-4 pb-10 sm:px-6 lg:px-8">

    {{-- KPI --}}
    <div class="grid grid-cols-1 gap-6">
        @foreach ($kpi as $item)
        <div class="overflow-hidden rounded-[24px] bg-gradient-to-br from-[#142B67] via-[#1E3A7A] to-[#2F49A8] px-6 py-5 text-white shadow-lg">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.22em] text-blue-100/70">
                        {{ $item['label'] }}
                    </p>

                    <h3 class="mt-2 text-lg font-bold">
                        {{ $item['title'] }}
                    </h3>
                </div>

                <div class="text-right">
                    <p class="text-4xl font-black text-[#FACC15]">
                        {{ $item['value'] }}
                    </p>

                    <p class="text-xs text-blue-100/70">
                        total data
                    </p>
                </div>

            </div>
        </div>
        @endforeach
    </div>

    {{-- ROW 1 --}}
    <div class="grid grid-cols-1 gap-8 xl:grid-cols-2">

        <x-dashboard-chart-card
            title="Jenis Usaha Berdasarkan SBU"
            canvas="jenisSbuChart"
            height="h-[280px]" />

        <x-dashboard-chart-card
            title="Pelaksana Sertifikasi SBU"
            canvas="pelaksanaChart"
            height="h-[280px]" />

    </div>

    {{-- ROW 2 --}}
    <div class="grid grid-cols-1 gap-8 xl:grid-cols-2">

        <x-dashboard-chart-card
            title="KBLI SBU"
            canvas="kbliChart"
            height="h-[280px]" />

        <x-dashboard-chart-card
            title="Kualifikasi SBU"
            canvas="qualificationChart"
            height="h-[280px]" />

    </div>

    {{-- ROW 3 --}}
    <div class="grid grid-cols-1 gap-8 xl:grid-cols-2">

        <x-dashboard-chart-card
            title="Sub Klasifikasi SBU"
            canvas="subKlasifikasiChart"
            height="h-[280px]" />

        <x-dashboard-chart-card
            title="Sifat Berdasarkan SBU"
            canvas="sifatChart"
            height="h-[280px]" />

    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const chartPalette = [
        '#21325e', // navy
        '#f1d00a', // yellow
        '#2F49A8', // blue
        '#f7e578', // light yellow
        '#90C4DF' // soft blue
    ];

    function pieChart(id, labels, values) {
        const el = document.getElementById(id);

        new Chart(el, {
            type: 'pie',
            data: {
                labels,
                datasets: [{
                    data: values,
                    backgroundColor: chartPalette
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    function barChart(id, labels, values) {
        const el = document.getElementById(id);

        new Chart(el, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    data: values,
                    backgroundColor: values.map((_, i) => chartPalette[i % chartPalette.length]),
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    pieChart(
        'jenisSbuChart',
        @json(collect($jenisSbu) -> pluck('label')),
        @json(collect($jenisSbu) -> pluck('value'))
    );

    barChart(
        'pelaksanaChart',
        @json(collect($pelaksanaSbu) -> pluck('label')),
        @json(collect($pelaksanaSbu) -> pluck('value'))
    );

    barChart(
        'kbliChart',
        @json(collect($kbliSbu) -> pluck('label')),
        @json(collect($kbliSbu) -> pluck('value'))
    );

    pieChart(
        'qualificationChart',
        @json(collect($kualifikasiSbu) -> pluck('label')),
        @json(collect($kualifikasiSbu) -> pluck('value'))
    );

    barChart(
        'subKlasifikasiChart',
        @json(collect($subKlasifikasiSbu) -> pluck('label')),
        @json(collect($subKlasifikasiSbu) -> pluck('value'))
    );

    barChart(
        'sifatChart',
        @json(collect($sifatSbu) -> pluck('label')),
        @json(collect($sifatSbu) -> pluck('value'))
    );
</script>
@endpush