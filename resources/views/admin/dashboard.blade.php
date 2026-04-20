@extends('layouts.admin')

@section('page-title', 'Beranda - Dashboard')
@section('page-subtitle', 'Ringkasan sistem SIBIKON setelah login admin')

@section('content')
    <div class="mb-5 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <div class="flex items-center gap-2 text-sm text-slate-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-white">Home</a>
                <span>/</span>
                <span class="font-medium text-slate-200">Dashboard</span>
            </div>
            <p class="mt-1 text-sm text-slate-500">
                © 2026 <span class="font-medium text-rose-400">SIBIKON DPUPRPERA Prov. Kaltim</span>
            </p>
        </div>

        <div class="flex items-center gap-2">
            <select class="rounded-xl border border-slate-700 bg-slate-900 px-3 py-2 text-sm text-slate-200 outline-none focus:border-indigo-500">
                <option>2026</option>
                <option>2025</option>
                <option>2024</option>
            </select>

            <button class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">
                Refresh Dashboard
            </button>
        </div>
    </div>

    <div class="mb-5 rounded-2xl border border-slate-800 bg-gradient-to-r from-slate-900 to-slate-800 p-5">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="max-w-3xl">
                <h3 class="text-2xl font-bold">Selamat datang, {{ auth()->check() ? auth()->user()->name : 'Admin' }} 👋</h3>
                <p class="mt-2 text-base leading-relaxed text-slate-400">
                    Halaman ini adalah pusat kontrol admin untuk memantau statistik, upload data, validasi, deteksi duplikat, dan integrasi fitur utama project optimalisasi SIBIKON.
                </p>
            </div>

            <div class="grid grid-cols-2 gap-3 lg:w-auto">
                <div class="rounded-xl border border-slate-700 bg-slate-900/70 p-4 min-w-[150px]">
                    <p class="text-[11px] uppercase tracking-wider text-slate-500">Duplicate NIB</p>
                    <p class="mt-1 text-2xl font-bold text-amber-400">{{ $summary['duplicate_nib'] }}</p>
                </div>
                <div class="rounded-xl border border-slate-700 bg-slate-900/70 p-4 min-w-[150px]">
                    <p class="text-[11px] uppercase tracking-wider text-slate-500">Pending Validasi</p>
                    <p class="mt-1 text-2xl font-bold text-sky-400">{{ $summary['pending_verification'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach($stats as $item)
            <div class="rounded-2xl border border-slate-800 bg-slate-900 p-4 shadow-lg shadow-black/10">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm text-slate-400">{{ $item['title'] }}</p>
                        <h3 class="mt-1 text-2xl font-bold">{{ $item['value'] }}</h3>
                        <p class="mt-2 text-sm text-slate-500">{{ $item['description'] }}</p>
                    </div>

                    <div class="rounded-xl bg-slate-800 p-3 text-indigo-300">
                        @if($item['icon'] === 'users')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5V18a4 4 0 00-5-3.87M17 20H7m10 0v-2c0-.653-.126-1.277-.356-1.848M7 20H2V18a4 4 0 015-3.87M7 20v-2c0-.653.126-1.277.356-1.848m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        @elseif($item['icon'] === 'briefcase')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2m-6 0h6m-6 0H6a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V8a2 2 0 00-2-2h-3"/>
                            </svg>
                        @elseif($item['icon'] === 'folder')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/>
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M16 8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                        @endif
                    </div>
                </div>

                <div class="mt-4 border-t border-slate-800 pt-3">
                    <span class="inline-flex rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-medium text-emerald-400">
                        {{ $item['trend'] }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-5 grid grid-cols-1 gap-5 xl:grid-cols-3">
        <div class="xl:col-span-2 rounded-2xl border border-slate-800 bg-slate-900 p-5">
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold">Statistik Aktivitas Sistem</h3>
                    <p class="text-sm text-slate-400">Monitoring upload dan pertumbuhan data</p>
                </div>
                <span class="rounded-full bg-slate-800 px-3 py-1 text-xs text-slate-400">6 bulan terakhir</span>
            </div>

            <div class="h-[320px]">
                <canvas id="dashboardChart"></canvas>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
            <div class="mb-4">
                <h3 class="text-xl font-bold">Ringkasan Data</h3>
                <p class="text-sm text-slate-400">Informasi prioritas untuk admin</p>
            </div>

            <div class="space-y-3">
                <div class="flex items-center justify-between rounded-xl border border-slate-800 bg-slate-950 px-4 py-3">
                    <span class="text-sm text-slate-300">Duplicate NIB</span>
                    <span class="font-bold text-amber-400">{{ $summary['duplicate_nib'] }}</span>
                </div>
                <div class="flex items-center justify-between rounded-xl border border-slate-800 bg-slate-950 px-4 py-3">
                    <span class="text-sm text-slate-300">Duplicate Alamat</span>
                    <span class="font-bold text-rose-400">{{ $summary['duplicate_alamat'] }}</span>
                </div>
                <div class="flex items-center justify-between rounded-xl border border-slate-800 bg-slate-950 px-4 py-3">
                    <span class="text-sm text-slate-300">Pending Verification</span>
                    <span class="font-bold text-sky-400">{{ $summary['pending_verification'] }}</span>
                </div>
                <div class="flex items-center justify-between rounded-xl border border-slate-800 bg-slate-950 px-4 py-3">
                    <span class="text-sm text-slate-300">Total Berita</span>
                    <span class="font-bold text-indigo-400">{{ $summary['total_berita'] }}</span>
                </div>
                <div class="flex items-center justify-between rounded-xl border border-slate-800 bg-slate-950 px-4 py-3">
                    <span class="text-sm text-slate-300">Kategori Berita</span>
                    <span class="font-bold text-emerald-400">{{ $summary['total_kategori'] }}</span>
                </div>
                <div class="flex items-center justify-between rounded-xl border border-slate-800 bg-slate-950 px-4 py-3">
                    <span class="text-sm text-slate-300">Buku Tamu</span>
                    <span class="font-bold text-fuchsia-400">{{ $summary['total_buku_tamu'] }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('dashboardChart');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartData['labels']),
            datasets: [
                {
                    label: 'File Upload',
                    data: @json($chartData['uploads']),
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99,102,241,0.15)',
                    tension: 0.35,
                    fill: true,
                    borderWidth: 2
                },
                {
                    label: 'Pengguna Baru',
                    data: @json($chartData['users']),
                    borderColor: '#22c55e',
                    backgroundColor: 'rgba(34,197,94,0.15)',
                    tension: 0.35,
                    fill: true,
                    borderWidth: 2
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: '#cbd5e1',
                        boxWidth: 28
                    }
                }
            },
            scales: {
                x: {
                    ticks: { color: '#94a3b8', font: { size: 11 } },
                    grid: { color: 'rgba(148,163,184,0.08)' }
                },
                y: {
                    ticks: { color: '#94a3b8', font: { size: 11 } },
                    grid: { color: 'rgba(148,163,184,0.08)' }
                }
            }
        }
    });
</script>
@endpush