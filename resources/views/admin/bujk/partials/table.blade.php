<div class="mt-4 flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm">
    <label class="inline-flex items-center gap-3 text-xs font-medium text-slate-700">
        <input
            type="checkbox"
            id="select-all-rows"
            class="h-4 w-4 rounded border-slate-300 bg-white text-indigo-600 focus:ring-indigo-500">
        <span>Pilih semua data di halaman ini</span>
    </label>

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
            {{ ($bujks->total() ?? 0) < 1 ? 'disabled' : '' }}
            class="{{ ($bujks->total() ?? 0) < 1
                ? 'cursor-not-allowed border border-rose-100 bg-white text-rose-300/60'
                : 'border border-rose-200 bg-white text-rose-600 hover:border-rose-300 hover:bg-rose-50' }} rounded-xl px-4 py-2 text-xs font-semibold transition">
            Hapus Semua
        </button>
    </div>
</div>

<div class="mt-5 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200 text-xs">
            <thead class="bg-slate-50 text-left text-[11px] uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="w-12 px-4 py-3">
                        <span class="sr-only">Pilih</span>
                    </th>
                    <th class="px-4 py-3">No.</th>
                    <th class="px-4 py-3">NIB</th>
                    <th class="px-4 py-3">Nama BUJK</th>
                    <th class="px-4 py-3">Jenis Usaha</th>
                    <th class="px-4 py-3">Tanggal Terbaru</th>
                    <th class="px-4 py-3">Alamat</th>
                    <th class="px-4 py-3">NPWP</th>
                    <th class="px-4 py-3">Kontak</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse($bujks as $item)
                <tr class="align-top text-slate-700 transition hover:bg-slate-50/80">
                    <td class="px-4 py-3">
                        <input
                            type="checkbox"
                            value="{{ $item->id }}"
                            data-row-checkbox
                            class="h-4 w-4 rounded border-slate-300 bg-white text-indigo-600 focus:ring-indigo-500">
                    </td>
                    <td class="whitespace-nowrap px-4 py-3 text-slate-500">{{ $bujks->firstItem() + $loop->index }}.</td>
                    <td class="whitespace-nowrap px-4 py-3 font-medium text-slate-700">{{ $item->nib }}</td>
                    <td class="px-4 py-3">
                        <p class="font-semibold text-slate-900">{{ $item->nama_bujk }}</p>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex flex-wrap gap-1.5">
                            @forelse($item->jenis_bujk_list as $jenis)
                            <span class="rounded-full bg-indigo-50 px-2.5 py-1 text-[11px] font-medium text-indigo-700 ring-1 ring-indigo-100">
                                {{ $jenis }}
                            </span>
                            @empty
                            <span class="text-slate-400">-</span>
                            @endforelse
                        </div>
                    </td>
                    <td class="whitespace-nowrap px-4 py-3 text-slate-600">
                        {{ $item->tgl_update ? \Illuminate\Support\Carbon::parse($item->tgl_update)->format('m/d/y') : '-' }}
                    </td>
                    <td class="max-w-xs px-4 py-3 text-slate-600">{{ $item->alamat_bujk ?: '-' }}</td>
                    <td class="whitespace-nowrap px-4 py-3 text-slate-600">{{ $item->npwp_bujk ?: '-' }}</td>
                    <td class="px-4 py-3">
                        <div class="space-y-1 text-[11px] leading-5 text-slate-600">
                            <p>{{ $item->telp_bujk ?: '-' }}</p>
                            @if($item->email_bujk)
                            <p>{{ $item->email_bujk }}</p>
                            @endif
                            @if($item->website_bujk)
                            <p>
                                <a
                                    href="{{ $item->website_url }}"
                                    target="_blank"
                                    class="text-sky-600 hover:text-sky-700 hover:underline">
                                    {{ $item->website_bujk }}
                                </a>
                            </p>
                            @endif
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center gap-2">
                            <a
                                href="{{ route('admin.bujk', array_merge(request()->query(), ['edit' => $item->id, 'panel' => 'manual'])) }}"
                                class="inline-flex items-center justify-center rounded-xl border border-amber-200 bg-amber-50 px-3 py-2 text-[11px] font-semibold text-amber-700 transition hover:border-amber-300 hover:bg-amber-100">
                                Edit
                            </a>

                            <form action="{{ route('admin.bujk.destroy', $item) }}" method="POST" class="single-delete-form">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="button"
                                    data-delete-single
                                    data-delete-name="{{ $item->nama_bujk }}"
                                    class="inline-flex items-center justify-center rounded-xl border border-rose-200 bg-white px-3 py-2 text-[11px] font-semibold text-rose-600 transition hover:border-rose-300 hover:bg-rose-50">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="px-4 py-8 text-center text-xs text-slate-500">
                        Belum ada data BUJK yang tampil. Klik tombol tambah data atau upload file untuk mulai mengisi data.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
    <p class="text-xs text-slate-500">
        Menampilkan {{ $bujks->firstItem() ?? 0 }} - {{ $bujks->lastItem() ?? 0 }} dari {{ $bujks->total() }} data.
    </p>

    @if($bujks->hasPages())
    <nav class="bujk-pagination flex flex-wrap items-center gap-2" aria-label="Pagination BUJK">
        @if($bujks->onFirstPage())
        <span class="inline-flex cursor-not-allowed items-center justify-center rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2 text-xs font-semibold text-slate-400">
            &laquo; Previous
        </span>
        @else
        <a
            href="{{ $bujks->previousPageUrl() }}"
            class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700">
            &laquo; Previous
        </a>
        @endif

        @php
        $startPage = max(1, $bujks->currentPage() - 1);
        $endPage = min($bujks->lastPage(), $bujks->currentPage() + 1);
        @endphp

        @if($startPage > 1)
        <a
            href="{{ $bujks->url(1) }}"
            class="inline-flex h-9 min-w-9 items-center justify-center rounded-xl border border-slate-200 bg-white px-3 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700">
            1
        </a>

        @if($startPage > 2)
        <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-xl px-2 text-xs font-semibold text-slate-400">
            ...
        </span>
        @endif
        @endif

        @foreach(range($startPage, $endPage) as $page)
        @if($page === $bujks->currentPage())
        <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-xl bg-indigo-600 px-3 text-xs font-bold text-white shadow-sm">
            {{ $page }}
        </span>
        @else
        <a
            href="{{ $bujks->url($page) }}"
            class="inline-flex h-9 min-w-9 items-center justify-center rounded-xl border border-slate-200 bg-white px-3 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700">
            {{ $page }}
        </a>
        @endif
        @endforeach

        @if($endPage < $bujks->lastPage())
        @if($endPage < $bujks->lastPage() - 1)
        <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-xl px-2 text-xs font-semibold text-slate-400">
            ...
        </span>
        @endif

        <a
            href="{{ $bujks->url($bujks->lastPage()) }}"
            class="inline-flex h-9 min-w-9 items-center justify-center rounded-xl border border-slate-200 bg-white px-3 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700">
            {{ $bujks->lastPage() }}
        </a>
        @endif

        @if($bujks->hasMorePages())
        <a
            href="{{ $bujks->nextPageUrl() }}"
            class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700">
            Next &raquo;
        </a>
        @else
        <span class="inline-flex cursor-not-allowed items-center justify-center rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2 text-xs font-semibold text-slate-400">
            Next &raquo;
        </span>
        @endif
    </nav>
    @endif
</div>