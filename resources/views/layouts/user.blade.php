<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-ReservLap</title>

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- ICON -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --primary: #3A7BFF;
            --primary-light: #EBF4FF;
            --bg: #F5F7FA;
            --text-dark: #1A1C1E;
            --text-gray: #718096;
            --white: #FFFFFF;
            --shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
            --radius: 20px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: var(--bg);
            color: var(--text-dark);
        }

        /* ===== DESKTOP NAVBAR ===== */
        .top-navbar {
            display: none;
            background: var(--white);
            padding: 15px 40px;
            box-shadow: var(--shadow);
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .top-navbar .logo {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary);
        }

        .top-nav-links {
            display: flex;
            gap: 25px;
        }

        .top-nav-links a {
            text-decoration: none;
            color: var(--text-gray);
            font-weight: 500;
            font-size: 14px;
            transition: 0.2s;
        }

        .top-nav-links a.active {
            color: var(--primary);
            font-weight: 600;
        }

        .top-nav-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* ===== WRAPPER ===== */
        .app-wrapper {
            max-width: 1100px;
            margin: auto;
            min-height: 100vh;
            padding-bottom: 90px;
        }

        /* ===== BOTTOM NAV (MOBILE) ===== */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            background: var(--white);
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
            box-shadow: 0 -5px 20px rgba(0,0,0,0.05);
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            z-index: 1000;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #A0AEC0;
            font-size: 11px;
            transition: 0.2s;
        }

        .nav-item i {
            font-size: 20px;
            margin-bottom: 4px;
        }

        .nav-item.active {
            color: var(--primary);
            transform: translateY(-2px);
        }

        /* ===== BUTTON ===== */
        .btn-primary {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
        }

        /* ===== CARD ===== */
        .card {
            background: white;
            border-radius: var(--radius);
            padding: 18px;
            box-shadow: var(--shadow);
            margin-bottom: 15px;
        }

        /* ===== RESPONSIVE ===== */
        @media (min-width: 768px) {
            .top-navbar {
                display: flex;
            }

            .bottom-nav {
                display: none;
            }

            .app-wrapper {
                padding: 20px;
            }
        }
    </style>

    @yield('styles')
</head>

<body>

    <!-- DESKTOP NAV -->
    <nav class="top-navbar">
        <div class="logo">E-ReservLap</div>

        <div class="top-nav-links">
            <a href="{{ route('user.home') }}" class="{{ Request::routeIs('user.home') ? 'active' : '' }}">Beranda</a>
            <a href="{{ route('lapangan.index') }}" class="{{ Request::is('*lapangan*') ? 'active' : '' }}">Lapangan</a>
            <a href="{{ route('status.index') }}" class="{{ Request::is('*status*') ? 'active' : '' }}">Status</a>
            <a href="{{ route('profile.index') }}" class="{{ Request::is('*profile*') ? 'active' : '' }}">Profil</a>
        </div>

        <div class="top-nav-user">
            <span style="font-size: 13px; font-weight: 600;">
                {{ explode(' ', Auth::user()->name)[0] }}
            </span>
            <i class="fa-solid fa-circle-user" style="font-size: 26px; color: var(--primary);"></i>
        </div>
    </nav>

    <!-- CONTENT -->
    <div class="app-wrapper">
        @yield('content')
    </div>

    <!-- MOBILE NAV -->
    <nav class="bottom-nav">
        <a href="{{ route('user.home') }}" class="nav-item {{ Request::routeIs('user.home') ? 'active' : '' }}">
            <i class="fa-solid fa-house"></i>
            <span>Beranda</span>
        </a>

        <a href="{{ route('lapangan.index') }}" class="nav-item {{ Request::is('*lapangan*') ? 'active' : '' }}">
            <i class="fa-solid fa-layer-group"></i>
            <span>Lapangan</span>
        </a>

        <a href="{{ route('status.index') }}" class="nav-item {{ Request::is('*status*') ? 'active' : '' }}">
            <i class="fa-solid fa-file-invoice"></i>
            <span>Status</span>
        </a>

        <a href="{{ route('profile.index') }}" class="nav-item {{ Request::is('*profile*') ? 'active' : '' }}">
            <i class="fa-solid fa-user"></i>
            <span>Profil</span>
        </a>
    </nav>

    @yield('scripts')

</body>
</html>