@if(session('success'))
    <div id="login-toast-template" class="hidden">
        <div
            id="login-toast-wrapper"
            style="position: fixed !important; top: 24px !important; right: 24px !important; z-index: 999999 !important; width: 100%; max-width: 360px;"
        >
            <div
                id="login-toast"
                class="rounded-2xl border border-emerald-200 bg-emerald-500 px-4 py-3 text-white shadow-2xl transition-all duration-300"
            >
                <div class="flex items-start gap-3">
                    <div class="mt-0.5 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                    </div>

                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-bold">Berhasil</p>
                        <p class="mt-1 text-sm leading-5 text-white/95">
                            {{ session('success') }}
                        </p>
                    </div>

                    <button
                        type="button"
                        id="login-toast-close"
                        class="shrink-0 rounded-lg p-1 text-white/80 transition hover:bg-white/10 hover:text-white"
                        aria-label="Tutup notifikasi"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif

<section class="min-h-screen relative overflow-hidden bg-[#1f315c]">
    <div
        class="absolute inset-0 bg-cover bg-center"
        style="background-image: url('{{ asset('images/gedung-dinas-PUPR.jpg') }}');"
    ></div>

    <div class="absolute inset-0 bg-[#1f315c]/90"></div>

    <div class="relative z-10 min-h-screen flex items-center justify-center px-6 py-10">
        <div class="w-full max-w-6xl grid grid-cols-1 lg:grid-cols-2 items-center gap-10">
            <div class="text-center lg:text-left flex flex-col items-center lg:items-start">
                <img
                    src="{{ asset('images/logo-sibikon.png') }}"
                    alt="Logo SIBIKON"
                    class="w-36 h-36 md:w-44 md:h-44 object-contain mb-6"
                >

                <h1 class="text-white text-5xl md:text-7xl font-extrabold tracking-wide leading-none">
                    SIBIKON
                </h1>

                <p class="mt-4 text-white text-2xl md:text-4xl font-semibold leading-tight">
                    Sistem Bina Konstruksi
                </p>
            </div>

            <div class="w-full max-w-[520px] mx-auto bg-white rounded-[28px] shadow-2xl px-8 md:px-12 py-10">
                <h2 class="text-center text-[#243966] text-2xl md:text-3xl font-extrabold mb-9">
                    Login to your account
                </h2>

                @if($errors->any())
                    <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                        <p class="font-semibold">Login gagal</p>
                        <ul class="mt-1 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                    @csrf

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
                                type="text"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="Masukkan email atau username"
                                required
                                oninvalid="this.setCustomValidity('Email atau username wajib diisi.')"
                                oninput="this.setCustomValidity('')"
                                class="sibikon-input w-full h-12 rounded-lg pl-12 pr-4 text-sm font-medium"
                            >
                        </div>
                    </div>

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
                                required
                                oninvalid="this.setCustomValidity('Password wajib diisi.')"
                                oninput="this.setCustomValidity('')"
                                class="sibikon-input w-full h-12 rounded-lg pl-12 pr-14 text-sm font-medium"
                            >

                            <button
                                type="button"
                                id="toggle-password"
                                class="absolute inset-y-0 right-0 z-20 flex w-12 items-center justify-center text-[#7182A8] transition hover:text-[#243966]"
                                aria-label="Lihat password"
                            >
                                <svg
                                    id="eye-open-icon"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>

                                <svg
                                    id="eye-closed-icon"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="hidden w-5 h-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 3l18 18" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10.584 10.587A2 2 0 0012 14a2 2 0 001.414-3.414" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.88 5.09A9.77 9.77 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.02 10.02 0 01-3.146 4.568M6.67 6.67A10.02 10.02 002.458 12C3.732 16.057 7.523 19 12 19a9.77 9.77 0 004.33-.998" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center gap-3 text-[#243966] font-medium cursor-pointer">
                            <input
                                type="checkbox"
                                id="remember"
                                name="remember"
                                value="1"
                                @checked(old('remember', true))
                                class="w-4 h-4 rounded accent-[#243966]"
                            >
                            Ingat saya
                        </label>

                        <a href="#" class="text-[#243966] font-semibold hover:underline">
                            Lupa password?
                        </a>
                    </div>

                    <button
                        type="submit"
                        class="w-full h-12 rounded-lg bg-[#243966] text-white font-bold hover:bg-[#1d2f57] transition"
                    >
                        Masuk
                    </button>

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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toastTemplate = document.getElementById('login-toast-template');

            if (toastTemplate) {
                const toastWrapper = toastTemplate.querySelector('#login-toast-wrapper');

                if (toastWrapper) {
                    document.body.appendChild(toastWrapper);
                    toastTemplate.remove();

                    const toast = document.getElementById('login-toast');
                    const toastClose = document.getElementById('login-toast-close');

                    const dismissToast = () => {
                        if (!toast || !toastWrapper) return;

                        toast.classList.add('translate-x-4', 'opacity-0');

                        setTimeout(() => {
                            toastWrapper.remove();
                        }, 300);
                    };

                    setTimeout(dismissToast, 3000);

                    if (toastClose) {
                        toastClose.addEventListener('click', dismissToast);
                    }
                }
            }

            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('toggle-password');
            const eyeOpenIcon = document.getElementById('eye-open-icon');
            const eyeClosedIcon = document.getElementById('eye-closed-icon');

            if (passwordInput && togglePassword) {
                togglePassword.addEventListener('click', function () {
                    const passwordIsHidden = passwordInput.type === 'password';

                    passwordInput.type = passwordIsHidden ? 'text' : 'password';

                    if (eyeOpenIcon && eyeClosedIcon) {
                        eyeOpenIcon.classList.toggle('hidden', passwordIsHidden);
                        eyeClosedIcon.classList.toggle('hidden', !passwordIsHidden);
                    }

                    togglePassword.setAttribute(
                        'aria-label',
                        passwordIsHidden ? 'Sembunyikan password' : 'Lihat password'
                    );
                });
            }
        });
    </script>
</section>