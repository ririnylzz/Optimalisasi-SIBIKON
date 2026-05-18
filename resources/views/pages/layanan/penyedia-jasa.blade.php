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
            <form
                id="penyedia-jasa-filter-form"
                action="{{ route('penyedia-jasa') }}"
                method="GET"
                class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between"
            >
                <div class="flex items-center gap-3 text-sm text-slate-500">
                    <span>Show</span>

                    <select
                        name="per_page"
                        class="rounded-lg border border-[#dfe5ef] bg-white px-3 py-2 text-sm text-slate-600 outline-none focus:border-[#293F81]"
                        onchange="document.getElementById('penyedia-jasa-filter-form').submit()"
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
                        name="search"
                        value="{{ $search }}"
                        class="w-full rounded-lg border border-[#dfe5ef] px-4 py-2 text-sm outline-none focus:border-[#293F81] md:w-72"
                    >
                </div>
            </form>

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

                    <tbody class="divide-y divide-[#e6ebf2] text-sm text-slate-600">
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
                <p class="text-sm text-slate-500">
                    @if ($penyediaJasaKonstruksi->total() > 0)
                        Showing {{ $penyediaJasaKonstruksi->firstItem() }}
                        to {{ $penyediaJasaKonstruksi->lastItem() }}
                        of {{ $penyediaJasaKonstruksi->total() }} entries
                    @else
                        Showing 0 to 0 of 0 entries
                    @endif
                </p>

                <div class="flex items-center justify-end gap-1">
                    @if ($penyediaJasaKonstruksi->onFirstPage())
                        <span class="rounded-lg bg-slate-100 px-4 py-3 text-sm font-medium text-slate-400">
                            Previous
                        </span>
                    @else
                        <a
                            href="{{ $penyediaJasaKonstruksi->previousPageUrl() }}"
                            class="rounded-lg bg-slate-100 px-4 py-3 text-sm font-medium text-slate-500 transition hover:bg-slate-200"
                        >
                            Previous
                        </a>
                    @endif

                    @if ($penyediaJasaKonstruksi->lastPage() <= 7)
                        @foreach ($penyediaJasaKonstruksi->getUrlRange(1, $penyediaJasaKonstruksi->lastPage()) as $page => $url)
                            @if ($page === $penyediaJasaKonstruksi->currentPage())
                                <span class="rounded-lg bg-yellow-400 px-4 py-3 text-sm font-extrabold text-slate-900">
                                    {{ $page }}
                                </span>
                            @else
                                <a
                                    href="{{ $url }}"
                                    class="rounded-lg bg-slate-100 px-4 py-3 text-sm font-medium text-slate-500 transition hover:bg-slate-200"
                                >
                                    {{ $page }}
                                </a>
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
                                    <a
                                        href="{{ $url }}"
                                        class="rounded-lg bg-slate-100 px-4 py-3 text-sm font-medium text-slate-500 transition hover:bg-slate-200"
                                    >
                                        {{ $page }}
                                    </a>
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
                        <a
                            href="{{ $penyediaJasaKonstruksi->nextPageUrl() }}"
                            class="rounded-lg bg-slate-100 px-4 py-3 text-sm font-medium text-slate-500 transition hover:bg-slate-200"
                        >
                            Next
                        </a>
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
        const form = document.getElementById('penyedia-jasa-filter-form');
        const searchInput = document.getElementById('search-penyedia-jasa');

        if (!form || !searchInput) {
            return;
        }

        let searchTimer = null;

        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimer);

            searchTimer = setTimeout(function () {
                form.submit();
            }, 500);
        });
    });
</script>
@endsection