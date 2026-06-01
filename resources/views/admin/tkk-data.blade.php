@extends('layouts.admin')

@section('page-title', 'Tenaga Kerja Konstruksi')
@section('page-subtitle', 'Data Tenaga Kerja Konstruksi Provinsi Kalimantan Timur')

@section('content')
@php
    $editingTkk = $editingTkk ?? null;
    $kabupatenOptions = $kabupatenOptions ?? [];
    $latestDataDate = $latestDataDate ?? null;

    $isEditing = $editingTkk !== null;
    $requestedPanel = request('panel');

    $latestDataDateLabel = null;

    if (!blank($latestDataDate)) {
        try {
            $latestDataDateLabel = \Illuminate\Support\Carbon::parse($latestDataDate)
                ->locale('id')
                ->translatedFormat('d F Y');
        } catch (\Throwable $exception) {
            $latestDataDateLabel = $latestDataDate;
        }
    }

    $hasUploadError = $errors->has('file_import') || $errors->has('tanggal_data_terbaru');
    $initialPanel = 'closed';

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
    } elseif ($errors->has('tanggal_data_terbaru')) {
        $toastMessages[] = ['type' => 'error', 'message' => $errors->first('tanggal_data_terbaru')];
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
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold">
                        {{ $toast['type'] === 'success' ? 'Berhasil' : 'Gagal' }}
                    </p>
                    <p class="mt-1 text-sm leading-5 text-white/95">
                        {{ $toast['message'] }}
                    </p>
                </div>

                <button type="button" data-toast-close class="rounded-lg p-1 text-white/80 hover:bg-white/10">
                    ✕
                </button>
            </div>
        </div>
    @endforeach
</div>

<div class="sibikon-card overflow-hidden rounded-[24px] border border-slate-200 bg-white">
    <div class="border-b border-slate-100 bg-gradient-to-r from-slate-50 to-blue-50/60 px-6 py-4">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h3 class="text-lg font-extrabold text-slate-900">Data Tenaga Kerja Konstruksi</h3>

                @if($latestDataDateLabel)
                    <div class="mt-3 flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center rounded-full border border-indigo-100 bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700">
                            Data terbaru per {{ $latestDataDateLabel }}
                        </span>
                    </div>
                @endif
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
    </div>

    <form
        id="tkk-filter-form"
        method="GET"
        action="{{ route('admin.tenaga-kerja-konstruksi') }}"
        class="flex flex-col gap-3 border-b border-slate-100 bg-white p-4 md:flex-row">

        <div class="flex-1">
            <input
                type="text"
                id="searchInput"
                placeholder="Cari data tenaga kerja..."
                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-[13px] text-slate-700 outline-none transition focus:border-[#3A4FAC] focus:bg-white focus:ring-4 focus:ring-[#3A4FAC]/10">
        </div>

        <div class="md:w-[240px]">
            <select
                id="searchCategory"
                class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-[13px] font-semibold text-slate-700 outline-none transition focus:border-[#3A4FAC] focus:ring-4 focus:ring-[#3A4FAC]/10">
                <option value="nama">Cari Berdasarkan Nama</option>
                <option value="kabupaten">Cari Berdasarkan Kabupaten</option>
                <option value="jabatan">Cari Berdasarkan Jabatan</option>
            </select>
        </div>
    </form>

    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 bg-white px-4 py-3">
        <div>
            <label class="inline-flex items-center gap-3 text-xs font-medium text-slate-700">
                <input
                    type="checkbox"
                    id="select-all-rows"
                    class="h-4 w-4 rounded border-slate-300 bg-white text-indigo-600 focus:ring-indigo-500">
                <span>Pilih semua data TKK di seluruh halaman</span>
            </label>

            <p id="select-all-info" class="mt-1 hidden text-xs font-semibold text-indigo-600">
                Semua data TKK di seluruh halaman dipilih.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <button
                type="button"
                id="bulk-delete-trigger"
                disabled
                class="cursor-not-allowed rounded-xl border border-rose-200 bg-white px-4 py-2 text-xs font-semibold text-rose-300 transition">
                Hapus Terpilih
            </button>

            <button
                type="button"
                id="delete-all-trigger"
                {{ ($totalTkk ?? 0) < 1 ? 'disabled' : '' }}
                class="{{ ($totalTkk ?? 0) < 1
                    ? 'cursor-not-allowed border border-rose-100 bg-white text-rose-300/60'
                    : 'border border-rose-200 bg-white text-rose-600 hover:border-rose-300 hover:bg-rose-50' }} rounded-xl px-4 py-2 text-xs font-semibold transition">
                Hapus Semua
            </button>
        </div>
    </div>

    <div class="overflow-x-auto min-h-[440px]">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50">
                <tr>
                    <th class="w-12 px-4 py-2"></th>
                    <th class="px-4 py-2 text-left text-[11px] font-extrabold uppercase tracking-[0.08em] text-slate-500">Nama</th>
                    <th class="px-4 py-2 text-left text-[11px] font-extrabold uppercase tracking-[0.08em] text-slate-500">Kabupaten</th>
                    <th class="px-4 py-2 text-left text-[11px] font-extrabold uppercase tracking-[0.08em] text-slate-500">Jabatan Kerja</th>
                    <th class="px-4 py-2 text-center text-[11px] font-extrabold uppercase tracking-[0.08em] text-slate-500">Jenjang</th>
                    <th class="px-4 py-2 text-center text-[11px] font-extrabold uppercase tracking-[0.08em] text-slate-500">Status</th>
                    <th class="px-4 py-2 text-center text-[11px] font-extrabold uppercase tracking-[0.08em] text-slate-500">Aksi</th>
                </tr>
            </thead>

            <tbody id="tkkTableBody" class="divide-y divide-slate-100 bg-white">
                @forelse ($tkkRows as $row)
                    @php
                        $statusRaw = $row['status'] ?? '-';
                        $statusText = ucfirst(strtolower($statusRaw));
                    @endphp

                    <tr class="transition hover:bg-blue-50/30">
                        <td class="px-4 py-2">
                            <input
                                type="checkbox"
                                value="{{ $row['id'] }}"
                                data-row-checkbox
                                class="h-4 w-4 rounded border-slate-300 bg-white text-indigo-600 focus:ring-indigo-500">
                        </td>

                        <td class="whitespace-nowrap px-4 py-2 text-[13px] font-semibold text-slate-700">
                            {{ $row['nama'] }}
                        </td>

                        <td class="whitespace-nowrap px-4 py-2 text-[13px] text-slate-600">
                            {{ $row['kabupaten'] ?? '-' }}
                        </td>

                        <td class="min-w-[260px] px-4 py-2 text-[13px] text-slate-600">
                            {{ $row['jabatan'] ?? '-' }}
                        </td>

                        <td class="whitespace-nowrap px-4 py-2 text-center text-[13px] font-extrabold text-[#142B67]">
                            {{ $row['jenjang'] ?? '-' }}
                        </td>

                        <td class="whitespace-nowrap px-4 py-2 text-center">
                            <span class="inline-flex rounded-full px-2.5 py-0.5 text-[11px] font-bold tracking-[0.06em]
                                {{ strtolower($statusRaw) === 'aktif'
                                    ? 'bg-emerald-100 text-emerald-700'
                                    : 'bg-red-100 text-red-700' }}">
                                {{ $statusText }}
                            </span>
                        </td>

                        <td class="px-4 py-2">
                            <div class="flex items-center justify-center gap-2">
                                <a
                                    href="{{ route('admin.tenaga-kerja-konstruksi', ['edit' => $row['id'], 'panel' => 'manual']) }}"
                                    class="rounded-xl border border-amber-200 bg-amber-50 px-3 py-2 text-[11px] font-semibold text-amber-700 transition hover:border-amber-300 hover:bg-amber-100">
                                    Edit
                                </a>

                                <form action="{{ route('admin.tenaga-kerja-konstruksi.destroy', $row['id']) }}" method="POST" class="single-delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="button"
                                        data-delete-single
                                        data-delete-name="{{ $row['nama'] }}"
                                        class="rounded-xl border border-rose-200 bg-white px-3 py-2 text-[11px] font-semibold text-rose-600 transition hover:border-rose-300 hover:bg-rose-50">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-xs text-slate-500">
                            Belum ada data TKK. Klik tombol tambah data atau upload file untuk mulai mengisi data.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex flex-col gap-3 border-t border-slate-100 bg-white px-6 py-4 text-sm sm:flex-row sm:items-center sm:justify-between">
        <p id="tableInfo" class="font-semibold text-slate-600">
            Hal:
            <span class="font-extrabold text-slate-900">
                1 - {{ min(10, $totalTkk ?? 0) }}
            </span>
            dari
            <span class="font-extrabold text-slate-900">
                {{ $totalTkk ?? 0 }}
            </span>
        </p>

        <div class="flex items-center gap-2">
            <button
                id="prevBtn"
                type="button"
                onclick="fetchSearchData(currentPage - 1)"
                class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-bold text-slate-600 transition hover:bg-slate-100 disabled:cursor-not-allowed disabled:opacity-40">
                Prev
            </button>

            <div id="paginationNumbers" class="flex items-center gap-1"></div>

            <button
                id="nextBtn"
                type="button"
                onclick="fetchSearchData(currentPage + 1)"
                class="rounded-xl border border-[#142B67] bg-[#142B67] px-3 py-2 text-sm font-bold text-white transition hover:bg-[#1d3b8f] disabled:cursor-not-allowed disabled:opacity-40">
                Next
            </button>
        </div>
    </div>
</div>

<div class="absolute left-[-9999px] top-auto h-0 w-0 overflow-hidden opacity-0" aria-hidden="true">
    <form id="bulk-delete-form" action="{{ route('admin.tenaga-kerja-konstruksi.bulk-destroy') }}" method="POST">
        @csrf
        @method('DELETE')
        <div id="bulk-delete-inputs"></div>
        <button type="submit" data-hidden-submit>submit</button>
    </form>

    <form id="delete-all-form" action="{{ route('admin.tenaga-kerja-konstruksi.destroy-all') }}" method="POST">
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
                    <h3 class="text-xl font-bold text-slate-900">Import Data TKK</h3>
                    <p class="mt-1 text-sm text-slate-500">
                        Upload file Excel atau CSV berisi data Tenaga Kerja Konstruksi.
                    </p>
                </div>

                <button type="button" data-modal-close class="h-9 w-9 rounded-full text-slate-500 hover:bg-slate-100">
                    ✕
                </button>
            </div>

            <div class="px-5 py-4">
                <form action="{{ route('admin.tenaga-kerja-konstruksi.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label for="file_import" class="mb-2 block text-sm font-medium text-slate-700">
                            File upload <span class="text-rose-500">*</span>
                        </label>

                        <input
                            id="file_import"
                            type="file"
                            name="file_import"
                            accept=".csv,.txt,.xlsx,.xls"
                            required
                            class="block w-full rounded-xl border border-slate-300 bg-white px-3 py-3 text-sm text-slate-700 file:mr-3 file:rounded-md file:border-0 file:bg-indigo-600 file:px-3 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-indigo-500">

                        @error('file_import')
                            <p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tanggal_data_terbaru" class="mb-2 block text-sm font-medium text-slate-700">
                            Tanggal data terbaru <span class="text-rose-500">*</span>
                        </label>

                        <input
                            id="tanggal_data_terbaru"
                            type="date"
                            name="tanggal_data_terbaru"
                            value="{{ old('tanggal_data_terbaru', $latestDataDate) }}"
                            required
                            class="w-full rounded-xl border border-slate-300 bg-white px-3 py-3 text-sm text-slate-800 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">

                        <p class="mt-2 text-xs leading-5 text-slate-500">
                            Tanggal ini akan ditampilkan sebagai penanda tanggal pembaruan data TKK.
                        </p>

                        @error('tanggal_data_terbaru')
                            <p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm leading-6 text-slate-600">
                        <p class="font-semibold text-slate-800">Urutan kolom jika memakai template sederhana:</p>
                        <p>1. Nama</p>
                        <p>2. Kabupaten</p>
                        <p>3. Klasifikasi</p>
                        <p>4. Jabatan Kerja</p>
                        <p>5. Jenjang</p>
                        <p>6. Asosiasi</p>
                        <p>7. Tanggal Aktif</p>
                        <p>8. Tanggal Kadaluwarsa</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button" data-modal-close class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
                            Batal
                        </button>

                        <button type="submit" class="rounded-xl bg-indigo-600 px-4 py-2.5 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500">
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
                    <h3 class="text-xl font-bold text-slate-900">
                        {{ $isEditing ? 'Ubah Data TKK' : 'Form Data TKK' }}
                    </h3>
                    <p class="mt-1 text-sm text-slate-500">
                        Isi data TKK secara manual melalui form berikut.
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    @if($isEditing)
                        <a href="{{ route('admin.tenaga-kerja-konstruksi') }}" class="rounded-xl border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                            Reset
                        </a>
                    @endif

                    <button type="button" data-modal-close class="h-9 w-9 rounded-full text-slate-500 hover:bg-slate-100">
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
                    action="{{ $isEditing ? route('admin.tenaga-kerja-konstruksi.update', $editingTkk) : route('admin.tenaga-kerja-konstruksi.store') }}"
                    method="POST"
                    class="space-y-3">
                    @csrf
                    @if($isEditing)
                        @method('PUT')
                    @endif

                    <div class="grid grid-cols-1 gap-3 lg:grid-cols-2">
                        <div>
                            <label for="nama" class="mb-2 block text-sm font-medium text-slate-700">Nama <span class="text-rose-500">*</span></label>
                            <input id="nama" type="text" name="nama" value="{{ old('nama', $editingTkk?->nama) }}" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                            @error('nama') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="kabupaten" class="mb-2 block text-sm font-medium text-slate-700">
                                Kabupaten / Kota
                            </label>
                            <select
                                id="kabupaten"
                                name="kabupaten"
                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">
                                <option value="">Pilih Kabupaten / Kota</option>

                                @foreach($kabupatenOptions as $value => $label)
                                    <option
                                        value="{{ $value }}"
                                        @selected(old('kabupaten', $editingTkk?->kabupaten) === $value)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kabupaten') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-3 lg:grid-cols-2">
                        <div>
                            <label for="klasifikasi" class="mb-2 block text-sm font-medium text-slate-700">Klasifikasi</label>
                            <input id="klasifikasi" type="text" name="klasifikasi" value="{{ old('klasifikasi', $editingTkk?->klasifikasi) }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                            @error('klasifikasi') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="jabatan_kerja" class="mb-2 block text-sm font-medium text-slate-700">Jabatan Kerja</label>
                            <input id="jabatan_kerja" type="text" name="jabatan_kerja" value="{{ old('jabatan_kerja', $editingTkk?->jabatan_kerja) }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                            @error('jabatan_kerja') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-3 lg:grid-cols-4">
                        <div>
                            <label for="jenjang" class="mb-2 block text-sm font-medium text-slate-700">Jenjang</label>
                            <input id="jenjang" type="number" name="jenjang" min="1" max="9" value="{{ old('jenjang', $editingTkk?->jenjang) }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                            @error('jenjang') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="asosiasi" class="mb-2 block text-sm font-medium text-slate-700">Asosiasi</label>
                            <input id="asosiasi" type="text" name="asosiasi" value="{{ old('asosiasi', $editingTkk?->asosiasi) }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                            @error('asosiasi') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="tanggal_aktif" class="mb-2 block text-sm font-medium text-slate-700">Tanggal Aktif</label>
                            <input id="tanggal_aktif" type="date" name="tanggal_aktif" value="{{ old('tanggal_aktif', $editingTkk?->tanggal_aktif) }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                            @error('tanggal_aktif') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="tanggal_kadaluwarsa" class="mb-2 block text-sm font-medium text-slate-700">Tanggal Kadaluwarsa</label>
                            <input id="tanggal_kadaluwarsa" type="date" name="tanggal_kadaluwarsa" value="{{ old('tanggal_kadaluwarsa', $editingTkk?->tanggal_kadaluwarsa) }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                            @error('tanggal_kadaluwarsa') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-200 pt-4">
                        <button type="button" data-modal-close class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
                            Batal
                        </button>

                        <button type="submit" class="rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-500">
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
                <h3 id="delete-modal-title" class="text-lg font-bold text-slate-900">Hapus data TKK?</h3>
                <p id="delete-modal-text" class="mt-2 text-sm leading-6 text-slate-500">
                    Data ini akan dihapus.
                </p>

                <div class="mt-6 flex items-center justify-end gap-2">
                    <button type="button" data-modal-close class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
                        Batal
                    </button>

                    <button type="button" id="confirm-delete-button" class="rounded-xl bg-rose-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-rose-500">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div
    id="tkk-script-data"
    class="hidden"
    data-initial-panel="{{ $initialPanel }}"
    data-search-endpoint="{{ route('admin.tenaga-kerja-konstruksi.search') }}"
    data-base-url="{{ route('admin.tenaga-kerja-konstruksi') }}"
    data-destroy-url-template="{{ route('admin.tenaga-kerja-konstruksi.destroy', ['tkk' => '__ID__']) }}"
    data-csrf="{{ csrf_token() }}"
    data-total-rows="{{ $totalTkk ?? 0 }}">
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const body = document.body;
    const scriptData = document.getElementById('tkk-script-data');

    if (!scriptData) return;

    const modalElements = {
        upload: document.getElementById('upload-modal'),
        manual: document.getElementById('manual-modal'),
        delete: document.getElementById('delete-confirm-modal'),
    };

    const tbody = document.getElementById('tkkTableBody');
    const searchInput = document.getElementById('searchInput');
    const searchCategory = document.getElementById('searchCategory');
    const selectAllRows = document.getElementById('select-all-rows');
    const bulkDeleteTrigger = document.getElementById('bulk-delete-trigger');
    const deleteAllTrigger = document.getElementById('delete-all-trigger');
    const confirmDeleteButton = document.getElementById('confirm-delete-button');
    const deleteModalTitle = document.getElementById('delete-modal-title');
    const deleteModalText = document.getElementById('delete-modal-text');
    const bulkDeleteForm = document.getElementById('bulk-delete-form');
    const bulkDeleteInputs = document.getElementById('bulk-delete-inputs');
    const deleteAllForm = document.getElementById('delete-all-form');
    const selectAllInfo = document.getElementById('select-all-info');

    const searchEndpoint = scriptData.dataset.searchEndpoint;
    const baseUrl = scriptData.dataset.baseUrl;
    const destroyUrlTemplate = scriptData.dataset.destroyUrlTemplate;
    const csrfToken = scriptData.dataset.csrf;
    const initialPanel = scriptData.dataset.initialPanel || 'closed';
    const totalAllRows = Number(scriptData.dataset.totalRows || 0);
    let selectAllAcrossPages = false;

    let currentPage = 1;
    let deleteState = { mode: null, form: null, ids: [] };
    let searchDebounce = null;

    window.currentPage = currentPage;

    const escapeHtml = (value) => String(value ?? '')
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');

    const submitHiddenForm = (form) => {
        if (!form) return;

        const hiddenSubmit = form.querySelector('[data-hidden-submit]');

        if (hiddenSubmit) {
            hiddenSubmit.click();
            return;
        }

        form.submit();
    };

    const hasOpenModal = () => Object.values(modalElements).some((modal) => modal && modal.dataset.state === 'open');

    const lockBody = () => {
        body.classList.toggle('overflow-hidden', hasOpenModal());
    };

    const showModal = (modal) => {
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
    };

    const hideModal = (modal) => {
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
    };

    document.querySelectorAll('[data-modal-open]').forEach((button) => {
        button.addEventListener('click', function () {
            const target = this.dataset.modalOpen;

            if (target === 'manual') showModal(modalElements.manual);
            if (target === 'upload') showModal(modalElements.upload);
        });
    });

    Object.values(modalElements).forEach((modal) => {
        if (!modal) return;

        modal.dataset.state = 'closed';

        modal.querySelectorAll('[data-modal-close], [data-modal-backdrop]').forEach((element) => {
            element.addEventListener('click', () => hideModal(modal));
        });
    });

    document.querySelectorAll('[data-toast]').forEach((toast, index) => {
        setTimeout(() => {
            toast.classList.add('translate-y-2', 'opacity-0');
            setTimeout(() => toast.remove(), 300);
        }, 3200 + (index * 300));
    });

    document.querySelectorAll('[data-toast-close]').forEach((button) => {
        button.addEventListener('click', function () {
            const toast = this.closest('[data-toast]');
            if (toast) toast.remove();
        });
    });

    const getRowCheckboxes = () => Array.from(document.querySelectorAll('[data-row-checkbox]'));

    const getSelectedIds = () => getRowCheckboxes()
        .filter((checkbox) => checkbox.checked)
        .map((checkbox) => checkbox.value);

    const refreshSelectionState = () => {
        const rowCheckboxes = getRowCheckboxes();
        const count = getSelectedIds().length;

        if (selectAllRows) {
            if (selectAllAcrossPages) {
                selectAllRows.checked = true;
                selectAllRows.indeterminate = false;
            } else {
                selectAllRows.checked = count > 0 && count === rowCheckboxes.length && rowCheckboxes.length > 0;
                selectAllRows.indeterminate = count > 0 && count < rowCheckboxes.length;
            }
        }

        if (selectAllInfo) {
            selectAllInfo.classList.toggle('hidden', !selectAllAcrossPages);
            selectAllInfo.textContent = `Semua ${totalAllRows} data TKK di seluruh halaman dipilih.`;
        }

        if (!bulkDeleteTrigger) return;

        if (selectAllAcrossPages) {
            bulkDeleteTrigger.disabled = false;
            bulkDeleteTrigger.classList.remove('cursor-not-allowed', 'text-rose-300');
            bulkDeleteTrigger.classList.add('border-rose-200', 'text-rose-600', 'hover:border-rose-300', 'hover:bg-rose-50');
            bulkDeleteTrigger.textContent = `Hapus Terpilih (${totalAllRows})`;
            return;
        }

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

    if (selectAllRows) {
        selectAllRows.addEventListener('change', function () {
            selectAllAcrossPages = this.checked;

            getRowCheckboxes().forEach((checkbox) => {
                checkbox.checked = this.checked;
            });

            refreshSelectionState();
        });
    }

    document.addEventListener('change', function (event) {
        if (event.target.matches('[data-row-checkbox]')) {
            selectAllAcrossPages = false;
            refreshSelectionState();
        }
    });
    const renderRows = (rows) => {
        if (!tbody) return;

        tbody.innerHTML = '';

        if (!selectAllAcrossPages && selectAllRows) {
            selectAllRows.checked = false;
            selectAllRows.indeterminate = false;
        }

        if (!rows.length) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-xs text-slate-500">
                        Data TKK tidak ditemukan.
                    </td>
                </tr>
            `;
            return;
        }

        rows.forEach((row) => {
            const statusClass = String(row.status || '').toLowerCase() === 'aktif'
                ? 'bg-emerald-100 text-emerald-700'
                : 'bg-red-100 text-red-700';

            const destroyUrl = destroyUrlTemplate.replace('__ID__', row.id);
            const editUrl = `${baseUrl}?edit=${encodeURIComponent(row.id)}&panel=manual`;

            tbody.innerHTML += `
                <tr class="transition hover:bg-blue-50/30">
                    <td class="px-4 py-2">
                        <input
                            type="checkbox"
                            value="${escapeHtml(row.id)}"
                            data-row-checkbox
                            class="h-4 w-4 rounded border-slate-300 bg-white text-indigo-600 focus:ring-indigo-500">
                    </td>

                    <td class="whitespace-nowrap px-4 py-2 text-[13px] font-semibold text-slate-700">
                        ${escapeHtml(row.nama)}
                    </td>

                    <td class="whitespace-nowrap px-4 py-2 text-[13px] text-slate-600">
                        ${escapeHtml(row.kabupaten || '-')}
                    </td>

                    <td class="min-w-[260px] px-4 py-2 text-[13px] text-slate-600">
                        ${escapeHtml(row.jabatan || '-')}
                    </td>

                    <td class="whitespace-nowrap px-4 py-2 text-center text-[13px] font-extrabold text-[#142B67]">
                        ${escapeHtml(row.jenjang || '-')}
                    </td>

                    <td class="whitespace-nowrap px-4 py-2 text-center">
                        <span class="inline-flex rounded-full px-2.5 py-0.5 text-[11px] font-bold tracking-[0.06em] ${statusClass}">
                            ${escapeHtml(row.status)}
                        </span>
                    </td>

                    <td class="px-4 py-2">
                        <div class="flex items-center justify-center gap-2">
                            <a
                                href="${editUrl}"
                                class="rounded-xl border border-amber-200 bg-amber-50 px-3 py-2 text-[11px] font-semibold text-amber-700 transition hover:border-amber-300 hover:bg-amber-100">
                                Edit
                            </a>

                            <form action="${destroyUrl}" method="POST" class="single-delete-form">
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <input type="hidden" name="_method" value="DELETE">

                                <button
                                    type="button"
                                    data-delete-single
                                    data-delete-name="${escapeHtml(row.nama)}"
                                    class="rounded-xl border border-rose-200 bg-white px-3 py-2 text-[11px] font-semibold text-rose-600 transition hover:border-rose-300 hover:bg-rose-50">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            `;
        });
            if (selectAllAcrossPages) {
        getRowCheckboxes().forEach((checkbox) => {
            checkbox.checked = true;
        });
    }
    };

    window.fetchSearchData = async function (page = 1) {
        page = Math.max(page, 1);

        const url = new URL(searchEndpoint, window.location.origin);
        url.searchParams.set('keyword', searchInput ? searchInput.value : '');
        url.searchParams.set('category', searchCategory ? searchCategory.value : 'nama');
        url.searchParams.set('page', page);

        const response = await fetch(url.toString(), {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
        });

        const result = await response.json();

        currentPage = result.current_page;
        window.currentPage = currentPage;

        renderRows(result.data || []);

        const start = result.total > 0 ? ((result.current_page - 1) * 10) + 1 : 0;
        const end = Math.min(result.current_page * 10, result.total);

        document.getElementById('tableInfo').innerHTML = `
            Hal:
            <span class="font-extrabold text-slate-900">${start} - ${end}</span>
            dari
            <span class="font-extrabold text-slate-900">${result.total}</span>
        `;

        const paginationNumbers = document.getElementById('paginationNumbers');
        paginationNumbers.innerHTML = '';

        const current = result.current_page;
        const last = result.last_page;

        let pages = [1];

        for (let i = current - 1; i <= current + 1; i++) {
            if (i > 1 && i < last) pages.push(i);
        }

        if (last > 1) pages.push(last);

        pages = [...new Set(pages)].sort((a, b) => a - b);

        let prevPage = null;

        pages.forEach((pageNumber) => {
            if (prevPage && pageNumber - prevPage > 1) {
                paginationNumbers.innerHTML += `<span class="px-2 text-slate-400 font-bold">...</span>`;
            }

            paginationNumbers.innerHTML += `
                <button
                    type="button"
                    onclick="fetchSearchData(${pageNumber})"
                    class="rounded-xl px-3 py-2 text-sm font-bold transition
                        ${pageNumber === current
                            ? 'bg-[#142B67] text-white'
                            : 'border border-slate-200 bg-white text-slate-600 hover:bg-slate-100'}">
                    ${pageNumber}
                </button>
            `;

            prevPage = pageNumber;
        });

        document.getElementById('prevBtn').disabled = current <= 1;
        document.getElementById('nextBtn').disabled = current >= last;

        refreshSelectionState();
    };

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            clearTimeout(searchDebounce);
            searchDebounce = setTimeout(() => fetchSearchData(1), 150);
        });
    }

    if (searchCategory) {
        searchCategory.addEventListener('change', function () {
            fetchSearchData(1);
        });
    }

    document.addEventListener('click', function (event) {
        const singleDeleteButton = event.target.closest('[data-delete-single]');

        if (singleDeleteButton) {
            deleteState = {
                mode: 'single',
                form: singleDeleteButton.closest('form'),
                ids: [],
            };

            deleteModalTitle.textContent = 'Hapus data TKK?';
            deleteModalText.innerHTML = `Data <span class="font-semibold text-slate-700">${escapeHtml(singleDeleteButton.dataset.deleteName || 'ini')}</span> akan dihapus. Tindakan ini tidak bisa dibatalkan.`;

            showModal(modalElements.delete);
            return;
        }

        if (event.target.closest('#bulk-delete-trigger')) {
            if (selectAllAcrossPages) {
                deleteState = {
                    mode: 'all',
                    form: null,
                    ids: [],
                };

                deleteModalTitle.textContent = 'Hapus semua data TKK?';
                deleteModalText.innerHTML = `Sebanyak <span class="font-semibold text-slate-700">${totalAllRows} data TKK di seluruh halaman</span> akan dihapus. Tindakan ini tidak bisa dibatalkan.`;

                showModal(modalElements.delete);
                return;
            }

            const ids = getSelectedIds();

            if (!ids.length) return;

            deleteState = {
                mode: 'bulk',
                form: null,
                ids,
            };

            deleteModalTitle.textContent = 'Hapus beberapa data TKK?';
            deleteModalText.innerHTML = `Sebanyak <span class="font-semibold text-slate-700">${ids.length} data</span> terpilih akan dihapus. Tindakan ini tidak bisa dibatalkan.`;

            showModal(modalElements.delete);
            return;
        }

        if (event.target.closest('#delete-all-trigger') && !deleteAllTrigger.disabled) {
            deleteState = {
                mode: 'all',
                form: null,
                ids: [],
            };

            deleteModalTitle.textContent = 'Hapus semua data TKK?';
            deleteModalText.innerHTML = 'Semua <span class="font-semibold text-slate-700">data TKK di seluruh halaman</span> akan dihapus, bukan hanya data yang sedang tampil.';

            showModal(modalElements.delete);
        }
    });

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

    if (initialPanel === 'upload') {
        showModal(modalElements.upload);
    } else if (initialPanel === 'manual') {
        showModal(modalElements.manual);
    }

    fetchSearchData(1);
});
</script>
@endpush