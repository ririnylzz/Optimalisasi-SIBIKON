@extends('layouts.app')

@section('content')
<section class="bg-white px-4 py-16 md:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">

        <div class="mb-12 text-center">
            <p class="mb-4 text-xs font-bold uppercase tracking-[0.45em] text-slate-400">
                Layanan
            </p>

            <h1 class="text-3xl font-extrabold uppercase tracking-[0.08em] text-[#071226] md:text-4xl">
                Pemanfaat Produk Jasa Konstruksi
            </h1>

            <span class="mx-auto mt-5 block h-1.5 w-40 rounded-full bg-yellow-400"></span>
        </div>

        <div class="rounded-[24px] border border-[#dfe5ef] bg-white p-6 shadow-[0_12px_35px_rgba(15,23,42,0.08)]">

            <form method="GET" action="{{ route('pemanfaat-produk') }}" class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-3 text-sm text-slate-500">
                    <span>Show</span>

                    <select
                        name="per_page"
                        onchange="this.form.submit()"
                        class="rounded-lg border border-[#dfe5ef] bg-white px-3 py-2 text-sm text-slate-600 outline-none focus:border-[#293F81]"
                    >
                        @foreach([10, 25, 50, 100] as $size)
                            <option value="{{ $size }}" @selected((int) $perPage === $size)>
                                {{ $size }}
                            </option>
                        @endforeach
                    </select>

                    <span>entries</span>
                </div>

                <div class="flex items-center gap-3 text-sm text-slate-500">
                    <label for="search-pemanfaat-produk">Search:</label>

                    <input
                        id="search-pemanfaat-produk"
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Cari nama bangunan, lokasi..."
                        autocomplete="off"
                        class="w-full rounded-lg border border-[#dfe5ef] px-4 py-2 text-sm outline-none focus:border-[#293F81] md:w-80"
                    >

                    <button
                        type="submit"
                        class="rounded-lg bg-[#293F81] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#1f3165]"
                    >
                        Cari
                    </button>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[1100px] border-collapse text-left">
                    <thead>
                        <tr class="border-y border-[#dfe5ef] bg-[#f8fafc] text-xs uppercase tracking-wide text-[#071226]">
                            <th class="w-16 px-5 py-5 font-extrabold">No.</th>
                            <th class="px-5 py-5 font-extrabold">Nama Bangunan</th>
                            <th class="px-5 py-5 font-extrabold">Pengelola/Pemilik Bangunan</th>
                            <th class="px-5 py-5 font-extrabold">Lokasi</th>
                            <th class="px-5 py-5 font-extrabold">Nama Pengelola/Pemilik</th>
                            <th class="px-5 py-5 font-extrabold">Tahun Anggaran</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[#e6ebf2] text-sm text-slate-600">
                        @forelse($pemanfaatProduks as $item)
                            <tr class="align-top">
                                <td class="px-5 py-6 font-semibold">
                                    {{ $pemanfaatProduks->firstItem() + $loop->index }}.
                                </td>

                                <td class="px-5 py-6">
                                    <span class="font-bold leading-7 text-blue-600">
                                        {{ $item->nama_bangunan ?: '-' }}
                                    </span>
                                </td>

                                <td class="px-5 py-6 leading-7">
                                    {{ $item->pengelola_pemilik_bangunan ?: '-' }}
                                </td>

                                <td class="px-5 py-6 leading-7">
                                    {{ $item->lokasi ?: '-' }}
                                </td>

                                <td class="px-5 py-6 leading-7">
                                    {{ $item->nama_pengelola_pemilik ?: '-' }}
                                </td>

                                <td class="px-5 py-6 leading-7">
                                    {{ $item->tahun_anggaran ?: '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-10 text-center text-slate-500">
                                    Data pemanfaat produk belum tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <p class="text-sm text-slate-500">
                    Showing {{ $pemanfaatProduks->firstItem() ?? 0 }}
                    to {{ $pemanfaatProduks->lastItem() ?? 0 }}
                    of {{ $pemanfaatProduks->total() }} entries
                </p>

                <div>
                    {{ $pemanfaatProduks->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection