@extends('admin.layout')

@section('title', $lesson->exists ? 'Edit Lesson' : 'New Lesson')

@section('content')
    <div class="card">
        <form method="POST"
              action="{{ $lesson->exists ? route('admin.lessons.update', [$course, $lesson]) : route('admin.lessons.store', $course) }}">
            @csrf
            @if ($lesson->exists)
                @method('PUT')
            @endif

            <div class="field">
                <label>Title</label>
                <input type="text" name="title" value="{{ old('title', $lesson->title) }}" required>
            </div>
            <div class="field">
                <label>Content</label>
                <textarea name="content" rows="5">{{ old('content', $lesson->content) }}</textarea>
            </div>
            <div class="field">
                <label>Position</label>
                <input type="number" name="position" value="{{ old('position', $lesson->position) }}">
            </div>
            <button class="btn" type="submit">Save</button>
        </form>
    </div>
@endsection
