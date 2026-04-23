<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-ReservLap</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0088FF;
            --bg: #F5F7FA;
            --text-dark: #1A1C1E;
            --text-gray: #6C757D;
            --white: #FFFFFF;
            --border: #E8ECF4;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--bg);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 420px;
        }

        /* App Icon */
        .app-icon {
            width: 72px;
            height: 72px;
            background: var(--primary);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 10px 25px rgba(0, 136, 255, 0.25);
        }

        /* Page Title */
        .auth-title {
            font-size: 28px;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .auth-subtitle {
            font-size: 14px;
            color: var(--text-gray);
            margin-bottom: 35px;
        }

        /* Error Alert */
        .alert-error {
            background: #FFF5F5;
            border: 1px solid #FED7D7;
            color: #C53030;
            padding: 14px 18px;
            border-radius: 14px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .alert-error ul {
            list-style: none;
            padding: 0;
        }

        .alert-error li::before {
            content: '⚠ ';
        }

        /* Input Group */
        .input-group {
            position: relative;
            margin-bottom: 16px;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #A0AEC0;
            font-size: 16px;
            pointer-events: none;
        }

        .input-group input {
            width: 100%;
            padding: 16px 50px;
            background: var(--white);
            border: 1.5px solid var(--border);
            border-radius: 14px;
            font-size: 15px;
            font-family: 'Outfit', sans-serif;
            color: var(--text-dark);
            transition: border-color 0.25s, box-shadow 0.25s;
        }

        .input-group input::placeholder {
            color: #A0AEC0;
            font-size: 14px;
        }

        .input-group input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(0, 136, 255, 0.1);
        }

        /* Password Toggle */
        .pwd-toggle {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #A0AEC0;
            cursor: pointer;
            font-size: 17px;
            background: none;
            border: none;
            padding: 0;
            transition: color 0.2s;
        }

        .pwd-toggle:hover {
            color: var(--primary);
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 16px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 14px;
            font-size: 16px;
            font-weight: 700;
            font-family: 'Outfit', sans-serif;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
            transition: background 0.25s, transform 0.2s, box-shadow 0.25s;
            box-shadow: 0 8px 20px rgba(0, 136, 255, 0.25);
        }

        .btn-submit:hover {
            background: #006EE0;
            transform: translateY(-1px);
            box-shadow: 0 12px 28px rgba(0, 136, 255, 0.35);
        }

        .btn-submit:active {
            transform: scale(0.98);
        }

        /* Footer Link */
        .auth-footer {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
            color: var(--text-gray);
        }

        .auth-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="app-icon">
            <i class="fa-solid fa-futbol"></i>
        </div>

        <h1 class="auth-title">Selamat Datang !</h1>
        <p class="auth-subtitle">Masuk ke akun E-ReservLap anda</p>

        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.process') }}">
            @csrf

            <div class="input-group">
                <i class="fa-regular fa-envelope input-icon"></i>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Email"
                    required
                    autofocus
                >
            </div>

            <div class="input-group">
                <i class="fa-solid fa-lock input-icon"></i>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Password"
                    required
                >
                <button type="button" class="pwd-toggle" onclick="togglePassword('password', this)">
                    <i class="fa-regular fa-eye"></i>
                </button>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-arrow-right-to-bracket"></i>
                Masuk
            </button>
        </form>

        <div class="auth-footer">
            Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
        </div>
    </div>

    <script>
        function togglePassword(id, btn) {
            const input = document.getElementById(id);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fa-regular fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'fa-regular fa-eye';
            }
        }
    </script>
</body>
</html>