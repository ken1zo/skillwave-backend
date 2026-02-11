@extends('site.layout')

@section('title', 'SkillWave - Регистрация')

@section('content')
    <div class="panel">
        <h1 class="title" style="font-size: 28px;">Регистрация</h1>
        <form class="form" action="{{ route('register.submit') }}" method="POST">
            @csrf
            <div class="field">
                <label for="first_name">Имя</label>
                <input id="first_name" name="first_name" type="text" value="{{ old('first_name') }}" required>
            </div>
            <div class="field">
                <label for="last_name">Фамилия</label>
                <input id="last_name" name="last_name" type="text" value="{{ old('last_name') }}" minlength="2" maxlength="100" required>
            </div>
            <div class="field">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required>
            </div>
            <div class="field">
                <label for="password">Пароль</label>
                <input id="password" name="password" type="password" required>
            </div>
            <div class="field">
                <label for="password_confirmation">Повторите пароль</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required>
            </div>
            <button class="btn btn-primary" type="submit">Создать аккаунт</button>
            <p class="muted" style="margin: 6px 0 0;">Уже есть аккаунт? <a href="{{ route('login') }}" style="color: var(--primary);">Войти</a></p>
        </form>
    </div>
@endsection
