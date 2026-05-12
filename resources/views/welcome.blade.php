<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIBIKON</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @php
        $page = $page ?? 'beranda';

        $authPages = [
            'login',
            'regist',
        ];
    @endphp

    @if(in_array($page, $authPages, true))
        <a
            href="{{ route('beranda') }}"
            class="fixed left-8 top-8 z-[9999] flex items-center gap-2 text-white font-medium transition hover:opacity-80"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            <span>Kembali</span>
        </a>
    @endif

    @if($page === 'login')
        @include('pages.login')
    @elseif($page === 'regist')
        @include('pages.regist')
    @elseif($page === 'tentang-kami')
        @include('pages.profil.tentang-kami')
    @elseif($page === 'struktur')
        @include('pages.profil.struktur')
    @elseif($page === 'sop-renja')
        @include('pages.profil.sop-renja')
    @elseif($page === 'kontak')
        @include('pages.kontak')
    @elseif($page === 'berita')
        @include('pages.berita')
    @elseif($page === 'detail-berita')
        @include('pages.detail-berita')
    @elseif($page === 'rakor')
        @include('pages.fungsi.pengaturan.rakor')
    @elseif($page === 'sosialisasi')
        @include('pages.fungsi.pengaturan.sosialisasi')
    @elseif($page === 'forum')
        @include('pages.fungsi.pengaturan.forum')
    @elseif($page === 'rantai-pasok')
        @include('pages.fungsi.pengaturan.rantai-pasok')
    @elseif($page === 'daftar-sosil')
        @include('pages.fungsi.pengaturan.daftar-sosil')
    @elseif($page === 'tabel-tkk')
        @include('pages.fungsi.pemberdayaan.tabel-tkk')
    @elseif($page === 'pelatihan-ahli')
        @include('pages.fungsi.pemberdayaan.pelatihan-ahli')
    @elseif($page === 'tertib-usaha')
        @include('pages.fungsi.pengawasan.tertib-usaha')
    @elseif($page === 'tertib-penyelenggaraan')
        @include('pages.fungsi.pengawasan.tertib-penyelenggaraan')
    @elseif($page === 'tertib-pemanfaatan')
        @include('pages.fungsi.pengawasan.tertib-pemanfaatan')
    @else
        @include('pages.beranda')
    @endif
</body>
</html>