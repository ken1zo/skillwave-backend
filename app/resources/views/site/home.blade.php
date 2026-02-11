@extends('site.layout')

@section('title', 'SkillWave - Главная')

@section('content')
    <h1 class="title">Курсы SkillWave</h1>
    <p class="muted" style="margin: 0 0 20px;">Каждый курс доступен прямо здесь: карточка, описание и список уроков на одной странице.</p>

    <div class="card-grid">
        @forelse ($courses as $course)
            @include('site.partials.course-card', ['course' => $course, 'ownedCourseIds' => $ownedCourseIds])
        @empty
            <div class="panel">Курсов пока нет. Добавьте их в админке.</div>
        @endforelse
    </div>
@endsection
