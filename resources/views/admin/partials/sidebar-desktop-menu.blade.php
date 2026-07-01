@php
    $menuBase = 'group flex items-center gap-3 rounded-xl px-3 py-2.5 text-[13px] font-medium transition';

    $menuIdle = 'text-blue-100/85 hover:bg-white/7 hover:text-white';

    $menuActive = 'bg-[#28428B] text-[#F7E578] shadow-[inset_0_1px_0_rgba(255,255,255,0.05)]';

    $sectionTitleClass = 'mb-2 flex items-center text-[10px] font-semibold uppercase tracking-[0.18em] text-blue-100/45';

    $subItemBase = 'relative block rounded-lg px-3 py-2 text-[13px] leading-relaxed';
    $subItemIdle = 'text-blue-100/70 hover:bg-white/6 hover:text-white';
    $subItemActive = 'bg-[#28428B] text-[#F7E578] font-semibold';

    $mjkActive = request()->routeIs(
        'admin.masyarakat-jasa-konstruksi',
        'admin.pengguna-jasa',
        'admin.asosiasi-perusahaan',
        'admin.asosiasi-profesi',
        'admin.lsp',
        'admin.perguruan-tinggi',
        'admin.lppkk',
        'admin.pemerhati-konstruksi',
        'admin.pemanfaat-produk*',
        'admin.rantai-pasok',
        'admin.bujk'
    );
@endphp


<div class="relative z-10 flex-1 overflow-y-auto scrollbar-dark px-3 py-4">

    {{-- SECTION: MENU UTAMA --}}
    <div class="mb-6">

        {{-- Judul section sidebar (Menu / ••• saat collapsed) --}}
        <p
            x-text="(sidebarPinned || sidebarHovered) ? 'Menu' : '•••'"
            :class="(sidebarPinned || sidebarHovered) ? 'text-left px-2' : 'text-center justify-center'"
            class="{{ $sectionTitleClass }}"
        ></p>

        {{-- Container menu Dashboard --}}
        <div
            x-data="{ open: {{ request()->routeIs('admin.dashboard-tkk') || request()->routeIs('admin.bujk') || request()->routeIs('admin.dashboard') ? 'true' : 'false' }} }"
            class="space-y-1.5"
        >

            {{-- Tombol dropdown Dashboard --}}
            <button
                type="button"
                @click="open = !open"
                class="group flex w-full items-center justify-between rounded-xl px-3 py-2.5 text-[13px] font-medium transition
                {{ request()->routeIs('admin.dashboard-tkk') || request()->routeIs('admin.bujk') || request()->routeIs('admin.dashboard') ? $menuActive : $menuIdle }}"
            >
                <div class="flex items-center gap-3">

                    {{-- Icon home dashboard --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M3 12l9-9 9 9M4.5 10.5V20a1 1 0 001 1h4.5v-6h4v6H18.5a1 1 0 001-1v-9.5"/>
                    </svg>

                    {{-- Label dashboard --}}
                    <span x-show="sidebarPinned || sidebarHovered" x-transition>
                        Dashboard
                    </span>
                </div>

                {{-- Icon arrow expand --}}
                <svg
                    x-show="sidebarPinned || sidebarHovered"
                    :class="open ? 'rotate-90' : ''"
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 transition-transform duration-200"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5l7 7-7 7" />
                </svg>
            </button>

            {{-- Submenu Dashboard --}}
            <div x-show="open && (sidebarPinned || sidebarHovered)" x-transition class="relative ml-6 pl-4">
                <div class="absolute bottom-2 left-[6px] top-1 w-px bg-white/15"></div>

                <div class="space-y-1">

                    {{-- Sub: Dashboard BUJK --}}
                    <a href="{{ route('admin.dashboard') }}"
                        class="{{ $subItemBase }} {{ request()->routeIs('admin.dashboard') || request()->routeIs('admin.bujk') ? $subItemActive : $subItemIdle }}">
                        <span class="absolute left-[-12px] top-1/2 h-2 w-2 -translate-y-1/2 rounded-full
                            {{ request()->routeIs('admin.dashboard') || request()->routeIs('admin.bujk') ? 'bg-[#F7E578]' : 'bg-white/30' }}">
                        </span>
                        Dashboard Badan Usaha Jasa Konstruksi
                    </a>

                    {{-- Sub: Dashboard TKK --}}
                    <a href="{{ route('admin.dashboard-tkk') }}"
                        class="{{ $subItemBase }} {{ request()->routeIs('admin.dashboard-tkk') ? $subItemActive : $subItemIdle }}">
                        <span class="absolute left-[-12px] top-1/2 h-2 w-2 -translate-y-1/2 rounded-full
                            {{ request()->routeIs('admin.dashboard-tkk') ? 'bg-[#F7E578]' : 'bg-white/30' }}">
                        </span>
                        Dashboard Tenaga Kerja Konstruksi
                    </a>

                </div>
            </div>
        </div>
    </div>

    <div class="mb-6">
        <p
            x-text="(sidebarPinned || sidebarHovered) ? 'Data Master' : '•••'"
            :class="(sidebarPinned || sidebarHovered) ? 'text-left px-2' : 'text-center justify-center'"
            class="{{ $sectionTitleClass }}"
        ></p>

        {{-- Container menu utama Data Master --}}
        <div class="space-y-1.5">
            {{-- Menu: Pengguna --}}
            <a href="{{ route('admin.pengguna') }}" class="{{ $menuBase }} {{ request()->routeIs('admin.pengguna') ? $menuActive : $menuIdle }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5V18a4 4 0 00-5-3.87M17 20H7m10 0v-2a5.002 5.002 0 00-9.288 0M15 7a3 3 0 11-6 0" />
                </svg>
                <span x-show="sidebarPinned || sidebarHovered">Pengguna</span>
            </a>

            {{-- Menu: Jabatan Kerja --}}
            <a href="{{ route('admin.jabatan-kerja') }}" class="{{ $menuBase }} {{ request()->routeIs('admin.jabatan-kerja') ? $menuActive : $menuIdle }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2m-6 0h6m-6 0H6a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V8a2 2 0 00-2-2h-3" />
                </svg>
                <span x-show="sidebarPinned || sidebarHovered">Jabatan Kerja</span>
            </a>

            {{-- Menu: Prodi Pendidikan --}}
            <a href="{{ route('admin.prodi-pendidikan') }}" class="{{ $menuBase }} {{ request()->routeIs('admin.prodi-pendidikan') ? $menuActive : $menuIdle }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0112 20.055a12.083 12.083 0 01-6.16-9.477L12 14z" />
                </svg>
                <span x-show="sidebarPinned || sidebarHovered">Prodi Pendidikan</span>
            </a>

            {{-- Menu: Pegawai --}}
            <a href="{{ route('admin.pegawai') }}" class="{{ $menuBase }} {{ request()->routeIs('admin.pegawai') ? $menuActive : $menuIdle }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5.121 17.804A11.953 11.953 0 0112 15c2.5 0 4.824.765 6.879 2.071M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span x-show="sidebarPinned || sidebarHovered">Pegawai</span>
            </a>

            {{-- Menu: Masyarakat Jasa Konstruksi --}}
            <div x-data="{ open: {{ $mjkActive ? 'true' : 'false' }} }" class="space-y-1.5">
                <button
                    type="button"
                    @click="open = !open"
                    class="flex w-full items-center justify-between rounded-xl px-3 py-2.5 text-[13px] font-medium transition {{ $mjkActive ? $menuActive : $menuIdle }}"
                >
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 10a3 3 0 110-6 3 3 0 010 6zm8 0a3 3 0 110-6 3 3 0 010 6zM8 14c-2.67 0-8 1.34-8 4v2h10m6-6c2.67 0 8 1.34 8 4v2H14" />
                        </svg>
                        <span x-show="sidebarPinned || sidebarHovered">Masyarakat Jasa Konstruksi</span>
                    </div>

                    {{-- Arrow indikator dropdown --}}
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

                {{-- Submenu container --}}
                <div x-show="open && (sidebarPinned || sidebarHovered)" x-transition class="relative ml-6 pl-4">
                    <div class="absolute bottom-2 left-[6px] top-1 w-px bg-white/15"></div>

                    <div class="space-y-1">
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
                               class="{{ $subItemBase }} {{ request()->routeIs($sub['route'] . '*') ? $subItemActive : $subItemIdle }}">
                                <span class="absolute left-[-12px] top-1/2 h-2 w-2 -translate-y-1/2 rounded-full {{ request()->routeIs($sub['route'] . '*') ? 'bg-[#F7E578]' : 'bg-white/30' }}"></span>
                                {{ $sub['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Menu: Paket Konstruksi --}}
            <a href="{{ route('admin.paket-konstruksi') }}" class="{{ $menuBase }} {{ request()->routeIs('admin.paket-konstruksi') ? $menuActive : $menuIdle }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" />
                </svg>
                <span x-show="sidebarPinned || sidebarHovered">Paket Konstruksi</span>
            </a>

            {{-- Menu: Kotak Saran --}}
            <a href="{{ route('admin.kotak-saran') }}" class="{{ $menuBase }} {{ request()->routeIs('admin.kotak-saran') ? $menuActive : $menuIdle }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l9 6 9-6m-18 8h18V8H3v8z" />
                </svg>
                <span x-show="sidebarPinned || sidebarHovered">Kotak Saran</span>
            </a>

            {{-- Menu: File Upload --}}
            <a href="{{ route('admin.file-upload') }}" class="{{ $menuBase }} {{ request()->routeIs('admin.file-upload') ? $menuActive : $menuIdle }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M16 8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                <span x-show="sidebarPinned || sidebarHovered">File Upload</span>
            </a>

            {{-- Menu: Buku Tamu --}}
            <a href="{{ route('admin.buku-tamu') }}" class="{{ $menuBase }} {{ request()->routeIs('admin.buku-tamu') ? $menuActive : $menuIdle }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.483 9.246 5 7.5 5 5.014 5 3 6.12 3 7.5v9C3 15.12 5.014 14 7.5 14c1.746 0 3.332.483 4.5 1.253m0-9C13.168 5.483 14.754 5 16.5 5c2.486 0 4.5 1.12 4.5 2.5v9c0-1.38-2.014-2.5-4.5-2.5-1.746 0-3.332.483-4.5 1.253"/>
                </svg>
                <span x-show="sidebarPinned || sidebarHovered">Buku Tamu</span>
            </a>
        </div>
    </div>

    <div class="mb-6">
    <p
            x-text="(sidebarPinned || sidebarHovered) ? 'Manajemen Berita' : '•••'"
            :class="(sidebarPinned || sidebarHovered) ? 'text-left px-2' : 'text-center justify-center'"
            class="{{ $sectionTitleClass }}"
        ></p>

        <!-- Menu: Kategori Berita -->
        <div class="space-y-1.5">
            <a href="{{ route('admin.kategori') }}" class="{{ $menuBase }} {{ request()->routeIs('admin.kategori') ? $menuActive : $menuIdle }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 7h10M7 12h10M7 17h10M4 7h.01M4 12h.01M4 17h.01" />
                </svg>
                <span x-show="sidebarPinned || sidebarHovered">Kategori</span>
            </a>

            <!-- Menu: Daftar Berita -->
            <a href="{{ route('admin.berita') }}" class="{{ $menuBase }} {{ request()->routeIs('admin.berita') ? $menuActive : $menuIdle }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 5H5a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2zM7 9h10M7 13h6" />
                </svg>
                <span x-show="sidebarPinned || sidebarHovered">Berita</span>
            </a>
        </div>
    </div>

    <div class="mb-6">
        <!-- Section Title: Sub Pengaturan -->
        <p
            x-text="(sidebarPinned || sidebarHovered) ? 'Sub Pengaturan' : '•••'"
            :class="(sidebarPinned || sidebarHovered) ? 'text-left px-2' : 'text-center justify-center'"
            class="{{ $sectionTitleClass }}"
        ></p>

        <div class="space-y-1.5">
            <!-- Menu: Acara & Kegiatan -->
            <a href="{{ route('admin.acara-kegiatan') }}" class="{{ $menuBase }} {{ request()->routeIs('admin.acara-kegiatan') ? $menuActive : $menuIdle }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10m-13 9h16a1 1 0 001-1V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a1 1 0 001 1z" />
                </svg>
                <span x-show="sidebarPinned || sidebarHovered">Acara/Kegiatan</span>
            </a>

            <!-- Menu: Peraturan -->
            <a href="{{ route('admin.peraturan') }}" class="{{ $menuBase }} {{ request()->routeIs('admin.peraturan') ? $menuActive : $menuIdle }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z" />
                </svg>
                <span x-show="sidebarPinned || sidebarHovered">Peraturan</span>
            </a>
        </div>
    </div>

    <div class="mb-6">
        <!-- Section Title: Sub Pemberdayaan -->
        <p
            x-text="(sidebarPinned || sidebarHovered) ? 'Sub Pemberdayaan' : '•••'"
            :class="(sidebarPinned || sidebarHovered) ? 'text-left px-2' : 'text-center justify-center'"
            class="{{ $sectionTitleClass }}"
        ></p>

        <!-- Menu: Tenaga Kerja Konstruksi -->
        <div class="space-y-1.5">
            <a href="{{ route('admin.tenaga-kerja-konstruksi') }}" class="{{ $menuBase }} {{ request()->routeIs('admin.tenaga-kerja-konstruksi') ? $menuActive : $menuIdle }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5V18a4 4 0 00-5-3.87M17 20H7m10 0v-2a5.002 5.002 0 00-9.288 0M15 7a3 3 0 11-6 0" />
                </svg>
                <span x-show="sidebarPinned || sidebarHovered">Tenaga Kerja Konstruksi</span>
            </a>

            <!-- Menu: Tenaga Kerja Konstruksi -->
            <div x-data="{ open: {{ request()->routeIs('admin.pelatihan-sertifikasi.*') ? 'true' : 'false' }} }" class="space-y-1.5">
                <button
                    type="button"
                    @click="open = !open"
                    class="flex w-full items-center justify-between rounded-xl px-3 py-2.5 text-[13px] font-medium transition {{ request()->routeIs('admin.pelatihan-sertifikasi.*') ? $menuActive : $menuIdle }}"
                >
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.483 9.246 5 7.5 5 5.014 5 3 6.12 3 7.5v9C3 15.12 5.014 14 7.5 14c1.746 0 3.332.483 4.5 1.253m0-9C13.168 5.483 14.754 5 16.5 5c2.486 0 4.5 1.12 4.5 2.5v9c0-1.38-2.014-2.5-4.5-2.5-1.746 0-3.332.483-4.5 1.253" />
                        </svg>
                        <span x-show="sidebarPinned || sidebarHovered">Pelatihan/Sertifikasi</span>
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

                <div x-show="open && (sidebarPinned || sidebarHovered)" x-transition class="relative ml-6 pl-4">
                    <div class="absolute bottom-2 left-[6px] top-1 w-px bg-white/15"></div>

                    <div class="space-y-1">
                        <a href="#" class="{{ $subItemBase }} {{ $subItemIdle }}">
                            <span class="absolute left-[-12px] top-1/2 h-2 w-2 -translate-y-1/2 rounded-full bg-white/30"></span>
                            Rencana Pelatihan (TNA)
                        </a>

                        <a href="{{ route('admin.pelatihan-sertifikasi.index') }}"
                            class="{{ $subItemBase }} {{ request()->routeIs('admin.pelatihan-sertifikasi.index') ? $subItemActive : $subItemIdle }}">
                            <span class="absolute left-[-12px] top-1/2 h-2 w-2 -translate-y-1/2 rounded-full {{ request()->routeIs('admin.pelatihan-sertifikasi.index') ? 'bg-[#F7E578]' : 'bg-white/30' }}"></span>
                            Pelatihan dan Sertifikasi TKK Ahli
                        </a>

                        <a href="#" class="{{ $subItemBase }} {{ $subItemIdle }}">
                            <span class="absolute left-[-12px] top-1/2 h-2 w-2 -translate-y-1/2 rounded-full bg-white/30"></span>
                            Bimbingan Teknis/Pelatihan
                        </a>

                        <a href="#" class="{{ $subItemBase }} {{ $subItemIdle }}">
                            <span class="absolute left-[-12px] top-1/2 h-2 w-2 -translate-y-1/2 rounded-full bg-white/30"></span>
                            Pelatihan dan Sertifikasi Instruktur/Asesor
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-6">
        <!-- Section: Sub Pengawasan -->
        <p
            x-text="(sidebarPinned || sidebarHovered) ? 'Sub Pengawasan' : '•••'"
            :class="(sidebarPinned || sidebarHovered) ? 'text-left px-2' : 'text-center justify-center'"
            class="{{ $sectionTitleClass }}"
        ></p>

        <div class="space-y-1.5">
            <a href="{{ route('admin.tertib-usaha') }}" class="{{ $menuBase }} {{ request()->routeIs('admin.tertib-usaha') ? $menuActive : $menuIdle }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12h18M12 3v18" />
                </svg>
                <span x-show="sidebarPinned || sidebarHovered">Tertib Usaha</span>
            </a>

            <a href="{{ route('admin.tertib-penyelenggaraan') }}" class="{{ $menuBase }} {{ request()->routeIs('admin.tertib-penyelenggaraan') ? $menuActive : $menuIdle }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 2a7 7 0 00-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 00-7-7zm0 9a2 2 0 110-4 2 2 0 010 4z" />
                </svg>
                <span x-show="sidebarPinned || sidebarHovered">Tertib Penyelenggaraan</span>
            </a>

            <a href="{{ route('admin.tertib-pemanfaatan') }}" class="{{ $menuBase }} {{ request()->routeIs('admin.tertib-pemanfaatan') ? $menuActive : $menuIdle }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 4h14v16H5zM9 8h6M9 12h6M9 16h4" />
                </svg>
                <span x-show="sidebarPinned || sidebarHovered">Tertib Pemanfaatan</span>
            </a>
        </div>
    </div>

    <div class="mb-6">
        <!-- Section: Arsip / Surat -->
        <p
            x-text="(sidebarPinned || sidebarHovered) ? 'Arsip / Surat' : '•••'"
            :class="(sidebarPinned || sidebarHovered) ? 'text-left px-2' : 'text-center justify-center'"
            class="{{ $sectionTitleClass }}"
        ></p>

        <div class="space-y-1.5">
            <a href="{{ route('admin.surat-menyurat') }}" class="{{ $menuBase }} {{ request()->routeIs('admin.surat-menyurat') ? $menuActive : $menuIdle }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l9 6 9-6m-18 8h18V8H3v8z" />
                </svg>
                <span x-show="sidebarPinned || sidebarHovered">Surat Menyurat</span>
            </a>

            <a href="{{ route('admin.arsip') }}" class="{{ $menuBase }} {{ request()->routeIs('admin.arsip') ? $menuActive : $menuIdle }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 2h9l5 5v13a2 2 0 01-2 2H6a2 2 0 01-2-2V4a2 2 0 012-2z" />
                </svg>
                <span x-show="sidebarPinned || sidebarHovered">Arsip</span>
            </a>
        </div>
    </div>

    <div class="pb-6">
        <!-- Section: Keuangan -->
        <p
            x-text="(sidebarPinned || sidebarHovered) ? 'Keuangan' : '•••'"
            :class="(sidebarPinned || sidebarHovered) ? 'text-left px-2' : 'text-center justify-center'"
            class="{{ $sectionTitleClass }}"
        ></p>

        <div class="space-y-1.5">
            <a href="{{ route('admin.penandatangan-dokumen') }}" class="{{ $menuBase }} {{ request()->routeIs('admin.penandatangan-dokumen') ? $menuActive : $menuIdle }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 20h9M12 4h9M4 9h16M4 15h16M4 4h4v5H4zM4 15h4v5H4z" />
                </svg>
                <span x-show="sidebarPinned || sidebarHovered">Penandatangan Dokumen</span>
            </a>

            <a href="{{ route('admin.anggaran-perjadin') }}" class="{{ $menuBase }} {{ request()->routeIs('admin.anggaran-perjadin') ? $menuActive : $menuIdle }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7h18M6 11h12M9 15h6M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z" />
                </svg>
                <span x-show="sidebarPinned || sidebarHovered">Anggaran Perjadin</span>
            </a>

            <a href="{{ route('admin.perjadin') }}" class="{{ $menuBase }} {{ request()->routeIs('admin.perjadin') ? $menuActive : $menuIdle }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 17l4 4 4-4m-4-5v9M4 4h16v4H4z" />
                </svg>
                <span x-show="sidebarPinned || sidebarHovered">Perjadin</span>
            </a>
        </div>
    </div>
</div>