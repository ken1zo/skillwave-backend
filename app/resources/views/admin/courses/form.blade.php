@extends('admin.layout')

@section('title', $course->exists ? 'Edit Course' : 'New Course')

@section('content')
    <div class="card">
        <form method="POST" enctype="multipart/form-data"
              action="{{ $course->exists ? route('admin.courses.update', $course) : route('admin.courses.store') }}">
            @csrf
            @if ($course->exists)
                @method('PUT')
            @endif

            <div class="field">
                <label>Title</label>
                <input type="text" name="title" value="{{ old('title', $course->title) }}" required>
            </div>
            <div class="field">
                <label>Description</label>
                <textarea name="description" rows="4">{{ old('description', $course->description) }}</textarea>
            </div>
            <div class="field">
                <label>Price</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $course->price) }}">
            </div>
            <div class="field">
                <label>Image</label>
                <input type="file" name="image" accept="image/*">
                @if ($course->image_path)
                    <div style="margin-top:8px;">
                        <img src="{{ asset('storage/'.$course->image_path) }}" width="80" height="80" alt="">
                    </div>
                @endif
            </div>
            <button class="btn" type="submit">Save</button>
        </form>
    </div>
@endsection
