@extends('layouts.app')

@section('content')
<section class="bg-white py-16 px-6">
    <div class="max-w-6xl mx-auto">

        {{-- Header --}}
        <div class="text-center mb-12">
            <span class="inline-flex items-center rounded-full bg-[#ECCC4B] px-5 py-2 text-sm font-medium text-slate-900">
                Hubungi kami
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
            <div class="h-96 overflow-hidden rounded-2xl bg-[#c5cae9]/50 shadow-sm">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3054.5877894269597!2d117.11029317352599!3d-0.5011770994938999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df67f94ab657bf1%3A0xc12f900bf7677ca4!2sDinas%20Pekerjaan%20Umum%2C%20Penataan%20Ruang%20dan%20Perumahan%20Rakyat%20Prov.%20Kaltim!5e1!3m2!1sid!2sid!4v1778658567387!5m2!1sid!2sid"
                    class="h-full w-full"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
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
        <div class="mx-auto w-full max-w-5xl rounded-[22px] border border-[#c5cae9]/50 bg-white p-6 shadow-lg md:p-8">
            <h2 class="mb-3 text-2xl font-extrabold text-[#21325e]">
                Kotak Saran
            </h2>

            <p class="mb-6 text-sm leading-7 text-[#21325e]/70 md:text-base">
                Berikan Masukan dan Saran Anda terkait kegiatan yang dilaksanakan oleh Bidang Bina Konstruksi
                Dinas Pekerjaan Umum Penataan Ruang dan Perumahan Rakyat Provinsi Kalimantan Timur.
            </p>

            <form action="#" method="POST" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-bold text-[#21325e]">
                            Nama Lengkap
                        </label>
                        <input
                            type="text"
                            name="nama"
                            placeholder="Masukkan nama lengkap"
                            class="h-12 w-full rounded-lg border border-[#c5cae9] px-4 text-sm focus:border-[#3a4fac] focus:outline-none focus:ring-4 focus:ring-[#7282cc]/20">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-[#21325e]">
                            Email
                        </label>
                        <input
                            type="email"
                            name="email"
                            placeholder="nama@email.com"
                            class="h-12 w-full rounded-lg border border-[#c5cae9] px-4 text-sm focus:border-[#3a4fac] focus:outline-none focus:ring-4 focus:ring-[#7282cc]/20">
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold text-[#21325e]">
                        Subjek
                    </label>
                    <input
                        type="text"
                        name="subjek"
                        placeholder="Subjek pesan"
                        class="h-12 w-full rounded-lg border border-[#c5cae9] px-4 text-sm focus:border-[#3a4fac] focus:outline-none focus:ring-4 focus:ring-[#7282cc]/20">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold text-[#21325e]">
                        Pesan
                    </label>
                    <textarea
                        name="pesan"
                        rows="4"
                        placeholder="Tulis pesan Anda di sini..."
                        class="min-h-[120px] max-h-[260px] w-full resize-y rounded-lg border border-[#c5cae9] px-4 py-3 text-sm focus:border-[#3a4fac] focus:outline-none focus:ring-4 focus:ring-[#7282cc]/20"></textarea>
                </div>

                <button
                    type="submit"
                    class="flex h-12 w-full items-center justify-center gap-3 rounded-lg bg-[#21325e] text-base font-bold text-white transition hover:bg-[#3a4fac]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
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