<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SkillWave')</title>
    <style>
        :root {
            --bg: #f4f6fb;
            --surface: #fff;
            --text: #0f172a;
            --muted: #64748b;
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --border: #dbe2ef;
            --danger: #dc2626;
            --success: #166534;
        }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; color: var(--text); background: var(--bg); }
        a { color: inherit; text-decoration: none; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 16px; }
        .header { position: sticky; top: 0; background: var(--surface); border-bottom: 1px solid var(--border); z-index: 10; }
        .header__row { min-height: 72px; display: flex; align-items: center; justify-content: space-between; gap: 16px; }
        .logo { font-size: 22px; font-weight: 700; color: var(--primary); }
        .nav { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; }
        .nav a { color: var(--muted); font-weight: 600; }
        .nav a.active, .nav a:hover { color: var(--primary); }
        .btn { border: 1px solid transparent; border-radius: 8px; padding: 8px 14px; font-size: 14px; font-weight: 600; cursor: pointer; }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-outline { border-color: var(--primary); color: var(--primary); background: transparent; }
        .btn-outline:hover { background: var(--primary); color: #fff; }
        .main { padding: 28px 0 40px; }
        .title { margin: 0 0 18px; font-size: 30px; }
        .muted { color: var(--muted); }
        .card-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px; }
        .course-card { background: var(--surface); border: 1px solid var(--border); border-radius: 14px; padding: 14px; display: flex; flex-direction: column; gap: 12px; }
        .course-card img { width: 100%; height: 170px; object-fit: cover; border-radius: 10px; border: 1px solid var(--border); }
        .course-card__placeholder { width: 100%; height: 170px; border-radius: 10px; border: 1px solid var(--border); background: linear-gradient(135deg, #dbeafe, #e2e8f0); }
        .course-card h3 { margin: 0; font-size: 20px; }
        .price { color: var(--primary); font-size: 22px; font-weight: 700; }
        .course-card details { border-top: 1px solid var(--border); padding-top: 10px; }
        .course-card details summary { cursor: pointer; font-weight: 600; color: var(--muted); }
        .course-card ul { margin: 10px 0 0; padding-left: 18px; color: var(--muted); }
        .course-card form { margin-top: auto; }
        .panel { background: var(--surface); border: 1px solid var(--border); border-radius: 14px; padding: 16px; }
        .form { max-width: 480px; display: grid; gap: 12px; }
        .field label { display: block; margin-bottom: 6px; font-weight: 600; }
        .field input { width: 100%; border: 1px solid var(--border); border-radius: 8px; padding: 10px 12px; font-size: 15px; }
        .flash { margin-bottom: 14px; padding: 10px 12px; border-radius: 8px; font-size: 14px; }
        .flash-error { background: #fee2e2; color: var(--danger); border: 1px solid #fecaca; }
        .flash-success { background: #dcfce7; color: var(--success); border: 1px solid #bbf7d0; }
        .footer { border-top: 1px solid var(--border); padding: 20px 0; color: var(--muted); background: var(--surface); }
        @media (max-width: 680px) {
            .header__row { min-height: 64px; align-items: flex-start; padding: 12px 0; }
            .title { font-size: 24px; }
        }
    </style>
</head>
<body>
<header class="header">
    <div class="container header__row">
        <a class="logo" href="{{ route('home') }}">SkillWave</a>
        <nav class="nav">
            <a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Главная</a>
            <a class="{{ request()->routeIs('catalog') ? 'active' : '' }}" href="{{ route('catalog') }}">Каталог</a>
            @auth
                <a class="{{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}">Профиль</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-outline" type="submit">Выйти</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline">Войти</a>
            @endauth
        </nav>
    </div>
</header>

<main class="main">
    <div class="container">
        @if (session('status'))
            <div class="flash flash-success">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="flash flash-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        @yield('content')
    </div>
</main>

<footer class="footer">
    <div class="container">© {{ now()->year }} SkillWave</div>
</footer>
</body>
</html>
