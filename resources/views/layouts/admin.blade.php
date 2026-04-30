<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }

        .scrollbar-dark::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .scrollbar-dark::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.45);
            border-radius: 9999px;
        }

        .scrollbar-dark::-webkit-scrollbar-track {
            background: transparent;
        }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-900">
    <div
        x-data="{ sidebarPinned: true, sidebarHovered: false, mobileSidebarOpen: false }"
        class="min-h-screen bg-slate-50"
    >
        <div class="flex min-h-screen">
            {{-- Sidebar Desktop --}}
            <aside
                @mouseenter="if (!sidebarPinned) sidebarHovered = true"
                @mouseleave="if (!sidebarPinned) sidebarHovered = false"
                :class="(sidebarPinned || sidebarHovered) ? 'w-[290px]' : 'w-[76px]'"
                class="fixed left-0 top-0 z-40 hidden h-screen flex-col overflow-hidden bg-[#142B67] text-white transition-all duration-300 md:flex"
            >
                {{-- Background decoration --}}
                <div class="pointer-events-none absolute bottom-0 right-0 opacity-[0.18]">
                    <img
                        src="{{ asset('images/logo-sibikon.png') }}"
                        alt="Decorative Logo"
                        class="w-56 translate-x-10 translate-y-8"
                    >
                </div>

                {{-- Brand --}}
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
                            <h1 class="truncate text-lg font-extrabold tracking-tight text-white">SIBIKON KALTIM</h1>
                        </div>
                    </div>

                    <button
                        @click="
                            sidebarPinned = !sidebarPinned;
                            if (sidebarPinned) sidebarHovered = false;
                        "
                        class="rounded-xl border border-white/10 bg-white/5 p-2 text-white/80 transition hover:bg-white/10"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M7 12h13M10 18h10" />
                        </svg>
                    </button>
                </div>

                @include('admin.partials.sidebar-desktop-menu')
            </aside>

            {{-- Overlay mobile --}}
            <div
                x-show="mobileSidebarOpen"
                x-cloak
                class="fixed inset-0 z-30 bg-slate-950/50 backdrop-blur-sm md:hidden"
                @click="mobileSidebarOpen = false"
            ></div>

            {{-- Sidebar mobile --}}
            <aside
                x-show="mobileSidebarOpen"
                x-cloak
                class="fixed left-0 top-0 z-40 flex h-screen w-72 flex-col overflow-hidden bg-[#142B67] text-white md:hidden"
            >
                <div class="relative flex h-[74px] items-center justify-between border-b border-white/10 px-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center overflow-hidden rounded-2xl bg-white/10">
                            <img src="{{ asset('images/logo-sibikon.png') }}" alt="Logo SIBIKON" class="h-10 w-10 object-contain">
                        </div>
                        <div>
                            <h1 class="text-lg font-extrabold tracking-tight">SIBIKON KALTIM</h1>
                        </div>
                    </div>

                    <button @click="mobileSidebarOpen = false" class="rounded-xl border border-white/10 bg-white/5 p-2 text-white/80">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="relative flex-1 overflow-y-auto scrollbar-dark px-3 py-4">
                    <div class="pointer-events-none absolute bottom-0 right-0 opacity-[0.18]">
                        <img src="{{ asset('images/logo-sibikon.png') }}" alt="Decorative Logo" class="w-56 translate-x-10 translate-y-8">
                    </div>

                    @include('admin.partials.sidebar-mobile-menu')
                </div>
            </aside>

            {{-- Main --}}
            <div
                :class="(sidebarPinned || sidebarHovered) ? 'md:ml-[290px]' : 'md:ml-[76px]'"
                class="flex min-h-screen flex-1 flex-col transition-all duration-300"
            >
                {{-- Topbar --}}
                <header class="sticky top-0 z-20 border-b border-slate-200/80 bg-white/90 backdrop-blur-xl">
                    <div class="flex h-20 items-center justify-between gap-4 px-4 md:px-8">
                        <div class="flex min-w-0 items-center gap-3">
                            <button
                                @click="mobileSidebarOpen = !mobileSidebarOpen"
                                class="rounded-xl border border-slate-200 bg-white p-2 text-slate-600 shadow-sm md:hidden"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M7 12h13M10 18h10" />
                                </svg>
                            </button>

                            <div class="min-w-0">
                                <h2 class="truncate text-2xl font-extrabold tracking-tight text-slate-900">@yield('page-title', 'Dashboard')</h2>
                                <p class="truncate text-sm text-slate-500">@yield('page-subtitle', 'Panel admin setelah login')</p>
                            </div>
                        </div>

                        <div class="flex shrink-0 items-center">
                            <div class="group flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-3 py-2 shadow-sm transition hover:shadow-md">
                                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-[#3A4FAC] to-[#7282CC] text-white shadow-sm">
                                    <span class="text-sm font-bold">
                                        {{ strtoupper(substr(auth()->check() ? auth()->user()->name : 'Admin', 0, 1)) }}
                                    </span>
                                </div>

                                <div class="hidden min-w-0 text-left sm:block">
                                    <p class="truncate text-sm font-bold text-slate-900">
                                        {{ auth()->check() ? auth()->user()->name : 'Admin' }}
                                    </p>
                                    <p class="text-xs text-slate-500">Administrator</p>
                                </div>

                                <button
                                    type="button"
                                    class="hidden rounded-xl p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-600 sm:inline-flex"
                                    title="Menu Akun"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="flex-1 bg-slate-50 p-4 md:p-8">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>
</html>