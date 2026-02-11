@extends('site.layout')

@section('title', 'SkillWave - Профиль')

@section('content')
    <h1 class="title">Мои курсы</h1>
    <p class="muted" style="margin: 0 0 20px;">{{ auth()->user()->name }} ({{ auth()->user()->email }})</p>

    <div class="card-grid">
        @forelse ($enrollments as $enrollment)
            <article class="course-card">
                @if ($enrollment->course->image_path)
                    <img src="{{ asset('storage/'.$enrollment->course->image_path) }}" alt="{{ $enrollment->course->title }}">
                @else
                    <div class="course-card__placeholder"></div>
                @endif

                <h3>{{ $enrollment->course->title }}</h3>
                <div class="muted">Покупка: {{ optional($enrollment->purchased_at)->format('d.m.Y H:i') ?? '—' }}</div>

                <details open>
                    <summary>Уроки курса</summary>
                    <ul>
                        @forelse ($enrollment->course->lessons as $lesson)
                            <li>{{ $lesson->title }}</li>
                        @empty
                            <li>Уроков пока нет.</li>
                        @endforelse
                    </ul>
                </details>
            </article>
        @empty
            <div class="panel">Вы пока не купили ни одного курса.</div>
        @endforelse
    </div>
@endsection
