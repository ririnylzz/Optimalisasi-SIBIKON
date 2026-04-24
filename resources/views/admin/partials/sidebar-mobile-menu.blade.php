<div class="relative z-10">
    <div class="space-y-1.5">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-[#28428B] text-[#F7E578]' : 'text-blue-100/85 hover:bg-white/7' }} px-3 py-2.5 text-sm font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l9-9 9 9M4.5 10.5V20a1 1 0 001 1h4.5v-6h4v6H18.5a1 1 0 001-1v-9.5"/>
            </svg>
            Dashboard
        </a>

        <div class="pt-2 text-[10px] font-semibold uppercase tracking-[0.18em] text-blue-100/45">Data Master</div>

        <a href="{{ route('admin.pengguna') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.pengguna') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">Pengguna</a>
        <a href="{{ route('admin.jabatan-kerja') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.jabatan-kerja') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">Jabatan Kerja</a>
        <a href="{{ route('admin.prodi-pendidikan') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.prodi-pendidikan') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">Prodi Pendidikan</a>
        <a href="{{ route('admin.pegawai') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.pegawai') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">Pegawai</a>
        <a href="{{ route('admin.paket-konstruksi') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.paket-konstruksi') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">Paket Konstruksi</a>
        <a href="{{ route('admin.kotak-saran') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.kotak-saran') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">Kotak Saran</a>
        <a href="{{ route('admin.file-upload') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.file-upload') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">File Upload</a>
        <a href="{{ route('admin.buku-tamu') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.buku-tamu') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">Buku Tamu</a>

        <div class="pt-2 text-[10px] font-semibold uppercase tracking-[0.18em] text-blue-100/45">Masyarakat Jasa Konstruksi</div>

        <a href="{{ route('admin.pengguna-jasa') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.pengguna-jasa') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">Pengguna Jasa</a>
        <a href="{{ route('admin.asosiasi-perusahaan') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.asosiasi-perusahaan') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">Asosiasi Perusahaan</a>
        <a href="{{ route('admin.asosiasi-profesi') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.asosiasi-profesi') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">Asosiasi Profesi</a>
        <a href="{{ route('admin.lsp') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.lsp') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">LSP</a>
        <a href="{{ route('admin.perguruan-tinggi') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.perguruan-tinggi') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">Perguruan Tinggi / Pakar</a>
        <a href="{{ route('admin.lppkk') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.lppkk') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">LPPKK</a>
        <a href="{{ route('admin.pemerhati-konstruksi') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.pemerhati-konstruksi') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">Pemerhati Konstruksi</a>
        <a href="{{ route('admin.pemanfaat-produk') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.pemanfaat-produk') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">Pemanfaat Produk</a>
        <a href="{{ route('admin.rantai-pasok') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.rantai-pasok') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">Rantai Pasok</a>
        <a href="{{ route('admin.bujk') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.bujk') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">BUJK</a>

        <div class="pt-2 text-[10px] font-semibold uppercase tracking-[0.18em] text-blue-100/45">Manajemen Berita</div>

        <a href="{{ route('admin.kategori') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.kategori') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">Kategori</a>
        <a href="{{ route('admin.berita') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.berita') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">Berita</a>

        <div class="pt-2 text-[10px] font-semibold uppercase tracking-[0.18em] text-blue-100/45">Lainnya</div>

        <a href="{{ route('admin.acara-kegiatan') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.acara-kegiatan') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">Acara/Kegiatan</a>
        <a href="{{ route('admin.peraturan') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.peraturan') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">Peraturan</a>
        <a href="{{ route('admin.tenaga-kerja-konstruksi') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.tenaga-kerja-konstruksi') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">Tenaga Kerja Konstruksi</a>
        <a href="{{ route('admin.pelatihan-sertifikasi') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.pelatihan-sertifikasi') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">Pelatihan/Sertifikasi</a>
        <a href="{{ route('admin.tertib-usaha') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.tertib-usaha') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">Tertib Usaha</a>
        <a href="{{ route('admin.tertib-penyelenggaraan') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.tertib-penyelenggaraan') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">Tertib Penyelenggaraan</a>
        <a href="{{ route('admin.tertib-pemanfaatan') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.tertib-pemanfaatan') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">Tertib Pemanfaatan</a>
        <a href="{{ route('admin.surat-menyurat') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.surat-menyurat') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">Surat Menyurat</a>
        <a href="{{ route('admin.arsip') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.arsip') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">Arsip</a>
        <a href="{{ route('admin.penandatangan-dokumen') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.penandatangan-dokumen') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">Penandatangan Dokumen</a>
        <a href="{{ route('admin.anggaran-perjadin') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.anggaran-perjadin') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">Anggaran Perjadin</a>
        <a href="{{ route('admin.perjadin') }}" class="block rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('admin.perjadin') ? 'bg-[#28428B] text-[#F7E578] font-semibold' : 'text-blue-100/85 hover:bg-white/7' }}">Perjadin</a>
    </div>
</div>