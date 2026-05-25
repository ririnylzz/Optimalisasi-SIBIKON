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
            class="inline-flex items-center rounded-xl bg-[#28428B] px-4 py-2 text-sm font-semibold text-white hover:bg-[#1d3270] transition">

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

    {{-- CARD TABLE --}}
    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

        {{-- FILTER --}}
        <div class="border-b border-slate-200 px-6 py-5">

            <form method="GET"
                action="{{ route('admin.pelatihan-sertifikasi.index') }}">

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

                    <tr class="transition hover:bg-slate-50">

                        <td class="px-6 py-5 text-sm text-slate-500">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-5">
                            <div class="max-w-[350px]">
                                <p class="font-semibold text-slate-800">
                                    {{ $item->nama_kegiatan }}
                                </p>
                            </div>
                        </td>

                        <td class="px-6 py-5 text-sm text-slate-600 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($item->waktu_kegiatan)->translatedFormat('d M Y') }}
                        </td>

                        <td class="px-6 py-5 text-sm font-semibold text-slate-700">
                            {{ $item->realisasi_peserta }}
                        </td>

                        <td class="px-6 py-5 text-sm text-slate-600">
                            {{ $item->standar_kompetensi }}
                        </td>

                        <td class="px-6 py-5 text-sm text-slate-600">
                            {{ $item->tempat_kegiatan }}
                        </td>

                        <td class="px-6 py-5 text-sm text-slate-600">
                            {{ $item->kabupaten_kota }}
                        </td>

                        <td class="px-6 py-5 text-center">

                            <div class="relative inline-block text-left">

                                <button
                                    type="button"
                                    onclick="toggleDropdown({{ $item->id }})"
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-amber-200 bg-amber-50 text-amber-600 transition hover:bg-amber-100">

                                    ✏️

                                </button>

                                {{-- DROPDOWN --}}
                                <div
                                    id="dropdown-{{ $item->id }}"
                                    class="absolute right-0 z-20 mt-2 hidden w-48 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl">

                                    {{-- EDIT --}}
                                    <button
                                        type="button"
                                        class="flex w-full items-center gap-3 px-4 py-3 text-sm text-slate-700 transition hover:bg-slate-50">

                                        ✏️
                                        Edit Kegiatan

                                    </button>

                                    {{-- DETAIL --}}
                                    <button
                                        type="button"
                                        class="flex w-full items-center gap-3 border-t border-slate-100 px-4 py-3 text-sm text-slate-700 transition hover:bg-slate-50">

                                        👁️
                                        Detail Kegiatan

                                    </button>

                                </div>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="9"
                            class="px-6 py-16 text-center">

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

{{-- MODAL TAMBAH DATA --}}
<div
    id="modalPelatihan"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">

    <div class="max-h-[95vh] w-full max-w-5xl overflow-y-auto rounded-3xl bg-white shadow-2xl">

        {{-- HEADER --}}
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

        {{-- FORM --}}
        <form
            action="{{ route('admin.pelatihan-sertifikasi.store') }}"
            method="POST"
            class="space-y-5 p-6">

            @csrf

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

                {{-- TAHUN --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Tahun
                    </label>

                    <select
                        name="tahun"
                        class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">

                        <option value="">Pilih...</option>

                        @for($i = date('Y') + 1; $i >= 2020; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor

                    </select>
                </div>

                {{-- STATUS --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Status Kegiatan
                    </label>

                    <select
                        name="status_kegiatan"
                        class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">

                        <option value="">Pilih...</option>
                        <option value="Terbuka">Terbuka</option>
                        <option value="Tertutup">Tertutup</option>

                    </select>
                </div>

                {{-- JENIS PESERTA --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Jenis Peserta
                    </label>

                    <select
                        name="jenis_peserta"
                        class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">

                        <option value="Umum">Umum</option>
                        <option value="Fresh Graduate">Fresh Graduate</option>
                        <option value="TKK">TKK</option>
                        <option value="ASN">ASN</option>

                    </select>
                </div>

                {{-- METODE --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Metode Kegiatan
                    </label>

                    <select
                        name="metode_kegiatan"
                        class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">

                        <option value="Luring">Luring</option>
                        <option value="Daring">Daring</option>
                        <option value="Luring dan Daring">Luring dan Daring</option>

                    </select>
                </div>

            </div>

            {{-- NAMA KEGIATAN --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">
                    Nama Kegiatan
                </label>

                <input
                    type="text"
                    name="nama_kegiatan"
                    class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"
                    placeholder="Masukkan nama kegiatan">
            </div>

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

                {{-- WAKTU --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Waktu Kegiatan
                    </label>

                    <input
                        type="date"
                        name="waktu_kegiatan"
                        class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                </div>

                {{-- PESERTA --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Realisasi Jumlah Peserta
                    </label>

                    <input
                        type="number"
                        name="jumlah_peserta"
                        class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"
                        placeholder="0">
                </div>

            </div>

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

                {{-- SUMBER DANA --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Sumber Dana
                    </label>

                    <select
                        name="sumber_dana"
                        class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">

                        <option value="">Pilih...</option>
                        <option value="APBD">APBD</option>
                        <option value="APBDP">APBDP</option>
                        <option value="APBN">APBN</option>

                    </select>
                </div>

                {{-- STANDAR --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Standar Kompetensi
                    </label>

                    <select
                        name="standar_kompetensi"
                        class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">

                        <option value="">Pilih...</option>

                        <option>Pengelola Teknis Pembangunan Bangunan Gedung Negara</option>
                        <option>Ahli Madya Rekayasa Konstruksi Bangunan Gedung</option>
                        <option>Ahli Muda Teknik Jalan</option>
                        <option>Ahli Muda Bidang Keahlian Teknik Sumber Daya Air</option>
                        <option>Ahli Muda K3 Konstruksi</option>
                        <option>Ahli Muda Teknik Jembatan</option>
                        <option>Ahli Muda Bidang Keahlian Manajemen Konstruksi</option>

                    </select>
                </div>

            </div>

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

                {{-- TUK --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Tempat Uji Kompetensi (TUK)
                    </label>

                    <input
                        type="text"
                        name="tuk"
                        class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                </div>

                {{-- LSP --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Lembaga Sertifikasi Profesi (LSP)
                    </label>

                    <select
                        name="lsp"
                        class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">

                        <option value="">Pilih...</option>

                        <option>ATAKI Konstruksi Indonesia</option>
                        <option>HATSINDO Indonesia Teknik</option>
                        <option>KATIGA Konstruksi Indonesia</option>
                        <option>GATAKI Konstruksi Mandiri</option>
                        <option>PERTAHKINDO Kaltim</option>
                        <option>Infrastruktur Jalan dan Jembatan Indonesia</option>
                        <option>ASTEKINDO Kaltim</option>

                    </select>
                </div>

            </div>

            {{-- TEMPAT --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">
                    Tempat Kegiatan
                </label>

                <input
                    type="text"
                    name="tempat_kegiatan"
                    class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
            </div>

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

                {{-- PROVINSI --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Provinsi
                    </label>

                    <select
                        id="provinsi"
                        name="provinsi"
                        class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">

                        <option value="">Pilih...</option>

                        <option>Aceh</option>
                        <option>Sumatera Utara</option>
                        <option>Sumatera Barat</option>
                        <option>Riau</option>
                        <option>Jambi</option>
                        <option>Sumatera Selatan</option>
                        <option>Bengkulu</option>
                        <option>Lampung</option>
                        <option>Kepulauan Bangka Belitung</option>
                        <option>Kepulauan Riau</option>
                        <option>DKI Jakarta</option>
                        <option>Jawa Barat</option>
                        <option>Jawa Tengah</option>
                        <option>DI Yogyakarta</option>
                        <option>Jawa Timur</option>
                        <option>Banten</option>
                        <option>Bali</option>
                        <option>Nusa Tenggara Barat</option>
                        <option>Nusa Tenggara Timur</option>
                        <option>Kalimantan Barat</option>
                        <option>Kalimantan Tengah</option>
                        <option>Kalimantan Selatan</option>
                        <option>Kalimantan Timur</option>
                        <option>Kalimantan Utara</option>
                        <option>Sulawesi Utara</option>
                        <option>Sulawesi Tengah</option>
                        <option>Sulawesi Selatan</option>
                        <option>Sulawesi Tenggara</option>
                        <option>Gorontalo</option>
                        <option>Sulawesi Barat</option>
                        <option>Maluku</option>
                        <option>Maluku Utara</option>
                        <option>Papua</option>
                        <option>Papua Barat</option>

                    </select>
                </div>

                {{-- KABUPATEN --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Kabupaten/Kota
                    </label>

                    <select
                        id="kabupaten"
                        name="kabupaten"
                        class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">

                        <option value="">
                            Pilih provinsi dulu...
                        </option>

                    </select>
                </div>

            </div>

            {{-- SYARAT --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">
                    Syarat Tambahan
                </label>

                <textarea
                    name="syarat_tambahan"
                    rows="3"
                    class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"
                    placeholder="Gunakan tanda semicolon (;) sebagai pemisah"></textarea>
            </div>

            {{-- BUTTON --}}
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

{{-- SCRIPT MODAL --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const modal = document.getElementById('modalPelatihan');

    document.querySelectorAll('[data-modal-target]').forEach(button => {

        button.addEventListener('click', () => {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });

    });

    document.querySelectorAll('[data-modal-close]').forEach(button => {

        button.addEventListener('click', () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });

    });

});

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

const provinsiSelect = document.getElementById('provinsi');
const kabupatenSelect = document.getElementById('kabupaten');

provinsiSelect.addEventListener('change', function () {

    const selectedProvinsi = this.value;

    kabupatenSelect.innerHTML = '';

    if (!selectedProvinsi || !kabupatenData[selectedProvinsi]) {

        kabupatenSelect.innerHTML =
            '<option value="">Pilih provinsi dulu...</option>';

        return;
    }

    kabupatenSelect.innerHTML =
        '<option value="">Pilih Kabupaten/Kota</option>';

    kabupatenData[selectedProvinsi].forEach(function (kabupaten) {

        const option = document.createElement('option');

        option.value = kabupaten;
        option.textContent = kabupaten;

        kabupatenSelect.appendChild(option);

    });

});

function toggleDropdown(id) {

    const dropdown = document.getElementById(`dropdown-${id}`);

    document.querySelectorAll('[id^="dropdown-"]').forEach(el => {

        if (el.id !== `dropdown-${id}`) {
            el.classList.add('hidden');
        }

    });

    dropdown.classList.toggle('hidden');
}

window.addEventListener('click', function(e) {

    if (!e.target.closest('.relative')) {

        document.querySelectorAll('[id^="dropdown-"]').forEach(el => {
            el.classList.add('hidden');
        });

    }

});

</script>

@endsection