@extends('layouts.admin')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan informasi sistem')

@section('content')
    <div class="space-y-6">
        <div class="grid grid-cols-1 gap-5 xl:grid-cols-4">
            @foreach($stats as $index => $item)
                @php
                    $accent = match($index) {
                        0 => 'bg-[#C5CAE9] text-[#21325E]',
                        1 => 'bg-sky-100 text-sky-600',
                        2 => 'bg-[#F7E578] text-[#8A6A00]',
                        default => 'bg-indigo-100 text-[#3A4FAC]',
                    };
                @endphp

                <div class="sibikon-card rounded-[28px] p-5">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-medium text-slate-500">{{ $item['title'] }}</p>
                            <h3 class="mt-2 text-4xl font-extrabold tracking-tight text-slate-900">{{ $item['value'] }}</h3>
                            <p class="mt-3 text-sm text-slate-500">{{ $item['description'] }}</p>
                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl {{ $accent }}">
                            @if($item['icon'] === 'users')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                          d="M17 20h5V18a4 4 0 00-5-3.87M17 20H7m10 0v-2c0-.653-.126-1.277-.356-1.848M7 20H2V18a4 4 0 015-3.87M7 20v-2c0-.653.126-1.277.356-1.848m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            @elseif($item['icon'] === 'briefcase')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                          d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2m-6 0h6m-6 0H6a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V8a2 2 0 00-2-2h-3"/>
                                </svg>
                            @elseif($item['icon'] === 'folder')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                          d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/>
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M16 8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                            @endif
                        </div>
                    </div>

                    <div class="mt-5">
                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $index === 2 ? 'sibikon-badge-yellow' : 'sibikon-badge-blue' }}">
                            {{ $item['trend'] }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <div class="sibikon-card rounded-[28px] p-6 xl:col-span-2">
                <div class="mb-5 flex items-center justify-between gap-3">
                    <div>
                        <h3 class="text-2xl font-extrabold tracking-tight text-slate-900">Grafik Aktivitas Sistem</h3>
                        <p class="text-sm text-slate-500">Perkembangan upload dan pertumbuhan pengguna</p>
                    </div>
                    <span class="rounded-full bg-slate-100 px-4 py-2 text-xs font-medium text-slate-500">6 bulan terakhir</span>
                </div>

                <div class="h-[320px]">
                    <canvas id="dashboardChart"></canvas>
                </div>
            </div>

            <div class="sibikon-card rounded-[28px] p-6">
                <div class="mb-5">
                    <h3 class="text-2xl font-extrabold tracking-tight text-slate-900">Ringkasan Data</h3>
                    <p class="text-sm text-slate-500">Informasi penting untuk admin</p>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                        <span class="text-sm font-medium text-slate-600">Duplicate NIB</span>
                        <span class="text-lg font-bold text-[#FB923C]">{{ $summary['duplicate_nib'] }}</span>
                    </div>
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                        <span class="text-sm font-medium text-slate-600">Duplicate Alamat</span>
                        <span class="text-lg font-bold text-[#3A4FAC]">{{ $summary['duplicate_alamat'] }}</span>
                    </div>
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                        <span class="text-sm font-medium text-slate-600">Pending Verification</span>
                        <span class="text-lg font-bold text-sky-500">{{ $summary['pending_verification'] }}</span>
                    </div>
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                        <span class="text-sm font-medium text-slate-600">Total Berita</span>
                        <span class="text-lg font-bold text-[#21325E]">{{ $summary['total_berita'] }}</span>
                    </div>
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                        <span class="text-sm font-medium text-slate-600">Kategori Berita</span>
                        <span class="text-lg font-bold text-[#7282CC]">{{ $summary['total_kategori'] }}</span>
                    </div>
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                        <span class="text-sm font-medium text-slate-600">Buku Tamu</span>
                        <span class="text-lg font-bold text-[#3A4FAC]">{{ $summary['total_buku_tamu'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <div class="sibikon-card rounded-[28px] p-6 xl:col-span-2">
                <div class="mb-5">
                    <h3 class="text-2xl font-extrabold tracking-tight text-slate-900">Aktivitas Terbaru</h3>
                    <p class="text-sm text-slate-500">Riwayat proses terbaru dari sistem</p>
                </div>

                <div class="space-y-3">
                    @foreach($latestActivities as $activity)
                        <div class="flex items-start justify-between gap-4 rounded-2xl bg-slate-50 px-4 py-4">
                            <div class="flex items-start gap-3">
                                <div class="mt-1 h-2.5 w-2.5 rounded-full bg-[#3A4FAC]"></div>
                                <div>
                                    <h4 class="font-semibold text-slate-900">{{ $activity['title'] }}</h4>
                                    <p class="mt-1 text-sm text-slate-500">{{ $activity['meta'] }}</p>
                                    <p class="mt-1 text-xs text-slate-400">{{ $activity['time'] }}</p>
                                </div>
                            </div>

                            <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-slate-600 shadow-sm">
                                {{ $activity['status'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="sibikon-card rounded-[28px] p-6">
                <div class="mb-5">
                    <h3 class="text-2xl font-extrabold tracking-tight text-slate-900">Informasi Sistem</h3>
                    <p class="text-sm text-slate-500">Status dan catatan umum</p>
                </div>

                <div class="space-y-3">
                    <div class="rounded-2xl bg-slate-50 px-4 py-4">
                        <p class="text-sm font-semibold text-slate-900">Sistem Informasi SIBIKON</p>
                        <p class="mt-1 text-sm text-slate-500">Versi dashboard admin sedang dalam pengembangan aktif.</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 px-4 py-4">
                        <p class="text-sm font-semibold text-slate-900">Validasi Data</p>
                        <p class="mt-1 text-sm text-slate-500">Fitur validasi per kolom dan deteksi duplikat akan terintegrasi dari dashboard.</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 px-4 py-4">
                        <p class="text-sm font-semibold text-slate-900">Integrasi Upload</p>
                        <p class="mt-1 text-sm text-slate-500">Upload file akan digunakan sebagai input otomatis untuk banyak modul data.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('dashboardChart');

    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chartData['labels']),
                datasets: [
                    {
                        label: 'File Upload',
                        data: @json($chartData['uploads']),
                        borderColor: '#3A4FAC',
                        backgroundColor: 'rgba(58,79,172,0.10)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 3,
                        pointBackgroundColor: '#3A4FAC',
                        pointRadius: 4
                    },
                    {
                        label: 'Pengguna Baru',
                        data: @json($chartData['users']),
                        borderColor: '#F1D00A',
                        backgroundColor: 'rgba(241,208,10,0.08)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 3,
                        pointBackgroundColor: '#F1D00A',
                        pointRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: '#475569',
                            boxWidth: 26,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: { color: '#64748B', font: { size: 11 } },
                        grid: { color: 'rgba(148, 163, 184, 0.15)' }
                    },
                    y: {
                        ticks: { color: '#64748B', font: { size: 11 } },
                        grid: { color: 'rgba(148, 163, 184, 0.15)' }
                    }
                }
            }
        });
    }
</script>
@endpush