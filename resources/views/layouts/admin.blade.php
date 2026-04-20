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
            background: #334155;
            border-radius: 9999px;
        }

        .scrollbar-dark::-webkit-scrollbar-track {
            background: #020617;
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 font-sans">
        <div x-data="{ sidebarPinned: true, sidebarHovered: false, mobileSidebarOpen: false }" class="min-h-screen bg-slate-950">        <div class="flex min-h-screen">
            {{-- Sidebar desktop --}}
            <aside
                @mouseenter="if (!sidebarPinned) sidebarHovered = true"
                @mouseleave="if (!sidebarPinned) sidebarHovered = false"
                :class="(sidebarPinned || sidebarHovered) ? 'w-64' : 'w-16'"
                class="fixed left-0 top-0 z-40 hidden h-screen flex-col border-r border-slate-800 bg-slate-950 transition-all duration-300 md:flex"
            >
                {{-- Brand --}}
                <div class="flex h-14 items-center justify-between border-b border-slate-800 px-3">
                    <div class="flex items-center gap-2 overflow-hidden">
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-indigo-600/20 ring-1 ring-indigo-500/30">
                            <span class="text-sm font-bold text-indigo-300">S</span>
                        </div>

                        <div x-show="sidebarPinned || sidebarHovered" x-transition class="min-w-0">
                            <h1 class="truncate text-sm font-bold tracking-tight">SIBIKON KALTIM</h1>
                            <p class="text-[11px] text-slate-400">Panel Admin</p>
                        </div>
                    </div>

                    <button
                        @click="
                            sidebarPinned = !sidebarPinned;
                            if (sidebarPinned) sidebarHovered = false;
                        "
                        class="rounded-md border border-slate-700 p-1.5 text-slate-300 hover:bg-slate-800"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M4 6h16M7 12h13M10 18h10" />
                        </svg>
                    </button>
                </div>

                {{-- Menu --}}
                <div class="flex-1 overflow-y-auto scrollbar-dark px-2 py-2">
                    {{-- Dashboard --}}
                    <div class="mb-4">
                        <p x-show="sidebarPinned || sidebarHovered" class="mb-1.5 px-2 text-[10px] font-semibold uppercase tracking-wider text-slate-500">
                            Menu
                        </p>

                        <a href="{{ route('admin.dashboard') }}"
                           class="group flex items-center gap-2 rounded-lg px-2.5 py-2 text-xs font-semibold transition
                           {{ request()->routeIs('admin.dashboard') ? 'border border-slate-700 bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                      d="M3 12l9-9 9 9M4.5 10.5V20a1 1 0 001 1h4.5v-6h4v6H18.5a1 1 0 001-1v-9.5"/>
                            </svg>
                            <span x-show="sidebarPinned || sidebarHovered" x-transition>Dashboard</span>
                        </a>
                    </div>

                    {{-- Data Master --}}
                    <div class="mb-4">
                        <p
                            x-text="(sidebarPinned || sidebarHovered) ? 'Data Master' : '•••'"
                            :class="(sidebarPinned || sidebarHovered) ? 'text-left px-2' : 'text-center justify-center'"
                            class="mb-2 flex items-center text-xs font-semibold uppercase tracking-wider text-slate-500 opacity-70"
                        ></p>

                        <div class="space-y-1">
                            @php
                                $masterMenus = [
                                    ['label' => 'Pengguna', 'route' => 'admin.pengguna', 'icon' => 'users'],
                                    ['label' => 'Jabatan Kerja', 'route' => 'admin.jabatan-kerja', 'icon' => 'briefcase'],
                                    ['label' => 'Prodi Pendidikan', 'route' => 'admin.prodi-pendidikan', 'icon' => 'academic'],
                                    ['label' => 'Pegawai', 'route' => 'admin.pegawai', 'icon' => 'pegawai'],
                                    ['label' => 'Masyarakat Jasa Konstruksi', 'route' => 'admin.masyarakat-jasa-konstruksi', 'icon' => 'community'],
                                    ['label' => 'Paket Konstruksi', 'route' => 'admin.paket-konstruksi', 'icon' => 'folder'],
                                    ['label' => 'Kotak Saran', 'route' => 'admin.kotak-saran', 'icon' => 'mail'],
                                    ['label' => 'File Upload', 'route' => 'admin.file-upload', 'icon' => 'upload'],
                                    ['label' => 'Buku Tamu', 'route' => 'admin.buku-tamu', 'icon' => 'book'],
                                ];
                            @endphp

                            @foreach($masterMenus as $menu)
                                <a href="{{ route($menu['route']) }}"
                                   class="group flex items-center gap-2 rounded-lg px-2.5 py-2 text-xs font-medium transition
                                   {{ request()->routeIs($menu['route']) ? 'border border-slate-700 bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                                    @if($menu['icon'] === 'users')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-slate-400 group-hover:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5V18a4 4 0 00-5-3.87M17 20H7m10 0v-2a5.002 5.002 0 00-9.288 0M15 7a3 3 0 11-6 0" /></svg>
                                    @elseif($menu['icon'] === 'briefcase')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-slate-400 group-hover:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2m-6 0h6m-6 0H6a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V8a2 2 0 00-2-2h-3" /></svg>
                                    @elseif($menu['icon'] === 'academic')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-slate-400 group-hover:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0112 20.055a12.083 12.083 0 01-6.16-9.477L12 14z" /></svg>
                                    @elseif($menu['icon'] === 'pegawai')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-slate-400 group-hover:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5.121 17.804A11.953 11.953 0 0112 15c2.5 0 4.824.765 6.879 2.071M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    @elseif($menu['icon'] === 'community')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-slate-400 group-hover:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 10a3 3 0 110-6 3 3 0 010 6zm8 0a3 3 0 110-6 3 3 0 010 6zM8 14c-2.67 0-8 1.34-8 4v2h10m6-6c2.67 0 8 1.34 8 4v2H14" /></svg>
                                    @elseif($menu['icon'] === 'folder')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-slate-400 group-hover:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" /></svg>
                                    @elseif($menu['icon'] === 'mail')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-slate-400 group-hover:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l9 6 9-6m-18 8h18V8H3v8z" /></svg>
                                    @elseif($menu['icon'] === 'upload')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-slate-400 group-hover:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M16 8l-4-4m0 0L8 8m4-4v12" /></svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-slate-400 group-hover:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.483 9.246 5 7.5 5 5.014 5 3 6.12 3 7.5v9C3 15.12 5.014 14 7.5 14c1.746 0 3.332.483 4.5 1.253m0-9C13.168 5.483 14.754 5 16.5 5c2.486 0 4.5 1.12 4.5 2.5v9c0-1.38-2.014-2.5-4.5-2.5-1.746 0-3.332.483-4.5 1.253" /></svg>
                                    @endif

                                    <span x-show="sidebarPinned || sidebarHovered" x-transition>{{ $menu['label'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Manajemen Berita --}}
                    <div class="mb-4">
                        <p
                            x-text="(sidebarPinned || sidebarHovered) ? 'Manajemen Berita' : '•••'"
                            :class="(sidebarPinned || sidebarHovered) ? 'text-left px-2' : 'text-center justify-center'"
                            class="mb-2 flex items-center text-xs font-semibold uppercase tracking-wider text-slate-500 opacity-70"
                        ></p>

                        <div class="space-y-1">
                            <a href="{{ route('admin.kategori') }}"
                               class="group flex items-center gap-2 rounded-lg px-2.5 py-2 text-xs font-medium transition {{ request()->routeIs('admin.kategori') ? 'border border-slate-700 bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-slate-400 group-hover:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 7h10M7 12h10M7 17h10M4 7h.01M4 12h.01M4 17h.01" /></svg>
                                <span x-show="sidebarPinned || sidebarHovered" x-transition>Kategori</span>
                            </a>

                            <a href="{{ route('admin.berita') }}"
                               class="group flex items-center gap-2 rounded-lg px-2.5 py-2 text-xs font-medium transition {{ request()->routeIs('admin.berita') ? 'border border-slate-700 bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-slate-400 group-hover:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 5H5a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2zM7 9h10M7 13h6" /></svg>
                                <span x-show="sidebarPinned || sidebarHovered" x-transition>Berita</span>
                            </a>
                        </div>
                    </div>

                    {{-- Sub Pengaturan --}}
                    <div class="mb-4">
                        <p
                            x-text="(sidebarPinned || sidebarHovered) ? 'Sub Pengaturan' : '•••'"
                            :class="(sidebarPinned || sidebarHovered) ? 'text-left px-2' : 'text-center justify-center'"
                            class="mb-2 flex items-center text-xs font-semibold uppercase tracking-wider text-slate-500 opacity-70"
                        ></p>

                        <div class="space-y-1">
                            <a href="{{ route('admin.acara-kegiatan') }}"
                               class="group flex items-center gap-2 rounded-lg px-2.5 py-2 text-xs font-medium transition {{ request()->routeIs('admin.acara-kegiatan') ? 'border border-slate-700 bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-slate-400 group-hover:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10m-13 9h16a1 1 0 001-1V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a1 1 0 001 1z" /></svg>
                                <span x-show="sidebarPinned || sidebarHovered" x-transition>Acara/Kegiatan</span>
                            </a>

                            <a href="{{ route('admin.peraturan') }}"
                               class="group flex items-center gap-2 rounded-lg px-2.5 py-2 text-xs font-medium transition {{ request()->routeIs('admin.peraturan') ? 'border border-slate-700 bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-slate-400 group-hover:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z" /></svg>
                                <span x-show="sidebarPinned || sidebarHovered" x-transition>Peraturan</span>
                            </a>
                        </div>
                    </div>

                    {{-- Sub Pemberdayaan --}}
                    <div class="mb-4">
                        <p
                            x-text="(sidebarPinned || sidebarHovered) ? 'Sub Pemberdayaan' : '•••'"
                            :class="(sidebarPinned || sidebarHovered) ? 'text-left px-2' : 'text-center justify-center'"
                            class="mb-2 flex items-center text-xs font-semibold uppercase tracking-wider text-slate-500 opacity-70"
                        ></p>

                        <div class="space-y-1">
                            <a href="{{ route('admin.tenaga-kerja-konstruksi') }}"
                               class="group flex items-center gap-2 rounded-lg px-2.5 py-2 text-xs font-medium transition {{ request()->routeIs('admin.tenaga-kerja-konstruksi') ? 'border border-slate-700 bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-slate-400 group-hover:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0-5v2m0 14v2m9-9h-2M5 12H3m15.364 6.364l-1.414-1.414M7.05 7.05 5.636 5.636m12.728 0L16.95 7.05M7.05 16.95l-1.414 1.414" /></svg>
                                <span x-show="sidebarPinned || sidebarHovered" x-transition>Tenaga Kerja Konstruksi</span>
                            </a>

                            <a href="{{ route('admin.pelatihan-sertifikasi') }}"
                               class="group flex items-center gap-2 rounded-lg px-2.5 py-2 text-xs font-medium transition {{ request()->routeIs('admin.pelatihan-sertifikasi') ? 'border border-slate-700 bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-slate-400 group-hover:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.483 9.246 5 7.5 5 5.014 5 3 6.12 3 7.5v9C3 15.12 5.014 14 7.5 14c1.746 0 3.332.483 4.5 1.253m0-9C13.168 5.483 14.754 5 16.5 5c2.486 0 4.5 1.12 4.5 2.5v9c0-1.38-2.014-2.5-4.5-2.5-1.746 0-3.332.483-4.5 1.253" /></svg>
                                <span x-show="sidebarPinned || sidebarHovered" x-transition>Pelatihan/Sertifikasi</span>
                            </a>
                        </div>
                    </div>

                    {{-- Sub Pengawasan --}}
                    <div class="mb-4">
                        <p
                            x-text="(sidebarPinned || sidebarHovered) ? 'Sub Pengawasan' : '•••'"
                            :class="(sidebarPinned || sidebarHovered) ? 'text-left px-2' : 'text-center justify-center'"
                            class="mb-2 flex items-center text-xs font-semibold uppercase tracking-wider text-slate-500 opacity-70"
                        ></p>

                        <div class="space-y-1">
                            <a href="{{ route('admin.tertib-usaha') }}"
                               class="group flex items-center gap-2 rounded-lg px-2.5 py-2 text-xs font-medium transition {{ request()->routeIs('admin.tertib-usaha') ? 'border border-slate-700 bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-slate-400 group-hover:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12h18M12 3v18" /></svg>
                                <span x-show="sidebarPinned || sidebarHovered" x-transition>Tertib Usaha</span>
                            </a>

                            <a href="{{ route('admin.tertib-penyelenggaraan') }}"
                               class="group flex items-center gap-2 rounded-lg px-2.5 py-2 text-xs font-medium transition {{ request()->routeIs('admin.tertib-penyelenggaraan') ? 'border border-slate-700 bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-slate-400 group-hover:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 2a7 7 0 00-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 00-7-7zm0 9a2 2 0 110-4 2 2 0 010 4z" /></svg>
                                <span x-show="sidebarPinned || sidebarHovered" x-transition>Tertib Penyelenggaraan</span>
                            </a>

                            <a href="{{ route('admin.tertib-pemanfaatan') }}"
                               class="group flex items-center gap-2 rounded-lg px-2.5 py-2 text-xs font-medium transition {{ request()->routeIs('admin.tertib-pemanfaatan') ? 'border border-slate-700 bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-slate-400 group-hover:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 4h14v16H5zM9 8h6M9 12h6M9 16h4" /></svg>
                                <span x-show="sidebarPinned || sidebarHovered" x-transition>Tertib Pemanfaatan</span>
                            </a>
                        </div>
                    </div>

                    {{-- Arsip / Surat --}}
                    <div class="mb-4">
                        <p
                            x-text="(sidebarPinned || sidebarHovered) ? 'Arsip / Surat' : '•••'"
                            :class="(sidebarPinned || sidebarHovered) ? 'text-left px-2' : 'text-center justify-center'"
                            class="mb-mb-2 flex items-center text-xs font-semibold uppercase tracking-wider text-slate-500 opacity-70"
                        ></p>

                        <div class="space-y-1">
                            <a href="{{ route('admin.surat-menyurat') }}"
                               class="group flex items-center gap-2 rounded-lg px-2.5 py-2 text-xs font-medium transition {{ request()->routeIs('admin.surat-menyurat') ? 'border border-slate-700 bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-slate-400 group-hover:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l9 6 9-6m-18 8h18V8H3v8z" /></svg>
                                <span x-show="sidebarPinned || sidebarHovered" x-transition>Surat Menyurat</span>
                            </a>

                            <a href="{{ route('admin.arsip') }}"
                               class="group flex items-center gap-2 rounded-lg px-2.5 py-2 text-xs font-medium transition {{ request()->routeIs('admin.arsip') ? 'border border-slate-700 bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-slate-400 group-hover:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 2h9l5 5v13a2 2 0 01-2 2H6a2 2 0 01-2-2V4a2 2 0 012-2z" /></svg>
                                <span x-show="sidebarPinned || sidebarHovered" x-transition>Arsip</span>
                            </a>
                        </div>
                    </div>

                    {{-- Keuangan --}}
                    <div class="pb-4">
                        <p
                            x-text="(sidebarPinned || sidebarHovered) ? 'Keuangan' : '•••'"
                            :class="(sidebarPinned || sidebarHovered) ? 'text-left px-2' : 'text-center justify-center'"
                            class="mb-2 flex items-center text-xs font-semibold uppercase tracking-wider text-slate-500 opacity-70"

                        <div class="space-y-1">
                            <a href="{{ route('admin.penandatangan-dokumen') }}"
                               class="group flex items-center gap-2 rounded-lg px-2.5 py-2 text-xs font-medium transition {{ request()->routeIs('admin.penandatangan-dokumen') ? 'border border-slate-700 bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-slate-400 group-hover:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 20h9M12 4h9M4 9h16M4 15h16M4 4h4v5H4zM4 15h4v5H4z" /></svg>
                                <span x-show="sidebarPinned || sidebarHovered" x-transition>Penandatangan Dokumen</span>
                            </a>

                            <a href="{{ route('admin.anggaran-perjadin') }}"
                               class="group flex items-center gap-2 rounded-lg px-2.5 py-2 text-xs font-medium transition {{ request()->routeIs('admin.anggaran-perjadin') ? 'border border-slate-700 bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-slate-400 group-hover:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7h18M6 11h12M9 15h6M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z" /></svg>
                                <span x-show="sidebarPinned || sidebarHovered" x-transition>Anggaran Perjadin</span>
                            </a>

                            <a href="{{ route('admin.perjadin') }}"
                               class="group flex items-center gap-2 rounded-lg px-2.5 py-2 text-xs font-medium transition {{ request()->routeIs('admin.perjadin') ? 'border border-slate-700 bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-slate-400 group-hover:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 17l4 4 4-4m-4-5v9M4 4h16v4H4z" /></svg>
                                <span x-show="sidebarPinned || sidebarHovered" x-transition>Perjadin</span>
                            </a>
                        </div>
                    </div>
                </div>
            </aside>

            {{-- Overlay mobile --}}
            <div x-show="mobileSidebarOpen" x-cloak class="fixed inset-0 z-30 bg-black/60 md:hidden" @click="mobileSidebarOpen = !mobileSidebarOpen"></div>
            {{-- Sidebar mobile --}}
            <aside x-show="mobileSidebarOpen" x-cloak class="fixed left-0 top-0 z-40 flex h-screen w-64 flex-col border-r border-slate-800 bg-slate-950 md:hidden">                <div class="flex h-14 items-center justify-between border-b border-slate-800 px-3">
                    <div class="flex items-center gap-2">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600/20 ring-1 ring-indigo-500/30">
                            <span class="text-sm font-bold text-indigo-300">S</span>
                        </div>
                        <div>
                            <h1 class="text-sm font-bold tracking-tight">SIBIKON KALTIM</h1>
                            <p class="text-[11px] text-slate-400">Panel Admin</p>
                        </div>
                    </div>

                    <button @click="sidebarOpen = false" class="rounded-md border border-slate-700 p-1.5 text-slate-300 hover:bg-slate-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto scrollbar-dark px-2 py-2">
                    <a href="{{ route('admin.dashboard') }}" class="mb-2 flex items-center gap-2 rounded-lg border border-slate-700 bg-slate-800 px-2.5 py-2 text-xs font-semibold text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l9-9 9 9M4.5 10.5V20a1 1 0 001 1h4.5v-6h4v6H18.5a1 1 0 001-1v-9.5"/>
                        </svg>
                        Dashboard
                    </a>

                    <div class="space-y-1">
                        <a href="{{ route('admin.pengguna') }}" class="block rounded-lg px-2.5 py-2 text-xs text-slate-300 hover:bg-slate-800/60">Pengguna</a>
                        <a href="{{ route('admin.jabatan-kerja') }}" class="block rounded-lg px-2.5 py-2 text-xs text-slate-300 hover:bg-slate-800/60">Jabatan Kerja</a>
                        <a href="{{ route('admin.prodi-pendidikan') }}" class="block rounded-lg px-2.5 py-2 text-xs text-slate-300 hover:bg-slate-800/60">Prodi Pendidikan</a>
                        <a href="{{ route('admin.pegawai') }}" class="block rounded-lg px-2.5 py-2 text-xs text-slate-300 hover:bg-slate-800/60">Pegawai</a>
                        <a href="{{ route('admin.masyarakat-jasa-konstruksi') }}" class="block rounded-lg px-2.5 py-2 text-xs text-slate-300 hover:bg-slate-800/60">Masyarakat Jasa Konstruksi</a>
                        <a href="{{ route('admin.paket-konstruksi') }}" class="block rounded-lg px-2.5 py-2 text-xs text-slate-300 hover:bg-slate-800/60">Paket Konstruksi</a>
                        <a href="{{ route('admin.kotak-saran') }}" class="block rounded-lg px-2.5 py-2 text-xs text-slate-300 hover:bg-slate-800/60">Kotak Saran</a>
                        <a href="{{ route('admin.file-upload') }}" class="block rounded-lg px-2.5 py-2 text-xs text-slate-300 hover:bg-slate-800/60">File Upload</a>
                        <a href="{{ route('admin.buku-tamu') }}" class="block rounded-lg px-2.5 py-2 text-xs text-slate-300 hover:bg-slate-800/60">Buku Tamu</a>
                        <a href="{{ route('admin.kategori') }}" class="block rounded-lg px-2.5 py-2 text-xs text-slate-300 hover:bg-slate-800/60">Kategori</a>
                        <a href="{{ route('admin.berita') }}" class="block rounded-lg px-2.5 py-2 text-xs text-slate-300 hover:bg-slate-800/60">Berita</a>
                        <a href="{{ route('admin.acara-kegiatan') }}" class="block rounded-lg px-2.5 py-2 text-xs text-slate-300 hover:bg-slate-800/60">Acara/Kegiatan</a>
                        <a href="{{ route('admin.peraturan') }}" class="block rounded-lg px-2.5 py-2 text-xs text-slate-300 hover:bg-slate-800/60">Peraturan</a>
                        <a href="{{ route('admin.tenaga-kerja-konstruksi') }}" class="block rounded-lg px-2.5 py-2 text-xs text-slate-300 hover:bg-slate-800/60">Tenaga Kerja Konstruksi</a>
                        <a href="{{ route('admin.pelatihan-sertifikasi') }}" class="block rounded-lg px-2.5 py-2 text-xs text-slate-300 hover:bg-slate-800/60">Pelatihan/Sertifikasi</a>
                        <a href="{{ route('admin.tertib-usaha') }}" class="block rounded-lg px-2.5 py-2 text-xs text-slate-300 hover:bg-slate-800/60">Tertib Usaha</a>
                        <a href="{{ route('admin.tertib-penyelenggaraan') }}" class="block rounded-lg px-2.5 py-2 text-xs text-slate-300 hover:bg-slate-800/60">Tertib Penyelenggaraan</a>
                        <a href="{{ route('admin.tertib-pemanfaatan') }}" class="block rounded-lg px-2.5 py-2 text-xs text-slate-300 hover:bg-slate-800/60">Tertib Pemanfaatan</a>
                        <a href="{{ route('admin.surat-menyurat') }}" class="block rounded-lg px-2.5 py-2 text-xs text-slate-300 hover:bg-slate-800/60">Surat Menyurat</a>
                        <a href="{{ route('admin.arsip') }}" class="block rounded-lg px-2.5 py-2 text-xs text-slate-300 hover:bg-slate-800/60">Arsip</a>
                        <a href="{{ route('admin.penandatangan-dokumen') }}" class="block rounded-lg px-2.5 py-2 text-xs text-slate-300 hover:bg-slate-800/60">Penandatangan Dokumen</a>
                        <a href="{{ route('admin.anggaran-perjadin') }}" class="block rounded-lg px-2.5 py-2 text-xs text-slate-300 hover:bg-slate-800/60">Anggaran Perjadin</a>
                        <a href="{{ route('admin.perjadin') }}" class="block rounded-lg px-2.5 py-2 text-xs text-slate-300 hover:bg-slate-800/60">Perjadin</a>
                    </div>
                </div>
            </aside>

            {{-- Main --}}
            <div :class="(sidebarPinned || sidebarHovered) ? 'md:ml-64' : 'md:ml-16'" class="flex min-h-screen flex-1 flex-col transition-all duration-200 ease-out">                {{-- Topbar --}}
                <header class="sticky top-0 z-20 border-b border-slate-800 bg-slate-950/95 backdrop-blur">
                    <div class="flex h-14 items-center justify-between gap-3 px-3 md:px-4">
                        <div class="flex min-w-0 items-center gap-2">
                            <button
                                @click="sidebarOpen = !sidebarOpen"
                                class="rounded-md border border-slate-700 p-1.5 text-slate-300 hover:bg-slate-800 md:hidden"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                          d="M4 6h16M7 12h13M10 18h10" />
                                </svg>
                            </button>

                            <div class="min-w-0">
                                <h2 class="truncate text-base font-bold tracking-tight md:text-lg">@yield('page-title', 'Dashboard')</h2>
                                <p class="truncate text-[11px] text-slate-400 md:text-xs">@yield('page-subtitle', 'Panel admin setelah login')</p>
                            </div>
                        </div>

                        <div class="flex shrink-0 items-center gap-2">
                            <div class="hidden lg:flex items-center gap-2 rounded-lg border border-slate-800 bg-slate-900 px-2.5 py-1.5 text-[11px] text-slate-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-slate-400" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                          d="M8 7V3m8 4V3m-9 8h10m-13 9h16a1 1 0 001-1V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a1 1 0 001 1z" />
                                </svg>
                                <span>{{ now()->translatedFormat('d F Y') }}</span>
                            </div>

                            <div class="flex items-center gap-2 rounded-xl border border-slate-800 bg-slate-900 px-2.5 py-1">
                                <div class="hidden text-right sm:block">
                                    <p class="text-[11px] font-semibold">{{ auth()->check() ? auth()->user()->name : 'Admin' }}</p>
                                    <p class="text-[10px] text-slate-400">Administrator</p>
                                </div>

                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-500/20 ring-1 ring-emerald-400/20">
                                    <span class="text-xs font-bold text-emerald-300">
                                        {{ strtoupper(substr(auth()->check() ? auth()->user()->name : 'Admin', 0, 1)) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="flex-1 bg-slate-950 p-3 md:p-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>
</html>s