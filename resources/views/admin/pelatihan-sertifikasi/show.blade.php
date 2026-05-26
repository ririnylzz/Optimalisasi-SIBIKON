@extends('layouts.admin')

@section('page-title', 'Detail Kegiatan')
@section('page-subtitle', 'Detail pelatihan dan sertifikasi tenaga kerja konstruksi')

@section('content')

<style>
    html,
    body {
        overflow-x: hidden !important;
    }

    #detailPageFit {
        width: 100%;
        max-width: 100%;
        min-width: 0;
        overflow-x: hidden;
    }

    @media (min-width: 1024px) {
        #detailPageFit {
            max-width: calc(100vw - 24rem);
        }
    }

    @media (max-width: 1023px) {
        #detailPageFit {
            max-width: calc(100vw - 2rem);
        }
    }

    .detail-fit-card {
        width: 100%;
        max-width: 100%;
        min-width: 0;
        overflow: hidden;
    }

    .peserta-table-slider {
        width: 100%;
        max-width: 100%;
        min-width: 0;
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
    }

    .peserta-table-slider table {
        width: 1320px;
        min-width: 1320px;
        max-width: none;
    }
</style>

@php
    $statusLabel = match ($pelatihan->status) {
        'dibuka' => 'Terbuka',
        'selesai' => 'Tertutup',
        'draft' => 'Draft',
        default => '-',
    };

    $statusColor = match ($pelatihan->status) {
        'dibuka' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
        'selesai' => 'bg-rose-100 text-rose-700 border-rose-200',
        'draft' => 'bg-slate-100 text-slate-600 border-slate-200',
        default => 'bg-slate-100 text-slate-600 border-slate-200',
    };

    $waktuPelaksanaan = $pelatihan->waktu_kegiatan ?? $pelatihan->tanggal_mulai;
    $waktuLabel = $waktuPelaksanaan
        ? \Carbon\Carbon::parse($waktuPelaksanaan)->translatedFormat('d M Y')
        : '-';

    $peserta = $pelatihan->realisasi_peserta ?? $pelatihan->peserta ?? 0;
    $jabatanKerja = $pelatihan->standar_kompetensi ?? $pelatihan->jabatan_kerja ?? '-';
    $tempat = $pelatihan->tempat_kegiatan ?? $pelatihan->tempat ?? '-';
@endphp

{{-- TOAST NOTIFICATION --}}
<div
    id="toastNotification"
    class="fixed right-6 top-6 z-[99999] hidden w-full max-w-sm overflow-hidden rounded-2xl shadow-2xl">

    <div id="toastBox" class="flex items-start gap-4 px-5 py-4 text-white">
        <div id="toastIcon" class="mt-0.5 text-xl font-bold">
            ✓
        </div>

        <div class="min-w-0 flex-1">
            <p id="toastTitle" class="text-sm font-extrabold">
                Berhasil
            </p>

            <p id="toastMessage" class="mt-1 text-sm leading-relaxed">
                Data berhasil diproses.
            </p>
        </div>

        <button
            type="button"
            id="toastClose"
            class="text-2xl font-light leading-none text-white/80 transition hover:text-white">
            &times;
        </button>
    </div>
</div>

<div id="detailPageFit" class="space-y-6">

    {{-- BREADCRUMB --}}
    <div class="flex min-w-0 flex-wrap items-center gap-2 text-sm text-slate-500">
        <a
            href="{{ route('admin.pelatihan-sertifikasi.index') }}"
            class="font-medium text-[#28428B] transition hover:text-[#1d3270]">
            Pelatihan dan Sertifikasi TKK Ahli
        </a>

        <span>/</span>

        <span class="font-semibold text-slate-700">
            Detail Kegiatan
        </span>
    </div>

    {{-- TOP ACTION --}}
    <div class="flex min-w-0 flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex min-w-0 flex-wrap items-center gap-2">
            <a
                href="{{ route('admin.pelatihan-sertifikasi.index') }}"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>

                Kembali
            </a>

            <button
                type="button"
                data-upload-modal-target
                data-upload-title="Form Upload Laporan"
                data-upload-label="Softcopy Laporan"
                class="inline-flex items-center gap-2 rounded-xl bg-rose-500 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-rose-600">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l-3 3m3-3l3 3M4.5 19.5h15" />
                </svg>

                Upload Laporan
            </button>
        </div>

        <div class="inline-flex w-fit shrink-0 items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 shadow-sm">
            {{ $pelatihan->tahun ?? date('Y') }}
        </div>
    </div>

    {{-- SUMMARY TABLES --}}
    <div class="grid w-full min-w-0 grid-cols-1 gap-5 xl:grid-cols-2">

        {{-- PENDAFTAR KAB/KOTA --}}
        <div class="detail-fit-card rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-emerald-100 bg-emerald-50 px-5 py-4">
                <h3 class="text-sm font-extrabold text-[#142B67]">
                    Pendaftar Berdasarkan Kab/Kota
                </h3>
            </div>

            <div class="w-full overflow-x-auto">
                <table class="w-full min-w-[420px] divide-y divide-slate-200">
                    <thead class="bg-white">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-extrabold uppercase tracking-wider text-slate-700">
                                Kab/Kota
                            </th>

                            <th class="px-5 py-3 text-right text-xs font-extrabold uppercase tracking-wider text-slate-700">
                                Jumlah
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($pendaftarByKabupaten as $row)
                            <tr>
                                <td class="px-5 py-4 text-sm font-semibold uppercase text-[#142B67]">
                                    {{ $row['kabupaten'] }}
                                </td>

                                <td class="px-5 py-4 text-right text-sm font-semibold text-[#142B67]">
                                    {{ $row['jumlah'] }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-5 py-8 text-center text-sm text-slate-500">
                                    Data pendaftar berdasarkan kabupaten/kota belum tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PENDAFTAR STATUS --}}
        <div class="detail-fit-card rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-cyan-100 bg-cyan-50 px-5 py-4">
                <h3 class="text-sm font-extrabold text-[#142B67]">
                    Pendaftar Berdasarkan Status
                </h3>
            </div>

            <div class="w-full overflow-x-auto">
                <table class="w-full min-w-[420px] divide-y divide-slate-200">
                    <thead class="bg-white">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-extrabold uppercase tracking-wider text-slate-700">
                                Status
                            </th>

                            <th class="px-5 py-3 text-right text-xs font-extrabold uppercase tracking-wider text-slate-700">
                                Jumlah
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($pendaftarByStatus as $row)
                            <tr>
                                <td class="px-5 py-4 text-sm font-semibold text-[#142B67]">
                                    {{ $row['status'] }}
                                </td>

                                <td class="px-5 py-4 text-right text-sm font-semibold text-[#142B67]">
                                    {{ $row['jumlah'] }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-5 py-8 text-center text-sm text-slate-500">
                                    Data pendaftar berdasarkan status belum tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- DETAIL KEGIATAN CARD --}}
    <div class="detail-fit-card rounded-2xl border border-slate-200 bg-white shadow-sm">

        {{-- ACTION BUTTONS --}}
        <div class="flex min-w-0 flex-wrap items-center gap-2 border-b border-slate-200 px-5 py-4">
            <button type="button" class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-3 py-2 text-xs font-bold text-white shadow-sm transition hover:bg-emerald-700">
                ▣ Export
            </button>

            <button type="button" class="inline-flex items-center gap-2 rounded-lg bg-blue-500 px-3 py-2 text-xs font-bold text-white shadow-sm transition hover:bg-blue-600">
                ▣ Cetak
            </button>

            <button type="button" data-upload-modal-target data-upload-title="Form Upload Absen" data-upload-label="Softcopy Absen" class="inline-flex items-center gap-2 rounded-lg bg-orange-500 px-3 py-2 text-xs font-bold text-white shadow-sm transition hover:bg-orange-600">
                ▣ Absen
            </button>

            <button type="button" data-upload-modal-target data-upload-title="Form Upload Materi" data-upload-label="Softcopy Materi" class="inline-flex items-center gap-2 rounded-lg bg-slate-500 px-3 py-2 text-xs font-bold text-white shadow-sm transition hover:bg-slate-600">
                ▣ Materi
            </button>

            <button type="button" data-upload-modal-target data-upload-title="Form Upload Sertifikat Peserta" data-upload-label="Softcopy Sertifikat Peserta" class="inline-flex items-center gap-2 rounded-lg bg-purple-500 px-3 py-2 text-xs font-bold text-white shadow-sm transition hover:bg-purple-600">
                ▣ Sertifikat Peserta
            </button>

            <button type="button" data-upload-modal-target data-upload-title="Form Upload SKK Peserta" data-upload-label="Softcopy SKK Peserta" class="inline-flex items-center gap-2 rounded-lg bg-stone-400 px-3 py-2 text-xs font-bold text-white shadow-sm transition hover:bg-stone-500">
                ▣ SKK Peserta
            </button>
        </div>

        {{-- DETAIL INFORMATION --}}
        <div class="px-5 py-5">
            <div class="grid grid-cols-1 gap-0 divide-y divide-slate-200">

                <div class="grid grid-cols-1 gap-2 py-3 md:grid-cols-[260px_20px_minmax(0,1fr)]">
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-500">Nama Kegiatan</div>
                    <div class="hidden text-slate-400 md:block">:</div>
                    <div class="min-w-0 break-words text-sm font-semibold text-[#142B67]">
                        {{ $pelatihan->nama_kegiatan ?? '-' }}
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-2 py-3 md:grid-cols-[260px_20px_minmax(0,1fr)]">
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-500">Waktu Kegiatan</div>
                    <div class="hidden text-slate-400 md:block">:</div>
                    <div class="min-w-0 break-words text-sm font-semibold text-[#142B67]">
                        {{ $waktuLabel }}
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-2 py-3 md:grid-cols-[260px_20px_minmax(0,1fr)]">
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-500">Tempat Kegiatan</div>
                    <div class="hidden text-slate-400 md:block">:</div>
                    <div class="min-w-0 break-words text-sm font-semibold text-[#142B67]">
                        {{ $tempat }}
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-2 py-3 md:grid-cols-[260px_20px_minmax(0,1fr)]">
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-500">Status Kegiatan</div>
                    <div class="hidden text-slate-400 md:block">:</div>
                    <div class="min-w-0">
                        <span class="inline-flex rounded-full border px-3 py-1 text-xs font-bold {{ $statusColor }}">
                            {{ $statusLabel }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-2 py-3 md:grid-cols-[260px_20px_minmax(0,1fr)]">
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-500">Realisasi Peserta</div>
                    <div class="hidden text-slate-400 md:block">:</div>
                    <div class="min-w-0 break-words text-sm font-semibold text-[#142B67]">
                        {{ $peserta }}
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-2 py-3 md:grid-cols-[260px_20px_minmax(0,1fr)]">
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-500">Standar Kompetensi</div>
                    <div class="hidden text-slate-400 md:block">:</div>
                    <div class="min-w-0 break-words text-sm font-semibold text-[#142B67]">
                        {{ $jabatanKerja }}
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-2 py-3 md:grid-cols-[260px_20px_minmax(0,1fr)]">
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-500">Laporan Kegiatan</div>
                    <div class="hidden text-slate-400 md:block">:</div>
                    <div class="min-w-0 text-sm italic text-slate-500">
                        Belum tersedia
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-2 py-3 md:grid-cols-[260px_20px_minmax(0,1fr)]">
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-500">Notulen Kegiatan</div>
                    <div class="hidden text-slate-400 md:block">:</div>
                    <div class="min-w-0 text-sm italic text-slate-500">
                        Belum tersedia
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- DATA PESERTA CARD --}}
    <div class="detail-fit-card rounded-2xl border border-slate-200 bg-white shadow-sm">

        {{-- HEADER --}}
        <div class="border-b border-slate-200 bg-gradient-to-r from-slate-50 to-blue-50/60 px-5 py-4">
            <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div>
                    <h3 class="text-lg font-extrabold text-slate-900">
                        Data Peserta
                    </h3>

                    <p class="text-sm text-slate-500">
                        Data peserta kegiatan pelatihan dan sertifikasi.
                    </p>
                </div>

                <div class="text-sm font-semibold text-slate-500">
                    Total Peserta:
                    <span class="font-extrabold text-slate-900">
                        {{ $pesertaRows->count() }}
                    </span>
                </div>
            </div>
        </div>

        {{-- PARTICIPANT ACTIONS --}}
        <div class="border-b border-slate-200 px-5 py-4">
            <div class="flex min-w-0 flex-col gap-3 lg:flex-row lg:items-center">
                <button
                    type="button"
                    data-peserta-modal-target
                    class="inline-flex w-fit items-center gap-2 rounded-lg bg-red-500 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-red-600">
                    + Tambah Peserta
                </button>

                <button
                    type="button"
                    class="inline-flex w-fit items-center gap-2 rounded-lg bg-cyan-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-700">
                    Pindah Calon Peserta
                </button>

                <select class="w-full max-w-xl rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-600 outline-none transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100">
                    <option value="">Pilih...</option>
                </select>
            </div>
        </div>

        {{-- FILTER PESERTA --}}
        <div class="border-b border-slate-200 px-5 py-4">
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-[minmax(0,1fr)_180px] lg:items-end">
                <div>
                    <label for="pesertaSearchInput" class="mb-2 block text-sm font-semibold text-slate-700">
                        Filter / keyword
                    </label>

                    <input
                        id="pesertaSearchInput"
                        type="text"
                        placeholder="Cari nama, NIK, email, telp, kab./kota..."
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-600 outline-none transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100">
                </div>

                <div>
                    <label for="pesertaShowSelect" class="mb-2 block text-sm font-semibold text-slate-700">
                        Show
                    </label>

                    <select
                        id="pesertaShowSelect"
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-600 outline-none transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="all">Semua</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- BULK DELETE FORM --}}
        <form
            id="bulkDeletePesertaForm"
            action="{{ route('admin.pelatihan-sertifikasi.peserta.bulk-destroy', $pelatihan) }}"
            method="POST">

            @csrf
            @method('DELETE')

            <div class="border-b border-slate-200 px-5 py-4">
                <div class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm md:flex-row md:items-center md:justify-between">
                    <label class="inline-flex items-center gap-3 text-sm font-medium text-slate-700">
                        <input
                            id="selectAllPeserta"
                            type="checkbox"
                            class="h-5 w-5 rounded border-slate-300 text-[#28428B] focus:ring-[#28428B]">

                        Pilih semua data di halaman ini
                    </label>

                    <div class="flex flex-wrap gap-2">
                        <button
                            id="bulkDeletePesertaButton"
                            type="submit"
                            disabled
                            class="rounded-xl border border-rose-200 bg-white px-5 py-2.5 text-sm font-bold text-rose-300 transition enabled:text-rose-500 enabled:hover:bg-rose-50 disabled:cursor-not-allowed">
                            Hapus Terpilih
                        </button>

                        <button
                            id="destroyAllPesertaButton"
                            type="button"
                            {{ $pesertaRows->count() === 0 ? 'disabled' : '' }}
                            class="rounded-xl border border-rose-200 bg-white px-5 py-2.5 text-sm font-bold text-rose-500 transition hover:bg-rose-50 disabled:cursor-not-allowed disabled:text-rose-300">
                            Hapus Semua
                        </button>
                    </div>
                </div>
            </div>

            {{-- TABLE SLIDER --}}
            <div class="peserta-table-slider">
                <table class="divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="w-12 px-4 py-4 text-left">
                                <input
                                    id="selectAllPesertaTable"
                                    type="checkbox"
                                    class="h-4 w-4 rounded border-slate-300 text-[#28428B] focus:ring-[#28428B]">
                            </th>

                            <th class="w-20 px-4 py-4 text-center text-xs font-extrabold uppercase tracking-wider text-slate-500">
                                No.
                            </th>

                            <th class="px-4 py-4 text-left text-xs font-extrabold uppercase tracking-wider text-slate-500">
                                Nama
                            </th>

                            <th class="px-4 py-4 text-left text-xs font-extrabold uppercase tracking-wider text-slate-500">
                                Email/Telp.
                            </th>

                            <th class="px-4 py-4 text-left text-xs font-extrabold uppercase tracking-wider text-slate-500">
                                Pendidikan/Jurusan
                            </th>

                            <th class="px-4 py-4 text-center text-xs font-extrabold uppercase tracking-wider text-slate-500">
                                ASN
                            </th>

                            <th class="px-4 py-4 text-left text-xs font-extrabold uppercase tracking-wider text-slate-500">
                                Jabatan/Instansi
                            </th>

                            <th class="px-4 py-4 text-left text-xs font-extrabold uppercase tracking-wider text-slate-500">
                                Alamat
                            </th>

                            <th class="px-4 py-4 text-left text-xs font-extrabold uppercase tracking-wider text-slate-500">
                                Kab./Kota
                            </th>

                            <th class="px-4 py-4 text-left text-xs font-extrabold uppercase tracking-wider text-slate-500">
                                Tanggal Daftar
                            </th>

                            <th class="px-4 py-4 text-center text-xs font-extrabold uppercase tracking-wider text-slate-500">
                                Status Peserta
                            </th>

                            <th class="px-4 py-4 text-center text-xs font-extrabold uppercase tracking-wider text-slate-500">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody id="pesertaTableBody" class="divide-y divide-slate-100 bg-white">
                        @forelse ($pesertaRows as $pesertaItem)
                            <tr
                                class="peserta-row transition hover:bg-slate-50"
                                data-search="{{ strtolower($pesertaItem->nama . ' ' . $pesertaItem->nik . ' ' . $pesertaItem->email . ' ' . $pesertaItem->telp . ' ' . $pesertaItem->pendidikan_jurusan . ' ' . $pesertaItem->asn . ' ' . $pesertaItem->jabatan_instansi . ' ' . $pesertaItem->alamat . ' ' . $pesertaItem->kab_kota . ' ' . $pesertaItem->status_peserta) }}"
                            >
                                <td class="px-4 py-4">
                                    <input
                                        type="checkbox"
                                        name="peserta_ids[]"
                                        value="{{ $pesertaItem->id }}"
                                        class="peserta-checkbox h-4 w-4 rounded border-slate-300 text-[#28428B] focus:ring-[#28428B]">
                                </td>

                                <td class="peserta-number px-4 py-4 text-center text-sm text-slate-500">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-4 py-4 text-sm">
                                    <div class="font-semibold text-blue-600">
                                        {{ $pesertaItem->nama }}
                                    </div>

                                    <div class="mt-1 text-xs text-slate-500">
                                        NIK: {{ $pesertaItem->nik }}
                                    </div>
                                </td>

                                <td class="px-4 py-4 text-sm">
                                    <div class="text-blue-600">
                                        {{ $pesertaItem->email }}
                                    </div>

                                    <div class="mt-1 text-slate-600">
                                        {{ $pesertaItem->telp }}
                                    </div>
                                </td>

                                <td class="px-4 py-4 text-sm text-slate-600">
                                    {{ $pesertaItem->pendidikan_jurusan }}
                                </td>

                                <td class="px-4 py-4 text-center">
                                    <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-700">
                                        {{ $pesertaItem->asn }}
                                    </span>
                                </td>

                                <td class="px-4 py-4 text-sm text-slate-600">
                                    {{ $pesertaItem->jabatan_instansi }}
                                </td>

                                <td class="px-4 py-4 text-sm text-slate-600">
                                    {{ $pesertaItem->alamat }}
                                </td>

                                <td class="px-4 py-4 text-sm text-slate-600">
                                    {{ $pesertaItem->kab_kota }}
                                </td>

                                <td class="px-4 py-4 text-sm text-slate-600">
                                    {{ $pesertaItem->waktu_daftar ? $pesertaItem->waktu_daftar->translatedFormat('d M Y') : '-' }}
                                </td>

                                <td class="px-4 py-4 text-center">
                                    <span class="inline-flex rounded-full bg-orange-100 px-3 py-1 text-xs font-bold text-orange-700">
                                        {{ $pesertaItem->status_peserta }}
                                    </span>
                                </td>

                                <td class="px-4 py-4 text-center">
                                    <button
                                        type="button"
                                        class="edit-peserta-trigger inline-flex rounded-lg border border-blue-400 bg-blue-50 px-4 py-2 text-sm font-bold text-blue-600 transition hover:bg-blue-100"
                                        data-update-url="{{ route('admin.pelatihan-sertifikasi.peserta.update', [$pelatihan, $pesertaItem]) }}"
                                        data-nama="{{ $pesertaItem->nama }}"
                                        data-nik="{{ $pesertaItem->nik }}"
                                        data-email="{{ $pesertaItem->email }}"
                                        data-telp="{{ $pesertaItem->telp }}"
                                        data-pendidikan-jurusan="{{ $pesertaItem->pendidikan_jurusan }}"
                                        data-asn="{{ $pesertaItem->asn }}"
                                        data-jabatan-instansi="{{ $pesertaItem->jabatan_instansi }}"
                                        data-alamat="{{ $pesertaItem->alamat }}"
                                        data-kab-kota="{{ $pesertaItem->kab_kota }}"
                                        data-waktu-daftar="{{ $pesertaItem->waktu_daftar ? $pesertaItem->waktu_daftar->format('Y-m-d') : '' }}"
                                        data-status-peserta="{{ $pesertaItem->status_peserta }}"
                                    >
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr id="pesertaEmptyRow">
                                <td colspan="12" class="px-5 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-2xl">
                                            👥
                                        </div>

                                        <h3 class="text-base font-extrabold text-slate-700">
                                            Belum Ada Data Peserta
                                        </h3>

                                        <p class="mt-1 max-w-md text-sm text-slate-500">
                                            Klik tombol Tambah Peserta untuk menambahkan data peserta kegiatan.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                        <tr id="pesertaNoResultRow" class="hidden">
                            <td colspan="12" class="px-5 py-14 text-center text-sm font-semibold text-slate-500">
                                Data peserta tidak ditemukan.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>

        <form
            id="destroyAllPesertaForm"
            action="{{ route('admin.pelatihan-sertifikasi.peserta.destroy-all', $pelatihan) }}"
            method="POST"
            class="hidden">
            @csrf
            @method('DELETE')
        </form>

    </div>

</div>

{{-- MODAL TAMBAH PESERTA --}}
<div
    id="modalTambahPeserta"
    class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/50 p-4">

    <div class="max-h-[95vh] w-full max-w-5xl overflow-y-auto rounded-3xl bg-white shadow-2xl">

        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">
                    Form Tambah Peserta
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Isi data peserta sesuai kolom tabel peserta.
                </p>
            </div>

            <button type="button" data-peserta-modal-close class="rounded-xl p-2 text-slate-500 hover:bg-slate-100">
                ✕
            </button>
        </div>

        <form
            id="formTambahPeserta"
            action="{{ route('admin.pelatihan-sertifikasi.peserta.store', $pelatihan) }}"
            method="POST"
            novalidate
            class="peserta-form space-y-5 p-6">

            @csrf

            @include('admin.pelatihan-sertifikasi.partials.peserta-form-fields', [
                'formPrefix' => 'create',
            ])

            <div class="flex items-center justify-end gap-3 border-t border-slate-200 pt-4">
                <button type="button" data-peserta-modal-close class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    Batal
                </button>

                <button type="submit" class="rounded-xl bg-[#28428B] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#1d3270]">
                    Simpan Peserta
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT PESERTA --}}
<div
    id="modalEditPeserta"
    class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/50 p-4">

    <div class="max-h-[95vh] w-full max-w-5xl overflow-y-auto rounded-3xl bg-white shadow-2xl">

        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">
                    Edit Peserta
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Ubah data peserta kegiatan.
                </p>
            </div>

            <button type="button" data-edit-peserta-modal-close class="rounded-xl p-2 text-slate-500 hover:bg-slate-100">
                ✕
            </button>
        </div>

        <form
            id="formEditPeserta"
            action="#"
            method="POST"
            novalidate
            class="peserta-form space-y-5 p-6">

            @csrf
            @method('PUT')

            @include('admin.pelatihan-sertifikasi.partials.peserta-form-fields', [
                'formPrefix' => 'edit',
            ])

            <div class="flex items-center justify-end gap-3 border-t border-slate-200 pt-4">
                <button type="button" data-edit-peserta-modal-close class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    Batal
                </button>

                <button type="submit" class="rounded-xl bg-[#28428B] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#1d3270]">
                    Update Peserta
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL UPLOAD FILE --}}
<div
    id="modalUploadFile"
    class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/50 p-4">

    <div class="w-full max-w-3xl overflow-hidden rounded-lg bg-white shadow-2xl">

        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">
            <h2 id="uploadModalTitle" class="text-xl font-bold text-slate-800">
                Form Upload File
            </h2>

            <button type="button" data-upload-modal-close class="text-3xl font-light leading-none text-slate-500 transition hover:text-slate-800">
                &times;
            </button>
        </div>

        <form action="#" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="px-6 py-7">
                <label id="uploadModalLabel" for="upload-file-input" class="mb-3 block text-base font-medium text-slate-700">
                    Softcopy File
                </label>

                <input
                    id="upload-file-input"
                    type="file"
                    name="softcopy_file"
                    class="block w-full border border-slate-300 text-sm text-slate-700 file:mr-5 file:border-0 file:border-r file:border-slate-300 file:bg-slate-50 file:px-5 file:py-3 file:text-sm file:font-medium file:text-slate-700 hover:file:bg-slate-100">
            </div>

            <div class="flex items-center justify-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-5">
                <button type="button" data-upload-modal-close class="rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-100">
                    Close
                </button>

                <button type="submit" class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const pesertaKabupatenData = {
    "Aceh": [
        "Banda Aceh",
        "Langsa",
        "Lhokseumawe",
        "Sabang",
        "Subulussalam",
        "Aceh Barat",
        "Aceh Besar",
        "Aceh Selatan",
        "Aceh Tengah",
        "Aceh Tenggara",
        "Aceh Timur",
        "Aceh Utara"
    ],
    "Sumatera Utara": [
        "Medan",
        "Binjai",
        "Pematangsiantar",
        "Tanjungbalai",
        "Tebing Tinggi",
        "Padangsidimpuan",
        "Gunungsitoli",
        "Asahan",
        "Deli Serdang",
        "Karo",
        "Labuhanbatu",
        "Langkat",
        "Simalungun"
    ],
    "Sumatera Barat": [
        "Padang",
        "Bukittinggi",
        "Padang Panjang",
        "Pariaman",
        "Payakumbuh",
        "Sawahlunto",
        "Solok",
        "Agam",
        "Dharmasraya",
        "Lima Puluh Kota",
        "Pasaman",
        "Pesisir Selatan"
    ],
    "Riau": [
        "Pekanbaru",
        "Dumai",
        "Bengkalis",
        "Indragiri Hilir",
        "Indragiri Hulu",
        "Kampar",
        "Kuantan Singingi",
        "Pelalawan",
        "Rokan Hilir",
        "Rokan Hulu",
        "Siak"
    ],
    "Jambi": [
        "Jambi",
        "Sungai Penuh",
        "Batanghari",
        "Bungo",
        "Kerinci",
        "Merangin",
        "Muaro Jambi",
        "Sarolangun",
        "Tanjung Jabung Barat",
        "Tanjung Jabung Timur",
        "Tebo"
    ],
    "Sumatera Selatan": [
        "Palembang",
        "Lubuklinggau",
        "Pagar Alam",
        "Prabumulih",
        "Banyuasin",
        "Empat Lawang",
        "Lahat",
        "Muara Enim",
        "Musi Banyuasin",
        "Musi Rawas",
        "Ogan Ilir",
        "Ogan Komering Ilir",
        "Ogan Komering Ulu"
    ],
    "Bengkulu": [
        "Bengkulu",
        "Bengkulu Selatan",
        "Bengkulu Tengah",
        "Bengkulu Utara",
        "Kaur",
        "Kepahiang",
        "Lebong",
        "Mukomuko",
        "Rejang Lebong",
        "Seluma"
    ],
    "Lampung": [
        "Bandar Lampung",
        "Metro",
        "Lampung Barat",
        "Lampung Selatan",
        "Lampung Tengah",
        "Lampung Timur",
        "Lampung Utara",
        "Mesuji",
        "Pesawaran",
        "Pringsewu",
        "Tanggamus",
        "Tulang Bawang",
        "Way Kanan"
    ],
    "Kepulauan Bangka Belitung": [
        "Pangkalpinang",
        "Bangka",
        "Bangka Barat",
        "Bangka Selatan",
        "Bangka Tengah",
        "Belitung",
        "Belitung Timur"
    ],
    "Kepulauan Riau": [
        "Batam",
        "Tanjungpinang",
        "Bintan",
        "Karimun",
        "Kepulauan Anambas",
        "Lingga",
        "Natuna"
    ],
    "DKI Jakarta": [
        "Jakarta Pusat",
        "Jakarta Barat",
        "Jakarta Timur",
        "Jakarta Selatan",
        "Jakarta Utara",
        "Kepulauan Seribu"
    ],
    "Jawa Barat": [
        "Bandung",
        "Bekasi",
        "Bogor",
        "Cimahi",
        "Cirebon",
        "Depok",
        "Sukabumi",
        "Tasikmalaya",
        "Banjar",
        "Bandung Barat",
        "Cianjur",
        "Garut",
        "Indramayu",
        "Karawang",
        "Kuningan",
        "Majalengka",
        "Pangandaran",
        "Purwakarta",
        "Subang",
        "Sumedang"
    ],
    "Jawa Tengah": [
        "Semarang",
        "Surakarta",
        "Magelang",
        "Pekalongan",
        "Salatiga",
        "Tegal",
        "Banjarnegara",
        "Banyumas",
        "Batang",
        "Blora",
        "Boyolali",
        "Brebes",
        "Cilacap",
        "Demak",
        "Grobogan",
        "Jepara",
        "Karanganyar",
        "Kebumen",
        "Kendal",
        "Klaten",
        "Kudus",
        "Pati",
        "Purworejo",
        "Rembang",
        "Sragen",
        "Sukoharjo",
        "Wonogiri",
        "Wonosobo"
    ],
    "DI Yogyakarta": [
        "Yogyakarta",
        "Bantul",
        "Gunungkidul",
        "Kulon Progo",
        "Sleman"
    ],
    "Jawa Timur": [
        "Surabaya",
        "Malang",
        "Batu",
        "Kediri",
        "Madiun",
        "Blitar",
        "Mojokerto",
        "Pasuruan",
        "Probolinggo",
        "Bangkalan",
        "Banyuwangi",
        "Bojonegoro",
        "Bondowoso",
        "Gresik",
        "Jember",
        "Jombang",
        "Lamongan",
        "Lumajang",
        "Magetan",
        "Nganjuk",
        "Ngawi",
        "Pacitan",
        "Pamekasan",
        "Ponorogo",
        "Sampang",
        "Sidoarjo",
        "Situbondo",
        "Sumenep",
        "Trenggalek",
        "Tuban",
        "Tulungagung"
    ],
    "Banten": [
        "Serang",
        "Tangerang",
        "Tangerang Selatan",
        "Cilegon",
        "Lebak",
        "Pandeglang"
    ],
    "Bali": [
        "Denpasar",
        "Badung",
        "Bangli",
        "Buleleng",
        "Gianyar",
        "Jembrana",
        "Karangasem",
        "Klungkung",
        "Tabanan"
    ],
    "Nusa Tenggara Barat": [
        "Mataram",
        "Bima",
        "Dompu",
        "Lombok Barat",
        "Lombok Tengah",
        "Lombok Timur",
        "Lombok Utara",
        "Sumbawa",
        "Sumbawa Barat"
    ],
    "Nusa Tenggara Timur": [
        "Kupang",
        "Alor",
        "Belu",
        "Ende",
        "Flores Timur",
        "Lembata",
        "Manggarai",
        "Ngada",
        "Rote Ndao",
        "Sikka",
        "Sumba Barat",
        "Sumba Timur",
        "Timor Tengah Selatan",
        "Timor Tengah Utara"
    ],
    "Kalimantan Barat": [
        "Pontianak",
        "Singkawang",
        "Bengkayang",
        "Kapuas Hulu",
        "Kayong Utara",
        "Ketapang",
        "Kubu Raya",
        "Landak",
        "Melawi",
        "Mempawah",
        "Sambas",
        "Sanggau",
        "Sekadau",
        "Sintang"
    ],
    "Kalimantan Tengah": [
        "Palangka Raya",
        "Barito Selatan",
        "Barito Timur",
        "Barito Utara",
        "Gunung Mas",
        "Kapuas",
        "Katingan",
        "Kotawaringin Barat",
        "Kotawaringin Timur",
        "Lamandau",
        "Murung Raya",
        "Pulang Pisau",
        "Seruyan",
        "Sukamara"
    ],
    "Kalimantan Selatan": [
        "Banjarmasin",
        "Banjarbaru",
        "Balangan",
        "Banjar",
        "Barito Kuala",
        "Hulu Sungai Selatan",
        "Hulu Sungai Tengah",
        "Hulu Sungai Utara",
        "Kotabaru",
        "Tabalong",
        "Tanah Bumbu",
        "Tanah Laut",
        "Tapin"
    ],
    "Kalimantan Timur": [
        "Kota Samarinda",
        "Kota Balikpapan",
        "Kota Bontang",
        "Kab. Paser",
        "Kab. Kutai Kartanegara",
        "Kab. Berau",
        "Kab. Kutai Barat",
        "Kab. Kutai Timur",
        "Kab. Penajam Paser Utara",
        "Kab. Mahakam Ulu"
    ],
    "Kalimantan Utara": [
        "Tarakan",
        "Bulungan",
        "Malinau",
        "Nunukan",
        "Tana Tidung"
    ],
    "Sulawesi Utara": [
        "Manado",
        "Bitung",
        "Kotamobagu",
        "Tomohon",
        "Bolaang Mongondow",
        "Kepulauan Sangihe",
        "Kepulauan Talaud",
        "Minahasa",
        "Minahasa Selatan",
        "Minahasa Tenggara",
        "Minahasa Utara"
    ],
    "Sulawesi Tengah": [
        "Palu",
        "Banggai",
        "Banggai Kepulauan",
        "Buol",
        "Donggala",
        "Morowali",
        "Parigi Moutong",
        "Poso",
        "Sigi",
        "Tojo Una-Una",
        "Tolitoli"
    ],
    "Sulawesi Selatan": [
        "Makassar",
        "Parepare",
        "Palopo",
        "Bantaeng",
        "Barru",
        "Bone",
        "Bulukumba",
        "Enrekang",
        "Gowa",
        "Jeneponto",
        "Luwu",
        "Maros",
        "Pangkajene dan Kepulauan",
        "Pinrang",
        "Sidenreng Rappang",
        "Sinjai",
        "Soppeng",
        "Takalar",
        "Tana Toraja",
        "Wajo"
    ],
    "Sulawesi Tenggara": [
        "Kendari",
        "Baubau",
        "Bombana",
        "Buton",
        "Kolaka",
        "Konawe",
        "Konawe Selatan",
        "Konawe Utara",
        "Muna",
        "Wakatobi"
    ],
    "Gorontalo": [
        "Gorontalo",
        "Boalemo",
        "Bone Bolango",
        "Gorontalo Utara",
        "Pohuwato"
    ],
    "Sulawesi Barat": [
        "Mamuju",
        "Majene",
        "Mamasa",
        "Mamuju Tengah",
        "Pasangkayu",
        "Polewali Mandar"
    ],
    "Maluku": [
        "Ambon",
        "Tual",
        "Buru",
        "Buru Selatan",
        "Kepulauan Aru",
        "Maluku Barat Daya",
        "Maluku Tengah",
        "Maluku Tenggara",
        "Seram Bagian Barat",
        "Seram Bagian Timur"
    ],
    "Maluku Utara": [
        "Ternate",
        "Tidore Kepulauan",
        "Halmahera Barat",
        "Halmahera Selatan",
        "Halmahera Tengah",
        "Halmahera Timur",
        "Halmahera Utara",
        "Kepulauan Sula",
        "Pulau Morotai"
    ],
    "Papua": [
        "Jayapura",
        "Biak Numfor",
        "Jayapura",
        "Keerom",
        "Kepulauan Yapen",
        "Mamberamo Raya",
        "Sarmi",
        "Supiori",
        "Waropen"
    ],
    "Papua Barat": [
        "Manokwari",
        "Fakfak",
        "Kaimana",
        "Manokwari Selatan",
        "Pegunungan Arfak",
        "Teluk Bintuni",
        "Teluk Wondama"
    ]
};

function resetKabupatenPeserta(kabupatenSelect) {
    kabupatenSelect.innerHTML = '<option value="" disabled hidden selected>Pilih provinsi dulu</option>';
    kabupatenSelect.value = '';
}

function fillKabupatenPeserta(provinsiSelect, kabupatenSelect, selectedKabupaten = '') {
    const selectedProvinsi = provinsiSelect.value;
    const kabupatenList = pesertaKabupatenData[selectedProvinsi] || [];

    kabupatenSelect.innerHTML = '';

    if (!selectedProvinsi || kabupatenList.length === 0) {
        resetKabupatenPeserta(kabupatenSelect);
        return;
    }

    const placeholder = document.createElement('option');
    placeholder.value = '';
    placeholder.textContent = 'Pilih';
    placeholder.disabled = true;
    placeholder.hidden = true;
    placeholder.selected = true;
    kabupatenSelect.appendChild(placeholder);

    kabupatenList.forEach(function (kabupaten) {
        const option = document.createElement('option');
        option.value = kabupaten;
        option.textContent = kabupaten;

        if (selectedKabupaten && selectedKabupaten === kabupaten) {
            option.selected = true;
            placeholder.selected = false;
        }

        kabupatenSelect.appendChild(option);
    });
}

function initializePesertaWilayah(form) {
    const provinsiSelect = form.querySelector('[data-provinsi-peserta]');
    const kabupatenSelect = form.querySelector('[data-kabupaten-peserta]');

    if (!provinsiSelect || !kabupatenSelect) {
        return;
    }

    provinsiSelect.addEventListener('change', function () {
        fillKabupatenPeserta(provinsiSelect, kabupatenSelect);
    });

    if (provinsiSelect.value) {
        fillKabupatenPeserta(provinsiSelect, kabupatenSelect, kabupatenSelect.dataset.selected || '');
    } else {
        resetKabupatenPeserta(kabupatenSelect);
    }
}

document.querySelectorAll('.peserta-form').forEach(function (form) {
    initializePesertaWilayah(form);
});

    const toastNotification = document.getElementById('toastNotification');
    const toastBox = document.getElementById('toastBox');
    const toastIcon = document.getElementById('toastIcon');
    const toastTitle = document.getElementById('toastTitle');
    const toastMessage = document.getElementById('toastMessage');
    const toastClose = document.getElementById('toastClose');

    let toastTimer = null;

    function showToast(type, title, message) {
        if (!toastNotification || !toastBox) return;

        clearTimeout(toastTimer);

        toastBox.classList.remove('bg-emerald-500', 'bg-rose-500');

        if (type === 'success') {
            toastBox.classList.add('bg-emerald-500');
            toastIcon.textContent = '✓';
        } else {
            toastBox.classList.add('bg-rose-500');
            toastIcon.textContent = '!';
        }

        toastTitle.textContent = title;
        toastMessage.textContent = message;

        toastNotification.classList.remove('hidden');

        toastTimer = setTimeout(function () {
            toastNotification.classList.add('hidden');
        }, 3500);
    }

    if (toastClose) {
        toastClose.addEventListener('click', function () {
            toastNotification.classList.add('hidden');
            clearTimeout(toastTimer);
        });
    }

    @if (session('success'))
        showToast('success', 'Berhasil', @json(session('success')));
    @endif

    const modalUploadFile = document.getElementById('modalUploadFile');
    const uploadModalTitle = document.getElementById('uploadModalTitle');
    const uploadModalLabel = document.getElementById('uploadModalLabel');
    const uploadFileInput = document.getElementById('upload-file-input');

    document.querySelectorAll('[data-upload-modal-target]').forEach(function (button) {
        button.addEventListener('click', function () {
            uploadModalTitle.textContent = this.dataset.uploadTitle || 'Form Upload File';
            uploadModalLabel.textContent = this.dataset.uploadLabel || 'Softcopy File';

            if (uploadFileInput) {
                uploadFileInput.value = '';
            }

            modalUploadFile.classList.remove('hidden');
            modalUploadFile.classList.add('flex');
        });
    });

    document.querySelectorAll('[data-upload-modal-close]').forEach(function (button) {
        button.addEventListener('click', function () {
            modalUploadFile.classList.add('hidden');
            modalUploadFile.classList.remove('flex');
        });
    });

    if (modalUploadFile) {
        modalUploadFile.addEventListener('click', function (event) {
            if (event.target === modalUploadFile) {
                modalUploadFile.classList.add('hidden');
                modalUploadFile.classList.remove('flex');
            }
        });
    }

    const modalTambahPeserta = document.getElementById('modalTambahPeserta');
    const modalEditPeserta = document.getElementById('modalEditPeserta');
    const formEditPeserta = document.getElementById('formEditPeserta');

    document.querySelectorAll('[data-peserta-modal-target]').forEach(function (button) {
        button.addEventListener('click', function () {
            modalTambahPeserta.classList.remove('hidden');
            modalTambahPeserta.classList.add('flex');
        });
    });

    document.querySelectorAll('[data-peserta-modal-close]').forEach(function (button) {
        button.addEventListener('click', function () {
            modalTambahPeserta.classList.add('hidden');
            modalTambahPeserta.classList.remove('flex');
        });
    });

    if (modalTambahPeserta) {
        modalTambahPeserta.addEventListener('click', function (event) {
            if (event.target === modalTambahPeserta) {
                modalTambahPeserta.classList.add('hidden');
                modalTambahPeserta.classList.remove('flex');
            }
        });
    }

    document.querySelectorAll('[data-edit-peserta-modal-close]').forEach(function (button) {
        button.addEventListener('click', function () {
            modalEditPeserta.classList.add('hidden');
            modalEditPeserta.classList.remove('flex');
        });
    });

    if (modalEditPeserta) {
        modalEditPeserta.addEventListener('click', function (event) {
            if (event.target === modalEditPeserta) {
                modalEditPeserta.classList.add('hidden');
                modalEditPeserta.classList.remove('flex');
            }
        });
    }

    function clearPesertaFieldError(field) {
        const wrapper = field.closest('.peserta-field-group');
        const errorText = wrapper ? wrapper.querySelector('.peserta-field-error') : null;

        if (errorText) {
            errorText.textContent = '';
            errorText.classList.add('hidden');
        }
    }

    function showPesertaFieldError(field, message) {
        const wrapper = field.closest('.peserta-field-group');
        const errorText = wrapper ? wrapper.querySelector('.peserta-field-error') : null;

        if (errorText) {
            errorText.textContent = message;
            errorText.classList.remove('hidden');
        }
    }

    function validatePesertaForm(form) {
        let valid = true;
        let firstInvalidField = null;

        form.querySelectorAll('.peserta-form-control').forEach(function (field) {
            clearPesertaFieldError(field);

            const value = String(field.value || '').trim();
            const label = field.dataset.label || 'Field ini';

            if (field.dataset.required === 'true' && !value) {
                valid = false;
                showPesertaFieldError(field, label + ' wajib diisi.');

                if (!firstInvalidField) {
                    firstInvalidField = field;
                }

                return;
            }

            if (field.dataset.email === 'true' && value) {
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (!emailPattern.test(value)) {
                    valid = false;
                    showPesertaFieldError(field, 'Format email tidak valid.');

                    if (!firstInvalidField) {
                        firstInvalidField = field;
                    }
                }
            }

            if (field.name === 'nik' && value && !/^[0-9]+$/.test(value)) {
                valid = false;
                showPesertaFieldError(field, 'NIK harus diisi dengan angka.');

                if (!firstInvalidField) {
                    firstInvalidField = field;
                }
            }

            if (field.name === 'telp' && value && !/^[0-9]+$/.test(value)) {
                valid = false;
                showPesertaFieldError(field, 'No. Telp harus diisi dengan angka.');

                if (!firstInvalidField) {
                    firstInvalidField = field;
                }
            }
        });

        if (!valid && firstInvalidField) {
            firstInvalidField.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });

            setTimeout(function () {
                firstInvalidField.focus();
            }, 250);
        }

        return valid;
    }

    document.querySelectorAll('.peserta-form').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!validatePesertaForm(form)) {
                event.preventDefault();
                event.stopPropagation();
            }
        });

        form.querySelectorAll('.peserta-form-control').forEach(function (field) {
            field.addEventListener('input', function () {
                clearPesertaFieldError(field);

                if (field.name === 'nik' || field.name === 'telp') {
                    field.value = field.value.replace(/[^0-9]/g, '');
                }
            });

            field.addEventListener('change', function () {
                clearPesertaFieldError(field);
            });
        });
    });

    function setEditPesertaField(name, value) {
        const field = formEditPeserta.querySelector('[name="' + name + '"]');

        if (field) {
            field.value = value || '';
            clearPesertaFieldError(field);
        }
    }

    document.querySelectorAll('.edit-peserta-trigger').forEach(function (button) {
        button.addEventListener('click', function () {
            formEditPeserta.action = this.dataset.updateUrl;

            setEditPesertaField('nama', this.dataset.nama);
            setEditPesertaField('nik', this.dataset.nik);
            setEditPesertaField('email', this.dataset.email);
            setEditPesertaField('telp', this.dataset.telp);
            setEditPesertaField('pendidikan_jurusan', this.dataset.pendidikanJurusan);
            setEditPesertaField('asn', this.dataset.asn);
            setEditPesertaField('jabatan_instansi', this.dataset.jabatanInstansi);
            setEditPesertaField('alamat', this.dataset.alamat);
            setEditPesertaField('kab_kota', this.dataset.kabKota);
            setEditPesertaField('waktu_daftar', this.dataset.waktuDaftar);
            setEditPesertaField('status_peserta', this.dataset.statusPeserta);

            modalEditPeserta.classList.remove('hidden');
            modalEditPeserta.classList.add('flex');
        });
    });

    const pesertaSearchInput = document.getElementById('pesertaSearchInput');
    const pesertaShowSelect = document.getElementById('pesertaShowSelect');
    const pesertaRows = Array.from(document.querySelectorAll('.peserta-row'));
    const pesertaNoResultRow = document.getElementById('pesertaNoResultRow');

    const selectAllPeserta = document.getElementById('selectAllPeserta');
    const selectAllPesertaTable = document.getElementById('selectAllPesertaTable');
    const bulkDeletePesertaButton = document.getElementById('bulkDeletePesertaButton');
    const bulkDeletePesertaForm = document.getElementById('bulkDeletePesertaForm');
    const destroyAllPesertaButton = document.getElementById('destroyAllPesertaButton');
    const destroyAllPesertaForm = document.getElementById('destroyAllPesertaForm');

    function visiblePesertaRows() {
        return pesertaRows.filter(function (row) {
            return !row.classList.contains('hidden');
        });
    }

    function updateBulkDeleteButton() {
        const checkedCount = document.querySelectorAll('.peserta-checkbox:checked').length;

        if (bulkDeletePesertaButton) {
            bulkDeletePesertaButton.disabled = checkedCount === 0;
        }

        const visibleRows = visiblePesertaRows();

        const visibleCheckedRows = visibleRows.filter(function (row) {
            const checkbox = row.querySelector('.peserta-checkbox');
            return checkbox && checkbox.checked;
        });

        const isAllVisibleChecked = visibleRows.length > 0 && visibleCheckedRows.length === visibleRows.length;

        if (selectAllPeserta) {
            selectAllPeserta.checked = isAllVisibleChecked;
        }

        if (selectAllPesertaTable) {
            selectAllPesertaTable.checked = isAllVisibleChecked;
        }
    }

    function filterPesertaTable() {
        const keyword = String(pesertaSearchInput.value || '').toLowerCase().trim();
        const limitValue = pesertaShowSelect.value;
        const limit = limitValue === 'all' ? Infinity : Number(limitValue);

        let matchedCount = 0;
        let visibleCount = 0;

        pesertaRows.forEach(function (row) {
            const haystack = row.dataset.search || '';
            const isMatch = !keyword || haystack.includes(keyword);

            if (isMatch) {
                matchedCount++;
            }

            const shouldShow = isMatch && visibleCount < limit;

            if (shouldShow) {
                visibleCount++;
                row.classList.remove('hidden');

                const numberCell = row.querySelector('.peserta-number');

                if (numberCell) {
                    numberCell.textContent = visibleCount;
                }
            } else {
                row.classList.add('hidden');

                const checkbox = row.querySelector('.peserta-checkbox');

                if (checkbox) {
                    checkbox.checked = false;
                }
            }
        });

        if (pesertaNoResultRow) {
            if (pesertaRows.length > 0 && matchedCount === 0) {
                pesertaNoResultRow.classList.remove('hidden');
            } else {
                pesertaNoResultRow.classList.add('hidden');
            }
        }

        updateBulkDeleteButton();
    }

    if (pesertaSearchInput) {
        pesertaSearchInput.addEventListener('input', filterPesertaTable);
    }

    if (pesertaShowSelect) {
        pesertaShowSelect.addEventListener('change', filterPesertaTable);
    }

    document.querySelectorAll('.peserta-checkbox').forEach(function (checkbox) {
        checkbox.addEventListener('change', updateBulkDeleteButton);
    });

    function toggleAllVisiblePeserta(checked) {
        visiblePesertaRows().forEach(function (row) {
            const checkbox = row.querySelector('.peserta-checkbox');

            if (checkbox) {
                checkbox.checked = checked;
            }
        });

        updateBulkDeleteButton();
    }

    if (selectAllPeserta) {
        selectAllPeserta.addEventListener('change', function () {
            toggleAllVisiblePeserta(this.checked);
        });
    }

    if (selectAllPesertaTable) {
        selectAllPesertaTable.addEventListener('change', function () {
            toggleAllVisiblePeserta(this.checked);
        });
    }

    if (bulkDeletePesertaForm) {
        bulkDeletePesertaForm.addEventListener('submit', function (event) {
            const checkedCount = document.querySelectorAll('.peserta-checkbox:checked').length;

            if (checkedCount === 0) {
                event.preventDefault();
                return;
            }

            if (!confirm('Yakin ingin menghapus peserta terpilih?')) {
                event.preventDefault();
            }
        });
    }

    if (destroyAllPesertaButton) {
        destroyAllPesertaButton.addEventListener('click', function () {
            if (pesertaRows.length === 0) {
                return;
            }

            if (confirm('Yakin ingin menghapus semua peserta pada kegiatan ini?')) {
                destroyAllPesertaForm.submit();
            }
        });
    }

    if (pesertaSearchInput && pesertaShowSelect) {
        filterPesertaTable();
    }
});
</script>

@endsection