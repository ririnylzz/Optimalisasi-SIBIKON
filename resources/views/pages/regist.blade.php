<section class="min-h-screen relative overflow-hidden bg-[#1f315c]">
    <div
        class="absolute inset-0 bg-cover bg-center"
        style="background-image: url('{{ asset('images/gedung-dinas-PUPR.jpg') }}');"></div>

    <div class="absolute inset-0 bg-[#1f315c]/90"></div>

    <div class="relative z-10 min-h-screen flex items-center justify-center px-6 py-10">
        <div class="w-full max-w-6xl grid grid-cols-1 lg:grid-cols-2 items-center gap-10">

            {{-- Kiri --}}
            <div class="text-center lg:text-left flex flex-col items-center lg:items-start">
                <img
                    src="{{ asset('images/logo-sibikon.png') }}"
                    alt="Logo SIBIKON"
                    class="w-36 h-36 md:w-44 md:h-44 object-contain mb-6">

                <h1 class="text-white text-5xl md:text-7xl font-extrabold tracking-wide leading-none">
                    SIBIKON
                </h1>

                <p class="mt-4 text-white text-2xl md:text-4xl font-semibold leading-tight">
                    Sistem Bina Konstruksi
                </p>
            </div>

            {{-- Card Registrasi --}}
            <div class="relative w-full max-w-[520px] mx-auto bg-white rounded-[26px] shadow-2xl px-8 py-7">
                <button
                    id="btn-back"
                    type="button"
                    onclick="showStep1()"
                    class="hidden absolute left-8 top-7 text-[#243966] hover:opacity-75 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </button>

                <h2 class="text-center text-[#243966] text-2xl font-extrabold mb-5">
                    Registrasi
                </h2>

                <form action="#" method="POST" class="space-y-4">
                    @csrf

                    {{-- STEP 1 --}}
                    <div id="step-1" class="space-y-3">
                        <div class="flex gap-3 rounded-lg border border-[#D7DCE8] bg-[#F7F8FC] px-4 py-3 text-[#243966]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 mt-0.5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
                            </svg>

                            <p class="text-sm leading-relaxed">
                                <span class="font-bold">Informasi!</span>
                                Apabila NIK dan Email telah terdaftar, silahkan login dengan memasukkan Email pada kolom email dan NIK pada kolom Password.
                            </p>
                        </div>

                        <div>
                            <label class="block text-[#243966] text-sm font-semibold mb-1.5">
                                Nama Lengkap
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#7182A8]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.5-1.632z" />
                                    </svg>
                                </span>
                                <input
                                    type="text"
                                    name="nama"
                                    placeholder="Masukkan nama lengkap"
                                    class="sibikon-input w-full h-10 rounded-lg pl-12 pr-4 text-sm font-medium">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[#243966] text-sm font-semibold mb-1.5">
                                NIK (Nomor Induk Kependudukan)
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#7182A8]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12h6m-6 4h6M7 4h10l2 2v14H5V4h2z" />
                                    </svg>
                                </span>
                                <input
                                    type="text"
                                    name="nik"
                                    maxlength="16"
                                    placeholder="16 digit NIK"
                                    class="sibikon-input w-full h-10 rounded-lg pl-12 pr-4 text-sm font-medium">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[#243966] text-sm font-semibold mb-1.5">
                                Email
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#7182A8]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </span>
                                <input
                                    type="search"
                                    name="reg_surel_pendaftar"
                                    placeholder="nama@email.com"
                                    class="sibikon-input w-full h-10 rounded-lg pl-12 pr-4 text-sm font-medium">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[#243966] text-sm font-semibold mb-1.5">
                                No. Telepon / WhatsApp
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#7182A8]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 5a2 2 0 012-2h3.28a2 2 0 011.94 1.515l.57 2.28a2 2 0 01-.45 1.91l-1.27 1.27a16 16 0 006.36 6.36l1.27-1.27a2 2 0 011.91-.45l2.28.57A2 2 0 0121 15.72V19a2 2 0 01-2 2h-1C9.163 21 3 14.837 3 7V5z" />
                                    </svg>
                                </span>
                                <input
                                    type="text"
                                    name="telepon"
                                    placeholder="08xxxxxxxxxx"
                                    class="sibikon-input w-full h-10 rounded-lg pl-12 pr-4 text-sm font-medium">
                            </div>
                        </div>

                        <button
                            type="button"
                            onclick="showStep2()"
                            class="w-full h-10 rounded-lg bg-[#243966] text-white text-sm font-bold hover:bg-[#1d2f57] transition">
                            Selanjutnya
                        </button>

                        <!-- <p class="text-center text-sm text-[#6B7898] pt-2">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="text-[#243966] font-semibold hover:underline">
                                Masuk
                            </a>
                        </p> -->
                    </div>

                    {{-- STEP 2 --}}
                    <div id="step-2" class="hidden space-y-4 py-10">
                        <div>
                            <label class="block text-[#243966] text-sm font-semibold mb-2">
                                Password
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#7182A8]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </span>
                                <input
                                    type="password"
                                    name="password"
                                    placeholder="Minimal 8 karakter"
                                    class="sibikon-input w-full h-10 rounded-lg pl-12 pr-12 text-sm font-medium">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[#243966] text-sm font-semibold mb-2">
                                Konfirmasi Password
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#7182A8]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </span>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    placeholder="Ulangi password"
                                    class="sibikon-input w-full h-10 rounded-lg pl-12 pr-12 text-sm font-medium">
                            </div>
                        </div>

                        <button
                            type="submit"
                            class="w-full h-10 rounded-lg bg-[#243966] text-white text-sm font-bold hover:bg-[#1d2f57] transition">
                            Daftar
                        </button>

                        <p class="text-center text-sm text-[#6B7898] pt-2">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="text-[#243966] font-semibold hover:underline">
                                Masuk
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    function showStep2() {
        document.getElementById('step-1').classList.add('hidden');
        document.getElementById('step-2').classList.remove('hidden');
        document.getElementById('btn-back').classList.remove('hidden');
    }

    function showStep1() {
        document.getElementById('step-2').classList.add('hidden');
        document.getElementById('step-1').classList.remove('hidden');
        document.getElementById('btn-back').classList.add('hidden');
    }
</script>