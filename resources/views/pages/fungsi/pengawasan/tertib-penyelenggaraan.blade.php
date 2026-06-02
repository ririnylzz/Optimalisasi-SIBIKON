@extends('layouts.app')

@section('content')
<section class="bg-white px-4 py-20 md:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">

        {{-- Header --}}
        <div class="mb-16 text-center">
            <p class="mb-4 text-xs font-bold uppercase tracking-[0.45em] text-slate-400">
                Fungsi Pengawasan
            </p>

            <h1 class="text-3xl font-extrabold uppercase text-[#071226] md:text-4xl">
                Tertib Penyelenggaraan
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
                        class="{{ request()->routeIs('tertib-usaha') ? 'text-yellow-300' : 'text-white' }} block border-y border-white/45 py-4 text-base transition hover:text-yellow-300">
                        Tertib Usaha
                    </a>

                    <a href="{{ route('tertib-pemanfaatan') }}"
                        class="{{ request()->routeIs('tertib-pemanfaatan') ? 'text-yellow-300' : 'text-white' }} block border-b border-white/45 py-4 text-base leading-relaxed transition hover:text-yellow-300">
                        Tertib Pemanfaatan
                    </a>

                    <a href="{{ route('tertib-penyelenggaraan') }}"
                        class="{{ request()->routeIs('tertib-penyelenggaraan') ? 'text-yellow-300' : 'text-white' }} block border-b border-white/45 py-4 text-base leading-relaxed transition hover:text-yellow-300">
                        Tertib Penyelenggaraan
                    </a>
                </nav>
            </aside>

            {{-- Content --}}
            <div class="min-w-0 rounded-[24px] border border-slate-200 bg-white p-6 shadow-[0_16px_45px_rgba(15,23,42,0.08)] md:p-8">

                <div class="mb-8 text-center">
                    <h2 class="text-2xl font-extrabold uppercase tracking-wide text-slate-900">
                        Form Tertib Penyelenggaraan
                    </h2>
                    <p class="mt-2 text-sm text-slate-500">
                        Form pengawasan digital untuk pemeriksaan tertib penyelenggaraan jasa konstruksi.
                    </p>

                    @if(session('success'))
                    <div class="mt-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="mt-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <p class="font-bold">Ada data yang belum sesuai:</p>
                        <ul class="mt-2 list-disc pl-5">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>

                <form action="{{ route('tertib-penyelenggaraan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    {{-- Informasi Umum --}}
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/70 p-5">
                        <h3 class="mb-5 text-base font-bold text-slate-800">
                            Informasi Pekerjaan
                        </h3>

                        <div class="grid grid-cols-1 gap-5">
                            <div class="grid grid-cols-1 gap-3 md:grid-cols-[170px_1fr] md:items-center">
                                <label for="paket_pekerjaan" class="text-sm font-bold uppercase text-slate-600">
                                    Paket Pekerjaan
                                </label>
                                <select id="paket_pekerjaan" name="paket_pekerjaan"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-[#293F81] focus:ring-4 focus:ring-[#293F81]/10">
                                    <option value="">Pilih...</option>
                                    <option value="Rekonstruksi Jalan Bts. Samarinda - Simp. 4 Sambera (Rp 45.270.400.000,00)">
                                        Rekonstruksi Jalan Bts. Samarinda - Simp. 4 Sambera (Rp 45.270.400.000,00)
                                    </option>
                                    <option value="Pelebaran Jalan Simp. 4 Sambera - Muara Badak (Rp 10.765.650.000,00)">
                                        Pelebaran Jalan Simp. 4 Sambera - Muara Badak (Rp 10.765.650.000,00)
                                    </option>
                                    <option value="Rekonstruksi Jalan Muara Badak - Bts. Bontang 1 (Rp 64.672.000.000,00)">
                                        Rekonstruksi Jalan Muara Badak - Bts. Bontang 1 (Rp 64.672.000.000,00)
                                    </option>
                                </select>
                            </div>

                            <div class="grid grid-cols-1 gap-3 md:grid-cols-[170px_1fr] md:items-center">
                                <label for="penyedia" class="text-sm font-bold uppercase text-slate-600">
                                    Penyedia
                                </label>
                                <input id="penyedia" type="text" name="penyedia" placeholder="Penyedia"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#293F81] focus:ring-4 focus:ring-[#293F81]/10">
                            </div>

                            <div class="grid grid-cols-1 gap-3 md:grid-cols-[170px_1fr] md:items-center">
                                <label for="nomor_kontrak" class="text-sm font-bold uppercase text-slate-600">
                                    Nomor Kontrak
                                </label>
                                <input id="nomor_kontrak" type="text" name="nomor_kontrak" placeholder="Nomor Kontrak"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#293F81] focus:ring-4 focus:ring-[#293F81]/10">
                            </div>

                            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                                <div class="grid grid-cols-1 gap-3 md:grid-cols-[170px_1fr] md:items-center">
                                    <label for="awal_kerja" class="text-sm font-bold uppercase text-slate-600">
                                        Awal Kerja
                                    </label>
                                    <input id="awal_kerja" type="date" name="awal_kerja"
                                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-[#293F81] focus:ring-4 focus:ring-[#293F81]/10">
                                </div>

                                <div class="grid grid-cols-1 gap-3 md:grid-cols-[170px_1fr] md:items-center">
                                    <label for="akhir_kerja" class="text-sm font-bold uppercase text-slate-600">
                                        Akhir Kerja
                                    </label>
                                    <input id="akhir_kerja" type="date" name="akhir_kerja"
                                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-[#293F81] focus:ring-4 focus:ring-[#293F81]/10">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tabel Pengawasan --}}
                    <div class="min-w-0 overflow-hidden rounded-2xl border border-slate-200 bg-white">
                        <div class="border-b border-slate-200 bg-[#293F81] px-5 py-4">
                            <h3 class="text-base font-bold uppercase tracking-wide text-white">
                                Lingkup Pengawasan Tertib Penyelenggaraan
                            </h3>
                        </div>


                        <div class="w-full overflow-x-auto overscroll-x-contain" style="-webkit-overflow-scrolling: touch;">
                            <table class="min-w-[1250px] w-full border-collapse text-left text-sm">
                                <thead>
                                    <tr class="bg-slate-100 text-xs font-extrabold uppercase tracking-wide text-slate-700">
                                        <th class="w-[60px] border border-slate-200 px-4 py-4 text-center">No</th>
                                        <th class="w-[230px] border border-slate-200 px-4 py-4">Lingkup Pengawasan</th>
                                        <th class="w-[300px] border border-slate-200 px-4 py-4">Indikator</th>
                                        <th class="w-[280px] border border-slate-200 px-4 py-4">Dokumen Yang Diperiksa</th>
                                        <th class="w-[300px] border border-slate-200 px-4 py-4">Upload Dokumen</th>
                                    </tr>
                                </thead>

                                <tbody class="align-top text-slate-700">
                                    <tr>
                                        <td class="border border-slate-200 px-4 py-5 text-center">1.</td>
                                        <td class="border border-slate-200 px-4 py-5 font-bold uppercase text-slate-800">
                                            Pengawasan terhadap proses pemilihan penyedia jasa
                                        </td>
                                        <td class="border border-slate-200 px-4 py-5 leading-7">
                                            Terlaksananya pemilihan Penyedia Jasa Konstruksi dilakukan sesuai dengan ketentuan peraturan perundang-undangan.
                                        </td>
                                        <td class="border border-slate-200 px-4 py-5 leading-7">
                                            Surat pernyataan Kuasa Pengguna Anggaran atau Pejabat Pembuat Komitmen bahwa proses pemilihan Penyedia Jasa Konstruksi sesuai ketentuan peraturan perundang-undangan.
                                        </td>
                                        <td class="border border-slate-200 px-4 py-5">
                                            <div class="space-y-4">
                                                <div>
                                                    <label class="mb-2 block text-xs font-bold text-slate-700">
                                                        Surat Pernyataan
                                                    </label>
                                                    <input type="file" name="surat_pernyataan_1"
                                                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs text-slate-600 file:mr-3 file:rounded-md file:border-0 file:bg-[#293F81] file:px-3 file:py-2 file:text-xs file:font-semibold file:text-white">
                                                </div>

                                                <div>
                                                    <label class="mb-2 block text-xs font-bold text-slate-700">
                                                        Dokumen Pendukung
                                                    </label>
                                                    <input type="file" name="dokumen_pendukung_1"
                                                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs text-slate-600 file:mr-3 file:rounded-md file:border-0 file:bg-yellow-400 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-slate-900">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="border border-slate-200 px-4 py-5 text-center">2.</td>
                                        <td class="border border-slate-200 px-4 py-5 font-bold uppercase text-slate-800">
                                            Pengawasan terhadap penyusunan dan pelaksanaan kontrak kerja konstruksi
                                        </td>
                                        <td class="border border-slate-200 px-4 py-5 leading-7">
                                            <ol class="list-[lower-alpha] space-y-1 pl-4">
                                                <li>Penggunaan standar kontrak.</li>
                                                <li>Penggunaan tenaga kerja konstruksi bersertifikat.</li>
                                                <li>Pemberian pekerjaan utama kepada subpenyedia jasa.</li>
                                                <li>Hak kekayaan intelektual untuk jasa konsultansi konstruksi.</li>
                                                <li>Kewajiban alih teknologi untuk kontrak dengan pihak asing.</li>
                                                <li>Penggunaan produk dalam negeri.</li>
                                                <li>Kewajiban pembayaran asuransi tenaga kerja konstruksi.</li>
                                            </ol>
                                        </td>
                                        <td class="border border-slate-200 px-4 py-5 leading-7">
                                            Surat pernyataan Kuasa Pengguna Anggaran atau Pejabat Pembuat Komitmen bahwa penyusunan dan pelaksanaan kontrak kerja konstruksi telah sesuai ketentuan.
                                        </td>
                                        <td class="border border-slate-200 px-4 py-5">
                                            <div class="space-y-4">
                                                <div>
                                                    <label class="mb-2 block text-xs font-bold text-slate-700">
                                                        Surat Pernyataan
                                                    </label>
                                                    <input type="file" name="surat_pernyataan_2"
                                                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs text-slate-600 file:mr-3 file:rounded-md file:border-0 file:bg-[#293F81] file:px-3 file:py-2 file:text-xs file:font-semibold file:text-white">
                                                </div>

                                                <div>
                                                    <label class="mb-2 block text-xs font-bold text-slate-700">
                                                        Dokumen Pendukung
                                                    </label>
                                                    <input type="file" name="dokumen_pendukung_2"
                                                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs text-slate-600 file:mr-3 file:rounded-md file:border-0 file:bg-yellow-400 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-slate-900">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="border border-slate-200 px-4 py-5 text-center">3.</td>
                                        <td class="border border-slate-200 px-4 py-5 font-bold uppercase text-slate-800">
                                            Pengawasan terhadap penerapan standar keamanan, keselamatan, kesehatan dan keberlanjutan konstruksi
                                        </td>
                                        <td class="border border-slate-200 px-4 py-5 leading-7">
                                            <ol class="list-[lower-alpha] space-y-1 pl-4">
                                                <li>Ketersediaan dokumen penerapan standar K4.</li>
                                                <li>Ketersediaan penerapan sistem manajemen keselamatan konstruksi.</li>
                                                <li>Ketersediaan dokumen bukti antisipasi kecelakaan konstruksi.</li>
                                            </ol>
                                        </td>
                                        <td class="border border-slate-200 px-4 py-5 leading-7">
                                            Surat pernyataan dari Kuasa Pengguna Anggaran atau Pejabat Pembuat Komitmen bahwa sudah memenuhi ketentuan standar K4.
                                        </td>
                                        <td class="border border-slate-200 px-4 py-5">
                                            <div class="space-y-4">
                                                <div>
                                                    <label class="mb-2 block text-xs font-bold text-slate-700">
                                                        Surat Pernyataan
                                                    </label>
                                                    <input type="file" name="surat_pernyataan_3"
                                                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs text-slate-600 file:mr-3 file:rounded-md file:border-0 file:bg-[#293F81] file:px-3 file:py-2 file:text-xs file:font-semibold file:text-white">
                                                </div>

                                                <div>
                                                    <label class="mb-2 block text-xs font-bold text-slate-700">
                                                        Dokumen Pendukung
                                                    </label>
                                                    <input type="file" name="dokumen_pendukung_3"
                                                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs text-slate-600 file:mr-3 file:rounded-md file:border-0 file:bg-yellow-400 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-slate-900">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="border border-slate-200 px-4 py-5 text-center">4.</td>
                                        <td class="border border-slate-200 px-4 py-5 font-bold uppercase text-slate-800">
                                            Pengawasan terhadap penerapan manajemen mutu konstruksi
                                        </td>
                                        <td class="border border-slate-200 px-4 py-5 leading-7">
                                            Sistem manajemen mutu konstruksi dilakukan sesuai ketentuan peraturan perundang-undangan tentang sistem manajemen mutu.
                                        </td>
                                        <td class="border border-slate-200 px-4 py-5 leading-7">
                                            Surat pernyataan dari Kuasa Pengguna Anggaran atau Pejabat Pembuat Komitmen bahwa sudah memenuhi ketentuan penerapan sistem manajemen mutu.
                                        </td>
                                        <td class="border border-slate-200 px-4 py-5">
                                            <div class="space-y-4">
                                                <div>
                                                    <label class="mb-2 block text-xs font-bold text-slate-700">
                                                        Surat Pernyataan
                                                    </label>
                                                    <input type="file" name="surat_pernyataan_4"
                                                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs text-slate-600 file:mr-3 file:rounded-md file:border-0 file:bg-[#293F81] file:px-3 file:py-2 file:text-xs file:font-semibold file:text-white">
                                                </div>

                                                <div>
                                                    <label class="mb-2 block text-xs font-bold text-slate-700">
                                                        Dokumen Pendukung
                                                    </label>
                                                    <input type="file" name="dokumen_pendukung_4"
                                                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs text-slate-600 file:mr-3 file:rounded-md file:border-0 file:bg-yellow-400 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-slate-900">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="border border-slate-200 px-4 py-5 text-center">5.</td>
                                        <td class="border border-slate-200 px-4 py-5 font-bold uppercase text-slate-800">
                                            Pengawasan terhadap penggunaan material, peralatan dan teknologi konstruksi
                                        </td>
                                        <td class="border border-slate-200 px-4 py-5 leading-7">
                                            <ol class="list-[lower-alpha] space-y-1 pl-4">
                                                <li>Pemenuhan penyediaan material, peralatan dan teknologi dalam pelaksanaan proyek konstruksi.</li>
                                                <li>Penggunaan material, peralatan, dan teknologi konstruksi sesuai SNI atau standar lain yang berlaku.</li>
                                                <li>Penggunaan produk dalam negeri sesuai ketentuan pemberdayaan industri nasional.</li>
                                            </ol>
                                        </td>
                                        <td class="border border-slate-200 px-4 py-5 leading-7">
                                            Surat pernyataan Kuasa Pengguna Anggaran atau Pejabat Pembuat Komitmen bahwa sudah memenuhi ketentuan penggunaan material, peralatan, dan teknologi konstruksi.
                                        </td>
                                        <td class="border border-slate-200 px-4 py-5">
                                            <div class="space-y-4">
                                                <div>
                                                    <label class="mb-2 block text-xs font-bold text-slate-700">
                                                        Surat Pernyataan
                                                    </label>
                                                    <input type="file" name="surat_pernyataan_5"
                                                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs text-slate-600 file:mr-3 file:rounded-md file:border-0 file:bg-[#293F81] file:px-3 file:py-2 file:text-xs file:font-semibold file:text-white">
                                                </div>

                                                <div>
                                                    <label class="mb-2 block text-xs font-bold text-slate-700">
                                                        Dokumen Pendukung
                                                    </label>
                                                    <input type="file" name="dokumen_pendukung_5"
                                                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs text-slate-600 file:mr-3 file:rounded-md file:border-0 file:bg-yellow-400 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-slate-900">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Button --}}
                    <div class="flex justify-start">
                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-xl bg-red-500 px-6 py-3 text-sm font-extrabold uppercase tracking-wide text-white shadow-lg shadow-red-500/20 transition hover:bg-red-600">
                            Simpan Data Pengawasan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection