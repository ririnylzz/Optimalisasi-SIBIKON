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
                Fungsi Pengawasan
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
                    <a href="{{ route('tertib-usaha') }}"
                        class="{{ request()->routeIs('tertib-usaha') ? 'text-yellow-300' : 'text-white' }} block border-y border-white/45 py-4 text-base font-bold transition hover:text-yellow-300">
                        Tertib Usaha
                    </a>

                    <a href="{{ route('tertib-pemanfaatan') }}"
                        class="{{ request()->routeIs('tertib-pemanfaatan') ? 'text-yellow-300' : 'text-white' }} block border-b border-white/45 py-4 text-base font-bold leading-relaxed transition hover:text-yellow-300">
                        Tertib Pemanfaatan
                    </a>

                    <a href="{{ route('tertib-penyelenggaraan') }}"
                        class="{{ request()->routeIs('tertib-penyelenggaraan') ? 'text-yellow-300' : 'text-white' }} block border-b border-white/45 py-4 text-base font-bold leading-relaxed transition hover:text-yellow-300">
                        Tertib Penyelenggaraan
                    </a>
                </nav>
            </aside>

            <!-- {{-- Card List --}}
            <div>
                @php
                $pelatihan = [
                [
                'judul' => 'Pelatihan dan Sertifikasi TKK Ahli Muda Teknik Sumber Daya Air Jenjang 7',
                'gambar' => 'images/poster-pelatihan.jpg',
                'waktu' => '07 - 10 April 2026',
                'lokasi' => 'Samarinda',
                'peserta' => '50 Peserta',
                ],
                [
                'judul' => 'Pelatihan dan Sertifikasi TKK Ahli Muda K3 Konstruksi Jenjang 7',
                'gambar' => 'images/poster-pelatihan.jpg',
                'waktu' => '14 - 17 April 2026',
                'lokasi' => 'Balikpapan',
                'peserta' => '45 Peserta',
                ],
                [
                'judul' => 'Pelatihan dan Sertifikasi TKK Ahli Muda Teknik Bangunan Gedung Jenjang 7',
                'gambar' => 'images/poster-pelatihan.jpg',
                'waktu' => '21 - 24 April 2026',
                'lokasi' => 'Bontang',
                'peserta' => '40 Peserta',
                ],
                ];
                @endphp

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($pelatihan as $item)
                    <article
                        class="overflow-hidden rounded-[16px] bg-white shadow-[0_8px_22px_rgba(15,23,42,0.08)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_14px_30px_rgba(15,23,42,0.12)]">

                        {{-- Poster --}}
                        <div class="px-4 pt-4">
                            <img
                                src="{{ asset($item['gambar']) }}"
                                alt="{{ $item['judul'] }}"
                                class="h-[115px] w-full rounded-lg object-cover">
                        </div>

                        {{-- Content --}}
                        <div class="px-4 pb-5 pt-4">
                            <h2 class="mb-3 text-base font-extrabold leading-snug text-[#071226]">
                                {{ $item['judul'] }}
                            </h2>

                            <div class="space-y-1.5 text-xs leading-relaxed text-slate-600">
                                <div>
                                    <span class="font-bold text-[#071226]">Waktu:</span>
                                    <span>{{ $item['waktu'] }}</span>
                                </div>

                                <div>
                                    <span class="font-bold text-[#071226]">Lokasi:</span>
                                    <span>{{ $item['lokasi'] }}</span>
                                </div>

                                <div>
                                    <span class="font-bold text-[#071226]">Peserta:</span>
                                    <span>{{ $item['peserta'] }}</span>
                                </div>
                            </div>

                            <a href="#"
                                class="mt-4 inline-flex rounded-md bg-[#293F81] px-4 py-2 text-[11px] font-extrabold text-white transition hover:bg-[#1f326a]">
                                Lihat Detail
                            </a>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div> -->
        </div>
    </div>
</section>
@endsection