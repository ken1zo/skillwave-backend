<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: Arial, sans-serif; background: #f3f4f6; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .card { background: #fff; padding: 24px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.08); width: 360px; }
        .field { margin-bottom: 12px; }
        label { display: block; margin-bottom: 4px; font-weight: bold; }
        input { width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 6px; }
        .btn { width: 100%; padding: 10px; background: #2563eb; color: #fff; border: none; border-radius: 6px; cursor: pointer; }
        .error { color: #dc2626; margin-bottom: 8px; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Admin Login</h2>
        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <div class="field">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="field">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button class="btn" type="submit">Login</button>
        </form>
    </div>
</body>
</html>
