@extends('layouts.app')

@section('content')
<section class="bg-white px-4 py-16 md:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">

        {{-- Header --}}
        <div class="mb-12 text-center">
            <p class="mb-4 text-xs font-bold uppercase tracking-[0.45em] text-slate-400">
                Layanan
            </p>

            <h1 class="text-3xl font-extrabold uppercase text-[#071226] md:text-4xl">
                Penyedia Jasa Konstruksi
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
                        id="penyedia-jasa-per-page"
                        class="rounded-lg border border-[#dfe5ef] bg-white px-3 py-2 text-sm text-slate-600 outline-none focus:border-[#293F81]"
                    >
                        @foreach ($allowedPerPage as $option)
                            <option value="{{ $option }}" @selected((int) $perPage === (int) $option)>
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>

                    <span>entries</span>
                </div>

                <div class="flex items-center gap-3 text-sm text-slate-500">
                    <label for="search-penyedia-jasa">Search:</label>

                    <input
                        id="search-penyedia-jasa"
                        type="text"
                        value="{{ $search }}"
                        autocomplete="off"
                        class="w-full rounded-lg border border-[#dfe5ef] px-4 py-2 text-sm outline-none focus:border-[#293F81] md:w-72"
                    >
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1000px] border-collapse text-left">
                    <thead>
                        <tr class="border-y border-[#dfe5ef] bg-[#f8fafc] text-xs uppercase tracking-wide text-[#071226]">
                            <th class="w-16 px-5 py-5 font-extrabold">No.</th>
                            <th class="px-5 py-5 font-extrabold">Nama</th>
                            <th class="px-5 py-5 font-extrabold">Alamat</th>
                            <th class="w-44 px-5 py-5 font-extrabold">Telp</th>
                            <th class="w-64 px-5 py-5 font-extrabold">Email</th>
                        </tr>
                    </thead>

                    <tbody id="penyedia-jasa-table-body" class="divide-y divide-[#e6ebf2] text-sm text-slate-600">
                        @forelse ($penyediaJasaKonstruksi as $penyedia)
                            <tr class="align-top">
                                <td class="px-5 py-6 font-semibold">
                                    {{ $penyediaJasaKonstruksi->firstItem() + $loop->index }}.
                                </td>

                                <td class="px-5 py-6">
                                    <span class="font-bold leading-7 text-blue-600">
                                        {{ $penyedia->nama_bu ?: '-' }}
                                    </span>
                                </td>

                                <td class="px-5 py-6 leading-7">
                                    {{ $penyedia->alamat ?: '-' }}
                                </td>

                                <td class="px-5 py-6 leading-7">
                                    {{ $penyedia->telepon ?: '-' }}
                                </td>

                                <td class="px-5 py-6 leading-7">
                                    @if (!blank($penyedia->email))
                                        <a
                                            href="mailto:{{ $penyedia->email }}"
                                            class="text-blue-600 hover:underline"
                                        >
                                            {{ $penyedia->email }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-slate-500">
                                    Data penyedia jasa konstruksi belum tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer Table --}}
            <div class="mt-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <p id="penyedia-jasa-info" class="text-sm text-slate-500">
                    @if ($penyediaJasaKonstruksi->total() > 0)
                        Showing {{ $penyediaJasaKonstruksi->firstItem() }}
                        to {{ $penyediaJasaKonstruksi->lastItem() }}
                        of {{ $penyediaJasaKonstruksi->total() }} entries
                    @else
                        Showing 0 to 0 of 0 entries
                    @endif
                </p>

                <div id="penyedia-jasa-pagination" class="flex items-center justify-end gap-1">
                    @if ($penyediaJasaKonstruksi->onFirstPage())
                        <span class="rounded-lg bg-slate-100 px-4 py-3 text-sm font-medium text-slate-400">
                            Previous
                        </span>
                    @else
                        <button
                            type="button"
                            data-page="{{ $penyediaJasaKonstruksi->currentPage() - 1 }}"
                            class="penyedia-page-btn rounded-lg bg-slate-100 px-4 py-3 text-sm font-medium text-slate-500 transition hover:bg-slate-200"
                        >
                            Previous
                        </button>
                    @endif

                    @if ($penyediaJasaKonstruksi->lastPage() <= 7)
                        @foreach ($penyediaJasaKonstruksi->getUrlRange(1, $penyediaJasaKonstruksi->lastPage()) as $page => $url)
                            @if ($page === $penyediaJasaKonstruksi->currentPage())
                                <span class="rounded-lg bg-yellow-400 px-4 py-3 text-sm font-extrabold text-slate-900">
                                    {{ $page }}
                                </span>
                            @else
                                <button
                                    type="button"
                                    data-page="{{ $page }}"
                                    class="penyedia-page-btn rounded-lg bg-slate-100 px-4 py-3 text-sm font-medium text-slate-500 transition hover:bg-slate-200"
                                >
                                    {{ $page }}
                                </button>
                            @endif
                        @endforeach
                    @else
                        @foreach ($penyediaJasaKonstruksi->getUrlRange(1, $penyediaJasaKonstruksi->lastPage()) as $page => $url)
                            @if (
                                $page === 1 ||
                                $page === $penyediaJasaKonstruksi->lastPage() ||
                                abs($page - $penyediaJasaKonstruksi->currentPage()) <= 1
                            )
                                @if ($page === $penyediaJasaKonstruksi->currentPage())
                                    <span class="rounded-lg bg-yellow-400 px-4 py-3 text-sm font-extrabold text-slate-900">
                                        {{ $page }}
                                    </span>
                                @else
                                    <button
                                        type="button"
                                        data-page="{{ $page }}"
                                        class="penyedia-page-btn rounded-lg bg-slate-100 px-4 py-3 text-sm font-medium text-slate-500 transition hover:bg-slate-200"
                                    >
                                        {{ $page }}
                                    </button>
                                @endif
                            @elseif (
                                ($page === 2 && $penyediaJasaKonstruksi->currentPage() > 3) ||
                                ($page === $penyediaJasaKonstruksi->lastPage() - 1 && $penyediaJasaKonstruksi->currentPage() < $penyediaJasaKonstruksi->lastPage() - 2)
                            )
                                <span class="px-2 py-3 text-sm font-medium text-slate-400">
                                    ...
                                </span>
                            @endif
                        @endforeach
                    @endif

                    @if ($penyediaJasaKonstruksi->hasMorePages())
                        <button
                            type="button"
                            data-page="{{ $penyediaJasaKonstruksi->currentPage() + 1 }}"
                            class="penyedia-page-btn rounded-lg bg-slate-100 px-4 py-3 text-sm font-medium text-slate-500 transition hover:bg-slate-200"
                        >
                            Next
                        </button>
                    @else
                        <span class="rounded-lg bg-slate-100 px-4 py-3 text-sm font-medium text-slate-400">
                            Next
                        </span>
                    @endif
                </div>
            </div>

        </div>

    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search-penyedia-jasa');
        const perPageSelect = document.getElementById('penyedia-jasa-per-page');
        const tableBody = document.getElementById('penyedia-jasa-table-body');
        const tableInfo = document.getElementById('penyedia-jasa-info');
        const pagination = document.getElementById('penyedia-jasa-pagination');

        const dataUrl = @json(route('penyedia-jasa.data'));

        let currentPage = 1;
        let searchTimer = null;
        let activeController = null;

        function escapeHtml(value) {
            return String(value ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function buildQueryParams(page = 1) {
            const params = new URLSearchParams();

            params.set('page', page);
            params.set('per_page', perPageSelect.value || '10');
            params.set('search', searchInput.value || '');

            return params;
        }

        function updateBrowserUrl(page = 1) {
            const params = buildQueryParams(page);
            const newUrl = `${window.location.pathname}?${params.toString()}`;

            window.history.replaceState({}, '', newUrl);
        }

        function renderTable(rows) {
            if (!rows.length) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-slate-500">
                            Data penyedia jasa konstruksi belum tersedia.
                        </td>
                    </tr>
                `;
                return;
            }

            tableBody.innerHTML = rows.map(function (row) {
                const email = row.email && row.email !== '-'
                    ? `<a href="mailto:${escapeHtml(row.email)}" class="text-blue-600 hover:underline">${escapeHtml(row.email)}</a>`
                    : '-';

                return `
                    <tr class="align-top">
                        <td class="px-5 py-6 font-semibold">
                            ${escapeHtml(row.no)}.
                        </td>

                        <td class="px-5 py-6">
                            <span class="font-bold leading-7 text-blue-600">
                                ${escapeHtml(row.nama)}
                            </span>
                        </td>

                        <td class="px-5 py-6 leading-7">
                            ${escapeHtml(row.alamat)}
                        </td>

                        <td class="px-5 py-6 leading-7">
                            ${escapeHtml(row.telp)}
                        </td>

                        <td class="px-5 py-6 leading-7">
                            ${email}
                        </td>
                    </tr>
                `;
            }).join('');
        }

        function renderInfo(meta) {
            if (!meta.total || meta.total < 1) {
                tableInfo.textContent = 'Showing 0 to 0 of 0 entries';
                return;
            }

            tableInfo.textContent = `Showing ${meta.from} to ${meta.to} of ${meta.total} entries`;
        }

        function getVisiblePages(current, last) {
            const pages = [];

            if (last <= 7) {
                for (let page = 1; page <= last; page++) {
                    pages.push(page);
                }

                return pages;
            }

            for (let page = 1; page <= last; page++) {
                if (
                    page === 1 ||
                    page === last ||
                    Math.abs(page - current) <= 1
                ) {
                    pages.push(page);
                } else if (
                    (page === 2 && current > 3) ||
                    (page === last - 1 && current < last - 2)
                ) {
                    pages.push('...');
                }
            }

            return pages.filter(function (page, index, array) {
                return page !== '...' || array[index - 1] !== '...';
            });
        }

        function renderPagination(meta) {
            const current = Number(meta.current_page || 1);
            const last = Number(meta.last_page || 1);
            const pages = getVisiblePages(current, last);

            let html = '';

            if (meta.on_first_page) {
                html += `
                    <span class="rounded-lg bg-slate-100 px-4 py-3 text-sm font-medium text-slate-400">
                        Previous
                    </span>
                `;
            } else {
                html += `
                    <button
                        type="button"
                        data-page="${current - 1}"
                        class="penyedia-page-btn rounded-lg bg-slate-100 px-4 py-3 text-sm font-medium text-slate-500 transition hover:bg-slate-200"
                    >
                        Previous
                    </button>
                `;
            }

            pages.forEach(function (page) {
                if (page === '...') {
                    html += `
                        <span class="px-2 py-3 text-sm font-medium text-slate-400">
                            ...
                        </span>
                    `;
                    return;
                }

                if (Number(page) === current) {
                    html += `
                        <span class="rounded-lg bg-yellow-400 px-4 py-3 text-sm font-extrabold text-slate-900">
                            ${page}
                        </span>
                    `;
                } else {
                    html += `
                        <button
                            type="button"
                            data-page="${page}"
                            class="penyedia-page-btn rounded-lg bg-slate-100 px-4 py-3 text-sm font-medium text-slate-500 transition hover:bg-slate-200"
                        >
                            ${page}
                        </button>
                    `;
                }
            });

            if (meta.has_more_pages) {
                html += `
                    <button
                        type="button"
                        data-page="${current + 1}"
                        class="penyedia-page-btn rounded-lg bg-slate-100 px-4 py-3 text-sm font-medium text-slate-500 transition hover:bg-slate-200"
                    >
                        Next
                    </button>
                `;
            } else {
                html += `
                    <span class="rounded-lg bg-slate-100 px-4 py-3 text-sm font-medium text-slate-400">
                        Next
                    </span>
                `;
            }

            pagination.innerHTML = html;
        }

        async function fetchData(page = 1) {
            currentPage = page;

            if (activeController) {
                activeController.abort();
            }

            activeController = new AbortController();

            const params = buildQueryParams(page);

            try {
                const response = await fetch(`${dataUrl}?${params.toString()}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    signal: activeController.signal,
                });

                if (!response.ok) {
                    throw new Error('Gagal mengambil data.');
                }

                const payload = await response.json();

                renderTable(payload.rows || []);
                renderInfo(payload.pagination || {});
                renderPagination(payload.pagination || {});
                updateBrowserUrl(page);
            } catch (error) {
                if (error.name === 'AbortError') {
                    return;
                }

                tableBody.innerHTML = `
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-red-500">
                            Gagal memuat data penyedia jasa konstruksi.
                        </td>
                    </tr>
                `;
            }
        }

        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimer);

            searchTimer = setTimeout(function () {
                fetchData(1);
            }, 200);
        });

        perPageSelect.addEventListener('change', function () {
            fetchData(1);
        });

        pagination.addEventListener('click', function (event) {
            const button = event.target.closest('.penyedia-page-btn');

            if (!button) {
                return;
            }

            const page = Number(button.dataset.page || 1);

            fetchData(page);
        });
    });
</script>
@endsection