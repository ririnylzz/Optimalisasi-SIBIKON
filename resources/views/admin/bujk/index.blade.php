@extends('layouts.admin')

@section('page-title', 'BUJK')
@section('page-subtitle', 'Badan Usaha Jasa Konstruksi')

@section('content')
    <div x-data="bujkPage()" class="space-y-4">
        {{-- Breadcrumb --}}
        <div class="flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <div class="flex items-center gap-2 text-sm text-slate-400">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-white">Home</a>
                    <span>/</span>
                    <span class="font-medium text-slate-200">BUJK</span>
                </div>
                <p class="mt-1 text-sm text-slate-500">
                    Kelola data badan usaha jasa konstruksi
                </p>
            </div>
        </div>

        {{-- Table card --}}
        <div class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900">
            <div class="border-b border-slate-800 bg-slate-900/80 px-5 py-4">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-800 text-indigo-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                      d="M19 11H5m14-4H5m14 8H5m16 6H3a1 1 0 01-1-1V4a1 1 0 011-1h18a1 1 0 011 1v16a1 1 0 01-1 1z"/>
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-white">
                                Daftar Badan Usaha Jasa Konstruksi
                            </h3>
                            <p class="text-sm text-slate-400">
                                Tabel data BUJK dengan filter pencarian
                            </p>
                        </div>
                    </div>

                    <button
                        type="button"
                        class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500 shadow-lg shadow-indigo-500/20"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Data
                    </button>
                </div>
            </div>

            <div class="border-b border-slate-800 px-5 py-4">
                <div class="flex flex-col gap-3 xl:flex-row xl:items-center xl:justify-between">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center">
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input
                                x-model="search"
                                type="text"
                                placeholder="Cari NIB, nama BUJK, alamat, kontak..."
                                class="w-full rounded-lg border border-slate-700 bg-slate-950 py-2.5 pl-10 pr-3 text-sm text-slate-200 outline-none placeholder:text-slate-500 focus:border-indigo-500 md:w-[360px]"
                            >
                        </div>

                        <select
                            x-model.number="perPage"
                            class="rounded-lg border border-slate-700 bg-slate-950 px-3 py-2.5 text-sm text-slate-200 outline-none focus:border-indigo-500"
                        >
                            <option value="5">Tampilkan 5</option>
                            <option value="10">Tampilkan 10</option>
                            <option value="25">Tampilkan 25</option>
                        </select>
                    </div>

                    <div class="text-sm text-slate-400">
                        Total hasil:
                        <span class="font-semibold text-slate-200" x-text="filteredRows.length"></span>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-950/80">
                        <tr class="border-b border-slate-800 text-left text-slate-300">
                            <th class="px-5 py-4 font-semibold">No.</th>
                            <th class="px-5 py-4 font-semibold">NIB</th>
                            <th class="px-5 py-4 font-semibold">Nama BUJK</th>
                            <th class="px-5 py-4 font-semibold">Jenis Usaha</th>
                            <th class="px-5 py-4 font-semibold">Alamat</th>
                            <th class="px-5 py-4 font-semibold">NPWP</th>
                            <th class="px-5 py-4 font-semibold">Kontak</th>
                            <th class="px-5 py-4 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <template x-for="(row, index) in paginatedRows" :key="row.nib">
                            <tr class="border-b border-slate-800/80 text-slate-300 hover:bg-slate-800/30">
                                <td class="px-5 py-4 align-top" x-text="index + 1"></td>
                                <td class="px-5 py-4 align-top font-medium text-slate-200" x-text="row.nib"></td>
                                <td class="px-5 py-4 align-top font-medium text-slate-100" x-text="row.nama_bujk"></td>
                                <td class="px-5 py-4 align-top" x-text="row.jenis_usaha"></td>
                                <td class="px-5 py-4 align-top max-w-[220px]" x-text="row.alamat"></td>
                                <td class="px-5 py-4 align-top" x-text="row.npwp"></td>
                                <td class="px-5 py-4 align-top max-w-[220px]" x-text="row.kontak"></td>
                                <td class="px-5 py-4 align-top">
                                    <div class="flex items-center justify-center gap-2">
                                        <button
                                            type="button"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-amber-500/40 bg-amber-500/10 text-amber-400 transition hover:bg-amber-500/20"
                                            title="Edit"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 113 3L12 14l-4 1 1-4 7.5-7.5z"/>
                                            </svg>
                                        </button>

                                        <button
                                            type="button"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-rose-500/40 bg-rose-500/10 text-rose-400 transition hover:bg-rose-500/20"
                                            title="Hapus"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>

                        <tr x-show="paginatedRows.length === 0">
                            <td colspan="8" class="px-5 py-10 text-center text-slate-500">
                                Tidak ada data yang cocok dengan pencarian.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col gap-3 border-t border-slate-800 px-5 py-4 text-sm text-slate-400 md:flex-row md:items-center md:justify-between">
                <p>
                    Menampilkan
                    <span class="font-semibold text-slate-200" x-text="paginatedRows.length"></span>
                    dari
                    <span class="font-semibold text-slate-200" x-text="filteredRows.length"></span>
                    data
                </p>

                <div class="flex items-center gap-2">
                    <button
                        type="button"
                        @click="prevPage"
                        class="rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-300 transition hover:bg-slate-800"
                    >
                        Sebelumnya
                    </button>
                    <button
                        type="button"
                        @click="nextPage"
                        class="rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-300 transition hover:bg-slate-800"
                    >
                        Selanjutnya
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function bujkPage() {
        return {
            search: '',
            perPage: 10,
            currentPage: 1,
            rows: @json($bujkRows),

            get filteredRows() {
                const keyword = this.search.toLowerCase().trim();

                if (!keyword) return this.rows;

                return this.rows.filter(row =>
                    row.nib.toLowerCase().includes(keyword) ||
                    row.nama_bujk.toLowerCase().includes(keyword) ||
                    row.jenis_usaha.toLowerCase().includes(keyword) ||
                    row.alamat.toLowerCase().includes(keyword) ||
                    row.npwp.toLowerCase().includes(keyword) ||
                    row.kontak.toLowerCase().includes(keyword)
                );
            },

            get paginatedRows() {
                const start = (this.currentPage - 1) * this.perPage;
                return this.filteredRows.slice(start, start + this.perPage);
            },

            nextPage() {
                if ((this.currentPage * this.perPage) < this.filteredRows.length) {
                    this.currentPage++;
                }
            },

            prevPage() {
                if (this.currentPage > 1) {
                    this.currentPage--;
                }
            }
        }
    }
</script>
@endpush