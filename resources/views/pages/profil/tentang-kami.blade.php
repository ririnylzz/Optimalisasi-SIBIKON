@extends('layouts.app')

@section('content')
<section class="bg-white px-4 py-14 md:px-6 md:py-20">
    <div class="mx-auto max-w-7xl">

        {{-- HERO TENTANG KAMI --}}
        <div class="grid grid-cols-1 items-stretch gap-8 lg:grid-cols-2">

            {{-- Card Deskripsi --}}
            <div class="rounded-[28px] bg-[#f8f8f6] px-8 py-10 md:px-12 md:py-14">
                <p class="mb-4 text-sm font-semibold text-[#21325e]/80">
                    Tentang Kami
                </p>

                <h1 class="mb-6 text-2xl font-extrabold leading-tight text-[#163B5C] md:text-5xl">
                    BIKON
                </h1>

                <p class="max-w-xl text-base leading-8 text-[#21325e]/75">
                    Bina Konstruksi adalah salah satu bidang pada Dinas Pekerjaan Umum Penataan Ruang dan
                    Perumahan Rakyat Provinsi Kalimantan Timur yang memiliki tugas, melaksanakan penyiapan
                    bahan perumusan kebijakan, koordinasi, pembinaan, bimbingan, pengendalian, serta
                    pengembangan teknis di bina konstruksi. Sesuai Peraturan Menteri Dalam Negeri Nomor
                    106 Tahun 2017, Bidang Bina Konstruksi dibagi menjadi 3 (tiga) Seksi.
                </p>

                <a href="#fungsi-bikon"
                    class="mt-10 inline-flex rounded-xl bg-yellow-400 px-7 py-4 text-sm font-bold leading-tight text-slate-900 transition hover:bg-yellow-300">
                    BACA<br>
                    SELENGKAPNYA
                </a>
            </div>

            {{-- Card Gambar --}}
            <div class="relative min-h-[360px] overflow-hidden rounded-[28px] bg-slate-200">
                <img
                    src="{{ asset('images/gedung-dinas-PUPR.jpg') }}"
                    alt="Dinas PUPR Provinsi Kalimantan Timur"
                    class="h-full min-h-[360px] w-full object-cover">

                <div class="absolute inset-0 bg-gradient-to-t from-black/65 via-black/10 to-transparent"></div>

                <button type="button"
                    class="absolute right-7 top-7 flex h-16 w-16 items-center justify-center bg-yellow-400 text-slate-900 shadow-lg transition hover:bg-yellow-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M8 5v14l11-7L8 5z" />
                    </svg>
                </button>

                <div class="absolute bottom-8 left-8 text-white">
                    <h3 class="text-lg font-extrabold">
                        Dinas PUPR Provinsi Kalimantan Timur
                    </h3>
                    <p class="mt-1 text-sm text-white/85">
                        Bidang Bina Konstruksi
                    </p>
                </div>
            </div>
        </div>

        {{-- SECTION FUNGSI BIKON --}}
        <div id="fungsi-bikon" class="pt-24">
            <div class="mb-12 text-center">
                <div class="mx-auto mb-3 h-1 w-10 rounded-full bg-yellow-400"></div>
                <h2 class="text-4xl font-extrabold text-[#143B5D] sm:text-5xl">
                    Fungsi BIKON
                </h2>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

                {{-- Card Pengaturan --}}
                <div class="rounded-[18px] border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="w-full">
                        <div class="flex items-start gap-4">
                            <div class="flex items-start gap-4">
                                <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-slate-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#1E2E5A]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 3.75h7.5L19.5 8.75V20.25a.75.75 0 0 1-.75.75H7a2.25 2.25 0 0 1-2.25-2.25V6A2.25 2.25 0 0 1 7 3.75Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 3.75v4.5h4.5" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 10.5h6" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 14.25h6" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18h3.75" />
                                    </svg>
                                </div>

                                <div class="pt-2">
                                    <h3 class="text-xl font-bold leading-none text-[#143B5D]">
                                        Pengaturan
                                    </h3>
                                    <p class="mt-2 max-w-[220px] text-base leading-8 text-slate-600">
                                        Penetapan kebijakan dan standar dalam bina konstruksi.
                                    </p>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div id="fungsi-card-1" class="pt-5">
                        <div class="mt-4 h-px w-full bg-slate-200 mb-4"></div>
                        <ul class="list-disc space-y-2 pl-5 text-slate-600 leading-8">
                            <li>Penyiapan bahan perumusan kebijakan.</li>
                            <li>Penyusunan norma, standar, prosedur, dan kriteria.</li>
                            <li>Penyebarluasan peraturan serta penjaminan mutu pelaksanaan pembinaan jasa konstruksi.</li>
                        </ul>
                    </div>
                </div>

                {{-- Card Pengawasan --}}
                <div class="rounded-[18px] border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="w-full">
                        <div class="flex items-start gap-4">
                            <div class="flex items-start gap-4">
                                <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-slate-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#1E2E5A]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 4.5h3A2.25 2.25 0 0 1 15.75 6.75v1.5h-7.5v-1.5A2.25 2.25 0 0 1 10.5 4.5Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 8.25h9A2.25 2.25 0 0 1 18 10.5v7.5a2.25 2.25 0 0 1-2.25 2.25h-9A2.25 2.25 0 0 1 4.5 18v-7.5a2.25 2.25 0 0 1 2.25-2.25Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 12h3.75" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15.75h2.25" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 15l4.5 4.5" />
                                        <circle cx="15" cy="15" r="3.25" />
                                    </svg>
                                </div>

                                <div class="pt-2">
                                    <h3 class="text-xl font-bold leading-none text-[#143B5D]">
                                        Pengawasan
                                    </h3>
                                    <p class="mt-2 max-w-[220px] text-base leading-8 text-slate-600">
                                        Pengendalian dan evaluasi pelaksanaan konstruksi.
                                    </p>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div id="fungsi-card-2" class="pt-5">
                        <div class="mt-4 h-px w-full bg-slate-200 mb-4"></div>
                        <ul class="list-disc space-y-2 pl-5 text-slate-600 leading-8">
                            <li>Monitoring pelaksanaan kegiatan konstruksi.</li>
                            <li>Evaluasi penerapan kebijakan dan program bina konstruksi.</li>
                            <li>Pengendalian mutu pekerjaan dan penyelenggaraan jasa konstruksi.</li>
                        </ul>
                    </div>
                </div>

                {{-- Card Pemberdayaan --}}
                <div class="rounded-[18px] border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="w-full">
                        <div class="flex items-start gap-4">
                            <div class="flex items-start gap-4">
                                <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-slate-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#1E2E5A]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75a5.25 5.25 0 0 0-9 0" />
                                        <circle cx="12" cy="11.25" r="3.75" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 18.75a4.5 4.5 0 0 1 3.188-4.299" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.75 18.75a4.5 4.5 0 0 0-3.188-4.299" />
                                        <circle cx="6.75" cy="12" r="2.25" />
                                        <circle cx="17.25" cy="12" r="2.25" />
                                    </svg>
                                </div>

                                <div class="pt-2">
                                    <h3 class="text-xl font-bold leading-none text-[#143B5D]">
                                        Pemberdayaan
                                    </h3>
                                    <p class="mt-2 max-w-[220px] text-base leading-8 text-slate-600">
                                        Penguatan kapasitas dan kualitas SDM konstruksi.
                                    </p>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div id="fungsi-card-3" class="pt-5">
                        <div class="mt-4 h-px w-full bg-slate-200 mb-4"></div>
                        <ul class="list-disc space-y-2 pl-5 text-slate-600 leading-8">
                            <li>Peningkatan kapasitas sumber daya manusia jasa konstruksi.</li>
                            <li>Pembinaan pelaku usaha dan tenaga kerja konstruksi.</li>
                            <li>Pengembangan sektor konstruksi yang profesional dan berkelanjutan.</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>
@endsection