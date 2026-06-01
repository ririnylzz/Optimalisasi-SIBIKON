@extends('layouts.admin')

@section('page-title', 'Data Rantai Pasok')
@section('page-subtitle', 'Kelola data rantai pasok konstruksi di Kalimantan Timur.')

@section('content')
@php
$isEditing = $editingRantaiPasok !== null;

$requestedPanel = request('panel');
$initialPanel = 'closed';
$hasUploadError = $errors->has('file_import');

if (in_array($requestedPanel, ['upload', 'manual'], true)) {
$initialPanel = $requestedPanel;
} elseif ($hasUploadError) {
$initialPanel = 'upload';
} elseif ($isEditing || ($errors->any() && !$hasUploadError)) {
$initialPanel = 'manual';
}

$toastMessages = [];

if (session('success')) {
$toastMessages[] = ['type' => 'success', 'message' => session('success')];
}

if (session('error')) {
$toastMessages[] = ['type' => 'error', 'message' => session('error')];
}

if ($errors->has('file_import')) {
$toastMessages[] = ['type' => 'error', 'message' => $errors->first('file_import')];
} elseif ($errors->any()) {
$toastMessages[] = ['type' => 'error', 'message' => $errors->first()];
}
@endphp

<div class="pointer-events-none fixed right-4 top-4 z-[100] flex w-full max-w-sm flex-col gap-3">
    @foreach($toastMessages as $toast)
    <div
        data-toast
        class="pointer-events-auto rounded-2xl border px-4 py-3 shadow-2xl transition duration-300
            {{ $toast['type'] === 'success'
                ? 'border-emerald-500/30 bg-emerald-500 text-white'
                : 'border-rose-500/30 bg-rose-500 text-white' }}">
        <div class="flex items-start gap-3">
            <div class="mt-0.5 shrink-0">
                @if($toast['type'] === 'success')
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                @else
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86l-7.13 12.5A1 1 0 004.03 18h15.94a1 1 0 00.87-1.64l-7.13-12.5a1 1 0 00-1.74 0z" />
                </svg>
                @endif
            </div>

            <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold">
                    {{ $toast['type'] === 'success' ? 'Berhasil' : 'Gagal' }}
                </p>
                <p class="mt-1 text-sm leading-5 text-white/95">
                    {{ $toast['message'] }}
                </p>
            </div>

            <button type="button" data-toast-close class="shrink-0 rounded-lg p-1 text-white/80 transition hover:bg-white/10 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
    @endforeach
</div>

<div class="space-y-4">
    <div>
        <div class="flex items-center gap-2 text-xs text-slate-500">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600">Home</a>
            <span>/</span>
            <span class="font-medium text-slate-500">Masyarakat Jasa Konstruksi</span>
            <span>/</span>
            <span class="font-medium text-slate-700">Rantai Pasok</span>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900">Tabel Data Rantai Pasok</h3>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <button
                    type="button"
                    data-modal-open="manual"
                    class="rounded-xl bg-indigo-600 px-4 py-2.5 text-xs font-semibold text-white shadow-sm transition hover:bg-indigo-500">
                    Tambah Data
                </button>

                <button
                    type="button"
                    data-modal-open="upload"
                    class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-indigo-300 hover:bg-indigo-50 hover:text-indigo-700">
                    Upload File
                </button>
            </div>
        </div>

        <form id="rantai-filter-form" method="GET" action="{{ route('admin.rantai-pasok') }}" class="mt-8 grid grid-cols-1 gap-3 text-xs md:grid-cols-2 xl:grid-cols-4">
            <div>
                <label for="search" class="mb-2 block text-xs font-semibold text-slate-600">Filter / keyword</label>
                <input
                    id="search"
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Cari nama atau bidang usaha"
                    autocomplete="off"
                    class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-xs text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10" />
            </div>

            <div>
                <label for="filter_bidang_usaha" class="mb-2 block text-xs font-semibold text-slate-600">Bidang usaha</label>
                <select
                    id="filter_bidang_usaha"
                    name="bidang_usaha"
                    class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-xs text-slate-800 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">
                    <option value="">Semua bidang</option>
                    @foreach($bidangOptions as $bidang)
                    <option value="{{ $bidang }}" @selected($bidangFilter===$bidang)>{{ $bidang }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="filter_kabupaten" class="mb-2 block text-xs font-semibold text-slate-600">Kabupaten / Kota</label>
                <select
                    id="filter_kabupaten"
                    name="kabupaten"
                    class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-xs text-slate-800 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">
                    <option value="">Semua kabupaten/kota</option>
                    @foreach($regencyFilterOptions as $kabupaten)
                    <option value="{{ $kabupaten }}" @selected($regencyFilter===$kabupaten)>{{ $kabupaten }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="per_page" class="mb-2 block text-xs font-semibold text-slate-600">Show</label>
                <select
                    id="per_page"
                    name="per_page"
                    class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-xs text-slate-800 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">
                    @foreach([10, 25, 50, 100] as $size)
                    <option value="{{ $size }}" @selected($perPage===$size)>{{ $size }}</option>
                    @endforeach
                </select>
            </div>
        </form>

        <div id="rantai-table-container">
            @include('admin.rantai-pasok.partials.table', [
            'rantaiPasoks' => $rantaiPasoks,
            'search' => $search,
            'bidangFilter' => $bidangFilter,
            'regencyFilter' => $regencyFilter,
            'perPage' => $perPage,
            ])
        </div>
    </div>
</div>

<div class="absolute left-[-9999px] top-auto h-0 w-0 overflow-hidden opacity-0" aria-hidden="true">
    <form id="bulk-delete-form" action="{{ route('admin.rantai-pasok.bulk-destroy') }}" method="POST">
        @csrf
        @method('DELETE')
        <div id="bulk-delete-inputs"></div>
        <button type="submit" data-hidden-submit>submit</button>
    </form>

    <form id="delete-all-form" action="{{ route('admin.rantai-pasok.destroy-all') }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" data-hidden-submit>submit</button>
    </form>
</div>

<div id="upload-modal" data-modal-wrapper="upload" class="pointer-events-none fixed inset-0 z-[70] hidden p-4 opacity-0 transition duration-200">
    <div data-modal-backdrop class="absolute inset-0 bg-slate-950/70 backdrop-blur-sm opacity-0 transition duration-200"></div>

    <div class="relative z-10 flex min-h-full items-center justify-center">
        <div data-modal-panel class="w-full max-w-3xl translate-y-4 scale-[0.98] rounded-3xl bg-white opacity-0 shadow-2xl transition duration-200 ease-out">
            <div class="flex items-start justify-between gap-4 border-b border-slate-200 px-5 py-4">
                <div>
                    <h3 class="text-xl font-bold text-slate-900">Import CSV / XLSX</h3>
                    <p class="mt-1 text-sm text-slate-500">Upload file Rantai Pasok melalui template CSV atau XLSX.</p>
                </div>

                <button type="button" data-modal-close class="inline-flex h-9 w-9 items-center justify-center rounded-full text-slate-500 transition hover:bg-slate-100 hover:text-slate-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="px-5 py-4">
                <form id="rantai-import-form" action="{{ route('admin.rantai-pasok.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label for="file_import" class="mb-2 block text-sm font-medium text-slate-700">
                            File upload <span class="text-rose-500">*</span>
                        </label>
                        <input
                            id="file_import"
                            type="file"
                            name="file_import"
                            accept=".csv,.txt,.xlsx"
                            required
                            class="block w-full rounded-xl border border-slate-300 bg-white px-3 py-3 text-sm text-slate-700 file:mr-3 file:rounded-md file:border-0 file:bg-indigo-600 file:px-3 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-indigo-500" />
                        @error('file_import')
                        <p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm leading-6 text-slate-600">
                        <p class="font-semibold text-slate-800">Aturan import:</p>
                        <p>1. File yang didukung: <span class="font-medium text-slate-800">CSV</span> dan <span class="font-medium text-slate-800">XLSX</span>.</p>
                        <p>2. Header yang didukung: nama, bidang_usaha, alamat, kabupaten, provinsi, kontak.</p>
                        <p>3. Data dengan nama dan kabupaten sama akan di-update, bukan ditambahkan duplikat baru.</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button" data-modal-close class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                            Batal
                        </button>

                        <button type="submit" class="rounded-xl bg-indigo-600 px-4 py-2.5 text-xs font-semibold text-white shadow-sm transition hover:bg-indigo-500">
                            Proses Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="manual-modal" data-modal-wrapper="manual" class="pointer-events-none fixed inset-0 z-[70] hidden p-4 opacity-0 transition duration-200">
    <div data-modal-backdrop class="absolute inset-0 bg-slate-950/70 backdrop-blur-sm opacity-0 transition duration-200"></div>

    <div class="relative z-10 flex min-h-full items-center justify-center">
        <div data-modal-panel class="w-full max-w-5xl translate-y-4 scale-[0.98] rounded-3xl bg-white opacity-0 shadow-2xl transition duration-200 ease-out">
            <div class="flex items-start justify-between gap-4 border-b border-slate-200 px-5 py-4">
                <div>
                    <h3 class="text-xl font-bold text-slate-900">{{ $isEditing ? 'Ubah Data Rantai Pasok' : 'Form Rantai Pasok' }}</h3>
                    <p class="mt-1 text-sm text-slate-500">Isi data rantai pasok secara manual melalui form berikut.</p>
                </div>

                <div class="flex items-center gap-2">
                    @if($isEditing)
                    <a href="{{ route('admin.rantai-pasok') }}" class="rounded-xl border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                        Reset
                    </a>
                    @endif

                    <button type="button" data-modal-close class="inline-flex h-9 w-9 items-center justify-center rounded-full text-slate-500 transition hover:bg-slate-100 hover:text-slate-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="px-5 py-4">
                @if($errors->any() && !$hasUploadError)
                <div class="mb-4 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    <p class="font-semibold">Masih ada input yang perlu diperbaiki:</p>
                    <ul class="mt-2 space-y-1 text-xs">
                        @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form
                    id="rantai-manual-form"
                    action="{{ $isEditing ? route('admin.rantai-pasok.update', $editingRantaiPasok) : route('admin.rantai-pasok.store') }}"
                    method="POST"
                    class="space-y-3"
                    novalidate>
                    @csrf
                    @if($isEditing)
                    @method('PUT')
                    @endif

                    <div class="grid grid-cols-1 gap-3 lg:grid-cols-2">
                        <div>
                            <label for="nama" class="mb-2 block text-sm font-medium text-slate-700">Nama</label>
                            <input
                                id="nama"
                                type="text"
                                name="nama"
                                value="{{ old('nama', $editingRantaiPasok?->nama) }}"
                                placeholder="Nama perusahaan / penyedia"
                                data-required="Nama wajib diisi."
                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10" />
                            <p class="mt-1 text-xs text-rose-500 {{ $errors->has('nama') ? '' : 'hidden' }}" data-error-for="nama">{{ $errors->first('nama') }}</p>
                        </div>

                        <div>
                            <label for="bidang_usaha" class="mb-2 block text-sm font-medium text-slate-700">Bidang Usaha</label>
                            <input
                                id="bidang_usaha"
                                type="text"
                                name="bidang_usaha"
                                value="{{ old('bidang_usaha', $editingRantaiPasok?->bidang_usaha) }}"
                                placeholder="Bidang usaha"
                                data-required="Bidang usaha wajib diisi."
                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10" />
                            <p class="mt-1 text-xs text-rose-500 {{ $errors->has('bidang_usaha') ? '' : 'hidden' }}" data-error-for="bidang_usaha">{{ $errors->first('bidang_usaha') }}</p>
                        </div>
                    </div>

                    <div>
                        <label for="alamat" class="mb-2 block text-sm font-medium text-slate-700">Alamat</label>
                        <textarea
                            id="alamat"
                            name="alamat"
                            rows="2"
                            placeholder="Alamat"
                            data-required="Alamat wajib diisi."
                            class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">{{ old('alamat', $editingRantaiPasok?->alamat) }}</textarea>
                        <p class="mt-1 text-xs text-rose-500 {{ $errors->has('alamat') ? '' : 'hidden' }}" data-error-for="alamat">{{ $errors->first('alamat') }}</p>
                    </div>
                    <div class="grid grid-cols-1 gap-3 lg:grid-cols-2">
                        <div>
                            <label for="provinsi" class="mb-2 block text-sm font-medium text-slate-700">Provinsi</label>
                            <select
                                id="provinsi"
                                name="provinsi"
                                data-required="Provinsi wajib dipilih."
                                data-selected="{{ old('provinsi', $editingRantaiPasok?->provinsi ?? 'Kalimantan Timur') }}"
                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">
                                <option value="">Pilih...</option>
                            </select>
                            <p class="mt-1 text-xs text-rose-500 {{ $errors->has('provinsi') ? '' : 'hidden' }}" data-error-for="provinsi">{{ $errors->first('provinsi') }}</p>
                        </div>

                        <div>
                            <label for="kabupaten" class="mb-2 block text-sm font-medium text-slate-700">Kabupaten/Kota</label>
                            <select
                                id="kabupaten"
                                name="kabupaten"
                                data-required="Kabupaten/Kota wajib dipilih."
                                data-selected="{{ old('kabupaten', $editingRantaiPasok?->kabupaten) }}"
                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">
                                <option value="">Pilih provinsi dulu...</option>
                            </select>
                            <p class="mt-1 text-xs text-rose-500 {{ $errors->has('kabupaten') ? '' : 'hidden' }}" data-error-for="kabupaten">{{ $errors->first('kabupaten') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-3 lg:grid-cols-3">
                        <div>
                            <label for="kontak" class="mb-2 block text-sm font-medium text-slate-700">Kontak</label>
                            <input
                                id="kontak"
                                type="text"
                                name="kontak"
                                value="{{ old('kontak', $editingRantaiPasok?->kontak) }}"
                                placeholder="Nomor kontak"
                                inputmode="numeric"
                                pattern="[0-9]*"
                                maxlength="20"
                                data-required="Kontak wajib diisi."
                                data-number-only="Kontak hanya boleh diisi angka."
                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10" />
                            <p class="mt-1 text-xs text-rose-500 {{ $errors->has('kontak') ? '' : 'hidden' }}" data-error-for="kontak">{{ $errors->first('kontak') }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-200 pt-4">
                        <button type="button" data-modal-close class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                            Batal
                        </button>

                        <button type="submit" class="rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500">
                            {{ $isEditing ? 'Update Data' : 'Simpan Data' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="delete-confirm-modal" data-modal-wrapper="delete" class="pointer-events-none fixed inset-0 z-[80] hidden p-4 opacity-0 transition duration-200">
    <div data-modal-backdrop class="absolute inset-0 bg-slate-950/75 backdrop-blur-sm opacity-0 transition duration-200"></div>

    <div class="relative z-10 flex min-h-full items-center justify-center">
        <div data-modal-panel class="w-full max-w-md translate-y-4 scale-[0.98] rounded-3xl bg-white opacity-0 shadow-2xl transition duration-200 ease-out">
            <div class="px-5 py-5">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-rose-100 text-rose-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16" />
                        </svg>
                    </div>

                    <div class="min-w-0 flex-1">
                        <h3 id="delete-modal-title" class="text-lg font-bold text-slate-900">Hapus data Rantai Pasok?</h3>
                        <p id="delete-modal-text" class="mt-1 text-sm leading-6 text-slate-500">Data ini akan dihapus.</p>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-2">
                    <button type="button" data-modal-close class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                        Batal
                    </button>

                    <button type="button" id="confirm-delete-button" class="rounded-xl bg-rose-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-rose-500">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="rantai-script-data" class="hidden" data-initial-panel="{{ $initialPanel }}"></div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const body = document.body;
        const scriptData = document.getElementById('rantai-script-data');
        if (!scriptData) return;

        const modalElements = {
            upload: document.getElementById('upload-modal'),
            manual: document.getElementById('manual-modal'),
            delete: document.getElementById('delete-confirm-modal'),
        };

        const tableContainer = document.getElementById('rantai-table-container');
        const openButtons = document.querySelectorAll('[data-modal-open]');
        const toastCloseButtons = document.querySelectorAll('[data-toast-close]');
        const importForm = document.getElementById('rantai-import-form');
        const manualForm = document.getElementById('rantai-manual-form');

        const filterForm = document.getElementById('rantai-filter-form');
        const searchInput = document.getElementById('search');
        const bidangSelect = document.getElementById('filter_bidang_usaha');
        const filterKabupatenSelect = document.getElementById('filter_kabupaten');
        const perPageSelect = document.getElementById('per_page');

        const confirmDeleteButton = document.getElementById('confirm-delete-button');
        const deleteModalTitle = document.getElementById('delete-modal-title');
        const deleteModalText = document.getElementById('delete-modal-text');
        const bulkDeleteForm = document.getElementById('bulk-delete-form');
        const bulkDeleteInputs = document.getElementById('bulk-delete-inputs');
        const deleteAllForm = document.getElementById('delete-all-form');

        const initialPanel = scriptData.dataset.initialPanel || 'closed';
        const provinceSelect = document.getElementById('provinsi');
        const regencySelect = document.getElementById('kabupaten');

        const provinceUrl = "{{ route('admin.bujk.regions.provinces') }}";
        const regencyUrl = "{{ route('admin.bujk.regions.regencies') }}";

        const selectedProvince = String(provinceSelect?.dataset.selected || '').trim();
        const selectedRegency = String(regencySelect?.dataset.selected || '').trim();

        const normalizeText = (value = '') => {
            return String(value).trim().replace(/\s+/g, ' ').toUpperCase();
        };

        const createRegionOption = (value, text, selected = false, code = '') => {
            const option = document.createElement('option');

            option.value = value;
            option.textContent = text;
            option.selected = selected;

            if (code) {
                option.dataset.code = code;
            }

            return option;
        };

        const resetRegencySelect = (placeholder = 'Pilih provinsi dulu...') => {
            if (!regencySelect) return;

            regencySelect.innerHTML = '';
            regencySelect.appendChild(createRegionOption('', placeholder, true));
            regencySelect.disabled = true;
        };

        const extractRegionItems = (payload) => {
            if (Array.isArray(payload)) {
                return payload;
            }

            if (Array.isArray(payload.data)) {
                return payload.data;
            }

            if (Array.isArray(payload.results)) {
                return payload.results;
            }

            if (Array.isArray(payload.items)) {
                return payload.items;
            }

            return [];
        };

        const getRegionLabel = (item) => {
            if (typeof item === 'string') {
                return item;
            }

            return item.label ||
                item.value ||
                item.name ||
                item.nama ||
                item.province_name ||
                item.regency_name ||
                item.provinsi ||
                item.kabupaten ||
                item.kota ||
                '';
        };

        const getRegionValue = (item) => {
            if (typeof item === 'string') {
                return item;
            }

            return item.value ||
                item.label ||
                item.name ||
                item.nama ||
                item.province_name ||
                item.regency_name ||
                item.provinsi ||
                item.kabupaten ||
                item.kota ||
                '';
        };

        const getRegionCode = (item) => {
            if (typeof item === 'string') {
                return '';
            }

            return item.code ||
                item.kode ||
                item.id ||
                item.province_code ||
                item.regency_code ||
                '';
        };

        const fetchRegionJson = async (url) => {
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            });

            let payload = {};

            try {
                payload = await response.json();
            } catch (error) {
                payload = {};
            }

            if (!response.ok) {
                throw new Error(payload.message || 'Gagal memuat data wilayah.');
            }

            return payload;
        };

        const renderProvinceOptions = (items) => {
            if (!provinceSelect) return;

            provinceSelect.innerHTML = '';
            provinceSelect.appendChild(createRegionOption('', 'Pilih...'));

            let matched = false;

            items.forEach((item) => {
                const label = getRegionLabel(item);
                const value = getRegionValue(item);
                const code = getRegionCode(item);

                if (!label || !value) return;

                const normalizedValue = normalizeText(value);
                const normalizedSelected = normalizeText(selectedProvince);

                const isSelected = normalizedSelected !== '' && (
                    normalizedSelected === normalizedValue ||
                    normalizedSelected === normalizeText(label) ||
                    normalizedSelected === normalizeText(code)
                );

                if (isSelected) {
                    matched = true;
                }

                provinceSelect.appendChild(
                    createRegionOption(value, label, isSelected, code)
                );
            });

            if (selectedProvince && !matched) {
                provinceSelect.appendChild(
                    createRegionOption(selectedProvince, selectedProvince, true)
                );
            }
        };

        const renderRegencyOptions = (items, selectedValue = '') => {
            if (!regencySelect) return;

            regencySelect.innerHTML = '';
            regencySelect.appendChild(createRegionOption('', 'Pilih...'));

            let matched = false;

            items.forEach((item) => {
                const label = getRegionLabel(item);
                const value = getRegionValue(item);
                const code = getRegionCode(item);

                if (!label || !value) return;

                const normalizedValue = normalizeText(value);
                const normalizedSelected = normalizeText(selectedValue);

                const isSelected = normalizedSelected !== '' && (
                    normalizedSelected === normalizedValue ||
                    normalizedSelected === normalizeText(label) ||
                    normalizedSelected === normalizeText(code)
                );

                if (isSelected) {
                    matched = true;
                }

                regencySelect.appendChild(
                    createRegionOption(value, label, isSelected, code)
                );
            });

            if (selectedValue && !matched) {
                regencySelect.appendChild(
                    createRegionOption(selectedValue, selectedValue, true)
                );
            }

            regencySelect.disabled = false;
        };

        const getSelectedProvinceCode = () => {
            if (!provinceSelect) return '';

            const selectedOption = provinceSelect.selectedOptions[0];

            return selectedOption?.dataset?.code || '';
        };

        const loadRegencies = async (selectedValue = '') => {
            if (!regencySelect || !provinceSelect) return;

            const provinceCode = getSelectedProvinceCode();

            if (!provinceCode) {
                resetRegencySelect('Pilih provinsi dulu...');
                return;
            }

            regencySelect.disabled = true;
            regencySelect.innerHTML = '';
            regencySelect.appendChild(createRegionOption('', 'Memuat kabupaten/kota...', true));

            try {
                const url = `${regencyUrl}?province_code=${encodeURIComponent(provinceCode)}`;
                const payload = await fetchRegionJson(url);
                const items = extractRegionItems(payload);

                if (!items.length) {
                    resetRegencySelect('Tidak ada data kabupaten/kota');
                    return;
                }

                renderRegencyOptions(items, selectedValue);
            } catch (error) {
                console.error(error);
                resetRegencySelect('Gagal memuat kabupaten/kota');
            }
        };

        const loadProvinces = async () => {
            if (!provinceSelect || !regencySelect) return;

            provinceSelect.disabled = true;
            provinceSelect.innerHTML = '';
            provinceSelect.appendChild(createRegionOption('', 'Memuat provinsi...', true));

            resetRegencySelect('Pilih provinsi dulu...');

            try {
                const payload = await fetchRegionJson(provinceUrl);
                const items = extractRegionItems(payload);

                renderProvinceOptions(items);
                provinceSelect.disabled = false;

                if (provinceSelect.value) {
                    await loadRegencies(selectedRegency);
                }
            } catch (error) {
                console.error(error);

                provinceSelect.innerHTML = '';
                provinceSelect.appendChild(createRegionOption('', 'Gagal memuat provinsi', true));
                provinceSelect.disabled = true;

                resetRegencySelect('Pilih provinsi dulu...');
            }
        };

        if (provinceSelect && regencySelect) {
            provinceSelect.addEventListener('change', function() {
                regencySelect.dataset.selected = '';
                loadRegencies('');
            });

            loadProvinces();
        }

        let deleteState = {
            mode: null,
            form: null,
            name: null,
            ids: []
        };
        let filterDebounce = null;
        let activeFilterController = null;

        const showFieldError = (field, message) => {
            if (!manualForm || !field) return;

            const error = manualForm.querySelector(`[data-error-for="${field.name}"]`);

            field.classList.remove('border-slate-300', 'focus:border-indigo-500', 'focus:ring-indigo-500/10');
            field.classList.add('border-rose-400', 'focus:border-rose-500', 'focus:ring-rose-500/10');

            if (error) {
                error.textContent = message;
                error.classList.remove('hidden');
            }
        };

        const clearFieldError = (field) => {
            if (!manualForm || !field) return;

            const error = manualForm.querySelector(`[data-error-for="${field.name}"]`);

            field.classList.remove('border-rose-400', 'focus:border-rose-500', 'focus:ring-rose-500/10');
            field.classList.add('border-slate-300', 'focus:border-indigo-500', 'focus:ring-indigo-500/10');

            if (error) {
                error.textContent = '';
                error.classList.add('hidden');
            }
        };

        const validateManualField = (field) => {
            if (!field) return true;

            const value = field.value.trim();

            if (field.dataset.required && value === '') {
                showFieldError(field, field.dataset.required);
                return false;
            }

            if (field.dataset.numberOnly && value !== '' && !/^[0-9]+$/.test(value)) {
                showFieldError(field, field.dataset.numberOnly);
                return false;
            }

            clearFieldError(field);
            return true;
        };

        const resetManualValidation = () => {
            if (!manualForm) return;

            manualForm.querySelectorAll('[data-required]').forEach((field) => {
                clearFieldError(field);
            });
        };

        if (manualForm) {
            const requiredFields = manualForm.querySelectorAll('[data-required]');

            requiredFields.forEach((field) => {
                field.addEventListener('input', function() {
                    if (field.dataset.numberOnly) {
                        field.value = field.value.replace(/[^0-9]/g, '');
                    }

                    if (field.value.trim() !== '') {
                        validateManualField(field);
                    }
                });

                field.addEventListener('blur', function() {
                    validateManualField(field);
                });

                field.addEventListener('change', function() {
                    validateManualField(field);
                });
            });

            manualForm.addEventListener('submit', function(event) {
                let isValid = true;

                requiredFields.forEach((field) => {
                    if (!validateManualField(field)) {
                        isValid = false;
                    }
                });

                if (!isValid) {
                    event.preventDefault();

                    const firstInvalid = manualForm.querySelector('.border-rose-400');
                    if (firstInvalid) {
                        firstInvalid.focus();
                    }
                }
            });
        }

        const resetImportForm = () => {
            if (!importForm) return;
            importForm.reset();

            const fileInput = importForm.querySelector('#file_import');
            if (fileInput) {
                fileInput.value = '';
                fileInput.setCustomValidity('');
            }
        };

        const hasOpenModal = () => Object.values(modalElements).some((modal) => modal && modal.dataset.state === 'open');

        const lockBody = () => {
            body.classList.toggle('overflow-hidden', hasOpenModal());
        };

        const updateQuery = (panelName = null) => {
            const url = new URL(window.location.href);

            if (panelName === 'upload' || panelName === 'manual') {
                url.searchParams.set('panel', panelName);
            } else {
                url.searchParams.delete('panel');
                url.searchParams.delete('edit');
            }

            window.history.replaceState({}, '', url.toString());
        };

        const showModal = (modal, panelName = null, writeQuery = true) => {
            if (!modal) return;

            modal.classList.remove('hidden');
            modal.dataset.state = 'open';

            requestAnimationFrame(() => {
                modal.classList.remove('pointer-events-none', 'opacity-0');
                modal.classList.add('pointer-events-auto', 'opacity-100');

                const backdrop = modal.querySelector('[data-modal-backdrop]');
                const panel = modal.querySelector('[data-modal-panel]');

                if (backdrop) {
                    backdrop.classList.remove('opacity-0');
                    backdrop.classList.add('opacity-100');
                }

                if (panel) {
                    panel.classList.remove('translate-y-4', 'scale-[0.98]', 'opacity-0');
                    panel.classList.add('translate-y-0', 'scale-100', 'opacity-100');
                }
            });

            lockBody();

            if (writeQuery && (panelName === 'upload' || panelName === 'manual')) {
                updateQuery(panelName);
            }
        };

        const hideModal = (modal, writeQuery = true) => {
            if (!modal) return;

            modal.dataset.state = 'closed';
            modal.classList.remove('pointer-events-auto', 'opacity-100');
            modal.classList.add('pointer-events-none', 'opacity-0');

            const backdrop = modal.querySelector('[data-modal-backdrop]');
            const panel = modal.querySelector('[data-modal-panel]');

            if (backdrop) {
                backdrop.classList.remove('opacity-100');
                backdrop.classList.add('opacity-0');
            }

            if (panel) {
                panel.classList.remove('translate-y-0', 'scale-100', 'opacity-100');
                panel.classList.add('translate-y-4', 'scale-[0.98]', 'opacity-0');
            }

            setTimeout(() => {
                if (modal.dataset.state !== 'open') {
                    modal.classList.add('hidden');
                }
                lockBody();
            }, 210);

            if (modal === modalElements.upload) {
                resetImportForm();
            }

            if (writeQuery && (modal === modalElements.upload || modal === modalElements.manual)) {
                updateQuery(null);
            }
        };

        const closeAllPrimaryModals = (writeQuery = true) => {
            hideModal(modalElements.upload, writeQuery);
            hideModal(modalElements.manual, writeQuery);
        };

        const submitHiddenForm = (form) => {
            if (!form) return;

            const hiddenSubmit = form.querySelector('[data-hidden-submit]');
            if (hiddenSubmit) {
                hiddenSubmit.click();
                return;
            }

            HTMLFormElement.prototype.submit.call(form);
        };

        const getRowCheckboxes = () => tableContainer ? Array.from(tableContainer.querySelectorAll('[data-row-checkbox]')) : [];
        const getSelectAllRows = () => tableContainer ? tableContainer.querySelector('#select-all-rows') : null;
        const getBulkDeleteTrigger = () => tableContainer ? tableContainer.querySelector('#bulk-delete-trigger') : null;

        const getSelectedIds = () => getRowCheckboxes()
            .filter((checkbox) => checkbox.checked)
            .map((checkbox) => checkbox.value);

        const updateBulkDeleteButton = (count) => {
            const bulkDeleteTrigger = getBulkDeleteTrigger();
            if (!bulkDeleteTrigger) return;

            if (count > 0) {
                bulkDeleteTrigger.disabled = false;
                bulkDeleteTrigger.classList.remove('cursor-not-allowed', 'text-rose-300');
                bulkDeleteTrigger.classList.add('border-rose-200', 'text-rose-600', 'hover:border-rose-300', 'hover:bg-rose-50');
                bulkDeleteTrigger.textContent = `Hapus Terpilih (${count})`;
            } else {
                bulkDeleteTrigger.disabled = true;
                bulkDeleteTrigger.classList.add('cursor-not-allowed', 'text-rose-300');
                bulkDeleteTrigger.classList.remove('text-rose-600', 'hover:border-rose-300', 'hover:bg-rose-50');
                bulkDeleteTrigger.textContent = 'Hapus Terpilih';
            }
        };

        const refreshSelectionState = () => {
            const rowCheckboxes = getRowCheckboxes();
            const selectAllRows = getSelectAllRows();
            const count = getSelectedIds().length;

            if (selectAllRows) {
                selectAllRows.checked = count > 0 && count === rowCheckboxes.length && rowCheckboxes.length > 0;
                selectAllRows.indeterminate = count > 0 && count < rowCheckboxes.length;
            }

            updateBulkDeleteButton(count);
        };

        const buildFilterUrl = (pageUrl = null) => {
            const url = pageUrl ?
                new URL(pageUrl, window.location.origin) :
                new URL(filterForm.action, window.location.origin);

            if (!pageUrl) {
                url.searchParams.delete('page');
            }

            const keyword = searchInput ? searchInput.value.trim() : '';
            const bidang = bidangSelect ? bidangSelect.value : '';
            const kabupaten = filterKabupatenSelect ? filterKabupatenSelect.value : '';
            const perPage = perPageSelect ? perPageSelect.value : '';

            keyword !== '' ? url.searchParams.set('search', keyword) : url.searchParams.delete('search');
            bidang !== '' ? url.searchParams.set('bidang_usaha', bidang) : url.searchParams.delete('bidang_usaha');
            kabupaten !== '' ? url.searchParams.set('kabupaten', kabupaten) : url.searchParams.delete('kabupaten');
            perPage !== '' ? url.searchParams.set('per_page', perPage) : url.searchParams.delete('per_page');

            return url;
        };

        const fetchFilteredTable = async (pageUrl = null) => {
            if (!filterForm || !tableContainer) return;

            const url = buildFilterUrl(pageUrl);

            if (activeFilterController) {
                activeFilterController.abort();
            }

            activeFilterController = new AbortController();

            try {
                const response = await fetch(url.toString(), {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    signal: activeFilterController.signal,
                });

                if (!response.ok) {
                    throw new Error('Gagal memuat data Rantai Pasok.');
                }

                const payload = await response.json();
                tableContainer.innerHTML = payload.html;
                refreshSelectionState();
                window.history.replaceState({}, '', url.toString());
            } catch (error) {
                if (error.name === 'AbortError') return;
                console.error(error);
                window.location.href = url.toString();
            }
        };

        const triggerRealtimeFilter = () => {
            clearTimeout(filterDebounce);
            filterDebounce = setTimeout(() => fetchFilteredTable(), 120);
        };

        if (searchInput) {
            searchInput.addEventListener('input', triggerRealtimeFilter);
            searchInput.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    clearTimeout(filterDebounce);
                    fetchFilteredTable();
                }
            });
        }

        [bidangSelect, filterKabupatenSelect, perPageSelect].forEach((element) => {
            if (!element) return;
            element.addEventListener('change', function() {
                clearTimeout(filterDebounce);
                fetchFilteredTable();
            });
        });

        if (filterForm) {
            filterForm.addEventListener('submit', function(event) {
                event.preventDefault();
                clearTimeout(filterDebounce);
                fetchFilteredTable();
            });
        }

        openButtons.forEach((button) => {
            button.addEventListener('click', function() {
                const target = this.dataset.modalOpen;

                if (target === 'upload') {
                    closeAllPrimaryModals(false);
                    resetImportForm();
                    showModal(modalElements.upload, 'upload', true);
                }

                if (target === 'manual') {
                    closeAllPrimaryModals(false);

                    @if(!$isEditing)
                    if (manualForm) {
                        manualForm.reset();
                        resetManualValidation();
                    }
                    @endif

                    showModal(modalElements.manual, 'manual', true);
                }
            });
        });

        Object.values(modalElements).forEach((modal) => {
            if (!modal) return;

            modal.dataset.state = 'closed';

            const backdrop = modal.querySelector('[data-modal-backdrop]');
            if (backdrop) {
                backdrop.addEventListener('click', () => hideModal(modal, true));
            }

            modal.querySelectorAll('[data-modal-close]').forEach((button) => {
                button.addEventListener('click', () => hideModal(modal, true));
            });
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                Object.values(modalElements).forEach((modal) => hideModal(modal, true));
            }
        });

        if (initialPanel === 'upload') {
            showModal(modalElements.upload, 'upload', false);
        } else if (initialPanel === 'manual') {
            showModal(modalElements.manual, 'manual', false);
        }

        const dismissToast = (toast) => {
            if (!toast) return;
            toast.classList.add('translate-y-2', 'opacity-0');
            setTimeout(() => toast.remove(), 300);
        };

        document.querySelectorAll('[data-toast]').forEach((toast, index) => {
            setTimeout(() => dismissToast(toast), 3200 + (index * 300));
        });

        toastCloseButtons.forEach((button) => {
            button.addEventListener('click', function() {
                dismissToast(this.closest('[data-toast]'));
            });
        });

        if (tableContainer) {
            tableContainer.addEventListener('change', function(event) {
                if (event.target.matches('#select-all-rows')) {
                    const checked = event.target.checked;
                    getRowCheckboxes().forEach((checkbox) => {
                        checkbox.checked = checked;
                    });
                    refreshSelectionState();
                }

                if (event.target.matches('[data-row-checkbox]')) {
                    refreshSelectionState();
                }
            });

            tableContainer.addEventListener('click', function(event) {
                const paginationLink = event.target.closest('.rantai-pagination a');
                if (paginationLink) {
                    event.preventDefault();
                    clearTimeout(filterDebounce);
                    fetchFilteredTable(paginationLink.href);
                    return;
                }

                const singleDeleteButton = event.target.closest('[data-delete-single]');
                if (singleDeleteButton) {
                    deleteState = {
                        mode: 'single',
                        form: singleDeleteButton.closest('form'),
                        name: singleDeleteButton.dataset.deleteName || 'data ini',
                        ids: [],
                    };

                    deleteModalTitle.textContent = 'Hapus data Rantai Pasok?';
                    deleteModalText.innerHTML = `Data <span class="font-semibold text-slate-700">${deleteState.name}</span> akan dihapus dari daftar aktif. Tindakan ini tidak bisa dibatalkan.`;
                    confirmDeleteButton.disabled = false;
                    confirmDeleteButton.textContent = 'Ya, Hapus';

                    showModal(modalElements.delete, null, false);
                    return;
                }

                const bulkDeleteTrigger = event.target.closest('#bulk-delete-trigger');
                if (bulkDeleteTrigger) {
                    const ids = getSelectedIds();
                    if (!ids.length) return;

                    deleteState = {
                        mode: 'bulk',
                        form: null,
                        name: null,
                        ids
                    };

                    deleteModalTitle.textContent = 'Hapus beberapa data Rantai Pasok?';
                    deleteModalText.innerHTML = `Sebanyak <span class="font-semibold text-slate-700">${ids.length} data</span> terpilih akan dihapus dari daftar aktif. Tindakan ini tidak bisa dibatalkan.`;
                    confirmDeleteButton.disabled = false;
                    confirmDeleteButton.textContent = 'Ya, Hapus';

                    showModal(modalElements.delete, null, false);
                    return;
                }

                const deleteAllTrigger = event.target.closest('#delete-all-trigger');
                if (deleteAllTrigger && !deleteAllTrigger.disabled) {
                    deleteState = {
                        mode: 'all',
                        form: null,
                        name: null,
                        ids: []
                    };

                    deleteModalTitle.textContent = 'Hapus semua data Rantai Pasok?';
                    deleteModalText.innerHTML = 'Semua <span class="font-semibold text-slate-700">data Rantai Pasok aktif</span> akan dihapus. Tindakan ini tidak bisa dibatalkan.';
                    confirmDeleteButton.disabled = false;
                    confirmDeleteButton.textContent = 'Ya, Hapus';

                    showModal(modalElements.delete, null, false);
                }
            });
        }

        if (confirmDeleteButton) {
            confirmDeleteButton.addEventListener('click', function() {
                this.disabled = true;
                this.textContent = 'Memproses...';

                if (deleteState.mode === 'single' && deleteState.form) {
                    submitHiddenForm(deleteState.form);
                    return;
                }

                if (deleteState.mode === 'bulk') {
                    bulkDeleteInputs.innerHTML = '';

                    deleteState.ids.forEach((id) => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'ids[]';
                        input.value = id;
                        bulkDeleteInputs.appendChild(input);
                    });

                    submitHiddenForm(bulkDeleteForm);
                    return;
                }

                if (deleteState.mode === 'all') {
                    submitHiddenForm(deleteAllForm);
                }
            });
        }

        refreshSelectionState();
    });
</script>
@endpush