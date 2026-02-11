@extends('admin.layout')

@section('title', 'Lessons')

@section('content')
    <div class="card">
        <div style="margin-bottom: 12px;">
            <a class="btn secondary" href="{{ route('admin.courses.index') }}">Back</a>
            <a class="btn" href="{{ route('admin.lessons.create', $course) }}">New Lesson</a>
        </div>
        <h3>Course: {{ $course->title }}</h3>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Position</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($lessons as $lesson)
                <tr>
                    <td>{{ $lesson->id }}</td>
                    <td>{{ $lesson->title }}</td>
                    <td>{{ $lesson->position }}</td>
                    <td class="actions">
                        <a class="btn secondary" href="{{ route('admin.lessons.edit', [$course, $lesson]) }}">Edit</a>
                        <form action="{{ route('admin.lessons.destroy', [$course, $lesson]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
