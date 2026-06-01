@extends('layouts.admin')

@section('page-title', 'Data Pemanfaat Produk Jasa Konstruksi')
@section('page-subtitle', 'Kelola data pemanfaat produk jasa konstruksi di Kalimantan Timur.')

@section('content')
@php
    $isEditing = $editingPemanfaatProduk !== null;

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
            <span class="font-medium text-slate-700">Pemanfaat Produk</span>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900">Tabel Data Pemanfaat Produk</h3>
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

        <form id="pemanfaat-filter-form" method="GET" action="{{ route('admin.pemanfaat-produk') }}" class="mt-8 grid grid-cols-1 gap-3 text-xs md:grid-cols-2 xl:grid-cols-4">
            <div class="xl:col-span-2">
                <label for="search" class="mb-2 block text-xs font-semibold text-slate-600">Filter / keyword</label>
                <input
                    id="search"
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Cari nama bangunan, lokasi, atau pengelola"
                    autocomplete="off"
                    class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-xs text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10" />
            </div>

            <div>
                <label for="filter_tahun_anggaran" class="mb-2 block text-xs font-semibold text-slate-600">Tahun Anggaran</label>
                <select
                    id="filter_tahun_anggaran"
                    name="tahun_anggaran"
                    class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-xs text-slate-800 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">
                    <option value="">Semua tahun</option>
                    @foreach($tahunOptions as $tahun)
                        <option value="{{ $tahun }}" @selected((string) $tahunFilter === (string) $tahun)>{{ $tahun }}</option>
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
                        <option value="{{ $size }}" @selected($perPage === $size)>{{ $size }}</option>
                    @endforeach
                </select>
            </div>
        </form>

        <div id="pemanfaat-table-container">
            @include('admin.pemanfaat-produk.partials.table', [
                'pemanfaatProduks' => $pemanfaatProduks,
                'search' => $search,
                'tahunFilter' => $tahunFilter,
                'perPage' => $perPage,
            ])
        </div>
    </div>
</div>

<div class="absolute left-[-9999px] top-auto h-0 w-0 overflow-hidden opacity-0" aria-hidden="true">
    <form id="bulk-delete-form" action="{{ route('admin.pemanfaat-produk.bulk-destroy') }}" method="POST">
        @csrf
        @method('DELETE')
        <div id="bulk-delete-inputs"></div>
        <button type="submit" data-hidden-submit>submit</button>
    </form>

    <form id="delete-all-form" action="{{ route('admin.pemanfaat-produk.destroy-all') }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" data-hidden-submit>submit</button>
    </form>
</div>

{{-- Upload Modal --}}
<div id="upload-modal" data-modal-wrapper="upload" class="pointer-events-none fixed inset-0 z-[70] hidden p-4 opacity-0 transition duration-200">
    <div data-modal-backdrop class="absolute inset-0 bg-slate-950/70 backdrop-blur-sm opacity-0 transition duration-200"></div>

    <div class="relative z-10 flex min-h-full items-center justify-center">
        <div data-modal-panel class="w-full max-w-3xl translate-y-4 scale-[0.98] rounded-3xl bg-white opacity-0 shadow-2xl transition duration-200 ease-out">
            <div class="flex items-start justify-between gap-4 border-b border-slate-200 px-5 py-4">
                <div>
                    <h3 class="text-xl font-bold text-slate-900">Import CSV / XLSX</h3>
                    <p class="mt-1 text-sm text-slate-500">Upload file Pemanfaat Produk melalui template CSV atau XLSX.</p>
                </div>

                <button type="button" data-modal-close class="inline-flex h-9 w-9 items-center justify-center rounded-full text-slate-500 transition hover:bg-slate-100 hover:text-slate-700">
                    ✕
                </button>
            </div>

            <div class="px-5 py-4">
                <form id="pemanfaat-import-form" action="{{ route('admin.pemanfaat-produk.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
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
                        <p>1. File yang didukung: CSV dan XLSX.</p>
                        <p>2. Header yang didukung: nama_bangunan, pengelola_pemilik_bangunan, lokasi, nama_pengelola_pemilik, tahun_anggaran, kontak.</p>
                        <p>3. Data dengan nama bangunan dan lokasi sama akan di-update, bukan ditambahkan duplikat baru.</p>
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

{{-- Manual Modal --}}
<div id="manual-modal" data-modal-wrapper="manual" class="pointer-events-none fixed inset-0 z-[70] hidden p-4 opacity-0 transition duration-200">
    <div data-modal-backdrop class="absolute inset-0 bg-slate-950/70 backdrop-blur-sm opacity-0 transition duration-200"></div>

    <div class="relative z-10 flex min-h-full items-center justify-center">
        <div data-modal-panel class="w-full max-w-5xl translate-y-4 scale-[0.98] rounded-3xl bg-white opacity-0 shadow-2xl transition duration-200 ease-out">
            <div class="flex items-start justify-between gap-4 border-b border-slate-200 px-5 py-4">
                <div>
                    <h3 class="text-xl font-bold text-slate-900">
                        {{ $isEditing ? 'Ubah Data Pemanfaat Produk' : 'Form Pemanfaat Produk' }}
                    </h3>
                    <p class="mt-1 text-sm text-slate-500">
                        Isi data pemanfaat produk secara manual melalui form berikut.
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    @if($isEditing)
                        <a href="{{ route('admin.pemanfaat-produk') }}" class="rounded-xl border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                            Reset
                        </a>
                    @endif

                    <button type="button" data-modal-close class="inline-flex h-9 w-9 items-center justify-center rounded-full text-slate-500 transition hover:bg-slate-100 hover:text-slate-700">
                        ✕
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
                    id="pemanfaat-manual-form"
                    action="{{ $isEditing ? route('admin.pemanfaat-produk.update', $editingPemanfaatProduk) : route('admin.pemanfaat-produk.store') }}"
                    method="POST"
                    class="space-y-3"
                    novalidate>
                    @csrf
                    @if($isEditing)
                        @method('PUT')
                    @endif

                    <div class="grid grid-cols-1 gap-3 lg:grid-cols-2">
                        <div>
                            <label for="nama_bangunan" class="mb-2 block text-sm font-medium text-slate-700">Nama Bangunan</label>
                            <input
                                id="nama_bangunan"
                                type="text"
                                name="nama_bangunan"
                                value="{{ old('nama_bangunan', $editingPemanfaatProduk?->nama_bangunan) }}"
                                placeholder="Nama bangunan"
                                data-required="Nama bangunan wajib diisi."
                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">
                            <p class="mt-1 text-xs text-rose-500 {{ $errors->has('nama_bangunan') ? '' : 'hidden' }}" data-error-for="nama_bangunan">{{ $errors->first('nama_bangunan') }}</p>
                        </div>

                        <div>
                            <label for="pengelola_pemilik_bangunan" class="mb-2 block text-sm font-medium text-slate-700">Pengelola/Pemilik Bangunan</label>
                            <input
                                id="pengelola_pemilik_bangunan"
                                type="text"
                                name="pengelola_pemilik_bangunan"
                                value="{{ old('pengelola_pemilik_bangunan', $editingPemanfaatProduk?->pengelola_pemilik_bangunan) }}"
                                placeholder="Pengelola/Pemilik bangunan"
                                data-required="Pengelola/Pemilik bangunan wajib diisi."
                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">
                            <p class="mt-1 text-xs text-rose-500 {{ $errors->has('pengelola_pemilik_bangunan') ? '' : 'hidden' }}" data-error-for="pengelola_pemilik_bangunan">{{ $errors->first('pengelola_pemilik_bangunan') }}</p>
                        </div>
                    </div>

                    <div>
                        <label for="lokasi" class="mb-2 block text-sm font-medium text-slate-700">Lokasi</label>
                        <textarea
                            id="lokasi"
                            name="lokasi"
                            rows="2"
                            placeholder="Lokasi"
                            data-required="Lokasi wajib diisi."
                            class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">{{ old('lokasi', $editingPemanfaatProduk?->lokasi) }}</textarea>
                        <p class="mt-1 text-xs text-rose-500 {{ $errors->has('lokasi') ? '' : 'hidden' }}" data-error-for="lokasi">{{ $errors->first('lokasi') }}</p>
                    </div>

                    <div class="grid grid-cols-1 gap-3 lg:grid-cols-3">
                        <div>
                            <label for="nama_pengelola_pemilik" class="mb-2 block text-sm font-medium text-slate-700">Nama Pengelola/Pemilik</label>
                            <input
                                id="nama_pengelola_pemilik"
                                type="text"
                                name="nama_pengelola_pemilik"
                                value="{{ old('nama_pengelola_pemilik', $editingPemanfaatProduk?->nama_pengelola_pemilik) }}"
                                placeholder="Nama pengelola/pemilik"
                                data-required="Nama pengelola/pemilik wajib diisi."
                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">
                            <p class="mt-1 text-xs text-rose-500 {{ $errors->has('nama_pengelola_pemilik') ? '' : 'hidden' }}" data-error-for="nama_pengelola_pemilik">{{ $errors->first('nama_pengelola_pemilik') }}</p>
                        </div>

                        <div>
                            <label for="tahun_anggaran" class="mb-2 block text-sm font-medium text-slate-700">Tahun Anggaran</label>
                            <input
                                id="tahun_anggaran"
                                type="text"
                                name="tahun_anggaran"
                                value="{{ old('tahun_anggaran', $editingPemanfaatProduk?->tahun_anggaran) }}"
                                placeholder="Contoh: 2026"
                                inputmode="numeric"
                                maxlength="4"
                                data-required="Tahun anggaran wajib diisi."
                                data-year-only="Tahun anggaran harus 4 digit angka."
                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">
                            <p class="mt-1 text-xs text-rose-500 {{ $errors->has('tahun_anggaran') ? '' : 'hidden' }}" data-error-for="tahun_anggaran">{{ $errors->first('tahun_anggaran') }}</p>
                        </div>

                        <div>
                            <label for="kontak" class="mb-2 block text-sm font-medium text-slate-700">Kontak</label>
                            <input
                                id="kontak"
                                type="text"
                                name="kontak"
                                value="{{ old('kontak', $editingPemanfaatProduk?->kontak) }}"
                                placeholder="Nomor kontak"
                                inputmode="numeric"
                                maxlength="20"
                                data-required="Kontak wajib diisi."
                                data-number-only="Kontak hanya boleh diisi angka."
                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">
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

{{-- Delete Modal --}}
<div id="delete-confirm-modal" data-modal-wrapper="delete" class="pointer-events-none fixed inset-0 z-[80] hidden p-4 opacity-0 transition duration-200">
    <div data-modal-backdrop class="absolute inset-0 bg-slate-950/75 backdrop-blur-sm opacity-0 transition duration-200"></div>

    <div class="relative z-10 flex min-h-full items-center justify-center">
        <div data-modal-panel class="w-full max-w-md translate-y-4 scale-[0.98] rounded-3xl bg-white opacity-0 shadow-2xl transition duration-200 ease-out">
            <div class="px-5 py-5">
                <h3 id="delete-modal-title" class="text-lg font-bold text-slate-900">Hapus data Pemanfaat Produk?</h3>
                <p id="delete-modal-text" class="mt-2 text-sm leading-6 text-slate-500">Data ini akan dihapus.</p>

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

<div id="pemanfaat-script-data" class="hidden" data-initial-panel="{{ $initialPanel }}"></div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const body = document.body;
    const scriptData = document.getElementById('pemanfaat-script-data');
    if (!scriptData) return;

    const modalElements = {
        upload: document.getElementById('upload-modal'),
        manual: document.getElementById('manual-modal'),
        delete: document.getElementById('delete-confirm-modal'),
    };

    const tableContainer = document.getElementById('pemanfaat-table-container');
    const openButtons = document.querySelectorAll('[data-modal-open]');
    const toastCloseButtons = document.querySelectorAll('[data-toast-close]');
    const importForm = document.getElementById('pemanfaat-import-form');
    const manualForm = document.getElementById('pemanfaat-manual-form');

    const filterForm = document.getElementById('pemanfaat-filter-form');
    const searchInput = document.getElementById('search');
    const tahunSelect = document.getElementById('filter_tahun_anggaran');
    const perPageSelect = document.getElementById('per_page');

    const confirmDeleteButton = document.getElementById('confirm-delete-button');
    const deleteModalTitle = document.getElementById('delete-modal-title');
    const deleteModalText = document.getElementById('delete-modal-text');
    const bulkDeleteForm = document.getElementById('bulk-delete-form');
    const bulkDeleteInputs = document.getElementById('bulk-delete-inputs');
    const deleteAllForm = document.getElementById('delete-all-form');

    const initialPanel = scriptData.dataset.initialPanel || 'closed';

    let deleteState = { mode: null, form: null, name: null, ids: [] };
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

        let value = field.value.trim();

        if (field.dataset.numberOnly) {
            field.value = field.value.replace(/[^0-9]/g, '');
            value = field.value.trim();
        }

        if (field.dataset.yearOnly) {
            field.value = field.value.replace(/[^0-9]/g, '').slice(0, 4);
            value = field.value.trim();
        }

        if (field.dataset.required && value === '') {
            showFieldError(field, field.dataset.required);
            return false;
        }

        if (field.dataset.numberOnly && value !== '' && !/^[0-9]+$/.test(value)) {
            showFieldError(field, field.dataset.numberOnly);
            return false;
        }

        if (field.dataset.yearOnly && value !== '' && !/^[0-9]{4}$/.test(value)) {
            showFieldError(field, field.dataset.yearOnly);
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
            field.addEventListener('input', function () {
                validateManualField(field);
            });

            field.addEventListener('blur', function () {
                validateManualField(field);
            });

            field.addEventListener('change', function () {
                validateManualField(field);
            });
        });

        manualForm.addEventListener('submit', function (event) {
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
        const url = pageUrl
            ? new URL(pageUrl, window.location.origin)
            : new URL(filterForm.action, window.location.origin);

        if (!pageUrl) {
            url.searchParams.delete('page');
        }

        const keyword = searchInput ? searchInput.value.trim() : '';
        const tahun = tahunSelect ? tahunSelect.value : '';
        const perPage = perPageSelect ? perPageSelect.value : '';

        keyword !== '' ? url.searchParams.set('search', keyword) : url.searchParams.delete('search');
        tahun !== '' ? url.searchParams.set('tahun_anggaran', tahun) : url.searchParams.delete('tahun_anggaran');
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
                throw new Error('Gagal memuat data Pemanfaat Produk.');
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
        searchInput.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                clearTimeout(filterDebounce);
                fetchFilteredTable();
            }
        });
    }

    [tahunSelect, perPageSelect].forEach((element) => {
        if (!element) return;
        element.addEventListener('change', function () {
            clearTimeout(filterDebounce);
            fetchFilteredTable();
        });
    });

    if (filterForm) {
        filterForm.addEventListener('submit', function (event) {
            event.preventDefault();
            clearTimeout(filterDebounce);
            fetchFilteredTable();
        });
    }

    openButtons.forEach((button) => {
        button.addEventListener('click', function () {
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

    document.addEventListener('keydown', function (event) {
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
        button.addEventListener('click', function () {
            dismissToast(this.closest('[data-toast]'));
        });
    });

    if (tableContainer) {
        tableContainer.addEventListener('change', function (event) {
            if (event.target.matches('#select-all-rows')) {
                const checked = event.target.checked;
                getRowCheckboxes().forEach((checkbox) => checkbox.checked = checked);
                refreshSelectionState();
            }

            if (event.target.matches('[data-row-checkbox]')) {
                refreshSelectionState();
            }
        });

        tableContainer.addEventListener('click', function (event) {
            const paginationLink = event.target.closest('.pemanfaat-pagination a');
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

                deleteModalTitle.textContent = 'Hapus data Pemanfaat Produk?';
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

                deleteState = { mode: 'bulk', form: null, name: null, ids };

                deleteModalTitle.textContent = 'Hapus beberapa data Pemanfaat Produk?';
                deleteModalText.innerHTML = `Sebanyak <span class="font-semibold text-slate-700">${ids.length} data</span> terpilih akan dihapus dari daftar aktif.`;
                confirmDeleteButton.disabled = false;
                confirmDeleteButton.textContent = 'Ya, Hapus';

                showModal(modalElements.delete, null, false);
                return;
            }

            const deleteAllTrigger = event.target.closest('#delete-all-trigger');
            if (deleteAllTrigger && !deleteAllTrigger.disabled) {
                deleteState = { mode: 'all', form: null, name: null, ids: [] };

                deleteModalTitle.textContent = 'Hapus semua data Pemanfaat Produk?';
                deleteModalText.innerHTML = 'Semua <span class="font-semibold text-slate-700">data Pemanfaat Produk aktif</span> akan dihapus.';
                confirmDeleteButton.disabled = false;
                confirmDeleteButton.textContent = 'Ya, Hapus';

                showModal(modalElements.delete, null, false);
            }
        });
    }

    if (confirmDeleteButton) {
        confirmDeleteButton.addEventListener('click', function () {
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