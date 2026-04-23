@extends('layouts.admin')

@section('page-title', 'Daftar Badan Usaha Jasa Konstruksi')
@section('page-subtitle', 'Upload CSV/XLSX, input manual, dan tampilkan data BUJK sesuai kebutuhan admin')

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
        $availableKabupaten = collect($regions[$selectedProvince] ?? []);

        if ($selectedKabupaten && !$availableKabupaten->contains($selectedKabupaten)) {
            $availableKabupaten->push($selectedKabupaten);
        }

        $importSummary = session('import_summary');
    @endphp

    <div class="space-y-4">
        <div>
            <div class="flex items-center gap-2 text-sm text-slate-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-white">Home</a>
                <span>/</span>
                <span class="font-medium text-slate-200">Masyarakat Jasa Konstruksi</span>
                <span>/</span>
                <span class="font-medium text-slate-200">BUJK</span>
            </div>
            <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-400">
                Halaman ini dipakai untuk upload file CSV/XLSX dan input manual data BUJK. Struktur data mengikuti
                tampilan tabel dan form seperti contoh desain SIBIKON, dengan fokus utama pada fungsi import yang jalan.
            </p>
        </div>

        @if(session('success'))
            <div class="rounded-2xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        @if($importSummary)
            <div class="rounded-2xl border border-sky-500/30 bg-sky-500/10 p-4 text-sm text-sky-100">
                <div class="flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
                    <div>
                        <h3 class="text-base font-semibold text-white">Ringkasan Import File</h3>
                        <p class="mt-1 text-slate-200">
                            File: <span class="font-semibold">{{ $importSummary['filename'] ?? '-' }}</span>
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-2 text-xs md:grid-cols-3 xl:grid-cols-6">
                        <div class="rounded-xl border border-white/10 bg-slate-950/40 px-3 py-2">
                            <p class="text-slate-400">Baris terbaca</p>
                            <p class="mt-1 text-lg font-bold text-white">{{ $importSummary['total_rows'] ?? 0 }}</p>
                        </div>
                        <div class="rounded-xl border border-white/10 bg-slate-950/40 px-3 py-2">
                            <p class="text-slate-400">Siap simpan</p>
                            <p class="mt-1 text-lg font-bold text-white">{{ $importSummary['prepared_rows'] ?? 0 }}</p>
                        </div>
                        <div class="rounded-xl border border-white/10 bg-slate-950/40 px-3 py-2">
                            <p class="text-slate-400">Data baru</p>
                            <p class="mt-1 text-lg font-bold text-emerald-300">{{ $importSummary['created'] ?? 0 }}</p>
                        </div>
                        <div class="rounded-xl border border-white/10 bg-slate-950/40 px-3 py-2">
                            <p class="text-slate-400">Data update</p>
                            <p class="mt-1 text-lg font-bold text-amber-300">{{ $importSummary['updated'] ?? 0 }}</p>
                        </div>
                        <div class="rounded-xl border border-white/10 bg-slate-950/40 px-3 py-2">
                            <p class="text-slate-400">Merge internal</p>
                            <p class="mt-1 text-lg font-bold text-sky-300">{{ $importSummary['merged_rows'] ?? 0 }}</p>
                        </div>
                        <div class="rounded-xl border border-white/10 bg-slate-950/40 px-3 py-2">
                            <p class="text-slate-400">Baris skip</p>
                            <p class="mt-1 text-lg font-bold text-rose-300">{{ $importSummary['skipped'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                @if(!empty($importSummary['errors']))
                    <div class="mt-4 rounded-xl border border-rose-500/20 bg-rose-500/10 p-3 text-xs text-rose-100">
                        <p class="font-semibold">Contoh error validasi saat import:</p>
                        <ul class="mt-2 space-y-1">
                            @foreach($importSummary['errors'] as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        @endif

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-slate-800 bg-slate-900 p-4">
                <p class="text-sm text-slate-400">Total Data Aktif</p>
                <p class="mt-2 text-3xl font-bold text-white">{{ number_format($stats['total_data']) }}</p>
                <p class="mt-2 text-xs text-slate-500">Data BUJK yang tampil di tabel aktif</p>
            </div>
            <div class="rounded-2xl border border-slate-800 bg-slate-900 p-4">
                <p class="text-sm text-slate-400">Data dengan Email</p>
                <p class="mt-2 text-3xl font-bold text-white">{{ number_format($stats['total_email']) }}</p>
                <p class="mt-2 text-xs text-slate-500">Siap dipakai untuk kontak lanjutan</p>
            </div>
            <div class="rounded-2xl border border-slate-800 bg-slate-900 p-4">
                <p class="text-sm text-slate-400">Data dengan Website</p>
                <p class="mt-2 text-3xl font-bold text-white">{{ number_format($stats['total_website']) }}</p>
                <p class="mt-2 text-xs text-slate-500">Menunjukkan BUJK yang punya situs web</p>
            </div>
            <div class="rounded-2xl border border-slate-800 bg-slate-900 p-4">
                <p class="text-sm text-slate-400">Hasil Filter Saat Ini</p>
                <p class="mt-2 text-3xl font-bold text-white">{{ number_format($stats['hasil_filter']) }}</p>
                <p class="mt-2 text-xs text-slate-500">Mengikuti keyword, jenis usaha, dan pagination</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 xl:grid-cols-5">
            <div id="upload-bujk" class="rounded-2xl border border-slate-800 bg-slate-900 p-4 xl:col-span-2">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-bold text-white">Import CSV / XLSX</h3>
                        <p class="mt-1 text-sm text-slate-400">
                            Mendukung template sederhana BUJK maupun file XLSX sumber data yang punya kolom seperti
                            <span class="font-medium text-slate-200">nib</span>,
                            <span class="font-medium text-slate-200">nama_bu</span>,
                            <span class="font-medium text-slate-200">alamat</span>,
                            <span class="font-medium text-slate-200">telepon</span>,
                            <span class="font-medium text-slate-200">email</span>,
                            <span class="font-medium text-slate-200">propinsi</span>,
                            <span class="font-medium text-slate-200">kabupaten</span>, dan
                            <span class="font-medium text-slate-200">jenis_usaha</span>.
                        </p>
                    </div>

                    <a href="{{ asset('templates/bujk-template.csv') }}"
                       class="rounded-lg border border-slate-700 px-3 py-2 text-xs font-medium text-slate-200 transition hover:border-indigo-500 hover:text-white">
                        Download Template
                    </a>
                </div>

                <form action="{{ route('admin.bujk.import') }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-4">
                    @csrf

                    <div>
                        <label for="file_import" class="mb-2 block text-sm font-medium text-slate-200">File upload</label>
                        <input id="file_import" type="file" name="file_import" accept=".csv,.txt,.xlsx"
                               class="block w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-sm text-slate-200 file:mr-3 file:rounded-md file:border-0 file:bg-indigo-600 file:px-3 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-indigo-500" />
                        @error('file_import')
                            <p class="mt-2 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="rounded-xl border border-slate-800 bg-slate-950/70 p-3 text-xs leading-6 text-slate-400">
                        <p class="font-semibold text-slate-200">Aturan import:</p>
                        <p>1. File yang didukung: <span class="text-white">CSV</span> dan <span class="text-white">XLSX</span>.</p>
                        <p>2. Header bisa dari template sederhana atau dari file sumber mentah yang punya alias kolom BUJK.</p>
                        <p>3. Data dengan NIB sama akan digabung dan di-update, bukan ditambahkan duplikat baru.</p>
                        <p>4. Jika satu BUJK muncul berkali-kali di file karena subklasifikasi berbeda, service akan merge menjadi satu record BUJK.</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="submit"
                                class="rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500">
                            Proses Import
                        </button>
                        <span class="text-xs text-slate-500">Maksimal 20 MB per file</span>
                    </div>
                </form>
            </div>

            <div id="form-bujk" class="rounded-2xl border border-slate-800 bg-slate-900 p-4 xl:col-span-3">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-white">{{ $isEditing ? 'Ubah Data BUJK' : 'Form BUJK' }}</h3>
                        <p class="mt-1 text-sm text-slate-400">
                            Field disesuaikan dengan form pada desain: NIB, nama BUJK, jenis usaha, alamat, provinsi,
                            kabupaten/kota, NPWP, email, nomor telepon, dan website.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.bujk') }}#form-bujk"
                           class="rounded-xl border border-slate-700 px-4 py-2 text-sm font-medium text-slate-200 transition hover:border-indigo-500 hover:text-white">
                            Tambah Baru
                        </a>
                        @if($isEditing)
                            <a href="{{ route('admin.bujk') }}"
                               class="rounded-xl border border-rose-500/40 px-4 py-2 text-sm font-medium text-rose-200 transition hover:bg-rose-500/10">
                                Batal Edit
                            </a>
                        @endif
                    </div>
                </div>

                @if($errors->any() && !$errors->has('file_import'))
                    <div class="mt-4 rounded-xl border border-rose-500/30 bg-rose-500/10 px-4 py-3 text-sm text-rose-100">
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

                <form action="{{ $isEditing ? route('admin.bujk.update', $editingBujk) : route('admin.bujk.store') }}"
                      method="POST"
                      class="mt-5 space-y-5">
                    @csrf
                    @if($isEditing)
                        @method('PUT')
                    @endif

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label for="nib" class="mb-2 block text-sm font-medium text-slate-200">NIB</label>
                            <input id="nib" type="text" name="nib" value="{{ old('nib', $editingBujk?->nib) }}"
                                   placeholder="NIB Perusahaan"
                                   class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-sm text-slate-100 outline-none transition focus:border-indigo-500" />
                            @error('nib')
                                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nama_bujk" class="mb-2 block text-sm font-medium text-slate-200">Nama BUJK</label>
                            <input id="nama_bujk" type="text" name="nama_bujk" value="{{ old('nama_bujk', $editingBujk?->nama_bujk) }}"
                                   placeholder="Nama BUJK"
                                   class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-sm text-slate-100 outline-none transition focus:border-indigo-500" />
                            @error('nama_bujk')
                                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-200">Jenis Usaha</label>
                        <div class="grid gap-2 sm:grid-cols-2">
                            @foreach($jenisOptions as $jenis)
                                <label class="flex items-center gap-3 rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-sm text-slate-200">
                                    <input type="checkbox" name="jenis_bujk[]" value="{{ $jenis }}"
                                           {{ in_array($jenis, $selectedJenis, true) ? 'checked' : '' }}
                                           class="h-4 w-4 rounded border-slate-600 bg-slate-900 text-indigo-500 focus:ring-indigo-500" />
                                    <span>{{ $jenis }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('jenis_bujk')
                            <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="alamat_bujk" class="mb-2 block text-sm font-medium text-slate-200">Alamat</label>
                        <textarea id="alamat_bujk" name="alamat_bujk" rows="3" placeholder="Alamat BUJK"
                                  class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-sm text-slate-100 outline-none transition focus:border-indigo-500">{{ old('alamat_bujk', $editingBujk?->alamat_bujk) }}</textarea>
                        @error('alamat_bujk')
                            <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
                        <div>
                            <label for="provinsi_bujk" class="mb-2 block text-sm font-medium text-slate-200">Provinsi</label>
                            <select id="provinsi_bujk" name="provinsi_bujk"
                                    class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-sm text-slate-100 outline-none transition focus:border-indigo-500">
                                <option value="">Pilih...</option>
                                @foreach($regions as $province => $kabupatenList)
                                    <option value="{{ $province }}" @selected($selectedProvince === $province)>{{ $province }}</option>
                                @endforeach
                            </select>
                            @error('provinsi_bujk')
                                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="kab_kota_bujk" class="mb-2 block text-sm font-medium text-slate-200">Kabupaten / Kota</label>
                            <select id="kab_kota_bujk" name="kab_kota_bujk"
                                    class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-sm text-slate-100 outline-none transition focus:border-indigo-500">
                                <option value="">Pilih...</option>
                                @foreach($availableKabupaten as $kabupaten)
                                    <option value="{{ $kabupaten }}" @selected($selectedKabupaten === $kabupaten)>{{ $kabupaten }}</option>
                                @endforeach
                            </select>
                            @error('kab_kota_bujk')
                                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="npwp_bujk" class="mb-2 block text-sm font-medium text-slate-200">NPWP</label>
                            <input id="npwp_bujk" type="text" name="npwp_bujk" value="{{ old('npwp_bujk', $editingBujk?->npwp_bujk) }}"
                                   placeholder="NPWP BUJK"
                                   class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-sm text-slate-100 outline-none transition focus:border-indigo-500" />
                            @error('npwp_bujk')
                                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
                        <div>
                            <label for="email_bujk" class="mb-2 block text-sm font-medium text-slate-200">Email</label>
                            <input id="email_bujk" type="email" name="email_bujk" value="{{ old('email_bujk', $editingBujk?->email_bujk) }}"
                                   placeholder="Email BUJK"
                                   class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-sm text-slate-100 outline-none transition focus:border-indigo-500" />
                            @error('email_bujk')
                                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="telp_bujk" class="mb-2 block text-sm font-medium text-slate-200">No. Telp</label>
                            <input id="telp_bujk" type="text" name="telp_bujk" value="{{ old('telp_bujk', $editingBujk?->telp_bujk) }}"
                                   placeholder="Nomor Telepon"
                                   class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-sm text-slate-100 outline-none transition focus:border-indigo-500" />
                            @error('telp_bujk')
                                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="website_bujk" class="mb-2 block text-sm font-medium text-slate-200">Website</label>
                            <input id="website_bujk" type="text" name="website_bujk" value="{{ old('website_bujk', $editingBujk?->website_bujk) }}"
                                   placeholder="Website"
                                   class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-sm text-slate-100 outline-none transition focus:border-indigo-500" />
                            @error('website_bujk')
                                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 pt-2">
                        <button type="submit"
                                class="rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500">
                            {{ $isEditing ? 'Update Data' : 'Simpan Data' }}
                        </button>
                        @if($isEditing)
                            <span class="text-xs text-slate-500">Sedang mengubah data: {{ $editingBujk->nama_bujk }}</span>
                        @else
                            <span class="text-xs text-slate-500">Data manual akan langsung masuk ke tabel BUJK aktif.</span>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-800 bg-slate-900 p-4">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <h3 class="text-lg font-bold text-white">Tabel Data BUJK</h3>
                    <p class="mt-1 text-sm text-slate-400">
                        Format kolom menyesuaikan desain: NIB, nama BUJK, jenis usaha, alamat, NPWP, kontak, dan aksi.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('admin.bujk') }}#form-bujk"
                       class="rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500">
                        Tambah Data
                    </a>
                    <a href="#upload-bujk"
                       class="rounded-xl border border-slate-700 px-4 py-2.5 text-sm font-medium text-slate-200 transition hover:border-indigo-500 hover:text-white">
                        Upload File
                    </a>
                </div>
            </div>

            <form method="GET" action="{{ route('admin.bujk') }}" class="mt-4 grid grid-cols-1 gap-3 lg:grid-cols-4">
                <div class="lg:col-span-2">
                    <label for="search" class="mb-2 block text-sm font-medium text-slate-300">Filter / keyword</label>
                    <input id="search" type="text" name="search" value="{{ $search }}"
                           placeholder="Cari NIB, nama BUJK, alamat, NPWP, email, atau kontak"
                           class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-sm text-slate-100 outline-none transition focus:border-indigo-500" />
                </div>

                <div>
                    <label for="jenis" class="mb-2 block text-sm font-medium text-slate-300">Jenis usaha</label>
                    <select id="jenis" name="jenis"
                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-sm text-slate-100 outline-none transition focus:border-indigo-500">
                        <option value="">Semua jenis</option>
                        @foreach($jenisOptions as $jenis)
                            <option value="{{ $jenis }}" @selected($jenisFilter === $jenis)>{{ $jenis }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="per_page" class="mb-2 block text-sm font-medium text-slate-300">Show</label>
                    <select id="per_page" name="per_page"
                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-sm text-slate-100 outline-none transition focus:border-indigo-500">
                        @foreach([10, 25, 50, 100] as $size)
                            <option value="{{ $size }}" @selected($perPage === $size)>{{ $size }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-wrap items-center gap-2 lg:col-span-4">
                    <button type="submit"
                            class="rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500">
                        Terapkan Filter
                    </button>
                    <a href="{{ route('admin.bujk') }}"
                       class="rounded-xl border border-slate-700 px-4 py-2.5 text-sm font-medium text-slate-200 transition hover:border-slate-500 hover:text-white">
                        Reset
                    </a>
                </div>
            </form>

            <div class="mt-4 overflow-hidden rounded-2xl border border-slate-800">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-800 text-sm">
                        <thead class="bg-slate-950/80 text-left text-xs uppercase tracking-wider text-slate-400">
                            <tr>
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
                                                <span class="rounded-full bg-indigo-500/10 px-3 py-1 text-xs font-medium text-indigo-300">{{ $jenis }}</span>
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
                                                    <a href="{{ $item->website_url }}" target="_blank" class="text-sky-300 hover:text-sky-200">
                                                        {{ $item->website_bujk }}
                                                    </a>
                                                </p>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.bujk', array_merge(request()->query(), ['edit' => $item->id])) }}#form-bujk"
                                               class="inline-flex items-center justify-center rounded-lg border border-amber-400/40 px-3 py-2 text-xs font-semibold text-amber-300 transition hover:bg-amber-500/10">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.bujk.destroy', $item) }}" method="POST"
                                                  onsubmit="return confirm('Hapus data BUJK ini dari daftar aktif?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center justify-center rounded-lg border border-rose-400/40 px-3 py-2 text-xs font-semibold text-rose-300 transition hover:bg-rose-500/10">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-8 text-center text-sm text-slate-500">
                                        Belum ada data BUJK yang tampil. Coba upload file atau tambahkan data manual.
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

    <div
        id="bujk-script-data"
        class="hidden"
        data-regions='@json($regions)'
        data-preserved='@json($selectedKabupaten)'>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const provinceSelect = document.getElementById('provinsi_bujk');
            const kabupatenSelect = document.getElementById('kab_kota_bujk');
            const scriptData = document.getElementById('bujk-script-data');

            if (!provinceSelect || !kabupatenSelect || !scriptData) {
                return;
            }

            const regions = JSON.parse(scriptData.dataset.regions || '{}');
            const preservedValue = JSON.parse(scriptData.dataset.preserved || '""');

            const renderKabupaten = (province, selected = '') => {
                const options = regions[province] || [];
                const currentOptions = new Set(options);

                kabupatenSelect.innerHTML = '<option value="">Pilih...</option>';

                if (selected && !currentOptions.has(selected)) {
                    currentOptions.add(selected);
                }

                [...currentOptions].forEach((item) => {
                    const option = document.createElement('option');
                    option.value = item;
                    option.textContent = item;
                    option.selected = selected === item;
                    kabupatenSelect.appendChild(option);
                });
            };

            renderKabupaten(provinceSelect.value, preservedValue || '');

            provinceSelect.addEventListener('change', function () {
                renderKabupaten(this.value, '');
            });
        });
    </script>
@endpush