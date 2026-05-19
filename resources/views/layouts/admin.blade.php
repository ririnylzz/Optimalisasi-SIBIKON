<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard' }}</title>

    <script>
        (function () {
            document.documentElement.dataset.theme = 'light';
            document.documentElement.classList.remove('dark');
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

    <style>
        [x-cloak] {
            display: none !important;
        }

        .scrollbar-dark::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .scrollbar-dark::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.38);
            border-radius: 9999px;
        }

        .scrollbar-dark::-webkit-scrollbar-track {
            background: transparent;
        }
    </style>
</head>

<body class="bg-slate-50 font-sans text-slate-900">
    @php
        $authUser = auth()->user();
        $displayName = $authUser?->name ?: 'Admin';
        $displayEmail = $authUser?->email ?: 'administrator@sibikon.local';
        $displayRole = 'Administrator';
        $initial = strtoupper(mb_substr($displayName, 0, 1)) ?: 'A';
    @endphp

    <div
        x-data="adminShell()"
        x-init="init()"
        class="min-h-screen bg-slate-50"
        @keydown.escape.window="
            accountMenuOpen = false;
            settingsPanelOpen = false;
            mobileSidebarOpen = false;
        "
    >
        <div class="flex min-h-screen">
            <aside
                @mouseenter="if (!sidebarPinned) sidebarHovered = true"
                @mouseleave="if (!sidebarPinned) sidebarHovered = false"
                :class="(sidebarPinned || sidebarHovered) ? 'w-[290px]' : 'w-[76px]'"
                class="fixed left-0 top-0 z-40 hidden h-screen flex-col overflow-hidden bg-[#142B67] text-white transition-all duration-300 md:flex"
            >
                <div class="pointer-events-none absolute bottom-0 right-0 opacity-[0.18]">
                    <img
                        src="{{ asset('images/logo-sibikon.png') }}"
                        alt="Decorative Logo"
                        class="w-56 translate-x-10 translate-y-8"
                    >
                </div>

                <div class="relative z-10 flex h-[74px] items-center justify-between border-b border-white/10 px-4">
                    <div class="flex min-w-0 items-center gap-3 overflow-hidden">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-white/10 ring-1 ring-white/10">
                            <img
                                src="{{ asset('images/logo-sibikon.png') }}"
                                alt="Logo SIBIKON"
                                class="h-10 w-10 object-contain"
                            >
                        </div>

                        <div x-show="sidebarPinned || sidebarHovered" x-transition class="min-w-0">
                            <h1 class="truncate text-lg font-extrabold tracking-tight text-white">
                                SIBIKON KALTIM
                            </h1>
                        </div>
                    </div>

                    <button
                        type="button"
                        @click="
                            sidebarPinned = !sidebarPinned;
                            if (sidebarPinned) sidebarHovered = false;
                        "
                        class="rounded-xl border border-white/10 bg-white/5 p-2 text-white/80 transition hover:bg-white/10"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M4 6h16M7 12h13M10 18h10" />
                        </svg>
                    </button>
                </div>

                @include('admin.partials.sidebar-desktop-menu')
            </aside>

            <div
                x-show="mobileSidebarOpen"
                x-cloak
                class="fixed inset-0 z-30 bg-slate-950/50 backdrop-blur-sm md:hidden"
                @click="mobileSidebarOpen = false"
            ></div>

            <aside
                x-show="mobileSidebarOpen"
                x-cloak
                class="fixed left-0 top-0 z-40 flex h-screen w-72 flex-col overflow-hidden bg-[#142B67] text-white md:hidden"
            >
                <div class="relative flex h-[74px] items-center justify-between border-b border-white/10 px-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center overflow-hidden rounded-2xl bg-white/10">
                            <img
                                src="{{ asset('images/logo-sibikon.png') }}"
                                alt="Logo SIBIKON"
                                class="h-10 w-10 object-contain"
                            >
                        </div>

                        <div>
                            <h1 class="text-lg font-extrabold tracking-tight">
                                SIBIKON KALTIM
                            </h1>
                        </div>
                    </div>

                    <button
                        type="button"
                        @click="mobileSidebarOpen = false"
                        class="rounded-xl border border-white/10 bg-white/5 p-2 text-white/80"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="relative flex-1 overflow-y-auto scrollbar-dark px-3 py-4">
                    <div class="pointer-events-none absolute bottom-0 right-0 opacity-[0.18]">
                        <img
                            src="{{ asset('images/logo-sibikon.png') }}"
                            alt="Decorative Logo"
                            class="w-56 translate-x-10 translate-y-8"
                        >
                    </div>

                    @include('admin.partials.sidebar-mobile-menu')
                </div>
            </aside>

            <div
                :class="(sidebarPinned || sidebarHovered) ? 'md:ml-[290px]' : 'md:ml-[76px]'"
                class="flex min-h-screen flex-1 flex-col transition-all duration-300"
            >
                <header class="admin-header sticky top-0 z-20 border-b border-slate-200/80 bg-white/90 backdrop-blur-xl">
                    <div class="flex h-20 items-center justify-between gap-4 px-4 md:px-8">
                        <div class="flex min-w-0 items-center gap-3">
                            <button
                                type="button"
                                @click="mobileSidebarOpen = !mobileSidebarOpen"
                                class="rounded-xl border border-slate-200 bg-white p-2 text-slate-600 shadow-sm md:hidden"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M4 6h16M7 12h13M10 18h10" />
                                </svg>
                            </button>

                            <div class="min-w-0">
                                <h2 class="admin-title truncate text-2xl font-extrabold tracking-tight text-slate-900">
                                    @yield('page-title', 'Dashboard')
                                </h2>
                                <p class="admin-subtitle truncate text-sm text-slate-500">
                                    @yield('page-subtitle', 'Panel admin setelah login')
                                </p>
                            </div>
                        </div>

                        <div class="relative flex shrink-0 items-center" @click.outside="accountMenuOpen = false">
                            <button
                                type="button"
                                @click="accountMenuOpen = !accountMenuOpen"
                                class="admin-account-button flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-3 py-2 shadow-sm transition hover:shadow-md focus:outline-none focus:ring-4 focus:ring-indigo-500/10"
                            >
                                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-[#3A4FAC] to-[#7282CC] text-white shadow-sm">
                                    <span class="text-sm font-bold">
                                        {{ $initial }}
                                    </span>
                                </div>

                                <div class="hidden min-w-0 text-left sm:block">
                                    <p class="max-w-[150px] truncate text-sm font-bold text-slate-900 admin-title">
                                        {{ $displayName }}
                                    </p>
                                    <p class="text-xs text-slate-500 admin-subtitle">
                                        {{ $displayRole }}
                                    </p>
                                </div>

                                <span
                                    class="hidden rounded-xl p-2 text-slate-400 transition sm:inline-flex"
                                    :class="{ 'rotate-180': accountMenuOpen }"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </button>

                            <div
                                x-show="accountMenuOpen"
                                x-cloak
                                x-transition.origin.top.right
                                class="admin-dropdown absolute right-0 top-[64px] z-50 w-72 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl"
                            >
                                <div class="border-b border-slate-100 px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-[#3A4FAC] to-[#7282CC] text-white shadow-sm">
                                            <span class="text-sm font-bold">
                                                {{ $initial }}
                                            </span>
                                        </div>

                                        <div class="min-w-0">
                                            <p class="truncate text-sm font-bold text-slate-900 admin-title">
                                                {{ $displayName }}
                                            </p>
                                            <p class="truncate text-xs text-slate-500 admin-subtitle">
                                                {{ $displayEmail }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-2">
                                    <button
                                        type="button"
                                        @click="
                                            settingsPanelOpen = true;
                                            accountMenuOpen = false;
                                        "
                                        class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left text-sm font-semibold text-indigo-700 transition hover:bg-indigo-50"
                                    >
                                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-50 text-indigo-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.757.427 1.757 2.925 0 3.352a1.724 1.724 0 00-1.065 2.572c.94 1.543-.827 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.065c-.426 1.757-2.924 1.757-3.35 0a1.724 1.724 0 00-2.573-1.065c-1.543.94-3.31-.827-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.757-.427-1.757-2.925 0-3.352a1.724 1.724 0 001.065-2.572c-.94-1.544.827-3.31 2.37-2.37.996.608 2.296.07 2.573-1.066z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </span>
                                        <span>Pengaturan</span>
                                    </button>

                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf

                                        <button
                                            type="submit"
                                            class="mt-1 flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left text-sm font-semibold text-rose-600 transition hover:bg-rose-50"
                                        >
                                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-rose-50 text-rose-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                                                </svg>
                                            </span>
                                            <span>Logout</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="admin-main flex-1 bg-slate-50 p-4 md:p-8">
                    @yield('content')
                </main>
            </div>
        </div>

        <div
            x-show="settingsPanelOpen"
            x-cloak
            class="fixed inset-0 z-[80]"
            aria-modal="true"
            role="dialog"
        >
            <div
                x-show="settingsPanelOpen"
                x-transition.opacity
                class="absolute inset-0 bg-slate-950/45 backdrop-blur-[2px]"
                @click="settingsPanelOpen = false"
            ></div>

            <aside
                x-show="settingsPanelOpen"
                x-transition:enter="transform transition ease-out duration-300"
                x-transition:enter-start="translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in duration-200"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full"
                class="settings-panel absolute right-0 top-0 flex h-full w-full max-w-[430px] flex-col border-l border-slate-200 bg-white shadow-2xl"
            >
                <div class="flex items-center justify-between border-b border-slate-200 px-5 py-5">
                    <div>
                        <h3 class="text-lg font-extrabold tracking-tight text-slate-900 admin-title">
                            Pengaturan
                        </h3>
                        <p class="mt-1 text-sm text-slate-500 settings-panel-muted">
                            Atur akun dan tampilan website.
                        </p>
                    </div>

                    <button
                        type="button"
                        @click="settingsPanelOpen = false"
                        class="rounded-xl p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto px-5 py-5">
                    <section class="settings-card rounded-3xl border border-slate-200 bg-slate-50 p-4">
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-slate-400">
                            Akun Pengguna
                        </p>

                        <div class="mt-4 flex items-center gap-4">
                            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-[#3A4FAC] to-[#7282CC] text-white shadow-sm">
                                <span class="text-base font-bold">
                                    {{ $initial }}
                                </span>
                            </div>

                            <div class="min-w-0">
                                <p class="truncate text-base font-extrabold text-slate-900 admin-title">
                                    {{ $displayName }}
                                </p>
                                <p class="truncate text-sm text-slate-500 settings-panel-muted">
                                    {{ $displayEmail }}
                                </p>
                                <span class="mt-2 inline-flex rounded-full bg-indigo-100 px-3 py-1 text-xs font-bold text-indigo-700">
                                    {{ $displayRole }}
                                </span>
                            </div>
                        </div>
                    </section>

                    <section class="mt-5">
                        <div class="mb-3">
                            <h4 class="text-sm font-extrabold text-slate-900 admin-title">
                                Mode Tampilan
                            </h4>
                            <p class="mt-1 text-sm text-slate-500 settings-panel-muted">
                                Pilihan mode hanya ditampilkan. Fitur pergantian mode belum diaktifkan.
                            </p>
                        </div>

                        <div class="space-y-3">
                            <button
                                type="button"
                                class="settings-card flex w-full items-center gap-4 rounded-2xl border border-indigo-500 bg-indigo-50 p-4 text-left ring-4 ring-indigo-500/10 transition"
                            >
                                <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-amber-50 text-amber-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364-6.364l-1.414 1.414M7.05 16.95l-1.414 1.414m12.728 0l-1.414-1.414M7.05 7.05L5.636 5.636M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </span>

                                <span class="min-w-0 flex-1">
                                    <span class="block text-sm font-bold text-slate-900 admin-title">
                                        Light mode
                                    </span>
                                    <span class="mt-1 block text-xs text-slate-500 settings-panel-muted">
                                        Tampilan terang untuk penggunaan normal.
                                    </span>
                                </span>

                                <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full border border-indigo-600 bg-indigo-600">
                                    <span class="h-2 w-2 rounded-full bg-white"></span>
                                </span>
                            </button>

                            <button
                                type="button"
                                class="settings-card flex w-full cursor-default items-center gap-4 rounded-2xl border border-slate-200 bg-white p-4 text-left transition hover:border-slate-200 hover:bg-white"
                            >
                                <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-slate-900 text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M21.752 15.002A9.718 9.718 0 0112 21.75 9.75 9.75 0 1112.998 2a7.5 7.5 0 008.754 13.002z" />
                                    </svg>
                                </span>

                                <span class="min-w-0 flex-1">
                                    <span class="block text-sm font-bold text-slate-900 admin-title">
                                        Dark mode
                                    </span>
                                    <span class="mt-1 block text-xs text-slate-500 settings-panel-muted">
                                        Hanya display, belum berfungsi.
                                    </span>
                                </span>

                                <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white"></span>
                            </button>

                            <button
                                type="button"
                                class="settings-card flex w-full cursor-default items-center gap-4 rounded-2xl border border-slate-200 bg-white p-4 text-left transition hover:border-slate-200 hover:bg-white"
                            >
                                <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-sky-50 text-sky-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M9.75 17L9 21l3-1.5L15 21l-.75-4M4.5 4.5h15v10.5h-15V4.5zm3 3h9m-9 3h5" />
                                    </svg>
                                </span>

                                <span class="min-w-0 flex-1">
                                    <span class="block text-sm font-bold text-slate-900 admin-title">
                                        Ikuti sistem
                                    </span>
                                    <span class="mt-1 block text-xs text-slate-500 settings-panel-muted">
                                        Hanya display, belum berfungsi.
                                    </span>
                                </span>

                                <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white"></span>
                            </button>
                        </div>
                    </section>

                    <section class="mt-5 rounded-3xl border border-slate-200 bg-white p-4 settings-card">
                        <h4 class="text-sm font-extrabold text-slate-900 admin-title">
                            Session Akun
                        </h4>
                        <p class="mt-1 text-sm text-slate-500 settings-panel-muted">
                            Keluar dari akun admin aktif.
                        </p>

                        <form action="{{ route('logout') }}" method="POST" class="mt-4">
                            @csrf

                            <button
                                type="submit"
                                class="flex w-full items-center justify-center gap-2 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-bold text-rose-600 transition hover:bg-rose-100"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </section>
                </div>
            </aside>
        </div>
    </div>

    <script>
        function adminShell() {
            return {
                sidebarPinned: true,
                sidebarHovered: false,
                mobileSidebarOpen: false,
                accountMenuOpen: false,
                settingsPanelOpen: false,

                init() {
                    document.documentElement.dataset.theme = 'light';
                    document.documentElement.classList.remove('dark');
                    localStorage.removeItem('sibikon_theme_mode');
                },
            };
        }
    </script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>
</html>