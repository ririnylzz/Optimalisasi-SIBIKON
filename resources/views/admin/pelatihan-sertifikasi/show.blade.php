@extends('layouts.admin')

@section('page-title', 'Detail Kegiatan')
@section('page-subtitle', 'Detail pelatihan dan sertifikasi tenaga kerja konstruksi')

@section('content')

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
$lokasi = $pelatihan->kabupaten_kota ?? $pelatihan->lokasi ?? $pelatihan->provinsi ?? '-';

$pendaftarByKabupaten = collect([
[
'kabupaten' => $lokasi,
'jumlah' => $peserta,
],
])->filter(fn ($item) => $item['kabupaten'] !== '-' && (int) $item['jumlah'] > 0);

$pendaftarByStatus = collect([
[
'status' => 'Peserta Terdata',
'jumlah' => $peserta,
],
])->filter(fn ($item) => (int) $item['jumlah'] > 0);

$pesertaRows = collect();
@endphp

<div class="w-full max-w-full space-y-6 overflow-hidden">

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
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4 text-slate-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M4.5 6.75h15A1.5 1.5 0 0121 8.25v10.5a1.5 1.5 0 01-1.5 1.5h-15A1.5 1.5 0 013 18.75V8.25a1.5 1.5 0 011.5-1.5z" />
            </svg>

            {{ $pelatihan->tahun ?? date('Y') }}
        </div>
    </div>

    {{-- SUMMARY TABLES --}}
    <div class="grid w-full min-w-0 grid-cols-1 gap-5 2xl:grid-cols-2">

        {{-- PENDAFTAR KAB/KOTA --}}
        <div class="min-w-0 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-emerald-100 bg-emerald-50 px-5 py-4">
                <h3 class="text-sm font-extrabold text-[#142B67]">
                    Pendaftar Berdasarkan Kab/Kota
                </h3>
            </div>

            <div class="w-full overflow-x-auto">
                <table class="w-full min-w-[520px] divide-y divide-slate-200">
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
        <div class="min-w-0 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-cyan-100 bg-cyan-50 px-5 py-4">
                <h3 class="text-sm font-extrabold text-[#142B67]">
                    Pendaftar Berdasarkan Status
                </h3>
            </div>

            <div class="w-full overflow-x-auto">
                <table class="w-full min-w-[520px] divide-y divide-slate-200">
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

    {{-- DETAIL CARD --}}
    <div class="min-w-0 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        {{-- ACTION BUTTONS --}}
        <div class="flex min-w-0 flex-wrap items-center gap-2 border-b border-slate-200 px-5 py-4">
            <button
                type="button"
                class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-3 py-2 text-xs font-bold text-white shadow-sm transition hover:bg-emerald-700">
                <span>▣</span>
                Export
            </button>

            <button
                type="button"
                class="inline-flex items-center gap-2 rounded-lg bg-blue-500 px-3 py-2 text-xs font-bold text-white shadow-sm transition hover:bg-blue-600">
                <span>▣</span>
                Cetak
            </button>

            <button
                type="button"
                data-upload-modal-target
                data-upload-title="Form Upload Absen"
                data-upload-label="Softcopy Absen"
                class="inline-flex items-center gap-2 rounded-lg bg-orange-500 px-3 py-2 text-xs font-bold text-white shadow-sm transition hover:bg-orange-600">
                <span>▣</span>
                Absen
            </button>

            <button
                type="button"
                data-upload-modal-target
                data-upload-title="Form Upload Materi"
                data-upload-label="Softcopy Materi"
                class="inline-flex items-center gap-2 rounded-lg bg-slate-500 px-3 py-2 text-xs font-bold text-white shadow-sm transition hover:bg-slate-600">
                <span>▣</span>
                Materi
            </button>

            <button
                type="button"
                data-upload-modal-target
                data-upload-title="Form Upload Sertifikat Peserta"
                data-upload-label="Softcopy Sertifikat Peserta"
                class="inline-flex items-center gap-2 rounded-lg bg-purple-500 px-3 py-2 text-xs font-bold text-white shadow-sm transition hover:bg-purple-600">
                <span>▣</span>
                Sertifikat Peserta
            </button>

            <button
                type="button"
                data-upload-modal-target
                data-upload-title="Form Upload SKK Peserta"
                data-upload-label="Softcopy SKK Peserta"
                class="inline-flex items-center gap-2 rounded-lg bg-stone-400 px-3 py-2 text-xs font-bold text-white shadow-sm transition hover:bg-stone-500">
                <span>▣</span>
                SKK Peserta
            </button>
        </div>

        {{-- DETAIL INFORMATION --}}
        <div class="px-5 py-5">
            <div class="grid grid-cols-1 gap-0 divide-y divide-slate-200">

                <div class="grid grid-cols-1 gap-2 py-3 md:grid-cols-[260px_20px_minmax(0,1fr)]">
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-500">
                        Nama Kegiatan
                    </div>

                    <div class="hidden text-slate-400 md:block">
                        :
                    </div>

                    <div class="min-w-0 break-words text-sm font-semibold text-[#142B67]">
                        {{ $pelatihan->nama_kegiatan ?? '-' }}
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-2 py-3 md:grid-cols-[260px_20px_minmax(0,1fr)]">
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-500">
                        Waktu Kegiatan
                    </div>

                    <div class="hidden text-slate-400 md:block">
                        :
                    </div>

                    <div class="min-w-0 break-words text-sm font-semibold text-[#142B67]">
                        {{ $waktuLabel }}
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-2 py-3 md:grid-cols-[260px_20px_minmax(0,1fr)]">
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-500">
                        Tempat Kegiatan
                    </div>

                    <div class="hidden text-slate-400 md:block">
                        :
                    </div>

                    <div class="min-w-0 break-words text-sm font-semibold text-[#142B67]">
                        {{ $tempat }}
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-2 py-3 md:grid-cols-[260px_20px_minmax(0,1fr)]">
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-500">
                        Status Kegiatan
                    </div>

                    <div class="hidden text-slate-400 md:block">
                        :
                    </div>

                    <div class="min-w-0">
                        <span class="inline-flex rounded-full border px-3 py-1 text-xs font-bold {{ $statusColor }}">
                            {{ $statusLabel }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-2 py-3 md:grid-cols-[260px_20px_minmax(0,1fr)]">
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-500">
                        Jenis Peserta
                    </div>

                    <div class="hidden text-slate-400 md:block">
                        :
                    </div>

                    <div class="min-w-0 break-words text-sm font-semibold text-[#142B67]">
                        {{ $pelatihan->jenis_peserta ?? '-' }}
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-2 py-3 md:grid-cols-[260px_20px_minmax(0,1fr)]">
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-500">
                        Metode Kegiatan
                    </div>

                    <div class="hidden text-slate-400 md:block">
                        :
                    </div>

                    <div class="min-w-0 break-words text-sm font-semibold text-[#142B67]">
                        {{ $pelatihan->metode_kegiatan ?? '-' }}
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-2 py-3 md:grid-cols-[260px_20px_minmax(0,1fr)]">
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-500">
                        Realisasi Peserta
                    </div>

                    <div class="hidden text-slate-400 md:block">
                        :
                    </div>

                    <div class="min-w-0 break-words text-sm font-semibold text-[#142B67]">
                        {{ $peserta }}
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-2 py-3 md:grid-cols-[260px_20px_minmax(0,1fr)]">
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-500">
                        Standar Kompetensi
                    </div>

                    <div class="hidden text-slate-400 md:block">
                        :
                    </div>

                    <div class="min-w-0 break-words text-sm font-semibold text-[#142B67]">
                        {{ $jabatanKerja }}
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-2 py-3 md:grid-cols-[260px_20px_minmax(0,1fr)]">
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-500">
                        Laporan Kegiatan
                    </div>

                    <div class="hidden text-slate-400 md:block">
                        :
                    </div>

                    <div class="min-w-0 text-sm italic text-slate-500">
                        Belum tersedia
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-2 py-3 md:grid-cols-[260px_20px_minmax(0,1fr)]">
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-500">
                        Notulen Kegiatan
                    </div>

                    <div class="hidden text-slate-400 md:block">
                        :
                    </div>

                    <div class="min-w-0 text-sm italic text-slate-500">
                        Belum tersedia
                    </div>
                </div>

            </div>
        </div>

        {{-- PARTICIPANT ACTIONS --}}
        <div class="flex min-w-0 flex-col gap-3 border-t border-slate-200 px-5 py-4 lg:flex-row lg:items-center">
            <button
                type="button"
                class="inline-flex w-fit items-center gap-2 rounded-lg bg-red-500 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-red-600">
                <span>＋</span>
                Tambah Peserta
            </button>

            <button
                type="button"
                class="inline-flex w-fit items-center gap-2 rounded-lg bg-cyan-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-700">
                <span>➜</span>
                Pindah Calon Peserta
            </button>

            <select
                class="w-full max-w-xl rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-600 outline-none transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100">
                <option value="">Pilih...</option>
            </select>
        </div>

        {{-- FILTER PESERTA --}}
        <div class="border-t border-slate-200 px-5 py-4">
            <div class="flex min-w-0 items-center gap-2">
                <label
                    for="filter-peserta"
                    class="shrink-0 text-sm font-medium text-slate-600">
                    Filter:
                </label>

                <input
                    id="filter-peserta"
                    type="text"
                    placeholder="Type to filter..."
                    class="w-full max-w-xs rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm text-slate-600 outline-none transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100">
            </div>
        </div>

        {{-- PESERTA TABLE --}}
        <div class="w-full overflow-x-auto border-t border-slate-200">
            <table class="w-full min-w-[1050px] divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="w-12 px-4 py-4 text-left">
                            <input
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
                            Kab/Kota
                        </th>

                        <th class="px-4 py-4 text-center text-xs font-extrabold uppercase tracking-wider text-slate-500">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($pesertaRows as $pesertaItem)
                    <tr class="transition hover:bg-slate-50">
                        <td class="px-4 py-4">
                            <input
                                type="checkbox"
                                class="h-4 w-4 rounded border-slate-300 text-[#28428B] focus:ring-[#28428B]">
                        </td>

                        <td class="px-4 py-4 text-center text-sm text-slate-500">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-4 py-4 text-sm font-semibold text-[#142B67]">
                            {{ $pesertaItem['nama'] ?? '-' }}
                        </td>

                        <td class="px-4 py-4 text-sm text-blue-600">
                            {{ $pesertaItem['email_telp'] ?? '-' }}
                        </td>

                        <td class="px-4 py-4 text-sm text-slate-600">
                            {{ $pesertaItem['pendidikan'] ?? '-' }}
                        </td>

                        <td class="px-4 py-4 text-center">
                            <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-700">
                                {{ $pesertaItem['asn'] ?? '-' }}
                            </span>
                        </td>

                        <td class="px-4 py-4 text-sm text-slate-600">
                            {{ $pesertaItem['jabatan_instansi'] ?? '-' }}
                        </td>

                        <td class="px-4 py-4 text-sm text-slate-600">
                            {{ $pesertaItem['alamat'] ?? '-' }}
                        </td>

                        <td class="px-4 py-4 text-sm text-slate-600">
                            {{ $pesertaItem['kab_kota'] ?? '-' }}
                        </td>

                        <td class="px-4 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button
                                    type="button"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-cyan-500 text-white transition hover:bg-cyan-600">
                                    ✓
                                </button>

                                <button
                                    type="button"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-red-500 text-white transition hover:bg-red-600">
                                    ✕
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="px-5 py-14 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-2xl">
                                    👥
                                </div>

                                <h3 class="text-base font-extrabold text-slate-700">
                                    Belum Ada Data Peserta
                                </h3>

                                <p class="mt-1 max-w-md text-sm text-slate-500">
                                    Data peserta belum tersedia. Jika nanti tabel peserta sudah dibuat, bagian ini bisa langsung dihubungkan ke database peserta kegiatan.
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>

{{-- MODAL UPLOAD FILE --}}
<div
    id="modalUploadFile"
    class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/50 p-4">

    <div class="w-full max-w-3xl overflow-hidden rounded-lg bg-white shadow-2xl">

        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">
            <h2
                id="uploadModalTitle"
                class="text-xl font-bold text-slate-800">
                Form Upload File
            </h2>

            <button
                type="button"
                data-upload-modal-close
                class="text-3xl font-light leading-none text-slate-500 transition hover:text-slate-800">
                &times;
            </button>
        </div>

        <form
            action="#"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            <div class="px-6 py-7">
                <label
                    id="uploadModalLabel"
                    for="upload-file-input"
                    class="mb-3 block text-base font-medium text-slate-700">
                    Softcopy File
                </label>

                <input
                    id="upload-file-input"
                    type="file"
                    name="softcopy_file"
                    class="block w-full border border-slate-300 text-sm text-slate-700 file:mr-5 file:border-0 file:border-r file:border-slate-300 file:bg-slate-50 file:px-5 file:py-3 file:text-sm file:font-medium file:text-slate-700 hover:file:bg-slate-100">
            </div>

            <div class="flex items-center justify-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-5">
                <button
                    type="button"
                    data-upload-modal-close
                    class="rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-100">
                    Close
                </button>

                <button
                    type="submit"
                    class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                    Simpan
                </button>
            </div>

        </form>

    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalUploadFile = document.getElementById('modalUploadFile');
        const uploadModalTitle = document.getElementById('uploadModalTitle');
        const uploadModalLabel = document.getElementById('uploadModalLabel');
        const uploadFileInput = document.getElementById('upload-file-input');

        document.querySelectorAll('[data-upload-modal-target]').forEach(function(button) {
            button.addEventListener('click', function() {
                const title = this.dataset.uploadTitle || 'Form Upload File';
                const label = this.dataset.uploadLabel || 'Softcopy File';

                uploadModalTitle.textContent = title;
                uploadModalLabel.textContent = label;

                if (uploadFileInput) {
                    uploadFileInput.value = '';
                }

                modalUploadFile.classList.remove('hidden');
                modalUploadFile.classList.add('flex');
            });
        });

        document.querySelectorAll('[data-upload-modal-close]').forEach(function(button) {
            button.addEventListener('click', function() {
                modalUploadFile.classList.add('hidden');
                modalUploadFile.classList.remove('flex');
            });
        });

        modalUploadFile.addEventListener('click', function(event) {
            if (event.target === modalUploadFile) {
                modalUploadFile.classList.add('hidden');
                modalUploadFile.classList.remove('flex');
            }
        });
    });
</script>

@endsection