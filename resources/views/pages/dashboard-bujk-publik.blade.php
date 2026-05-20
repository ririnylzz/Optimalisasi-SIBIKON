@extends('layouts.app')

@section('page-title', 'Dashboard BUJK')
@section('page-subtitle', 'Dashboard Badan Usaha Jasa Konstruksi')

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

    {{-- CHART --}}
    <div class="grid grid-cols-1 gap-8 xl:grid-cols-2">

        <x-dashboard-chart-card
            title="Asosiasi BUJK"
            canvas="associationChart"
            height="h-[280px]"
        />

        <x-dashboard-chart-card
            title="Jenis Usaha Berdasarkan BUJK"
            canvas="jenisBujkChart"
            height="h-[280px]"
        />

    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const sibikonAccent = ['#142B67', '#FACC15', '#F97316', '#22C55E'];

    function barChart(id, labels, values) {
        const el = document.getElementById(id);
        if (!el) return;

        new Chart(el, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    data: values,
                    backgroundColor: '#173A73',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
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
                    backgroundColor: sibikonAccent
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    barChart(
        'associationChart',
        @json(collect($association)->pluck('label')),
        @json(collect($association)->pluck('value'))
    );

    pieChart(
        'jenisBujkChart',
        @json(collect($jenisBujk)->pluck('label')),
        @json(collect($jenisBujk)->pluck('value'))
    );
</script>
@endpush