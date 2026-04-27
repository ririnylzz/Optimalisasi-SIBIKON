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
    @elseif ($page === 'profil')
        @include('pages.profil')
    @endif

</body>
</html>