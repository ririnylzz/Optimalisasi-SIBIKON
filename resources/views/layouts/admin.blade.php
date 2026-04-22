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
<body class="bg-slate-50 text-slate-900 font-sans">
    <div x-data="{ sidebarPinned: true, sidebarHovered: false, mobileSidebarOpen: false }" class="min-h-screen bg-slate-50">
        <div class="flex min-h-screen">
            {{-- Sidebar desktop --}}
            <aside
                @mouseenter="if (!sidebarPinned) sidebarHovered = true"
                @mouseleave="if (!sidebarPinned) sidebarHovered = false"
                :class="(sidebarPinned || sidebarHovered) ? 'w-64' : 'w-16'"
                class="fixed left-0 top-0 z-40 hidden h-screen flex-col bg-[#21325E] text-white transition-all duration-300 md:flex"
            >
                {{-- Brand --}}
                <div class="flex h-14 items-center justify-between border-b border-white/10 px-3">                    <div class="flex items-center gap-3 overflow-hidden">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-white/10 ring-1 ring-white/10">                            <span class="text-sm font-bold text-white">S</span>
                        </div>

                        <div x-show="sidebarPinned || sidebarHovered" x-transition class="min-w-0">
                            <h1 class="truncate text-sm font-bold tracking-tight text-white">SIBIKON KALTIM</h1>
                            <p class="text-[10px] text-blue-100/65">Panel Admin</p>
                        </div>
                    </div>

                    <button
                        @click="
                            sidebarPinned = !sidebarPinned;
                            if (sidebarPinned) sidebarHovered = false;
                        "
                        class="rounded-lg border border-white/10 bg-white/5 p-1.5 text-white/80 hover:bg-white/10"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M4 6h16M7 12h13M10 18h10" />
                        </svg>
                    </button>
                </div>

                {{-- Menu --}}
                <div class="flex-1 overflow-y-auto scrollbar-dark px-2.5 py-3">
                    {{-- Dashboard --}}
                    <div class="mb-6">
                        <p x-show="sidebarPinned || sidebarHovered" class="mb-2 px-3 text-[11px] font-semibold uppercase tracking-[0.18em] text-blue-100/45">
                            Menu
                        </p>

                        <a href="{{ route('admin.dashboard') }}"
                           class="group flex items-center gap-2.5 rounded-xl px-2.5 py-2 text-[13px] font-semibold transition
                           {{ request()->routeIs('admin.dashboard') ? 'bg-white/12 text-white shadow-sm' : 'text-blue-100/80 hover:bg-white/8 hover:text-white' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                      d="M3 12l9-9 9 9M4.5 10.5V20a1 1 0 001 1h4.5v-6h4v6H18.5a1 1 0 001-1v-9.5"/>
                            </svg>
                            <span x-show="sidebarPinned || sidebarHovered" x-transition>Dashboard</span>
                        </a>
                    </div>

                    {{-- Data Master --}}
                    <div class="mb-6">
                        <p
                            x-text="(sidebarPinned || sidebarHovered) ? 'Data Master' : '•••'"
                            :class="(sidebarPinned || sidebarHovered) ? 'text-left px-3' : 'text-center justify-center'"
                           class="mb-2 flex items-center text-[10px] font-semibold uppercase tracking-[0.15em] text-blue-100/40"
                        ></p>

                        <div class="space-y-1.5">
                           @php
                                $menuBase = 'group flex items-center gap-2.5 rounded-xl px-2.5 py-2 text-[13px] font-medium transition';
                                $menuIdle = 'text-blue-100/80 hover:bg-white/8 hover:text-white';
                                $menuActive = 'bg-white/12 text-white shadow-sm';
                            @endphp

                            <a href="{{ route('admin.pengguna') }}" class="{{ $menuBase }} {{ request()->routeIs('admin.pengguna') ? $menuActive : $menuIdle }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5V18a4 4 0 00-5-3.87M17 20H7m10 0v-2a5.002 5.002 0 00-9.288 0M15 7a3 3 0 11-6 0" /></svg>
                                <span x-show="sidebarPinned || sidebarHovered">Pengguna</span>
                            </a>

                            <a href="{{ route('admin.jabatan-kerja') }}" class="{{ $menuBase }} {{ request()->routeIs('admin.jabatan-kerja') ? $menuActive : $menuIdle }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2m-6 0h6m-6 0H6a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V8a2 2 0 00-2-2h-3" /></svg>
                                <span x-show="sidebarPinned || sidebarHovered">Jabatan Kerja</span>
                            </a>

                            <a href="{{ route('admin.prodi-pendidikan') }}" class="{{ $menuBase }} {{ request()->routeIs('admin.prodi-pendidikan') ? $menuActive : $menuIdle }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0112 20.055a12.083 12.083 0 01-6.16-9.477L12 14z" /></svg>
                                <span x-show="sidebarPinned || sidebarHovered">Prodi Pendidikan</span>
                            </a>

                            <a href="{{ route('admin.pegawai') }}" class="{{ $menuBase }} {{ request()->routeIs('admin.pegawai') ? $menuActive : $menuIdle }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5.121 17.804A11.953 11.953 0 0112 15c2.5 0 4.824.765 6.879 2.071M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                <span x-show="sidebarPinned || sidebarHovered">Pegawai</span>
                            </a>

                            {{-- Dropdown MJK --}}
                            <div
                                x-data="{ open: {{ request()->routeIs(
                                    'admin.masyarakat-jasa-konstruksi',
                                    'admin.pengguna-jasa',
                                    'admin.asosiasi-perusahaan',
                                    'admin.asosiasi-profesi',
                                    'admin.lsp',
                                    'admin.perguruan-tinggi',
                                    'admin.lppkk',
                                    'admin.pemerhati-konstruksi',
                                    'admin.pemanfaat-produk',
                                    'admin.rantai-pasok',
                                    'admin.bujk'
                                ) ? 'true' : 'false' }} }"
                                class="space-y-1.5"
                            >
                                <button
                                    type="button"
                                    @click="open = !open"
                                    class="flex w-full items-center justify-between rounded-xl px-2.5 py-2 text-[13px] font-medium transition
                                    {{ request()->routeIs(
                                        'admin.masyarakat-jasa-konstruksi',
                                        'admin.pengguna-jasa',
                                        'admin.asosiasi-perusahaan',
                                        'admin.asosiasi-profesi',
                                        'admin.lsp',
                                        'admin.perguruan-tinggi',
                                        'admin.lppkk',
                                        'admin.pemerhati-konstruksi',
                                        'admin.pemanfaat-produk',
                                        'admin.rantai-pasok',
                                        'admin.bujk'
                                    ) ? $menuActive : $menuIdle }}"
                                >
                                    <div class="flex items-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 10a3 3 0 110-6 3 3 0 010 6zm8 0a3 3 0 110-6 3 3 0 010 6zM8 14c-2.67 0-8 1.34-8 4v2h10m6-6c2.67 0 8 1.34 8 4v2H14" />
                                        </svg>
                                        <span x-show="sidebarPinned || sidebarHovered">Masyarakat Jasa Konstruksi</span>
                                    </div>

                                    <svg
                                        x-show="sidebarPinned || sidebarHovered"
                                        :class="open ? 'rotate-90' : ''"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 transition-transform duration-200"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>

                                <div x-show="open && (sidebarPinned || sidebarHovered)" x-transition class="ml-8 space-y-1">
                                    @foreach ([
                                        ['label' => 'Pengguna Jasa', 'route' => 'admin.pengguna-jasa'],
                                        ['label' => 'Asosiasi Perusahaan', 'route' => 'admin.asosiasi-perusahaan'],
                                        ['label' => 'Asosiasi Profesi', 'route' => 'admin.asosiasi-profesi'],
                                        ['label' => 'LSP', 'route' => 'admin.lsp'],
                                        ['label' => 'Perguruan Tinggi / Pakar', 'route' => 'admin.perguruan-tinggi'],
                                        ['label' => 'LPPKK', 'route' => 'admin.lppkk'],
                                        ['label' => 'Pemerhati Konstruksi', 'route' => 'admin.pemerhati-konstruksi'],
                                        ['label' => 'Pemanfaat Produk', 'route' => 'admin.pemanfaat-produk'],
                                        ['label' => 'Rantai Pasok', 'route' => 'admin.rantai-pasok'],
                                        ['label' => 'BUJK', 'route' => 'admin.bujk'],
                                    ] as $sub)
                                        <a href="{{ route($sub['route']) }}"
                                          class="block rounded-lg px-2.5 py-1.5 text-[13px] transition {{ request()->routeIs($sub['route']) ? 'bg-white/10 text-[#F7E578]' : 'text-blue-100/70 hover:bg-white/6 hover:text-white' }}">
                                            {{ $sub['label'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                            <a href="{{ route('admin.paket-konstruksi') }}" class="{{ $menuBase }} {{ request()->routeIs('admin.paket-konstruksi') ? $menuActive : $menuIdle }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" /></svg>
                                <span x-show="sidebarPinned || sidebarHovered">Paket Konstruksi</span>
                            </a>

                            <a href="{{ route('admin.kotak-saran') }}" class="{{ $menuBase }} {{ request()->routeIs('admin.kotak-saran') ? $menuActive : $menuIdle }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l9 6 9-6m-18 8h18V8H3v8z" /></svg>
                                <span x-show="sidebarPinned || sidebarHovered">Kotak Saran</span>
                            </a>

                            <a href="{{ route('admin.file-upload') }}" class="{{ $menuBase }} {{ request()->routeIs('admin.file-upload') ? $menuActive : $menuIdle }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M16 8l-4-4m0 0L8 8m4-4v12" /></svg>
                                <span x-show="sidebarPinned || sidebarHovered">File Upload</span>
                            </a>

                            <a href="{{ route('admin.buku-tamu') }}" class="{{ $menuBase }} {{ request()->routeIs('admin.buku-tamu') ? $menuActive : $menuIdle }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.483 9.246 5 7.5 5 5.014 5 3 6.12 3 7.5v9C3 15.12 5.014 14 7.5 14c1.746 0 3.332.483 4.5 1.253m0-9C13.168 5.483 14.754 5 16.5 5c2.486 0 4.5
                                <span x-show="sidebarPinned || sidebarHovered">Buku Tamu</span>
                            </a>
                            
                        </div>
                    </div>
                    {{-- Manajemen Berita --}}
                    <div class="mb-6 mt-6">
                        <p
                            x-text="(sidebarPinned || sidebarHovered) ? 'Manajemen Berita' : '•••'"
                            :class="(sidebarPinned || sidebarHovered) ? 'text-left px-3' : 'text-center justify-center'"
                            class="mb-2 flex items-center text-[10px] font-semibold uppercase tracking-[0.15em] text-blue-100/40"
                        ></p>

                        <div class="space-y-1">
                            <a href="{{ route('admin.kategori') }}"
                            class="{{ $menuBase }} {{ request()->routeIs('admin.kategori') ? $menuActive : $menuIdle }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 7h10M7 12h10M7 17h10M4 7h.01M4 12h.01M4 17h.01" />
                                </svg>
                                <span x-show="sidebarPinned || sidebarHovered">Kategori</span>
                            </a>

                            <a href="{{ route('admin.berita') }}"
                            class="{{ $menuBase }} {{ request()->routeIs('admin.berita') ? $menuActive : $menuIdle }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 5H5a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2zM7 9h10M7 13h6" />
                                </svg>
                                <span x-show="sidebarPinned || sidebarHovered">Berita</span>
                            </a>
                        </div>
                    </div>

                    {{-- Sub Pengaturan --}}
                    <div class="mb-6">
                        <p
                            x-text="(sidebarPinned || sidebarHovered) ? 'Sub Pengaturan' : '•••'"
                            :class="(sidebarPinned || sidebarHovered) ? 'text-left px-3' : 'text-center justify-center'"
                            class="mb-2 flex items-center text-[10px] font-semibold uppercase tracking-[0.15em] text-blue-100/40"
                        ></p>

                        <div class="space-y-1.5">
                            <a href="{{ route('admin.acara-kegiatan') }}"
                            class="{{ $menuBase }} {{ request()->routeIs('admin.acara-kegiatan') ? $menuActive : $menuIdle }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10m-13 9h16a1 1 0 001-1V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a1 1 0 001 1z" />
                                </svg>
                                <span x-show="sidebarPinned || sidebarHovered">Acara/Kegiatan</span>
                            </a>

                            <a href="{{ route('admin.peraturan') }}"
                            class="{{ $menuBase }} {{ request()->routeIs('admin.peraturan') ? $menuActive : $menuIdle }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z" />
                                </svg>
                                <span x-show="sidebarPinned || sidebarHovered">Peraturan</span>
                            </a>
                        </div>
                    </div>

                    {{-- Sub Pemberdayaan --}}
                    <div class="mb-6">
                        <p
                            x-text="(sidebarPinned || sidebarHovered) ? 'Sub Pemberdayaan' : '•••'"
                            :class="(sidebarPinned || sidebarHovered) ? 'text-left px-3' : 'text-center justify-center'"
                            class="mb-2 flex items-center text-[10px] font-semibold uppercase tracking-[0.15em] text-blue-100/40"
                        ></p>

                        <div class="space-y-1.5">
                            <a href="{{ route('admin.tenaga-kerja-konstruksi') }}"
                            class="{{ $menuBase }} {{ request()->routeIs('admin.tenaga-kerja-konstruksi') ? $menuActive : $menuIdle }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0-5v2m0 14v2m9-9h-2M5 12H3m15.364 6.364l-1.414-1.414M7.05 7.05 5.636 5.636m12.728 0L16.95 7.05M7.05 16.95l-1.414 1.414" />
                                </svg>
                                <span x-show="sidebarPinned || sidebarHovered">Tenaga Kerja Konstruksi</span>
                            </a>

                            <a href="{{ route('admin.pelatihan-sertifikasi') }}"
                            class="{{ $menuBase }} {{ request()->routeIs('admin.pelatihan-sertifikasi') ? $menuActive : $menuIdle }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.483 9.246 5 7.5 5 5.014 5 3 6.12 3 7.5v9C3 15.12 5.014 14 7.5 14c1.746 0 3.332.483 4.5 1.253m0-9C13.168 5.483 14.754 5 16.5 5c2.486 0 4.5 1.12 4.5 2.5v9c0-1.38-2.014-2.5-4.5-2.5-1.746 0-3.332.483-4.5 1.253" />
                                </svg>
                                <span x-show="sidebarPinned || sidebarHovered">Pelatihan/Sertifikasi</span>
                            </a>
                        </div>
                    </div>

                    {{-- Sub Pengawasan --}}
                    <div class="mb-6">
                        <p
                            x-text="(sidebarPinned || sidebarHovered) ? 'Sub Pengawasan' : '•••'"
                            :class="(sidebarPinned || sidebarHovered) ? 'text-left px-3' : 'text-center justify-center'"
                            class="mb-2 flex items-center text-[10px] font-semibold uppercase tracking-[0.15em] text-blue-100/40"
                        ></p>

                        <div class="space-y-1.5">
                            <a href="{{ route('admin.tertib-usaha') }}"
                            class="{{ $menuBase }} {{ request()->routeIs('admin.tertib-usaha') ? $menuActive : $menuIdle }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12h18M12 3v18" />
                                </svg>
                                <span x-show="sidebarPinned || sidebarHovered">Tertib Usaha</span>
                            </a>

                            <a href="{{ route('admin.tertib-penyelenggaraan') }}"
                            class="{{ $menuBase }} {{ request()->routeIs('admin.tertib-penyelenggaraan') ? $menuActive : $menuIdle }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 2a7 7 0 00-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 00-7-7zm0 9a2 2 0 110-4 2 2 0 010 4z" />
                                </svg>
                                <span x-show="sidebarPinned || sidebarHovered">Tertib Penyelenggaraan</span>
                            </a>

                            <a href="{{ route('admin.tertib-pemanfaatan') }}"
                            class="{{ $menuBase }} {{ request()->routeIs('admin.tertib-pemanfaatan') ? $menuActive : $menuIdle }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 4h14v16H5zM9 8h6M9 12h6M9 16h4" />
                                </svg>
                                <span x-show="sidebarPinned || sidebarHovered">Tertib Pemanfaatan</span>
                            </a>
                        </div>
                    </div>

                    {{-- Arsip / Surat --}}
                    <div class="mb-6">
                        <p
                            x-text="(sidebarPinned || sidebarHovered) ? 'Arsip / Surat' : '•••'"
                            :class="(sidebarPinned || sidebarHovered) ? 'text-left px-3' : 'text-center justify-center'"
                            class="mb-2 flex items-center text-[10px] font-semibold uppercase tracking-[0.15em] text-blue-100/40"
                        ></p>

                        <div class="space-y-1.5">
                            <a href="{{ route('admin.surat-menyurat') }}"
                            class="{{ $menuBase }} {{ request()->routeIs('admin.surat-menyurat') ? $menuActive : $menuIdle }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l9 6 9-6m-18 8h18V8H3v8z" />
                                </svg>
                                <span x-show="sidebarPinned || sidebarHovered">Surat Menyurat</span>
                            </a>

                            <a href="{{ route('admin.arsip') }}"
                            class="{{ $menuBase }} {{ request()->routeIs('admin.arsip') ? $menuActive : $menuIdle }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 2h9l5 5v13a2 2 0 01-2 2H6a2 2 0 01-2-2V4a2 2 0 012-2z" />
                                </svg>
                                <span x-show="sidebarPinned || sidebarHovered">Arsip</span>
                            </a>
                        </div>
                    </div>

                    {{-- Keuangan --}}
                    <div class="pb-4">
                        <p
                            x-text="(sidebarPinned || sidebarHovered) ? 'Keuangan' : '•••'"
                            :class="(sidebarPinned || sidebarHovered) ? 'text-left px-3' : 'text-center justify-center'"
                            class="mb-2 flex items-center text-[10px] font-semibold uppercase tracking-[0.15em] text-blue-100/40"
                        ></p>

                        <div class="space-y-1.5">
                            <a href="{{ route('admin.penandatangan-dokumen') }}"
                            class="{{ $menuBase }} {{ request()->routeIs('admin.penandatangan-dokumen') ? $menuActive : $menuIdle }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 20h9M12 4h9M4 9h16M4 15h16M4 4h4v5H4zM4 15h4v5H4z" />
                                </svg>
                                <span x-show="sidebarPinned || sidebarHovered">Penandatangan Dokumen</span>
                            </a>

                            <a href="{{ route('admin.anggaran-perjadin') }}"
                            class="{{ $menuBase }} {{ request()->routeIs('admin.anggaran-perjadin') ? $menuActive : $menuIdle }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7h18M6 11h12M9 15h6M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z" />
                                </svg>
                                <span x-show="sidebarPinned || sidebarHovered">Anggaran Perjadin</span>
                            </a>

                            <a href="{{ route('admin.perjadin') }}"
                            class="{{ $menuBase }} {{ request()->routeIs('admin.perjadin') ? $menuActive : $menuIdle }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 17l4 4 4-4m-4-5v9M4 4h16v4H4z" />
                                </svg>
                                <span x-show="sidebarPinned || sidebarHovered">Perjadin</span>
                            </a>
                        </div>
                    </div>
                </div>
            </aside>

            {{-- Overlay mobile --}}
            <div x-show="mobileSidebarOpen" x-cloak class="fixed inset-0 z-30 bg-slate-950/50 backdrop-blur-sm md:hidden" @click="mobileSidebarOpen = false"></div>

            {{-- Sidebar mobile --}}
            <aside x-show="mobileSidebarOpen" x-cloak class="fixed left-0 top-0 z-40 flex h-screen w-64 flex-col bg-[#21325E] text-white md:hidden">
                    <div class="flex h-14 items-center justify-between border-b border-white/10 px-3">                    <div class="flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white/10">
                            <span class="text-sm font-bold text-white">S</span>
                        </div>
                        <div>
                            <h1 class="text-lg font-extrabold tracking-tight">SIBIKON KALTIM</h1>
                            <p class="text-xs text-blue-100/70">Panel Admin</p>
                        </div>
                    </div>

                    <button @click="mobileSidebarOpen = false" class="rounded-xl border border-white/10 bg-white/5 p-2 text-white/80">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto scrollbar-dark px-2.5 py-3">
                    <a href="{{ route('admin.dashboard') }}" class="mb-3 flex items-center gap-3 rounded-2xl bg-white/12 px-3 py-3 text-sm font-semibold text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l9-9 9 9M4.5 10.5V20a1 1 0 001 1h4.5v-6h4v6H18.5a1 1 0 001-1v-9.5"/>
                        </svg>
                        Dashboard
                    </a>

                    <div class="space-y-1 text-sm text-blue-100/80">
                        <a href="{{ route('admin.pengguna') }}" class="block rounded-xl px-3 py-2.5 hover:bg-white/8">Pengguna</a>
                        <a href="{{ route('admin.jabatan-kerja') }}" class="block rounded-xl px-3 py-2.5 hover:bg-white/8">Jabatan Kerja</a>
                        <a href="{{ route('admin.prodi-pendidikan') }}" class="block rounded-xl px-3 py-2.5 hover:bg-white/8">Prodi Pendidikan</a>
                        <a href="{{ route('admin.pegawai') }}" class="block rounded-xl px-3 py-2.5 hover:bg-white/8">Pegawai</a>
                        <a href="{{ route('admin.bujk') }}" class="block rounded-xl px-3 py-2.5 hover:bg-white/8">BUJK</a>
                    </div>
                </div>
            </aside>

            {{-- Main --}}
            <div :class="(sidebarPinned || sidebarHovered) ? 'md:ml-64' : 'md:ml-16'" class="flex min-h-screen flex-1 flex-col transition-all duration-300">                {{-- Topbar --}}
                <header class="sticky top-0 z-20 border-b border-slate-200/80 bg-white/90 backdrop-blur-xl">
                    <div class="flex h-20 items-center justify-between gap-4 px-4 md:px-8">
                        <div class="flex min-w-0 items-center gap-3">
                            <button
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
                                <h2 class="truncate text-2xl font-extrabold tracking-tight text-slate-900">@yield('page-title', 'Dashboard')</h2>
                                <p class="truncate text-sm text-slate-500">@yield('page-subtitle', 'Panel admin setelah login')</p>
                            </div>
                        </div>

                        <div class="flex shrink-0 items-center gap-3">
                            <div class="hidden lg:flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-600 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                          d="M8 7V3m8 4V3m-9 8h10m-13 9h16a1 1 0 001-1V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a1 1 0 001 1z" />
                                </svg>
                                <span>{{ now()->translatedFormat('d F Y') }}</span>
                            </div>

                            <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-3 py-2 shadow-sm">
                                <div class="hidden text-right sm:block">
                                    <p class="text-sm font-semibold text-slate-900">{{ auth()->check() ? auth()->user()->name : 'Admin' }}</p>
                                    <p class="text-xs text-slate-500">Administrator</p>
                                </div>

                                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#3A4FAC] text-white shadow-sm">
                                    <span class="text-sm font-bold">
                                        {{ strtoupper(substr(auth()->check() ? auth()->user()->name : 'Admin', 0, 1)) }}
                                    </span>
                                </div>
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