<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIBIKON</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-white">

    @if (($page ?? 'beranda') === 'beranda')
        @include('pages.beranda')
    @elseif ($page === 'tentang-kami')
        @include('pages.profil.tentang-kami')
    @elseif ($page == 'struktur')
        @include('pages.profil.struktur')
    @elseif ($page == 'sop-renja')
        @include('pages.profil.sop-renja')
    @elseif ($page == 'rakor')
        @include('pages.fungsi.pengaturan.rakor')
    @elseif ($page == 'sosialisasi')
        @include('pages.fungsi.pengaturan.sosialisasi')
    @elseif ($page === 'daftar-sosil')
        @include('pages.fungsi.pengaturan.daftar-sosil')
    @elseif ($page === 'forum')
        @include('pages.fungsi.pengaturan.forum')
    @elseif ($page === 'rantai-pasok')
        @include('pages.fungsi.pengaturan.rantai-pasok')
    @elseif ($page === 'tabel-tkk')
        @include('pages.fungsi.pemberdayaan.tabel-tkk')
    @elseif ($page === 'pelatihan-ahli')
        @include('pages.fungsi.pemberdayaan.pelatihan-ahli')
    @elseif ($page === 'tertib-usaha')
        @include('pages.fungsi.pengawasan.tertib-usaha')
    @elseif ($page === 'tertib-penyelenggaraan')
        @include('pages.fungsi.pengawasan.tertib-penyelenggaraan')
    @elseif ($page === 'tertib-pemanfaatan')
        @include('pages.fungsi.pengawasan.tertib-pemanfaatan')
    @elseif ($page === 'asosiasi-perusahaan')
        @include('pages.layanan.asosiasi-perusahaan')
    @elseif ($page === 'asosiasi-profesi')
        @include('pages.layanan.asosiasi-profesi')
    @elseif ($page === 'penyedia-jasa')
        @include('pages.layanan.penyedia-jasa')
    @elseif ($page === 'login')
        @include('pages.login')
    @elseif ($page === 'regist')
        @include('pages.regist')
    @elseif ($page === 'kontak')
        @include('pages.kontak')
    @elseif ($page === 'berita')
        @include('pages.berita')
    @elseif ($page === 'detail-berita')
        @include('pages.detail-berita')
    @endif

</body>
</html>

<!-- <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIBIKON</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-white">

    @yield('content')

</body>
</html> -->