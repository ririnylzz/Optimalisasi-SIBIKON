@extends('layouts.app')

@section('content')
<section class="bg-white px-4 py-10 md:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">

        {{-- Top Bar --}}
        <div class="mb-10 flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
            <a href="{{ route('berita') }}"
                class="inline-flex items-center gap-2 text-sm font-bold text-[#21325e] transition hover:text-[#3a4fac]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Berita
            </a>

            <div class="relative w-full md:w-72">
                <input
                    type="text"
                    placeholder="Cari berita..."
                    class="w-full rounded-full border border-[#c5cae9] px-5 py-3 pl-11 text-sm text-[#21325e] outline-none transition focus:border-[#3a4fac] focus:ring-4 focus:ring-[#7282cc]/20">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-[#7282cc]"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" />
                </svg>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-10 lg:grid-cols-[1fr_360px]">

            {{-- Main Article --}}
            <article>
                <h1 class="mb-4 text-3xl font-extrabold leading-tight text-[#071226] md:text-4xl">
                    Bidang Bina Konstruksi Lakukan Rapat Persiapan Pelatihan dan Sertifikasi Tahun 2026 Bersama Perguruan Tinggi
                </h1>

                {{-- Meta --}}
                <div class="mb-7 flex flex-wrap items-center gap-3 text-sm text-slate-500">
                    <div class="flex items-center gap-2">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-[#f7e578] text-[#21325e]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 21a7.5 7.5 0 0115 0" />
                            </svg>
                        </div>
                        <span class="font-semibold text-[#21325e]">Admin SIBIKON</span>
                    </div>

                    <span>•</span>
                    <span>Berita</span>
                    <span>•</span>
                    <span>Februari 11, 2026</span>
                </div>

                {{-- Image --}}
                <img
                    src="{{ asset('images/berita-utama.jpg') }}"
                    alt="Bidang Bina Konstruksi Lakukan Rapat Persiapan Pelatihan dan Sertifikasi"
                    class="mb-8 h-[420px] w-full rounded-[18px] object-cover shadow-[0_14px_35px_rgba(33,50,94,0.12)]">

                {{-- Content --}}
                <div class="space-y-6 text-base leading-8 text-slate-700">
                    <p>
                        <span class="font-extrabold text-[#21325e]">Samarinda, Kalimantan Timur —</span>
                        Bidang Bina Konstruksi Dinas Pekerjaan Umum Penataan Ruang dan Perumahan Rakyat
                        Provinsi Kalimantan Timur melaksanakan rapat persiapan pelatihan dan sertifikasi
                        tenaga kerja konstruksi tahun 2026 bersama perguruan tinggi.
                    </p>

                    <p>
                        Kegiatan ini menjadi bagian dari upaya peningkatan kualitas sumber daya manusia
                        konstruksi, khususnya dalam menyiapkan tenaga kerja yang kompeten, tersertifikasi,
                        dan mampu mendukung kebutuhan pembangunan daerah secara profesional.
                    </p>

                    <h2 class="pt-3 text-2xl font-extrabold text-[#21325e]">
                        Fokus Persiapan Pelatihan dan Sertifikasi
                    </h2>

                    <p>
                        Rapat membahas koordinasi teknis pelaksanaan kegiatan, kesiapan peserta, kebutuhan
                        asesor, jadwal pelatihan, serta mekanisme sertifikasi yang akan dilaksanakan.
                        Sinergi bersama perguruan tinggi diharapkan mampu memperkuat kualitas pelaksanaan
                        program agar sesuai dengan kebutuhan sektor jasa konstruksi.
                    </p>

                    <p>
                        Melalui kegiatan ini, Bidang Bina Konstruksi mendorong peningkatan kompetensi
                        tenaga kerja konstruksi di Kalimantan Timur agar semakin siap menghadapi tantangan
                        pembangunan infrastruktur yang terus berkembang.
                    </p>

                    <h2 class="pt-3 text-2xl font-extrabold text-[#21325e]">
                        Komitmen Penguatan SDM Konstruksi
                    </h2>

                    <p>
                        Pemerintah Provinsi Kalimantan Timur melalui Bidang Bina Konstruksi terus
                        berkomitmen memperkuat pembinaan jasa konstruksi, salah satunya melalui pelatihan
                        dan sertifikasi yang terarah, terukur, serta berkelanjutan.
                    </p>
                </div>

                {{-- Bottom Interaction --}}
                <div class="mt-10 rounded-[18px] border border-[#c5cae9]/60 bg-white p-5 shadow-[0_10px_28px_rgba(33,50,94,0.08)]">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div class="flex flex-wrap items-center gap-5 text-sm text-[#21325e]/80">
                            <button class="inline-flex items-center gap-2 font-semibold transition hover:text-[#3a4fac]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14 9V5a3 3 0 00-6 0v4H5a2 2 0 00-2 2v8a2 2 0 002 2h11.28a2 2 0 001.94-1.515l1.5-6A2 2 0 0017.78 11H14z" />
                                </svg>
                                1.3K Likes
                            </button>

                            <button class="inline-flex items-center gap-2 font-semibold transition hover:text-[#3a4fac]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8 12h8M8 16h5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                55 Komentar
                            </button>

                            <button class="inline-flex items-center gap-2 font-semibold transition hover:text-[#3a4fac]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4 12v7a1 1 0 001 1h14a1 1 0 001-1v-7M16 6l-4-4m0 0L8 6m4-4v14" />
                                </svg>
                                960 Shares
                            </button>
                        </div>

                        <div class="flex w-full items-center gap-3 md:w-auto">
                            <input
                                type="text"
                                placeholder="Tulis komentar..."
                                class="w-full rounded-full border border-[#c5cae9] px-5 py-3 text-sm outline-none focus:border-[#3a4fac] md:w-72">

                            <button class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#21325e] text-white transition hover:bg-[#3a4fac]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M5 12h14M13 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </article>

            {{-- Sidebar --}}
            <aside class="lg:border-l lg:border-[#c5cae9]/60 lg:pl-8">

                {{-- Share --}}
                <div class="mb-10 rounded-[20px] border border-[#c5cae9]/60 bg-white p-6 shadow-[0_10px_28px_rgba(33,50,94,0.06)]">
                    <h3 class="mb-5 text-xl font-extrabold text-[#21325e]">
                        Bagikan
                    </h3>

                    <div class="flex flex-wrap gap-3">
                        <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full bg-[#c5cae9]/30 text-[#21325e] transition hover:bg-[#f1d00a]">
                            in
                        </a>
                        <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full bg-[#c5cae9]/30 text-[#21325e] transition hover:bg-[#f1d00a]">
                            wa
                        </a>
                        <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full bg-[#c5cae9]/30 text-[#21325e] transition hover:bg-[#f1d00a]">
                            x
                        </a>
                        <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full bg-[#c5cae9]/30 text-[#21325e] transition hover:bg-[#f1d00a]">
                            f
                        </a>
                        <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full bg-[#c5cae9]/30 text-[#21325e] transition hover:bg-[#f1d00a]">
                            @
                        </a>
                    </div>
                </div>

                {{-- Related Articles --}}
                <div>
                    <h3 class="mb-6 text-xl font-extrabold text-[#21325e]">
                        Berita Terkait
                    </h3>

                    <div class="space-y-6">

                        {{-- Related 1 --}}
                        <a href="#" class="grid grid-cols-[120px_1fr] gap-4 group">
                            <img src="{{ asset('images/berita-1.png') }}"
                                alt="Pembukaan Serentak Kelas Pelatihan"
                                class="h-24 w-full rounded-xl object-cover">

                            <div>
                                <p class="mb-1 text-xs font-bold text-[#7282cc]">
                                    Berita Populer
                                </p>

                                <h4 class="text-sm font-extrabold leading-snug text-[#21325e] group-hover:text-[#3a4fac]">
                                    Pembukaan Serentak Kelas Pelatihan Tenaga Kerja Konstruksi Ahli
                                </h4>

                                <p class="mt-2 text-xs text-slate-500">
                                    Admin SIBIKON • April 09, 2026
                                </p>
                            </div>
                        </a>

                        {{-- Related 2 --}}
                        <a href="#" class="grid grid-cols-[120px_1fr] gap-4 group">
                            <img src="{{ asset('images/berita-2.png') }}"
                                alt="Dari Jawa Ke Kepulauan Riau"
                                class="h-24 w-full rounded-xl object-cover">

                            <div>
                                <p class="mb-1 text-xs font-bold text-[#7282cc]">
                                    Berita Populer
                                </p>

                                <h4 class="text-sm font-extrabold leading-snug text-[#21325e] group-hover:text-[#3a4fac]">
                                    Dari Jawa Ke Kepulauan Riau, BIKON Singgah Untuk Bertukar
                                </h4>

                                <p class="mt-2 text-xs text-slate-500">
                                    Admin SIBIKON • April 10, 2026
                                </p>
                            </div>
                        </a>

                        {{-- Related 3 --}}
                        <a href="#" class="grid grid-cols-[120px_1fr] gap-4 group">
                            <img src="{{ asset('images/berita-3.png') }}"
                                alt="Pelatihan dan Sertifikasi Penilai Ahli"
                                class="h-24 w-full rounded-xl object-cover">

                            <div>
                                <p class="mb-1 text-xs font-bold text-[#7282cc]">
                                    Berita Populer
                                </p>

                                <h4 class="text-sm font-extrabold leading-snug text-[#21325e] group-hover:text-[#3a4fac]">
                                    Pelatihan Dan Sertifikasi Penilai Ahli Kegagalan Bangunan dan TKK
                                </h4>

                                <p class="mt-2 text-xs text-slate-500">
                                    Admin SIBIKON • April 12, 2026
                                </p>
                            </div>
                        </a>

                    </div>
                </div>
            </aside>

        </div>
    </div>
</section>
@endsection