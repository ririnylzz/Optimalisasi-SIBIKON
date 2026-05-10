<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIBIKON</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-white">
    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Content utama halaman -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

</body>
</html>