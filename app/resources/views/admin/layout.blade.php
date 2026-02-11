<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f6f7fb; }
        header { background: #1f2937; color: #fff; padding: 12px 20px; display: flex; gap: 16px; align-items: center; }
        header a { color: #fff; text-decoration: none; }
        .container { padding: 20px; }
        .card { background: #fff; border-radius: 8px; padding: 16px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        th, td { border-bottom: 1px solid #e5e7eb; padding: 8px; text-align: left; }
        .actions { display: flex; gap: 8px; }
        .btn { display: inline-block; padding: 6px 10px; border-radius: 6px; background: #2563eb; color: #fff; text-decoration: none; border: none; cursor: pointer; }
        .btn.secondary { background: #6b7280; }
        .btn.danger { background: #dc2626; }
        .error { color: #dc2626; margin-bottom: 10px; }
        .field { margin-bottom: 12px; }
        .field label { display: block; font-weight: bold; margin-bottom: 4px; }
        .field input, .field textarea { width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 6px; }
    </style>
</head>
<body>
<header>
    <strong>Skillwave Admin</strong>
    <a href="{{ route('home') }}">Public Site</a>
    <a href="{{ route('admin.courses.index') }}">Courses</a>
    <a href="{{ route('admin.enrollments.index') }}">Enrollments</a>
    <form action="{{ route('admin.logout') }}" method="POST" style="margin-left:auto;">
        @csrf
        <button class="btn secondary" type="submit">Logout</button>
    </form>
</header>
<div class="container">
    @if (session('status'))
        <div style="color:#166534;margin-bottom:10px;">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif
    @yield('content')
</div>
</body>
</html>
