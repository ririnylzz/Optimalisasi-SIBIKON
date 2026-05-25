@extends('layouts.admin')

@section('page-title', 'Pelatihan dan Sertifikasi TKK Ahli')
@section('page-subtitle', 'Daftar kegiatan pelatihan dan sertifikasi tenaga kerja konstruksi')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">
                Daftar Kegiatan
            </h1>
        </div>

        <button
            type="button"
            data-modal-target="modalPelatihan"
            class="inline-flex items-center rounded-xl bg-[#28428B] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#1d3270]">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="mr-2 h-4 w-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 4v16m8-8H4" />
            </svg>

            Tambah Data
        </button>
    </div>

    {{-- ALERT --}}
    @if (session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700">
            <p class="mb-2 font-bold">Data gagal disimpan:</p>

            <ul class="list-inside list-disc space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- CARD TABLE --}}
    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">

        {{-- FILTER --}}
        <div class="border-b border-slate-200 px-6 py-5">

            <form method="GET" action="{{ route('admin.pelatihan-sertifikasi.index') }}">

                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                    <div class="relative w-full max-w-md">

                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                            🔍
                        </span>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari kegiatan, jabatan kerja, lokasi..."
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm text-slate-700 outline-none transition focus:border-[#28428B] focus:bg-white focus:ring-4 focus:ring-blue-100">

                    </div>

                    <div class="text-sm text-slate-500">
                        Total Data :
                        <span class="font-bold text-slate-700">
                            {{ $pelatihan->total() }}
                        </span>
                    </div>

                </div>

            </form>

        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-slate-200">

                <thead class="bg-slate-50">

                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            No
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Nama Kegiatan
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Waktu Pelaksanaan
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Peserta
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Jabatan Kerja
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Tempat
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Lokasi
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-500">
                            Aksi
                        </th>
                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100 bg-white">

                    @forelse($pelatihan as $item)

                        @php
                            $waktuPelaksanaan = $item->waktu_kegiatan ?? $item->tanggal_mulai;
                            $peserta = $item->realisasi_peserta ?? $item->peserta ?? 0;
                            $jabatanKerja = $item->standar_kompetensi ?? $item->jabatan_kerja ?? '-';
                            $tempat = $item->tempat_kegiatan ?? $item->tempat ?? '-';
                            $lokasi = $item->kabupaten_kota ?? $item->lokasi ?? $item->provinsi ?? '-';
                        @endphp

                        <tr class="transition hover:bg-slate-50">

                            <td class="px-6 py-5 text-sm text-slate-500">
                                {{ $pelatihan->firstItem() + $loop->index }}
                            </td>

                            <td class="px-6 py-5">
                                <div class="max-w-[350px]">
                                    <p class="font-semibold text-slate-800">
                                        {{ $item->nama_kegiatan }}
                                    </p>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-6 py-5 text-sm text-slate-600">
                                @if ($waktuPelaksanaan)
                                    {{ \Carbon\Carbon::parse($waktuPelaksanaan)->translatedFormat('d M Y') }}
                                @else
                                    -
                                @endif
                            </td>

                            <td class="px-6 py-5 text-sm font-semibold text-slate-700">
                                {{ $peserta }}
                            </td>

                            <td class="px-6 py-5 text-sm text-slate-600">
                                {{ $jabatanKerja }}
                            </td>

                            <td class="px-6 py-5 text-sm text-slate-600">
                                {{ $tempat }}
                            </td>

                            <td class="px-6 py-5 text-sm text-slate-600">
                                {{ $lokasi }}
                            </td>

                        <td class="px-6 py-5">

                            <div class="flex items-center justify-center gap-2">

                                {{-- EDIT --}}
                                <button
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-amber-200 bg-amber-50 text-amber-600 transition hover:bg-amber-100">

                                    ✏️

                                </button>

                                {{-- DELETE --}}
                                <button
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-rose-200 bg-rose-50 text-rose-600 transition hover:bg-rose-100">

                                    🗑️

                                </button>

                            </div>

                        </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="px-6 py-16 text-center">

                                <div class="flex flex-col items-center">

                                    <div class="mb-4 text-5xl">
                                        📁
                                    </div>

                                    <h3 class="text-lg font-bold text-slate-700">
                                        Belum Ada Data
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Data pelatihan dan sertifikasi belum tersedia.
                                    </p>

                                </div>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        <div class="border-t border-slate-200 px-6 py-4">
            {{ $pelatihan->links() }}
        </div>

    </div>

</div>

{{-- GLOBAL ACTION DROPDOWN --}}
<div
    id="actionDropdownMenu"
    class="fixed z-[9999] hidden w-56 overflow-hidden rounded-xl border border-slate-200 bg-white text-left shadow-xl">

    <button
        type="button"
        id="actionEditButton"
        class="block w-full px-5 py-3 text-left text-sm font-medium text-slate-700 transition hover:bg-slate-50">
        Edit Kegiatan
    </button>

    <button
        type="button"
        id="actionDetailButton"
        class="block w-full px-5 py-3 text-left text-sm font-medium text-slate-700 transition hover:bg-slate-50">
        Detail Kegiatan
    </button>

    <div class="border-t border-slate-200"></div>

    <button
        type="button"
        id="actionDeleteButton"
        class="block w-full px-5 py-3 text-left text-sm font-medium text-rose-600 transition hover:bg-rose-50">
        Hapus Kegiatan
    </button>
</div>

<form
    id="deletePelatihanForm"
    action="#"
    method="POST"
    class="hidden">
    @csrf
    @method('DELETE')
</form>

{{-- MODAL TAMBAH DATA --}}
<div
    id="modalPelatihan"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">

    <div class="max-h-[95vh] w-full max-w-5xl overflow-y-auto rounded-3xl bg-white shadow-2xl">

        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">
                    Form Pelatihan
                </h2>
            </div>

            <button
                type="button"
                data-modal-close
                class="rounded-xl p-2 text-slate-500 hover:bg-slate-100">
                ✕
            </button>
        </div>

        <form
            action="{{ route('admin.pelatihan-sertifikasi.store') }}"
            method="POST"
            class="space-y-5 p-6">

            @csrf

            @include('admin.pelatihan-sertifikasi.partials.form-fields', [
                'mode' => 'create',
                'prefix' => 'create',
                'pelatihanItem' => null,
            ])

            <div class="flex items-center justify-end gap-3 border-t border-slate-200 pt-4">

                <button
                    type="button"
                    data-modal-close
                    class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    Batal
                </button>

                <button
                    type="submit"
                    class="rounded-xl bg-[#28428B] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#1d3270]">
                    Simpan Data
                </button>

            </div>

        </form>

    </div>

</div>

{{-- MODAL EDIT DATA --}}
<div
    id="modalEditPelatihan"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">

    <div class="max-h-[95vh] w-full max-w-5xl overflow-y-auto rounded-3xl bg-white shadow-2xl">

        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">
                    Edit Kegiatan
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    Ubah data kegiatan pelatihan dan sertifikasi.
                </p>
            </div>

            <button
                type="button"
                data-edit-modal-close
                class="rounded-xl p-2 text-slate-500 hover:bg-slate-100">
                ✕
            </button>
        </div>

        <form
            id="editPelatihanForm"
            action="#"
            method="POST"
            class="space-y-5 p-6">

            @csrf
            @method('PUT')

            @include('admin.pelatihan-sertifikasi.partials.form-fields', [
                'mode' => 'edit',
                'prefix' => 'edit',
                'pelatihanItem' => null,
            ])

            <div class="flex items-center justify-end gap-3 border-t border-slate-200 pt-4">

                <button
                    type="button"
                    data-edit-modal-close
                    class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    Batal
                </button>

                <button
                    type="submit"
                    class="rounded-xl bg-[#28428B] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#1d3270]">
                    Update Data
                </button>

            </div>

        </form>

    </div>

</div>

{{-- SCRIPT MODAL + GLOBAL DROPDOWN --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const modalCreate = document.getElementById('modalPelatihan');
    const modalEdit = document.getElementById('modalEditPelatihan');
    const editForm = document.getElementById('editPelatihanForm');

    const actionDropdownMenu = document.getElementById('actionDropdownMenu');
    const actionEditButton = document.getElementById('actionEditButton');
    const actionDetailButton = document.getElementById('actionDetailButton');
    const actionDeleteButton = document.getElementById('actionDeleteButton');
    const deletePelatihanForm = document.getElementById('deletePelatihanForm');

    let activeActionButton = null;

    const kabupatenData = {
        "Kalimantan Timur": [
            "Samarinda",
            "Balikpapan",
            "Bontang",
            "Kutai Kartanegara",
            "Kutai Timur",
            "Kutai Barat",
            "Berau",
            "Paser",
            "Penajam Paser Utara",
            "Mahakam Ulu"
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
            "Depok",
            "Cimahi",
            "Tasikmalaya"
        ],
        "Jawa Timur": [
            "Surabaya",
            "Malang",
            "Kediri",
            "Madiun",
            "Blitar"
        ],
        "Sulawesi Selatan": [
            "Makassar",
            "Parepare",
            "Palopo"
        ]
    };

    function renderKabupatenOptions(prefix, selectedProvinsi, selectedKabupaten = null) {
        const kabupatenSelect = document.getElementById(prefix + '_kabupaten');

        if (!kabupatenSelect) {
            return;
        }

        kabupatenSelect.innerHTML = '';

        if (!selectedProvinsi || !kabupatenData[selectedProvinsi]) {
            kabupatenSelect.innerHTML = '<option value="">Pilih provinsi dulu...</option>';
            return;
        }

        kabupatenSelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';

        kabupatenData[selectedProvinsi].forEach(function (kabupaten) {
            const option = document.createElement('option');

            option.value = kabupaten;
            option.textContent = kabupaten;

            if (selectedKabupaten && selectedKabupaten === kabupaten) {
                option.selected = true;
            }

        kabupatenSelect.appendChild(option);

    });

});

</script>

@endsection