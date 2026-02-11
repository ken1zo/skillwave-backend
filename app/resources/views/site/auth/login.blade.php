@extends('site.layout')

@section('title', 'SkillWave - Вход')

@section('content')
    <div class="panel">
        <h1 class="title" style="font-size: 28px;">Вход</h1>
        <form class="form" action="{{ route('login.submit') }}" method="POST">
            @csrf
            <div class="field">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required>
            </div>
            <div class="field">
                <label for="password">Пароль</label>
                <input id="password" name="password" type="password" required>
            </div>
            <button class="btn btn-primary" type="submit">Войти</button>
            <p class="muted" style="margin: 6px 0 0;">Нет аккаунта? <a href="{{ route('register') }}" style="color: var(--primary);">Зарегистрироваться</a></p>
        </form>
    </div>
@endsection
