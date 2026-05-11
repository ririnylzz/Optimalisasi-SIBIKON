@extends('layouts.app')

@section('content')
    <section class="bg-white py-16 px-6">
        <div class="max-w-6xl mx-auto">

            {{-- Header --}}
            <div class="text-center mb-12">
                <span class="inline-block bg-[#f1d00a]/60 text-[#21325e] text-xs font-semibold px-4 py-2 rounded-full mb-4">
                    Hubungi Kami
                </span>

                <h1 class="text-3xl md:text-4xl font-extrabold text-[#21325e] mb-3">
                    Kontak & Lokasi
                </h1>

                <p class="text-[#7282cc] text-sm">
                    Silakan hubungi kami untuk informasi lebih lanjut mengenai layanan SIBIKON
                </p>
            </div>

            {{-- Kontak dan Peta --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-stretch mb-16">

                {{-- Peta --}}
                <div class="h-96 rounded-2xl bg-[#c5cae9]/50 flex items-center justify-center">
                    <div class="text-center text-[#21325e]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 11.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 9c0 7.5-7.5 12-7.5 12S4.5 16.5 4.5 9a7.5 7.5 0 1115 0z" />
                        </svg>
                        <p class="text-xl font-semibold">Peta Lokasi</p>
                    </div>
                </div>

                {{-- Informasi Kontak --}}
                <div class="h-96 flex flex-col justify-center">
                    <h2 class="text-3xl font-extrabold text-[#21325e] mb-10">
                        Informasi Kontak
                    </h2>

                    <div class="space-y-8">

                        {{-- Alamat --}}
                        <div class="flex gap-5 items-start">
                            <div class="w-16 h-16 rounded-xl bg-[#21325e] text-white flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none"
                                    viewBox="0 0 24 24" stroke="#f1d00a" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 11.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 9c0 7.5-7.5 12-7.5 12S4.5 16.5 4.5 9a7.5 7.5 0 1115 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-[#21325e] text-2xl mb-1">Alamat</h3>
                                <p class="text-lg text-[#21325e]/70 leading-relaxed">
                                    Jalan. Tengkawang No.1, Samarinda
                                </p>
                            </div>
                        </div>

                        {{-- Telepon --}}
                        <div class="flex gap-5 items-start">
                            <div class="w-16 h-16 rounded-xl bg-[#21325e] text-white flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none"
                                    viewBox="0 0 24 24" stroke="#f1d00a" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 5a2 2 0 012-2h3.28a2 2 0 011.94 1.515l.57 2.28a2 2 0 01-.45 1.91l-1.27 1.27a16 16 0 006.36 6.36l1.27-1.27a2 2 0 011.91-.45l2.28.57A2 2 0 0121 15.72V19a2 2 0 01-2 2h-1C9.163 21 3 14.837 3 7V5z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-[#21325e] text-2xl mb-1">Telepon</h3>
                                <p class="text-lg text-[#21325e]/70">(+0541) ......</p>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="flex gap-5 items-start">
                            <div class="w-16 h-16 rounded-xl bg-[#21325e] text-white flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none"
                                    viewBox="0 0 24 24" stroke="#f1d00a" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-[#21325e] text-2xl mb-1">Email</h3>
                                <p class="text-lg text-[#21325e]/70">bikon.kaltim@gmail.com</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            {{-- Form Kotak Saran --}}
            <div class="w-full bg-white rounded-[28px] shadow-xl border border-[#c5cae9]/50 p-8 md:p-10">
                <h2 class="text-2xl font-extrabold text-[#21325e] mb-4">
                    Kotak saran
                </h2>
                
                <p class="text-m text-[#21325e]/70 mb-8">
                    Berikan Masukan dan Saran Anda terkait Kegiatan yang dilaksanakan oleh Bidang Bina Konstruksi Dinas Pekerjaan Umum Penataan Ruang dan Perumahaan Rakyat Provinsi Kalimantan Timur.
                </p>

                <form action="#" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-base font-bold text-[#21325e] mb-3">
                                Nama Lengkap
                            </label>
                            <input
                                type="text"
                                name="nama"
                                placeholder="Masukkan nama lengkap"
                                class="w-full h-14 rounded-lg border border-[#c5cae9] px-5 text-base focus:outline-none focus:border-[#3a4fac] focus:ring-4 focus:ring-[#7282cc]/20">
                        </div>

                        <div>
                            <label class="block text-base font-bold text-[#21325e] mb-3">
                                Email
                            </label>
                            <input
                                type="email"
                                name="email"
                                placeholder="nama@email.com"
                                class="w-full h-14 rounded-lg border border-[#c5cae9] px-5 text-base focus:outline-none focus:border-[#3a4fac] focus:ring-4 focus:ring-[#7282cc]/20">
                        </div>
                    </div>

                    <div>
                        <label class="block text-base font-bold text-[#21325e] mb-3">
                            Subjek
                        </label>
                        <input
                            type="text"
                            name="subjek"
                            placeholder="Subjek pesan"
                            class="w-full h-14 rounded-lg border border-[#c5cae9] px-5 text-base focus:outline-none focus:border-[#3a4fac] focus:ring-4 focus:ring-[#7282cc]/20">
                    </div>

                    <div>
                        <label class="block text-base font-bold text-[#21325e] mb-3">
                            Pesan
                        </label>
                        <textarea
                            name="pesan"
                            rows="6"
                            placeholder="Tulis pesan Anda di sini..."
                            class="w-full rounded-lg border border-[#c5cae9] px-5 py-4 text-base resize-none focus:outline-none focus:border-[#3a4fac] focus:ring-4 focus:ring-[#7282cc]/20"></textarea>
                    </div>

                    <button
                        type="submit"
                        class="w-full h-14 rounded-lg bg-[#21325e] text-white text-lg font-bold flex items-center justify-center gap-3 hover:bg-[#3a4fac] transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.768 59.768 0 013.27 20.876L6 12zm0 0h7.5" />
                        </svg>
                        Kirim Pesan
                    </button>
                </form>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggles = document.querySelectorAll('#fungsi-bikon .accordion-toggle');

        toggles.forEach((btn) => {
            btn.addEventListener('click', function() {
                const target = document.getElementById(this.dataset.target);
                const arrow = this.querySelector('.arrow');
                const isHidden = target.classList.contains('hidden');

                document.querySelectorAll('#fungsi-bikon .accordion-content').forEach((item) => {
                    item.classList.add('hidden');
                });

                document.querySelectorAll('#fungsi-bikon .arrow').forEach((item) => {
                    item.classList.remove('rotate-180');
                });

                if (isHidden) {
                    target.classList.remove('hidden');
                    arrow.classList.add('rotate-180');
                }
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.nav-dropdown-btn');

        buttons.forEach((button) => {
            button.addEventListener('click', function(e) {
                e.stopPropagation();

                const dropdownId = this.dataset.dropdown;
                const dropdown = document.getElementById(dropdownId);
                const arrow = this.querySelector('.dropdown-arrow');

                document.querySelectorAll('.nav-dropdown').forEach((item) => {
                    if (item !== dropdown) {
                        item.classList.add('hidden');
                    }
                });

                document.querySelectorAll('.dropdown-arrow').forEach((item) => {
                    if (item !== arrow) {
                        item.classList.remove('rotate-180');
                    }
                });

                dropdown.classList.toggle('hidden');
                arrow.classList.toggle('rotate-180');
            });
        });

        document.querySelectorAll('.nav-dropdown').forEach((dropdown) => {
            dropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });

        document.addEventListener('click', function() {
            document.querySelectorAll('.nav-dropdown').forEach((item) => {
                item.classList.add('hidden');
            });

            document.querySelectorAll('.dropdown-arrow').forEach((item) => {
                item.classList.remove('rotate-180');
            });
        });
    });
</script>
@endpush