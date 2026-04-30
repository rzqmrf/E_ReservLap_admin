<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-ReservLap</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0088FF;
            --primary-light: #E6F3FF;
            --bg: #F8FAFF;
            --text-dark: #1A1C1E;
            --text-gray: #6C757D;
            --white: #FFFFFF;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            --border-radius: 20px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--bg);
            color: var(--text-dark);
            min-height: 100vh;
            position: relative;
        }

        /* Top Navigation for Desktop */
        .top-navbar {
            display: none;
            background: var(--white);
            padding: 15px 50px;
            box-shadow: var(--shadow);
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .top-navbar .logo {
            font-size: 22px;
            font-weight: 800;
            color: var(--primary);
        }

        .top-nav-links {
            display: flex;
            gap: 30px;
        }

        .top-nav-links a {
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 600;
            font-size: 15px;
            transition: color 0.3s;
        }

        .top-nav-links a.active { color: var(--primary); }

        /* Responsive Wrapper */
        .app-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            min-height: 100vh;
            padding-bottom: 40px;
        }

        .container {
            padding: 20px;
        }

        /* Bottom Navigation for Mobile */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            background: var(--white);
            display: flex;
            justify-content: space-around;
            padding: 12px 0;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.05);
            z-index: 1000;
        }

        @media (min-width: 769px) {
            .top-navbar { display: flex; }
            .bottom-nav { display: none; }
            body { padding-bottom: 0; }
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #A0AEC0;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .nav-item i {
            font-size: 20px;
            margin-bottom: 4px;
        }

        .nav-item.active {
            color: var(--primary);
        }

        /* Common Elements */
        .btn-primary {
            background: var(--primary);
            color: var(--white);
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .btn-primary:active {
            transform: scale(0.95);
        }

        .card {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: var(--shadow);
            margin-bottom: 20px;
        }

        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-success { background: #E6FFFA; color: #38B2AC; }
        .badge-danger { background: #FFF5F5; color: #F56565; }
        .badge-warning { background: #FFFAF0; color: #DD6B20; }

        @media (min-width: 481px) {
            body {
                border-left: 1px solid #eee;
                border-right: 1px solid #eee;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="top-navbar">
        <div class="logo">E-ReservLap</div>
        <div class="top-nav-links">
            <a href="{{ route('user.home') }}" class="{{ Request::routeIs('user.home') ? 'active' : '' }}">Beranda</a>
            <a href="{{ route('lapangan.index') }}" class="{{ Request::is('*lapangan*') ? 'active' : '' }}">Lapangan</a>
            <a href="{{ route('status.index') }}" class="{{ Request::is('*status*') ? 'active' : '' }}">Status</a>
            <a href="{{ route('profile.index') }}" class="{{ Request::is('*profile*') ? 'active' : '' }}">Profil</a>
        </div>
        <div class="top-nav-user">
            <span style="font-weight: 600; font-size: 14px; margin-right: 15px;">{{ Auth::user()->name }}</span>
            <i class="fa-solid fa-circle-user" style="font-size: 30px; color: var(--primary);"></i>
        </div>
    </nav>

    <div class="app-wrapper">
        @yield('content')
    </div>

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
            <span>Profile</span>
        </a>
    </nav>

    @yield('scripts')
</body>
</html>
