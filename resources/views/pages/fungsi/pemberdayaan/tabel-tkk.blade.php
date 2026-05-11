@extends('layouts.app')

@section('content')
<section class="bg-white px-4 py-20 md:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">

        {{-- Header --}}
        <div class="mb-16 text-center">
            <p class="mb-4 text-xs font-bold uppercase tracking-[0.45em] text-slate-400">
                Masyarakat Konstruksi
            </p>

            <h1 class="text-3xl font-extrabold uppercase text-[#071226] md:text-4xl">
                Tenaga Kerja Konstruksi
            </h1>

            <span class="mx-auto mt-8 block h-2 w-60 rounded-full bg-yellow-400"></span>
        </div>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-[240px_1fr]">

            {{-- Sidebar Kategori --}}
            <aside class="rounded-[24px] bg-[#293F81] px-8 py-8 text-white shadow-lg lg:min-h-[430px]">
                <h2 class="mb-6 text-2xl font-extrabold">
                    Kategori
                </h2>

                <nav>
                    <a href="{{ route('tabel-tkk') }}"
                        class="{{ request()->routeIs('tabel-tkk') ? 'text-yellow-300' : 'text-white' }} block border-y border-white/45 py-4 text-base transition hover:text-yellow-300">
                        Tenaga Kerja Konstruksi
                    </a>

                    <a href="{{ route('pelatihan-ahli') }}"
                        class="{{ request()->routeIs('pelatihan-ahli') ? 'text-yellow-300' : 'text-white' }} block border-b border-white/45 py-4 text-base leading-relaxed transition hover:text-yellow-300">
                        Pelatihan dan Sertifikasi Ahli
                    </a>
                </nav>
            </aside>

            {{-- Table Card --}}
            <div class="rounded-[28px] border border-[#dfe5ef] bg-white p-8 shadow-[0_12px_35px_rgba(15,23,42,0.08)]">

                {{-- Table Controls --}}
                <div class="mb-8 flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center gap-3 text-lg text-slate-600">
                        <span>Show</span>

                        <select
                            class="rounded-xl border border-[#dfe5ef] bg-white px-5 py-3 text-lg text-slate-600 outline-none focus:border-[#293F81]">
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                            <option>100</option>
                        </select>

                        <span>entries</span>
                    </div>

                    <div class="flex items-center gap-4 text-lg text-slate-600">
                        <label for="search-tkk">Search:</label>

                        <input
                            id="search-tkk"
                            type="text"
                            class="w-full rounded-xl border border-[#dfe5ef] px-5 py-3 text-lg outline-none focus:border-[#293F81] md:w-80">
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[900px] border-collapse text-left">
                        <thead>
                            <tr class="border-y border-[#dfe5ef] bg-[#f8fafc] text-sm uppercase tracking-wide text-[#334155]">
                                <th class="w-24 px-6 py-6 font-extrabold">No.</th>
                                <th class="px-6 py-6 font-extrabold">Nama Tenaga Kerja</th>
                                <th class="w-80 px-6 py-6 font-extrabold">Pendidikan</th>
                                <th class="w-72 px-6 py-6 font-extrabold">Keahlian</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#e6ebf2] text-base text-slate-600">
                            {{-- Kosong seperti tampilan pada gambar --}}
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-slate-500">
                                    Data belum tersedia.
                                </td>
                            </tr>

                            {{-- Contoh jika nanti ingin isi data:
                            <tr>
                                <td class="px-6 py-5 font-semibold">1.</td>
                                <td class="px-6 py-5 font-bold text-blue-600">Nama Tenaga Kerja</td>
                                <td class="px-6 py-5">S1 Teknik Sipil</td>
                                <td class="px-6 py-5">Ahli Muda Teknik Bangunan Gedung</td>
                            </tr>
                            --}}
                        </tbody>
                    </table>
                </div>

                {{-- Footer Table --}}
                <div class="mt-8 flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                    <p class="text-lg text-slate-500">
                        Showing 0 to 0 of 0 entries
                    </p>

                    <div class="flex items-center justify-end">
                        <button
                            class="rounded-l-xl border border-[#dfe5ef] bg-slate-100 px-6 py-4 text-lg font-medium text-slate-500">
                            Previous
                        </button>

                        <button
                            class="border-y border-yellow-400 bg-yellow-400 px-6 py-4 text-lg font-extrabold text-slate-900">
                            1
                        </button>

                        <button
                            class="rounded-r-xl border border-[#dfe5ef] bg-white px-6 py-4 text-lg font-medium text-slate-500">
                            Next
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>
@endsection