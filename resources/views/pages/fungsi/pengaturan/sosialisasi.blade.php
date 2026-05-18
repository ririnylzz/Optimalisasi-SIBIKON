@extends('layouts.app')

@section('content')
<section class="bg-white px-4 py-16 md:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">

        <div class="mb-12 text-center">
            <p class="mb-4 text-xs font-bold uppercase tracking-[0.45em] text-slate-400">
                Fungsi Pengaturan
            </p>

            <h1 class="text-3xl font-extrabold uppercase text-[#071226] md:text-4xl">
                Sosialisasi Sub Urusan Jasa Konstruksi
            </h1>

            <span class="mx-auto mt-5 block h-1.5 w-40 rounded-full bg-yellow-400"></span>
        </div>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-[240px_1fr]">

            <aside class="rounded-[24px] bg-[#293F81] px-8 py-8 text-white shadow-lg lg:min-h-[430px]">
                <h2 class="mb-6 text-2xl font-extrabold">Kategori</h2>

                <nav>
                    <a href="{{ route('rakor') }}"
                        class="block border-y border-white/45 py-4 text-base transition hover:text-yellow-300">
                        Rakor
                    </a>

                    <a href="{{ route('sosialisasi') }}"
                        class="block border-b border-white/45 py-4 text-base text-yellow-300">
                        Sosialisasi
                    </a>

                    <a href="{{ route('forum') }}"
                        class="block border-b border-white/45 py-4 text-base transition hover:text-yellow-300">
                        Forum
                    </a>

                    <a href="{{ route('rantai-pasok') }}"
                        class="block border-b border-white/45 py-4 text-base transition hover:text-yellow-300">
                        Rantai Pasok
                    </a>
                </nav>
            </aside>

            <div class="rounded-[24px] border border-[#dfe5ef] bg-white p-6 shadow-[0_12px_35px_rgba(15,23,42,0.08)]">

                <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center gap-3 text-sm text-slate-500">
                        <span>Show</span>
                        <select class="rounded-lg border border-[#dfe5ef] bg-white px-3 py-2 text-sm text-slate-600">
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                        </select>
                        <span>entries</span>
                    </div>

                    <div class="flex items-center gap-3 text-sm text-slate-500">
                        <label>Search:</label>
                        <input type="text"
                            class="w-full rounded-lg border border-[#dfe5ef] px-4 py-2 text-sm outline-none focus:border-[#293F81] md:w-72">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[900px] border-collapse text-left">
                        <thead>
                            <tr class="border-y border-[#dfe5ef] bg-[#f8fafc] text-xs uppercase tracking-wide text-[#071226]">
                                <th class="w-16 px-5 py-5 font-extrabold">No.</th>
                                <th class="px-5 py-5 font-extrabold">Judul Kegiatan</th>
                                <th class="w-44 px-5 py-5 font-extrabold">Waktu Kegiatan</th>
                                <th class="px-5 py-5 font-extrabold">Tempat Kegiatan</th>
                                <th class="w-36 px-5 py-5 font-extrabold">Kab/Kota</th>
                                <th class="w-36 px-5 py-5 font-extrabold">Peserta</th>
                                <th class="w-32 px-5 py-5 font-extrabold">Daftar</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#e6ebf2] text-sm text-slate-600">
                            <tr class="align-top">
                                <td class="px-5 py-6 font-semibold">1.</td>
                                <td class="px-5 py-6">
                                    <a href="#" class="font-bold leading-7 text-blue-600 hover:underline">
                                        Sosialisasi Kebijakan Pembinaan Jasa Konstruksi Tahun 2025
                                    </a>
                                </td>
                                <td class="px-5 py-6 leading-7">12 September 2025</td>
                                <td class="px-5 py-6 leading-7">
                                    Aula Dinas PUPRPERA Provinsi Kalimantan Timur
                                </td>
                                <td class="px-5 py-6 font-bold uppercase">Samarinda</td>
                                <td class="px-5 py-6">
                                    <span class="inline-flex rounded-md bg-blue-600 px-3 py-2 text-xs font-extrabold text-white">
                                        Masyarakat Jasa Konstruksi
                                    </span>
                                </td>
                                <td class="px-5 py-6">
                                    <a href="{{ route('daftar-sosil') }}"
                                        class="inline-flex rounded-md bg-yellow-400 px-4 py-2 text-xs font-extrabold text-slate-900 transition hover:bg-yellow-300">
                                        Daftar
                                    </a>
                                </td>
                            </tr>

                            <tr class="align-top">
                                <td class="px-5 py-6 font-semibold">2.</td>
                                <td class="px-5 py-6">
                                    <a href="#" class="font-bold leading-7 text-blue-600 hover:underline">
                                        Sosialisasi Sistem Informasi Pembinaan Jasa Konstruksi
                                    </a>
                                </td>
                                <td class="px-5 py-6 leading-7">18 Juli 2025</td>
                                <td class="px-5 py-6 leading-7">
                                    Hotel Grand Tjokro Balikpapan
                                </td>
                                <td class="px-5 py-6 font-bold uppercase">Balikpapan</td>
                                <td class="px-5 py-6">
                                    <span class="inline-flex rounded-md bg-blue-600 px-3 py-2 text-xs font-extrabold text-white">
                                        Penyedia Jasa
                                    </span>
                                </td>
                                <td class="px-5 py-6">
                                    <a href="#"
                                        class="inline-flex rounded-md bg-yellow-400 px-4 py-2 text-xs font-extrabold text-slate-900 transition hover:bg-yellow-300">
                                        Daftar
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <p class="text-sm text-slate-500">Showing 1 to 2 of 2 entries</p>

                    <div class="flex items-center justify-end gap-1">
                        <button class="rounded-lg bg-slate-100 px-4 py-3 text-sm text-slate-500">Previous</button>
                        <button class="rounded-lg bg-yellow-400 px-4 py-3 text-sm font-extrabold text-slate-900">1</button>
                        <button class="rounded-lg bg-slate-100 px-4 py-3 text-sm text-slate-500">Next</button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>
@endsection