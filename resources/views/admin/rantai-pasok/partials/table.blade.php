<div class="mt-4 rounded-2xl border border-slate-200 bg-white">
    <div class="flex flex-col gap-3 border-b border-slate-200 px-4 py-3 lg:flex-row lg:items-center lg:justify-between">
        <label class="inline-flex items-center gap-3 text-sm font-semibold text-slate-700">
            <input
                id="select-all-rows"
                type="checkbox"
                class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
            <span>Pilih semua data di halaman ini</span>
        </label>

        <div class="flex flex-wrap items-center gap-2">
            <button
                type="button"
                id="bulk-delete-trigger"
                disabled
                class="rounded-xl border border-rose-100 px-4 py-2.5 text-xs font-semibold text-rose-300 transition">
                Hapus Terpilih
            </button>

            <button
                type="button"
                id="delete-all-trigger"
                class="rounded-xl border border-rose-200 px-4 py-2.5 text-xs font-semibold text-rose-600 transition hover:border-rose-300 hover:bg-rose-50">
                Hapus Semua
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
            <thead class="bg-slate-50 text-slate-500">
                <tr>
                    <th class="w-12 px-4 py-3"></th>
                    <th class="px-4 py-3 font-semibold">No.</th>
                    <th class="px-4 py-3 font-semibold">Nama</th>
                    <th class="px-4 py-3 font-semibold">Bidang Usaha</th>
                    <th class="px-4 py-3 font-semibold">Alamat</th>
                    <th class="px-4 py-3 font-semibold">Wilayah</th>
                    <th class="px-4 py-3 font-semibold">Kontak</th>
                    <th class="px-4 py-3 text-right font-semibold">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100 bg-white text-slate-700">
                @forelse($rantaiPasoks as $rantaiPasok)
                <tr class="transition hover:bg-slate-50">
                    <td class="px-4 py-3 align-top">
                        <input
                            type="checkbox"
                            data-row-checkbox
                            value="{{ $rantaiPasok->id }}"
                            class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    </td>

                    <td class="px-4 py-3 align-top text-slate-500">
                        {{ $rantaiPasoks->firstItem() + $loop->index }}
                    </td>

                    <td class="px-4 py-3 align-top">
                        <p class="max-w-[220px] font-bold uppercase leading-5 text-slate-900">
                            {{ $rantaiPasok->nama ?: '-' }}
                        </p>
                    </td>

                    <td class="px-4 py-3 align-top">
                        @if($rantaiPasok->bidang_usaha)
                        <span class="inline-flex rounded-full border border-indigo-100 bg-indigo-50 px-2.5 py-1 text-xs font-semibold text-indigo-700">
                            {{ $rantaiPasok->bidang_usaha }}
                        </span>
                        @else
                        <span>-</span>
                        @endif
                    </td>

                    <td class="px-4 py-3 align-top">
                        <p class="max-w-[220px] leading-5 text-slate-600">
                            {{ $rantaiPasok->alamat ?: '-' }}
                        </p>
                    </td>

                    <td class="px-4 py-3 align-top">
                        <p>{{ $rantaiPasok->kabupaten ?: '-' }}</p>
                        <p class="mt-1 text-slate-400">{{ $rantaiPasok->provinsi ?: '-' }}</p>
                    </td>

                    <td class="px-4 py-3 align-top">
                        <div class="max-w-[240px] leading-5 text-slate-600">
                            <p>{{ $rantaiPasok->kontak ?: '-' }}</p>
                        </div>
                    </td>

                    <td class="px-4 py-3 align-top">
                        <div class="flex justify-end gap-2">
                            <a
                                href="{{ route('admin.rantai-pasok', array_merge(request()->query(), ['edit' => $rantaiPasok->id, 'panel' => 'manual'])) }}"
                                class="rounded-lg border border-amber-200 px-3 py-1.5 text-xs font-semibold text-amber-600 transition hover:bg-amber-50">
                                Edit
                            </a>

                            <form action="{{ route('admin.rantai-pasok.destroy', $rantaiPasok) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button
                                    type="button"
                                    data-delete-single
                                    data-delete-name="{{ $rantaiPasok->nama ?: 'data ini' }}"
                                    class="rounded-lg border border-rose-200 px-3 py-1.5 text-xs font-semibold text-rose-600 transition hover:bg-rose-50">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-12 text-center">
                        <p class="text-sm font-semibold text-slate-700">Belum ada data Rantai Pasok.</p>
                        <p class="mt-1 text-xs text-slate-500">Tambahkan data manual atau import melalui file CSV/XLSX.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex flex-col gap-4 border-t border-slate-100 px-4 py-4 text-xs text-slate-500 lg:flex-row lg:items-center lg:justify-between">
        <div>
            @if($rantaiPasoks->total() > 0)
            Menampilkan {{ $rantaiPasoks->firstItem() }} - {{ $rantaiPasoks->lastItem() }} dari {{ $rantaiPasoks->total() }} data.
            @else
            Menampilkan 0 data.
            @endif
        </div>

        @if($rantaiPasoks->hasPages())
        <nav class="rantai-pagination flex flex-wrap items-center justify-end gap-2" aria-label="Pagination">
            {{-- Previous --}}
            @if($rantaiPasoks->onFirstPage())
            <span class="inline-flex h-10 min-w-[96px] cursor-not-allowed items-center justify-center rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-400">
                « Previous
            </span>
            @else
            <a
                href="{{ $rantaiPasoks->previousPageUrl() }}"
                class="inline-flex h-10 min-w-[96px] items-center justify-center rounded-xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-500 shadow-sm transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-600">
                « Previous
            </a>
            @endif

            {{-- Page Numbers --}}
            @foreach($rantaiPasoks->getUrlRange(1, $rantaiPasoks->lastPage()) as $page => $url)
            @php
            $current = $rantaiPasoks->currentPage();
            $last = $rantaiPasoks->lastPage();

            $shouldShow =
            $page === 1 ||
            $page === 2 ||
            $page === $last ||
            $page === $current ||
            $page === $current - 1 ||
            $page === $current + 1;

            $shouldShowLeftDots = $page === 3 && $current > 4;
            $shouldShowRightDots = $page === $current + 2 && $page < $last - 1;
                @endphp

                @if($shouldShowLeftDots)
                <span class="inline-flex h-10 min-w-10 items-center justify-center px-2 text-sm font-semibold text-slate-400">
                ...
                </span>
                @endif

                @if($shouldShow)
                @if($page === $current)
                <span class="inline-flex h-10 min-w-10 items-center justify-center rounded-xl bg-indigo-600 px-4 text-sm font-bold text-white shadow-sm">
                    {{ $page }}
                </span>
                @else
                <a
                    href="{{ $url }}"
                    class="inline-flex h-10 min-w-10 items-center justify-center rounded-xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-600">
                    {{ $page }}
                </a>
                @endif
                @endif

                @if($shouldShowRightDots)
                <span class="inline-flex h-10 min-w-10 items-center justify-center px-2 text-sm font-semibold text-slate-400">
                    ...
                </span>
                @endif
                @endforeach

                {{-- Next --}}
                @if($rantaiPasoks->hasMorePages())
                <a
                    href="{{ $rantaiPasoks->nextPageUrl() }}"
                    class="inline-flex h-10 min-w-[80px] items-center justify-center rounded-xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-600">
                    Next »
                </a>
                @else
                <span class="inline-flex h-10 min-w-[80px] cursor-not-allowed items-center justify-center rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-400">
                    Next »
                </span>
                @endif
        </nav>
        @endif
    </div>
</div>