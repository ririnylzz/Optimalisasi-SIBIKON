@extends('layouts.app')

@section('content')
<section class="bg-white px-4 py-16 md:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">

        {{-- Header --}}
        <div class="mb-12 text-center">
            <p class="mb-4 text-xs font-bold uppercase tracking-[0.45em] text-slate-400">
                Masyarakat Konstruksi
            </p>

            <h1 class="text-3xl font-extrabold uppercase text-[#071226] md:text-4xl">
                Asosiasi Profesi
            </h1>

            <span class="mx-auto mt-5 block h-1.5 w-40 rounded-full bg-yellow-400"></span>
        </div>

        {{-- Table Card --}}
        <div class="rounded-[24px] border border-[#dfe5ef] bg-white p-6 shadow-[0_12px_35px_rgba(15,23,42,0.08)]">

            {{-- Table Controls --}}
            <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-3 text-sm text-slate-500">
                    <span>Show</span>

                    <select
                        id="entries-select"
                        class="rounded-lg border border-[#dfe5ef] bg-white px-3 py-2 text-sm text-slate-600 outline-none focus:border-[#293F81]">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>

                    <span>entries</span>
                </div>

                <div class="flex items-center gap-3 text-sm text-slate-500">
                    <label for="search-input">Search:</label>

                    <input
                        id="search-input"
                        type="text"
                        class="w-full rounded-lg border border-[#dfe5ef] px-4 py-2 text-sm outline-none focus:border-[#293F81] md:w-72">
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1100px] border-collapse text-left">
                    <thead>
                        <tr class="border-y border-[#dfe5ef] bg-[#f8fafc] text-xs uppercase tracking-wide text-[#071226]">
                            <th class="w-16 px-5 py-5 font-extrabold">No.</th>
                            <th class="px-5 py-5 font-extrabold">Nama Asosiasi</th>
                            <th class="w-40 px-5 py-5 font-extrabold">Singkatan</th>
                            <th class="px-5 py-5 font-extrabold">Alamat</th>
                            <th class="w-44 px-5 py-5 font-extrabold">Telepon</th>
                            <th class="w-64 px-5 py-5 font-extrabold">Email</th>
                        </tr>
                    </thead>

                    <tbody id="asosiasi-table-body" class="divide-y divide-[#e6ebf2] text-sm text-slate-600">
                        @forelse ($asosiasiProfesi ?? [] as $asosiasi)
                            <tr class="asosiasi-row align-top">
                                <td class="px-5 py-6 font-semibold text-slate-600">
                                    {{ $loop->iteration }}.
                                </td>

                                <td class="px-5 py-6">
                                    <span class="font-bold leading-7 text-blue-600">
                                        {{ data_get($asosiasi, 'nama_asosiasi') }}
                                    </span>
                                </td>

                                <td class="px-5 py-6 font-bold uppercase text-slate-600">
                                    {{ data_get($asosiasi, 'singkatan') }}
                                </td>

                                <td class="px-5 py-6 leading-7">
                                    {{ data_get($asosiasi, 'alamat') }}
                                </td>

                                <td class="px-5 py-6 leading-7">
                                    {{ data_get($asosiasi, 'telepon') }}
                                </td>

                                <td class="px-5 py-6 leading-7">
                                    {{ data_get($asosiasi, 'email') }}
                                </td>
                            </tr>
                        @empty
                            <tr id="empty-row">
                                <td colspan="6" class="px-5 py-10 text-center text-slate-500">
                                    Data asosiasi profesi belum tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer Table --}}
            <div class="mt-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <p id="table-info" class="text-sm text-slate-500">
                    Showing 0 to 0 of 0 entries
                </p>

                <div class="flex items-center justify-end gap-1">
                    <button
                        class="rounded-lg bg-slate-100 px-4 py-3 text-sm font-medium text-slate-500">
                        Previous
                    </button>

                    <button
                        class="rounded-lg bg-yellow-400 px-4 py-3 text-sm font-extrabold text-slate-900">
                        1
                    </button>

                    <button
                        class="rounded-lg bg-slate-100 px-4 py-3 text-sm font-medium text-slate-500">
                        Next
                    </button>
                </div>
            </div>

        </div>

    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search-input');
        const tableInfo = document.getElementById('table-info');
        const rows = Array.from(document.querySelectorAll('.asosiasi-row'));
        const emptyRow = document.getElementById('empty-row');

        function updateTableInfo(visibleRows) {
            if (rows.length === 0) {
                tableInfo.textContent = 'Showing 0 to 0 of 0 entries';
                return;
            }

            const visibleCount = visibleRows.length;

            if (visibleCount === 0) {
                tableInfo.textContent = `Showing 0 to 0 of ${rows.length} entries`;
            } else {
                tableInfo.textContent = `Showing 1 to ${visibleCount} of ${rows.length} entries`;
            }
        }

        function filterTable() {
            const keyword = searchInput.value.toLowerCase();

            const visibleRows = rows.filter(function (row) {
                const rowText = row.textContent.toLowerCase();
                const isMatch = rowText.includes(keyword);

                row.classList.toggle('hidden', !isMatch);

                return isMatch;
            });

            if (emptyRow) {
                emptyRow.classList.toggle('hidden', rows.length !== 0);
            }

            updateTableInfo(visibleRows);
        }

        filterTable();

        searchInput.addEventListener('input', filterTable);
    });
</script>
@endpush