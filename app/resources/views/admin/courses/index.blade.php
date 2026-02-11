@extends('admin.layout')

@section('title', 'Courses')

@section('content')
    <div class="card">
        <div class="actions" style="margin-bottom: 12px;">
            <a class="btn" href="{{ route('admin.courses.create') }}">New Course</a>
        </div>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Lessons</th>
                <th>Price</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($courses as $course)
                <tr>
                    <td>{{ $course->id }}</td>
                    <td>{{ $course->title }}</td>
                    <td>{{ $course->lessons_count }}</td>
                    <td>{{ $course->price }}</td>
                    <td>
                        @if ($course->image_path)
                            <img src="{{ asset('storage/'.$course->image_path) }}" width="48" height="48" alt="">
                        @endif
                    </td>
                    <td class="actions">
                        <a class="btn secondary" href="{{ route('admin.courses.edit', $course) }}">Edit</a>
                        <a class="btn secondary" href="{{ route('admin.lessons.index', $course) }}">Lessons</a>
                        <form action="{{ route('admin.courses.destroy', $course) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div style="margin-top: 12px;">
            {{ $courses->links() }}
        </div>
    </div>
@endsection
