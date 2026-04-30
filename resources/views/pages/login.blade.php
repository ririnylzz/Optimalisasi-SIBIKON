<section class="min-h-screen relative overflow-hidden bg-[#1f315c]">
    {{-- Background --}}
    <div
        class="absolute inset-0 bg-cover bg-center"
        style="background-image: url('{{ asset('images/gedung-dinas-PUPR.jpg') }}');"></div>

    {{-- Overlay biru gelap --}}
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

            {{-- Card Login --}}
            <div class="w-full max-w-[520px] mx-auto bg-white rounded-[28px] shadow-2xl px-8 md:px-12 py-10">
                <h2 class="text-center text-[#243966] text-2xl md:text-3xl font-extrabold mb-9">
                    Login to your account
                </h2>

                <a href="{{ route('beranda') }}"
                    class="absolute top-8 left-8 flex items-center gap-2 text-white font-medium hover:opacity-80 transition">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>

                    <span>Kembali</span>
                </a>

                <form action="#" method="POST" class="space-y-6">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-[#243966] font-semibold mb-2">
                            Email/Username
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
                                type="email"
                                id="email"
                                name="email"
                                placeholder="Massukkan email atau username"
                                class="sibikon-input w-full h-12 rounded-lg pl-12 pr-4 text-sm font-medium">
                        </div>
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-[#243966] font-semibold mb-2">
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
                                id="password"
                                name="password"
                                placeholder="Masukkan password"
                                class="sibikon-input w-full h-12 rounded-lg pl-12 pr-12 text-sm font-medium">

                            <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#7182A8]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Remember + Forgot --}}
                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center gap-3 text-[#243966] font-medium">
                            <input
                                type="checkbox"
                                checked
                                class="w-4 h-4 rounded accent-[#243966]">
                            Ingat saya
                        </label>

                        <a href="#" class="text-[#243966] font-semibold hover:underline">
                            Lupa password?
                        </a>
                    </div>

                    {{-- Button --}}
                    <button
                        type="submit"
                        class="w-full h-12 rounded-lg bg-[#243966] text-white font-bold hover:bg-[#1d2f57] transition">
                        Masuk
                    </button>

                    {{-- Register --}}
                    <p class="text-center text-sm text-[#6B7898]">
                        Belum punya akun?
                        <a href="{{ route('regist') }}" class="text-[#243966] font-semibold hover:underline">
                            Daftar sekarang
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>