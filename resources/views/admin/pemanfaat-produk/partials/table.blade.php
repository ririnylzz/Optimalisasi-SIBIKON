<div class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white">
    <div class="flex flex-col gap-3 border-b border-slate-200 bg-slate-50 px-4 py-3 md:flex-row md:items-center md:justify-between">
        <div class="text-xs text-slate-500">
            Menampilkan
            <span class="font-semibold text-slate-700">{{ $pemanfaatProduks->firstItem() ?? 0 }}</span>
            -
            <span class="font-semibold text-slate-700">{{ $pemanfaatProduks->lastItem() ?? 0 }}</span>
            dari
            <span class="font-semibold text-slate-700">{{ $pemanfaatProduks->total() }}</span>
            data
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <button
                type="button"
                id="bulk-delete-trigger"
                disabled
                class="cursor-not-allowed rounded-xl border border-rose-100 px-3 py-2 text-xs font-semibold text-rose-300">
                Hapus Terpilih
            </button>

            <button
                type="button"
                id="delete-all-trigger"
                @disabled($pemanfaatProduks->total() === 0)
                class="rounded-xl border border-rose-200 px-3 py-2 text-xs font-semibold text-rose-600 transition hover:border-rose-300 hover:bg-rose-50 disabled:cursor-not-allowed disabled:border-rose-100 disabled:text-rose-300 disabled:hover:bg-transparent">
                Hapus Semua
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-[1100px] w-full text-left text-sm">
            <thead>
                <tr class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <th class="w-12 px-4 py-3">
                        <input
                            type="checkbox"
                            id="select-all-rows"
                            class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    </th>
                    <th class="w-16 px-4 py-3">No</th>
                    <th class="px-4 py-3">Nama Bangunan</th>
                    <th class="px-4 py-3">Pengelola/Pemilik Bangunan</th>
                    <th class="px-4 py-3">Lokasi</th>
                    <th class="px-4 py-3">Nama Pengelola/Pemilik</th>
                    <th class="px-4 py-3">Tahun Anggaran</th>
                    <th class="px-4 py-3">Kontak</th>
                    <th class="w-40 px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @forelse($pemanfaatProduks as $pemanfaatProduk)
                    <tr class="text-slate-700 hover:bg-slate-50/70">
                        <td class="px-4 py-3 align-top">
                            <input
                                type="checkbox"
                                value="{{ $pemanfaatProduk->id }}"
                                data-row-checkbox
                                class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        </td>

                        <td class="px-4 py-3 align-top text-slate-500">
                            {{ $pemanfaatProduks->firstItem() + $loop->index }}
                        </td>

                        <td class="px-4 py-3 align-top">
                            <div class="max-w-[240px] font-semibold text-slate-900">
                                {{ $pemanfaatProduk->nama_bangunan ?: '-' }}
                            </div>
                        </td>

                        <td class="px-4 py-3 align-top">
                            <div class="max-w-[240px] text-slate-600">
                                {{ $pemanfaatProduk->pengelola_pemilik_bangunan ?: '-' }}
                            </div>
                        </td>

                        <td class="px-4 py-3 align-top">
                            <div class="max-w-[260px] text-slate-600">
                                {{ $pemanfaatProduk->lokasi ?: '-' }}
                            </div>
                        </td>

                        <td class="px-4 py-3 align-top">
                            <div class="max-w-[240px] text-slate-600">
                                {{ $pemanfaatProduk->nama_pengelola_pemilik ?: '-' }}
                            </div>
                        </td>

                        <td class="px-4 py-3 align-top">
                            <span class="inline-flex rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700">
                                {{ $pemanfaatProduk->tahun_anggaran ?: '-' }}
                            </span>
                        </td>

                        <td class="px-4 py-3 align-top">
                            <div class="max-w-[180px] text-slate-600">
                                {{ $pemanfaatProduk->kontak ?: '-' }}
                            </div>
                        </td>

                        <td class="px-4 py-3 align-top">
                            <div class="flex justify-end gap-2">
                                <a
                                    href="{{ route('admin.pemanfaat-produk', array_merge(request()->query(), ['edit' => $pemanfaatProduk->id, 'panel' => 'manual'])) }}"
                                    class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:border-indigo-300 hover:bg-indigo-50 hover:text-indigo-700">
                                    Edit
                                </a>

                                <form action="{{ route('admin.pemanfaat-produk.destroy', $pemanfaatProduk) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="button"
                                        data-delete-single
                                        data-delete-name="{{ $pemanfaatProduk->nama_bangunan }}"
                                        class="rounded-lg border border-rose-200 px-3 py-1.5 text-xs font-semibold text-rose-600 transition hover:border-rose-300 hover:bg-rose-50">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-4 py-10 text-center text-sm text-slate-500">
                            Belum ada data pemanfaat produk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex flex-col gap-3 border-t border-slate-100 px-4 py-4 text-xs text-slate-500 lg:flex-row lg:items-center lg:justify-between">
        <div>
            Halaman {{ $pemanfaatProduks->currentPage() }} dari {{ $pemanfaatProduks->lastPage() }}
        </div>

        <div class="pemanfaat-pagination">
            {{ $pemanfaatProduks->links() }}
        </div>
    </div>
</div>