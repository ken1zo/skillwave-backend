@extends('site.layout')

@section('title', 'SkillWave - Каталог')

@section('content')
    <h1 class="title">Каталог курсов</h1>

    <div class="card-grid" style="margin-bottom: 20px;">
        @forelse ($courses as $course)
            @include('site.partials.course-card', ['course' => $course, 'ownedCourseIds' => $ownedCourseIds])
        @empty
            <div class="panel">Курсы не найдены.</div>
        @endforelse
    </div>

    <div class="panel">
        {{ $courses->links() }}
    </div>
@endsection
