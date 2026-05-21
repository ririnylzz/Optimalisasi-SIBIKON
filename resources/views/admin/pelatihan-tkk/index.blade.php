@extends('layouts.admin')

@section('page-title', 'Pelatihan & Sertifikasi TKK')
@section('page-subtitle', 'Manajemen pelatihan tenaga kerja konstruksi')

@section('content')
<div x-data="{ openModal: false }" class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-800">
                Data Pelatihan & Sertifikasi
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Kelola data pelatihan dan sertifikasi tenaga kerja konstruksi.
            </p>
        </div>

        <button
            @click="openModal = true"
            class="rounded-xl bg-[#1E3A8A] px-5 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-[#142B67]">
            + Tambah Data
        </button>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Nama Pelatihan
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Tanggal
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
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-slate-700">
                            Pelatihan Ahli Muda K3
                        </td>

                        <td class="px-6 py-4 text-sm text-slate-600">
                            12 Mei 2026
                        </td>

                        <td class="px-6 py-4 text-sm text-slate-600">
                            Samarinda
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">

                                <button class="rounded-lg bg-amber-100 p-2 text-amber-600 hover:bg-amber-200">
                                    ✏️
                                </button>

                                <button class="rounded-lg bg-rose-100 p-2 text-rose-600 hover:bg-rose-200">
                                    🗑️
                                </button>

                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
<!-- Modal Tambah Data -->
<div
    x-show="openModal"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm"
>
    <div
        @click.outside="openModal = false"
        class="max-h-[95vh] w-full max-w-5xl overflow-y-auto rounded-3xl bg-white shadow-2xl"
    >

        <!-- Header -->
        <div class="sticky top-0 flex items-center justify-between border-b border-slate-200 bg-white px-8 py-5">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-800">
                    Form Pelatihan
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Tambahkan data pelatihan dan sertifikasi TKK.
                </p>
            </div>

            <button
                @click="openModal = false"
                class="rounded-xl bg-slate-100 p-2 text-slate-500 transition hover:bg-slate-200"
            >
                ✕
            </button>
        </div>

        <!-- Form -->
        <form class="space-y-8 px-8 py-8">

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                <!-- Tahun -->
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Tahun
                    </label>

                    <select class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-[#1E3A8A] focus:outline-none">
                        <option>Pilih...</option>
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Status Kegiatan
                    </label>

                    <select class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-[#1E3A8A] focus:outline-none">
                        <option>Pilih...</option>
                    </select>
                </div>

                <!-- Jenis Peserta -->
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Jenis Peserta
                    </label>

                    <input
                        type="text"
                        value="Umum"
                        class="w-full rounded-2xl border border-slate-300 bg-slate-100 px-4 py-3 text-sm"
                    >
                </div>

                <!-- Metode -->
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Metode Kegiatan
                    </label>

                    <input
                        type="text"
                        value="Luring"
                        class="w-full rounded-2xl border border-slate-300 bg-slate-100 px-4 py-3 text-sm"
                    >
                </div>

                <!-- Nama Kegiatan -->
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Nama Kegiatan
                    </label>

                    <input
                        type="text"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-[#1E3A8A] focus:outline-none"
                    >
                </div>

                <!-- Waktu -->
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Waktu Kegiatan
                    </label>

                    <input
                        type="date"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-[#1E3A8A] focus:outline-none"
                    >
                </div>

                <!-- Peserta -->
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Realisasi Jumlah Peserta
                    </label>

                    <input
                        type="number"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-[#1E3A8A] focus:outline-none"
                    >
                </div>

                <!-- Sumber Dana -->
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Sumber Dana
                    </label>

                    <select class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-[#1E3A8A] focus:outline-none">
                        <option>Pilih...</option>
                    </select>
                </div>

                <!-- Standar Kompetensi -->
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Standar Kompetensi
                    </label>

                    <select class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-[#1E3A8A] focus:outline-none">
                        <option>Pilih...</option>
                    </select>
                </div>

                <!-- TUK -->
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Tempat Uji Kompetensi (TUK)
                    </label>

                    <input
                        type="text"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-[#1E3A8A] focus:outline-none"
                    >
                </div>

                <!-- LSP -->
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Lembaga Sertifikasi Profesi (LSP)
                    </label>

                    <select class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-[#1E3A8A] focus:outline-none">
                        <option>Pilih...</option>
                    </select>
                </div>

                <!-- Tempat -->
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Tempat Kegiatan
                    </label>

                    <input
                        type="text"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-[#1E3A8A] focus:outline-none"
                    >
                </div>

                <!-- Provinsi -->
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Provinsi
                    </label>

                    <select class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-[#1E3A8A] focus:outline-none">
                        <option>Pilih...</option>
                    </select>
                </div>

                <!-- Kabupaten -->
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Kabupaten/Kota
                    </label>

                    <select class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-[#1E3A8A] focus:outline-none">
                        <option>Pilih...</option>
                    </select>
                </div>

                <!-- Syarat -->
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Syarat Tambahan
                    </label>

                    <textarea
                        rows="4"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-[#1E3A8A] focus:outline-none"
                    ></textarea>

                    <p class="mt-2 text-xs text-slate-400">
                        Gunakan tanda semicolon (;) sebagai pemisah
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex items-center justify-end gap-3 border-t border-slate-200 pt-6">

                <button
                    type="button"
                    @click="openModal = false"
                    class="rounded-2xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-100"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="rounded-2xl bg-[#1E3A8A] px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-[#142B67]"
                >
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection