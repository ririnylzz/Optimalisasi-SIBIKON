<div class="mt-4 flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-slate-800 bg-slate-950/40 px-4 py-3">
    <label class="inline-flex items-center gap-3 text-sm text-slate-300">
        <input
            type="checkbox"
            id="select-all-rows"
            class="h-4 w-4 rounded border-slate-600 bg-slate-950 text-indigo-600 focus:ring-indigo-500"
        >
        <span>Pilih semua data di halaman ini</span>
    </label>

    <div class="flex flex-wrap items-center gap-2">
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

    <div class="bujk-pagination">
        {{ $bujks->onEachSide(1)->links() }}
    </div>
</div>