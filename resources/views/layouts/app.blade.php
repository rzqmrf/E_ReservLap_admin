<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Content -->
    <div class="container">
        @yield('content')
    </div>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Javascript -->
    <script src="{{ asset('js/script.js') }}"></script>

</body>
</html>
