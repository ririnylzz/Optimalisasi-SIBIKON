@extends('layouts.admin')

@section('page-title', 'Detail Kegiatan')
@section('page-subtitle', 'Informasi detail pelatihan dan sertifikasi tenaga kerja konstruksi')

@section('content')

@php
    $statusLabel = match ($pelatihan->status) {
        'dibuka' => 'Terbuka',
        'selesai' => 'Tertutup',
        default => 'Draft',
    };

    $waktuPelaksanaan = $pelatihan->waktu_kegiatan ?? $pelatihan->tanggal_mulai;
    $peserta = $pelatihan->realisasi_peserta ?? $pelatihan->peserta ?? 0;
    $jabatanKerja = $pelatihan->standar_kompetensi ?? $pelatihan->jabatan_kerja ?? '-';
    $tempat = $pelatihan->tempat_kegiatan ?? $pelatihan->tempat ?? '-';
    $lokasi = $pelatihan->kabupaten_kota ?? $pelatihan->lokasi ?? $pelatihan->provinsi ?? '-';
@endphp

<div class="space-y-6">

    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">
                Detail Kegiatan
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                {{ $pelatihan->nama_kegiatan }}
            </p>
        </div>

        <a
            href="{{ route('admin.pelatihan-sertifikasi.index') }}"
            class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
            Kembali
        </a>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">
            <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-xl font-extrabold text-slate-800">
                        {{ $pelatihan->nama_kegiatan }}
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Data lengkap kegiatan pelatihan dan sertifikasi.
                    </p>
                </div>

                <span class="inline-flex w-fit rounded-full bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700">
                    {{ $statusLabel }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 p-6 lg:grid-cols-2">

            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Tahun</p>
                <p class="mt-2 text-sm font-semibold text-slate-800">{{ $pelatihan->tahun ?? '-' }}</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Waktu Pelaksanaan</p>
                <p class="mt-2 text-sm font-semibold text-slate-800">
                    @if ($waktuPelaksanaan)
                        {{ \Carbon\Carbon::parse($waktuPelaksanaan)->translatedFormat('d M Y') }}
                    @else
                        -
                    @endif
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Jenis Peserta</p>
                <p class="mt-2 text-sm font-semibold text-slate-800">{{ $pelatihan->jenis_peserta ?? '-' }}</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Metode Kegiatan</p>
                <p class="mt-2 text-sm font-semibold text-slate-800">{{ $pelatihan->metode_kegiatan ?? '-' }}</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Realisasi Peserta</p>
                <p class="mt-2 text-sm font-semibold text-slate-800">{{ $peserta }}</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Sumber Dana</p>
                <p class="mt-2 text-sm font-semibold text-slate-800">{{ $pelatihan->sumber_dana ?? '-' }}</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Standar Kompetensi / Jabatan Kerja</p>
                <p class="mt-2 text-sm font-semibold text-slate-800">{{ $jabatanKerja }}</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">TUK</p>
                <p class="mt-2 text-sm font-semibold text-slate-800">{{ $pelatihan->tuk ?? '-' }}</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">LSP</p>
                <p class="mt-2 text-sm font-semibold text-slate-800">{{ $pelatihan->lsp ?? '-' }}</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Tempat</p>
                <p class="mt-2 text-sm font-semibold text-slate-800">{{ $tempat }}</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Provinsi</p>
                <p class="mt-2 text-sm font-semibold text-slate-800">{{ $pelatihan->provinsi ?? '-' }}</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Kabupaten/Kota / Lokasi</p>
                <p class="mt-2 text-sm font-semibold text-slate-800">{{ $lokasi }}</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 lg:col-span-2">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Syarat Tambahan</p>
                <p class="mt-2 whitespace-pre-line text-sm font-semibold text-slate-800">
                    {{ $pelatihan->syarat_tambahan ?? '-' }}
                </p>
            </div>

        </div>

    </div>

</div>

@endsection