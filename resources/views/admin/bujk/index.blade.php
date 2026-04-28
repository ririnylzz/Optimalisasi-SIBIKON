@extends('layouts.admin')

@section('page-title', 'Daftar Badan Usaha Jasa Konstruksi')
@section('page-subtitle', 'Kelola data BUJK melalui input manual dan import file')

@section('content')
    @php
        $isEditing = $editingBujk !== null;
        $selectedJenis = old('jenis_bujk');

        if (is_string($selectedJenis)) {
            $selectedJenis = collect(explode(',', $selectedJenis))
                ->map(fn ($item) => trim($item))
                ->filter()
                ->values()
                ->all();
        }

        $selectedJenis = $selectedJenis ?? ($editingBujk?->jenis_bujk_list ?? []);

        $selectedProvince = old('provinsi_bujk', $editingBujk?->provinsi_bujk);
        $selectedKabupaten = old('kab_kota_bujk', $editingBujk?->kab_kota_bujk);
        $availableKabupaten = collect();

        if ($selectedKabupaten) {
            $availableKabupaten->push($selectedKabupaten);
        }

        $requestedPanel = request('panel');
        $initialPanel = 'closed';

        if (in_array($requestedPanel, ['upload', 'manual'], true)) {
            $initialPanel = $requestedPanel;
        } elseif ($errors->has('file_import')) {
            $initialPanel = 'upload';
        } elseif ($isEditing || ($errors->any() && !$errors->has('file_import'))) {
            $initialPanel = 'manual';
        }

        $toastMessages = [];

        if (session('success')) {
            $toastMessages[] = [
                'type' => 'success',
                'message' => session('success'),
            ];
        }

        if (session('error')) {
            $toastMessages[] = [
                'type' => 'error',
                'message' => session('error'),
            ];
        }

        if ($errors->has('file_import')) {
            $toastMessages[] = [
                'type' => 'error',
                'message' => $errors->first('file_import'),
            ];
        } elseif ($errors->any()) {
            $toastMessages[] = [
                'type' => 'error',
                'message' => $errors->first(),
            ];
        }
    @endphp

    <div class="pointer-events-none fixed right-4 top-4 z-[100] flex w-full max-w-sm flex-col gap-3">
        @foreach($toastMessages as $toast)
            <div
                data-toast
                class="pointer-events-auto rounded-2xl border px-4 py-3 shadow-2xl transition duration-300
                    {{ $toast['type'] === 'success'
                        ? 'border-emerald-500/30 bg-emerald-500 text-white'
                        : 'border-rose-500/30 bg-rose-500 text-white' }}"
            >
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

                    <button
                        type="button"
                        data-toast-close
                        class="shrink-0 rounded-lg p-1 text-white/80 transition hover:bg-white/10 hover:text-white"
                    >
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
            <div class="flex items-center gap-2 text-sm text-slate-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-white">Home</a>
                <span>/</span>
                <span class="font-medium text-slate-200">Masyarakat Jasa Konstruksi</span>
                <span>/</span>
                <span class="font-medium text-slate-200">BUJK</span>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-800 bg-slate-900 p-4">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <h3 class="text-lg font-bold text-white">Tabel Data BUJK</h3>
                    <p class="mt-1 text-sm text-slate-400">
                        Format kolom menyesuaikan kebutuhan data utama: NIB, nama BUJK, jenis usaha, alamat, NPWP, kontak, dan aksi.
                    </p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center sm:justify-end">
                    <div class="flex flex-wrap items-center gap-2 rounded-2xl border border-slate-800 bg-slate-950/50 px-3 py-3">
                        <span class="w-full text-xs font-semibold uppercase tracking-wider text-slate-500 sm:w-auto">Aksi Data</span>

                        <button
                            type="button"
                            data-modal-open="manual"
                            class="rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500"
                        >
                            Tambah Data
                        </button>

                        <button
                            type="button"
                            data-modal-open="upload"
                            class="rounded-xl border border-slate-700 px-4 py-2.5 text-sm font-medium text-slate-200 transition hover:border-indigo-500 hover:text-white"
                        >
                            Upload File
                        </button>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 rounded-2xl border border-slate-800 bg-slate-950/50 px-3 py-3">
                        <span class="w-full text-xs font-semibold uppercase tracking-wider text-slate-500 sm:w-auto">Aksi Hapus</span>

                        <button
                            type="button"
                            id="bulk-delete-trigger"
                            disabled
                            class="cursor-not-allowed rounded-xl border border-rose-500/30 px-4 py-2.5 text-sm font-semibold text-rose-300/60 transition"
                        >
                            Hapus Terpilih
                        </button>

                        <button
                            type="button"
                            id="delete-all-trigger"
                            {{ ($bujks->total() ?? 0) < 1 ? 'disabled' : '' }}
                            class="{{ ($bujks->total() ?? 0) < 1
                                ? 'cursor-not-allowed border border-rose-500/20 text-rose-300/40'
                                : 'border border-rose-500/40 text-rose-300 hover:bg-rose-500/10' }} rounded-xl px-4 py-2.5 text-sm font-semibold transition"
                        >
                            Hapus Semua
                        </button>
                    </div>
                </div>
            </div>

            <form id="bujk-filter-form" method="GET" action="{{ route('admin.bujk') }}" class="mt-5 grid grid-cols-1 gap-3 lg:grid-cols-4">
                <div class="lg:col-span-2">
                    <label for="search" class="mb-2 block text-sm font-medium text-slate-300">Filter / keyword</label>
                    <input
                        id="search"
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Cari NIB, nama BUJK, alamat, NPWP, email, atau kontak"
                        autocomplete="off"
                        class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-sm text-slate-100 outline-none transition focus:border-indigo-500"
                    />
                </div>

                <div>
                    <label for="jenis" class="mb-2 block text-sm font-medium text-slate-300">Jenis usaha</label>
                    <select
                        id="jenis"
                        name="jenis"
                        class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-sm text-slate-100 outline-none transition focus:border-indigo-500"
                    >
                        <option value="">Semua jenis</option>
                        @foreach($jenisOptions as $jenis)
                            <option value="{{ $jenis }}" @selected($jenisFilter === $jenis)>{{ $jenis }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="per_page" class="mb-2 block text-sm font-medium text-slate-300">Show</label>
                    <select
                        id="per_page"
                        name="per_page"
                        class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-sm text-slate-100 outline-none transition focus:border-indigo-500"
                    >
                        @foreach([10, 25, 50, 100] as $size)
                            <option value="{{ $size }}" @selected($perPage === $size)>{{ $size }}</option>
                        @endforeach
                    </select>
                </div>
            </form>

            <div class="mt-4 flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-slate-800 bg-slate-950/40 px-4 py-3">
                <label class="inline-flex items-center gap-3 text-sm text-slate-300">
                    <input
                        type="checkbox"
                        id="select-all-rows"
                        class="h-4 w-4 rounded border-slate-600 bg-slate-950 text-indigo-600 focus:ring-indigo-500"
                    >
                    <span>Pilih semua data di halaman ini</span>
                </label>

                <div class="text-sm text-slate-400">
                    <span id="selected-count">0</span> data dipilih
                </div>
            </div>

            <div class="mt-5 overflow-hidden rounded-2xl border border-slate-800">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-800 text-sm">
                        <thead class="bg-slate-950/80 text-left text-xs uppercase tracking-wider text-slate-400">
                            <tr>
                                <th class="w-12 px-4 py-3">
                                    <span class="sr-only">Pilih</span>
                                </th>
                                <th class="px-4 py-3">No.</th>
                                <th class="px-4 py-3">NIB</th>
                                <th class="px-4 py-3">Nama BUJK</th>
                                <th class="px-4 py-3">Jenis Usaha</th>
                                <th class="px-4 py-3">Alamat</th>
                                <th class="px-4 py-3">NPWP</th>
                                <th class="px-4 py-3">Kontak</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800 bg-slate-900/60">
                            @forelse($bujks as $item)
                                <tr class="align-top text-slate-200">
                                    <td class="px-4 py-4">
                                        <input
                                            type="checkbox"
                                            value="{{ $item->id }}"
                                            data-row-checkbox
                                            class="h-4 w-4 rounded border-slate-600 bg-slate-950 text-indigo-600 focus:ring-indigo-500"
                                        >
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-4">{{ $bujks->firstItem() + $loop->index }}.</td>
                                    <td class="whitespace-nowrap px-4 py-4 font-medium">{{ $item->nib }}</td>
                                    <td class="px-4 py-4">
                                        <p class="font-semibold text-white">{{ $item->nama_bujk }}</p>
                                        <p class="mt-1 text-xs text-slate-500">
                                            {{ $item->provinsi_bujk ?: '-' }}
                                            @if($item->kab_kota_bujk)
                                                • {{ $item->kab_kota_bujk }}
                                            @endif
                                        </p>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($item->jenis_bujk_list as $jenis)
                                                <span class="rounded-full bg-indigo-500/10 px-3 py-1 text-xs font-medium text-indigo-300">
                                                    {{ $jenis }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="max-w-xs px-4 py-4 text-slate-300">{{ $item->alamat_bujk ?: '-' }}</td>
                                    <td class="whitespace-nowrap px-4 py-4">{{ $item->npwp_bujk ?: '-' }}</td>
                                    <td class="px-4 py-4">
                                        <div class="space-y-1 text-xs text-slate-300">
                                            <p>{{ $item->telp_bujk ?: '-' }}</p>
                                            @if($item->email_bujk)
                                                <p>{{ $item->email_bujk }}</p>
                                            @endif
                                            @if($item->website_bujk)
                                                <p>
                                                    <a
                                                        href="{{ $item->website_url }}"
                                                        target="_blank"
                                                        class="text-sky-300 hover:text-sky-200"
                                                    >
                                                        {{ $item->website_bujk }}
                                                    </a>
                                                </p>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a
                                                href="{{ route('admin.bujk', array_merge(request()->query(), ['edit' => $item->id, 'panel' => 'manual'])) }}"
                                                class="inline-flex items-center justify-center rounded-lg border border-amber-400/40 px-3 py-2 text-xs font-semibold text-amber-300 transition hover:bg-amber-500/10"
                                            >
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.bujk.destroy', $item) }}" method="POST" class="single-delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="button"
                                                    data-delete-single
                                                    data-delete-name="{{ $item->nama_bujk }}"
                                                    class="inline-flex items-center justify-center rounded-lg border border-rose-400/40 px-3 py-2 text-xs font-semibold text-rose-300 transition hover:bg-rose-500/10"
                                                >
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-4 py-8 text-center text-sm text-slate-500">
                                        Belum ada data BUJK yang tampil. Klik tombol tambah data atau upload file untuk mulai mengisi data.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <p class="text-sm text-slate-500">
                    Menampilkan {{ $bujks->firstItem() ?? 0 }} - {{ $bujks->lastItem() ?? 0 }} dari {{ $bujks->total() }} data.
                </p>

                {{ $bujks->onEachSide(1)->links() }}
            </div>
        </div>
    </div>

    <div class="absolute left-[-9999px] top-auto h-0 w-0 overflow-hidden opacity-0" aria-hidden="true">
        <form id="bulk-delete-form" action="{{ route('admin.bujk.bulk-destroy') }}" method="POST">
            @csrf
            @method('DELETE')
            <div id="bulk-delete-inputs"></div>
            <button type="submit" data-hidden-submit>submit</button>
        </form>

        <form id="delete-all-form" action="{{ route('admin.bujk.destroy-all') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" data-hidden-submit>submit</button>
        </form>
    </div>

    <div
        id="upload-modal"
        data-modal-wrapper="upload"
        class="pointer-events-none fixed inset-0 z-[70] hidden p-4 opacity-0 transition duration-200"
    >
        <div data-modal-backdrop class="absolute inset-0 bg-slate-950/70 backdrop-blur-sm opacity-0 transition duration-200"></div>

        <div class="relative z-10 flex min-h-full items-center justify-center">
            <div
                data-modal-panel
                class="w-full max-w-3xl translate-y-4 scale-[0.98] rounded-3xl bg-white opacity-0 shadow-2xl transition duration-200 ease-out"
            >
                <div class="flex items-start justify-between gap-4 border-b border-slate-200 px-5 py-4">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">Import CSV / XLSX</h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Upload file BUJK melalui template CSV atau XLSX.
                        </p>
                    </div>

                    <button
                        type="button"
                        data-modal-close
                        class="inline-flex h-9 w-9 items-center justify-center rounded-full text-slate-500 transition hover:bg-slate-100 hover:text-slate-700"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="px-5 py-4">
                    <form action="{{ route('admin.bujk.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        <div>
                            <label for="file_import" class="mb-2 block text-sm font-medium text-slate-700">File upload</label>
                            <input
                                id="file_import"
                                type="file"
                                name="file_import"
                                accept=".csv,.txt,.xlsx"
                                class="block w-full rounded-xl border border-slate-300 bg-white px-3 py-3 text-sm text-slate-700 file:mr-3 file:rounded-md file:border-0 file:bg-indigo-600 file:px-3 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-indigo-500"
                            />
                            @error('file_import')
                                <p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm leading-6 text-slate-600">
                            <p class="font-semibold text-slate-800">Aturan import:</p>
                            <p>1. File yang didukung: <span class="font-medium text-slate-800">CSV</span> dan <span class="font-medium text-slate-800">XLSX</span>.</p>
                            <p>2. Header bisa dari template sederhana atau dari file sumber mentah yang punya alias kolom BUJK.</p>
                            <p>3. Data dengan NIB sama akan digabung dan di-update, bukan ditambahkan duplikat baru.</p>
                            <p>4. Jika satu BUJK muncul berkali-kali di file karena subklasifikasi berbeda, service akan merge menjadi satu record BUJK.</p>
                        </div>

                        <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-200 pt-4">
                            <a
                                href="{{ asset('templates/bujk-template.csv') }}"
                                class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:border-indigo-500 hover:text-indigo-600"
                            >
                                Download Template
                            </a>

                            <div class="flex items-center gap-2">
                                <button
                                    type="button"
                                    data-modal-close
                                    class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                                >
                                    Batal
                                </button>

                                <button
                                    type="submit"
                                    class="rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500"
                                >
                                    Proses Import
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div
        id="manual-modal"
        data-modal-wrapper="manual"
        class="pointer-events-none fixed inset-0 z-[70] hidden p-4 opacity-0 transition duration-200"
    >
        <div data-modal-backdrop class="absolute inset-0 bg-slate-950/70 backdrop-blur-sm opacity-0 transition duration-200"></div>

        <div class="relative z-10 flex min-h-full items-center justify-center">
            <div
                data-modal-panel
                class="w-full max-w-5xl translate-y-4 scale-[0.98] rounded-3xl bg-white opacity-0 shadow-2xl transition duration-200 ease-out"
            >
                <div class="flex items-start justify-between gap-4 border-b border-slate-200 px-5 py-4">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">{{ $isEditing ? 'Ubah Data BUJK' : 'Form BUJK' }}</h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Isi data BUJK secara manual melalui form berikut.
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        @if($isEditing)
                            <a
                                href="{{ route('admin.bujk') }}"
                                class="rounded-xl border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                            >
                                Reset
                            </a>
                        @endif

                        <button
                            type="button"
                            data-modal-close
                            class="inline-flex h-9 w-9 items-center justify-center rounded-full text-slate-500 transition hover:bg-slate-100 hover:text-slate-700"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="px-5 py-4">
                    @if($errors->any() && !$errors->has('file_import'))
                        <div class="mb-4 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                            <p class="font-semibold">Masih ada input yang perlu diperbaiki:</p>
                            <ul class="mt-2 space-y-1 text-xs">
                                @foreach($errors->all() as $error)
                                    @if($error !== $errors->first('file_import'))
                                        <li>• {{ $error }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form
                        action="{{ $isEditing ? route('admin.bujk.update', $editingBujk) : route('admin.bujk.store') }}"
                        method="POST"
                        class="space-y-3"
                    >
                        @csrf
                        @if($isEditing)
                            @method('PUT')
                        @endif

                        <div class="grid grid-cols-1 gap-3 lg:grid-cols-2">
                            <div>
                                <label for="nib" class="mb-2 block text-sm font-medium text-slate-700">NIB</label>
                                <input
                                    id="nib"
                                    type="text"
                                    name="nib"
                                    value="{{ old('nib', $editingBujk?->nib) }}"
                                    placeholder="NIB Perusahaan"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-500"
                                />
                                @error('nib')
                                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="nama_bujk" class="mb-2 block text-sm font-medium text-slate-700">Nama BUJK</label>
                                <input
                                    id="nama_bujk"
                                    type="text"
                                    name="nama_bujk"
                                    value="{{ old('nama_bujk', $editingBujk?->nama_bujk) }}"
                                    placeholder="Nama BUJK"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-500"
                                />
                                @error('nama_bujk')
                                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Jenis Usaha</label>
                            <div class="grid gap-3 lg:grid-cols-2">
                                @foreach($jenisOptions as $jenis)
                                    <label class="flex items-center gap-3 rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700">
                                        <input
                                            type="checkbox"
                                            name="jenis_bujk[]"
                                            value="{{ $jenis }}"
                                            {{ in_array($jenis, $selectedJenis, true) ? 'checked' : '' }}
                                            class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                                        />
                                        <span>{{ $jenis }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('jenis_bujk')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="alamat_bujk" class="mb-2 block text-sm font-medium text-slate-700">Alamat</label>
                            <textarea
                                id="alamat_bujk"
                                name="alamat_bujk"
                                rows="2"
                                placeholder="Alamat BUJK"
                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-500"
                            >{{ old('alamat_bujk', $editingBujk?->alamat_bujk) }}</textarea>
                            @error('alamat_bujk')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 gap-3 lg:grid-cols-3">
                            <div>
                                <label for="provinsi_bujk" class="mb-2 block text-sm font-medium text-slate-700">Provinsi</label>
                                <select
                                    id="provinsi_bujk"
                                    name="provinsi_bujk"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-500"
                                >
                                    <option value="">Pilih...</option>
                                    @if($selectedProvince)
                                        <option value="{{ $selectedProvince }}" selected>{{ $selectedProvince }}</option>
                                    @endif
                                </select>
                                @error('provinsi_bujk')
                                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="kab_kota_bujk" class="mb-2 block text-sm font-medium text-slate-700">Kabupaten / Kota</label>
                                <select
                                    id="kab_kota_bujk"
                                    name="kab_kota_bujk"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-500"
                                >
                                    <option value="">{{ $selectedProvince ? 'Pilih...' : 'Pilih provinsi dulu...' }}</option>
                                    @foreach($availableKabupaten as $kabupaten)
                                        <option value="{{ $kabupaten }}" selected>{{ $kabupaten }}</option>
                                    @endforeach
                                </select>
                                @error('kab_kota_bujk')
                                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="npwp_bujk" class="mb-2 block text-sm font-medium text-slate-700">NPWP</label>
                                <input
                                    id="npwp_bujk"
                                    type="text"
                                    name="npwp_bujk"
                                    value="{{ old('npwp_bujk', $editingBujk?->npwp_bujk) }}"
                                    placeholder="NPWP BUJK"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-500"
                                />
                                @error('npwp_bujk')
                                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-3 lg:grid-cols-3">
                            <div>
                                <label for="email_bujk" class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                                <input
                                    id="email_bujk"
                                    type="email"
                                    name="email_bujk"
                                    value="{{ old('email_bujk', $editingBujk?->email_bujk) }}"
                                    placeholder="Email BUJK"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-500"
                                />
                                @error('email_bujk')
                                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="telp_bujk" class="mb-2 block text-sm font-medium text-slate-700">No. Telp</label>
                                <input
                                    id="telp_bujk"
                                    type="text"
                                    name="telp_bujk"
                                    value="{{ old('telp_bujk', $editingBujk?->telp_bujk) }}"
                                    placeholder="Nomor Telepon"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-500"
                                />
                                @error('telp_bujk')
                                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="website_bujk" class="mb-2 block text-sm font-medium text-slate-700">Website</label>
                                <input
                                    id="website_bujk"
                                    type="text"
                                    name="website_bujk"
                                    value="{{ old('website_bujk', $editingBujk?->website_bujk) }}"
                                    placeholder="Website"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-500"
                                />
                                @error('website_bujk')
                                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-200 pt-4">
                            <button
                                type="button"
                                data-modal-close
                                class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                            >
                                Batal
                            </button>

                            <div class="flex items-center gap-2">
                                @if($isEditing)
                                    <span class="hidden text-xs text-slate-500 sm:inline">
                                        Sedang mengubah: {{ $editingBujk->nama_bujk }}
                                    </span>
                                @endif

                                <button
                                    type="submit"
                                    class="rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500"
                                >
                                    {{ $isEditing ? 'Update Data' : 'Simpan Data' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div
        id="delete-confirm-modal"
        data-modal-wrapper="delete"
        class="pointer-events-none fixed inset-0 z-[80] hidden p-4 opacity-0 transition duration-200"
    >
        <div data-modal-backdrop class="absolute inset-0 bg-slate-950/75 backdrop-blur-sm opacity-0 transition duration-200"></div>

        <div class="relative z-10 flex min-h-full items-center justify-center">
            <div
                data-modal-panel
                class="w-full max-w-md translate-y-4 scale-[0.98] rounded-3xl bg-white opacity-0 shadow-2xl transition duration-200 ease-out"
            >
                <div class="px-5 py-5">
                    <div class="flex items-start gap-4">
                        <div id="delete-modal-icon-box" class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-rose-100 text-rose-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16" />
                            </svg>
                        </div>

                        <div class="min-w-0 flex-1">
                            <h3 id="delete-modal-title" class="text-lg font-bold text-slate-900">Hapus data BUJK?</h3>
                            <p id="delete-modal-text" class="mt-1 text-sm leading-6 text-slate-500">
                                Data ini akan dihapus.
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-2">
                        <button
                            type="button"
                            data-modal-close
                            class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                        >
                            Batal
                        </button>

                        <button
                            type="button"
                            id="confirm-delete-button"
                            class="rounded-xl bg-rose-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-rose-500"
                        >
                            Ya, Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div
        id="bujk-script-data"
        class="hidden"
        data-selected-province="{{ e((string) $selectedProvince) }}"
        data-selected-kabupaten="{{ e((string) $selectedKabupaten) }}"
        data-provinces-endpoint="{{ route('admin.bujk.regions.provinces') }}"
        data-regencies-endpoint="{{ route('admin.bujk.regions.regencies') }}"
        data-initial-panel="{{ $initialPanel }}"
    ></div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const body = document.body;
    const scriptData = document.getElementById('bujk-script-data');

    if (!scriptData) return;

    const modalElements = {
        upload: document.getElementById('upload-modal'),
        manual: document.getElementById('manual-modal'),
        delete: document.getElementById('delete-confirm-modal'),
    };

    const openButtons = document.querySelectorAll('[data-modal-open]');
    const toastCloseButtons = document.querySelectorAll('[data-toast-close]');
    const provinceSelect = document.getElementById('provinsi_bujk');
    const kabupatenSelect = document.getElementById('kab_kota_bujk');

    const filterForm = document.getElementById('bujk-filter-form');
    const searchInput = document.getElementById('search');
    const jenisSelect = document.getElementById('jenis');
    const perPageSelect = document.getElementById('per_page');

    const selectAllRows = document.getElementById('select-all-rows');
    const rowCheckboxes = document.querySelectorAll('[data-row-checkbox]');
    const selectedCountEl = document.getElementById('selected-count');
    const bulkDeleteTrigger = document.getElementById('bulk-delete-trigger');
    const deleteAllTrigger = document.getElementById('delete-all-trigger');

    const deleteSingleTriggers = document.querySelectorAll('[data-delete-single]');
    const confirmDeleteButton = document.getElementById('confirm-delete-button');
    const deleteModalTitle = document.getElementById('delete-modal-title');
    const deleteModalText = document.getElementById('delete-modal-text');
    const bulkDeleteForm = document.getElementById('bulk-delete-form');
    const bulkDeleteInputs = document.getElementById('bulk-delete-inputs');
    const deleteAllForm = document.getElementById('delete-all-form');

    const selectedProvince = String(scriptData.dataset.selectedProvince || '').trim();
    const selectedKabupaten = String(scriptData.dataset.selectedKabupaten || '').trim();
    const provincesEndpoint = scriptData.dataset.provincesEndpoint || '';
    const regenciesEndpoint = scriptData.dataset.regenciesEndpoint || '';
    const initialPanel = scriptData.dataset.initialPanel || 'closed';

    let deleteState = {
        mode: null,
        form: null,
        name: null,
        ids: [],
    };

    let filterDebounce = null;
    let filterSubmitting = false;

    const hasOpenModal = () => {
        return Object.values(modalElements).some((modal) => modal && modal.dataset.state === 'open');
    };

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

    const submitFilterForm = () => {
        if (!filterForm || filterSubmitting) return;

        filterSubmitting = true;
        filterForm.submit();
    };

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            clearTimeout(filterDebounce);
            filterDebounce = setTimeout(() => {
                submitFilterForm();
            }, 450);
        });

        searchInput.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                clearTimeout(filterDebounce);
                submitFilterForm();
            }
        });
    }

    if (jenisSelect) {
        jenisSelect.addEventListener('change', function () {
            clearTimeout(filterDebounce);
            submitFilterForm();
        });
    }

    if (perPageSelect) {
        perPageSelect.addEventListener('change', function () {
            clearTimeout(filterDebounce);
            submitFilterForm();
        });
    }

    openButtons.forEach((button) => {
        button.addEventListener('click', function () {
            const target = this.dataset.modalOpen;

            if (target === 'upload') {
                closeAllPrimaryModals(false);
                showModal(modalElements.upload, 'upload', true);
            }

            if (target === 'manual') {
                closeAllPrimaryModals(false);
                showModal(modalElements.manual, 'manual', true);
            }
        });
    });

    Object.values(modalElements).forEach((modal) => {
        if (!modal) return;

        modal.dataset.state = 'closed';

        const backdrop = modal.querySelector('[data-modal-backdrop]');
        if (backdrop) {
            backdrop.addEventListener('click', function () {
                hideModal(modal, true);
            });
        }

        modal.querySelectorAll('[data-modal-close]').forEach((button) => {
            button.addEventListener('click', function () {
                hideModal(modal, true);
            });
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

    const getSelectedIds = () => {
        return Array.from(rowCheckboxes)
            .filter((checkbox) => checkbox.checked)
            .map((checkbox) => checkbox.value);
    };

    const updateBulkDeleteButton = (count) => {
        if (!bulkDeleteTrigger) return;

        if (count > 0) {
            bulkDeleteTrigger.disabled = false;
            bulkDeleteTrigger.classList.remove('cursor-not-allowed', 'border-rose-500/30', 'text-rose-300/60');
            bulkDeleteTrigger.classList.add('border-rose-500/40', 'text-rose-300', 'hover:bg-rose-500/10');
            bulkDeleteTrigger.textContent = `Hapus Terpilih (${count})`;
        } else {
            bulkDeleteTrigger.disabled = true;
            bulkDeleteTrigger.classList.add('cursor-not-allowed', 'border-rose-500/30', 'text-rose-300/60');
            bulkDeleteTrigger.classList.remove('border-rose-500/40', 'text-rose-300', 'hover:bg-rose-500/10');
            bulkDeleteTrigger.textContent = 'Hapus Terpilih';
        }
    };

    const refreshSelectionState = () => {
        const ids = getSelectedIds();
        const count = ids.length;

        if (selectedCountEl) {
            selectedCountEl.textContent = count;
        }

        if (selectAllRows) {
            selectAllRows.checked = count > 0 && count === rowCheckboxes.length;
            selectAllRows.indeterminate = count > 0 && count < rowCheckboxes.length;
        }

        updateBulkDeleteButton(count);
    };

    if (selectAllRows) {
        selectAllRows.addEventListener('change', function () {
            rowCheckboxes.forEach((checkbox) => {
                checkbox.checked = this.checked;
            });
            refreshSelectionState();
        });
    }

    rowCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', refreshSelectionState);
    });

    const openDeleteModal = ({ mode, form = null, name = '', ids = [] }) => {
        deleteState = { mode, form, name, ids };

        if (mode === 'single') {
            deleteModalTitle.textContent = 'Hapus data BUJK?';
            deleteModalText.innerHTML = `Data <span class="font-semibold text-slate-700">${name}</span> akan dihapus dari daftar aktif. Tindakan ini tidak bisa dibatalkan.`;
        }

        if (mode === 'bulk') {
            deleteModalTitle.textContent = 'Hapus beberapa data BUJK?';
            deleteModalText.innerHTML = `Sebanyak <span class="font-semibold text-slate-700">${ids.length} data</span> terpilih akan dihapus dari daftar aktif. Tindakan ini tidak bisa dibatalkan.`;
        }

        if (mode === 'all') {
            deleteModalTitle.textContent = 'Hapus semua data BUJK?';
            deleteModalText.innerHTML = `Semua <span class="font-semibold text-slate-700">data BUJK aktif</span> akan dihapus. Pastikan kamu benar-benar yakin karena tindakan ini tidak bisa dibatalkan.`;
        }

        confirmDeleteButton.disabled = false;
        confirmDeleteButton.textContent = 'Ya, Hapus';

        showModal(modalElements.delete, null, false);
    };

    deleteSingleTriggers.forEach((button) => {
        button.addEventListener('click', function () {
            openDeleteModal({
                mode: 'single',
                form: this.closest('form'),
                name: this.dataset.deleteName || 'data ini',
            });
        });
    });

    if (bulkDeleteTrigger) {
        bulkDeleteTrigger.addEventListener('click', function () {
            const ids = getSelectedIds();
            if (!ids.length) return;

            openDeleteModal({
                mode: 'bulk',
                ids,
            });
        });
    }

    if (deleteAllTrigger) {
        deleteAllTrigger.addEventListener('click', function () {
            if (this.disabled) return;

            openDeleteModal({
                mode: 'all',
            });
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
                return;
            }
        });
    }

    refreshSelectionState();

    if (!provinceSelect || !kabupatenSelect) return;

    const normalizeText = (value = '') => {
        return String(value).trim().replace(/\s+/g, ' ').toUpperCase();
    };

    const createOption = (value, text, selected = false, dataCode = '') => {
        const option = document.createElement('option');
        option.value = value;
        option.textContent = text;
        option.selected = selected;

        if (dataCode) {
            option.dataset.code = dataCode;
        }

        return option;
    };

    const resetKabupaten = (placeholder = 'Pilih provinsi dulu...') => {
        kabupatenSelect.innerHTML = '';
        kabupatenSelect.appendChild(createOption('', placeholder, true));
        kabupatenSelect.disabled = true;
    };

    const renderProvinces = (items) => {
        provinceSelect.innerHTML = '';
        provinceSelect.appendChild(createOption('', 'Pilih...'));

        let matched = false;

        items.forEach((item) => {
            const value = normalizeText(item.value || item.label || '');
            const label = item.label || item.value || '';
            const code = item.code || '';
            const isSelected = selectedProvince !== '' && normalizeText(selectedProvince) === value;

            if (isSelected) matched = true;

            provinceSelect.appendChild(createOption(value, label, isSelected, code));
        });

        if (selectedProvince && !matched) {
            provinceSelect.appendChild(createOption(selectedProvince, selectedProvince, true));
        }
    };

    const renderRegencies = (items, selectedValue = '') => {
        kabupatenSelect.innerHTML = '';
        kabupatenSelect.appendChild(createOption('', 'Pilih...'));

        let matched = false;

        items.forEach((item) => {
            const value = normalizeText(item.value || item.label || '');
            const label = item.label || item.value || '';
            const isSelected = selectedValue !== '' && normalizeText(selectedValue) === value;

            if (isSelected) matched = true;

            kabupatenSelect.appendChild(createOption(value, label, isSelected, item.code || ''));
        });

        if (selectedValue && !matched) {
            kabupatenSelect.appendChild(createOption(selectedValue, selectedValue, true));
        }

        kabupatenSelect.disabled = false;
    };

    const fetchJson = async (url) => {
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

    const loadRegencies = async (provinceCode, selectedRegency = '') => {
        if (!provinceCode) {
            resetKabupaten('Pilih provinsi dulu...');
            return;
        }

        kabupatenSelect.disabled = true;
        kabupatenSelect.innerHTML = '';
        kabupatenSelect.appendChild(createOption('', 'Memuat kabupaten/kota...', true));

        try {
            const url = `${regenciesEndpoint}?province_code=${encodeURIComponent(provinceCode)}`;
            const payload = await fetchJson(url);
            const items = Array.isArray(payload.data) ? payload.data : [];

            renderRegencies(items, selectedRegency);
        } catch (error) {
            console.error(error);
            resetKabupaten('Gagal memuat kabupaten/kota');
        }
    };

    const loadProvinces = async () => {
        provinceSelect.disabled = true;
        provinceSelect.innerHTML = '';
        provinceSelect.appendChild(createOption('', 'Memuat provinsi...', true));
        resetKabupaten('Pilih provinsi dulu...');

        try {
            const payload = await fetchJson(provincesEndpoint);
            const items = Array.isArray(payload.data) ? payload.data : [];

            renderProvinces(items);
            provinceSelect.disabled = false;

            const selectedOption = provinceSelect.selectedOptions[0];
            const provinceCode = selectedOption ? (selectedOption.dataset.code || '') : '';

            await loadRegencies(provinceCode, selectedKabupaten);
        } catch (error) {
            console.error(error);
            provinceSelect.innerHTML = '';
            provinceSelect.appendChild(createOption('', 'Gagal memuat provinsi', true));
            provinceSelect.disabled = true;
            resetKabupaten('Pilih provinsi dulu...');
        }
    };

    provinceSelect.addEventListener('change', function () {
        const selectedOption = this.selectedOptions[0];
        const provinceCode = selectedOption ? (selectedOption.dataset.code || '') : '';
        loadRegencies(provinceCode, '');
    });

    loadProvinces();
});
</script>
@endpush