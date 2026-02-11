@extends('admin.layout')

@section('title', 'Enrollments')

@section('content')
    <div class="card">
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Course</th>
                <th>Purchased</th>
                <th>Certificate</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($enrollments as $enrollment)
                <tr>
                    <td>{{ $enrollment->id }}</td>
                    <td>{{ $enrollment->user->email }}</td>
                    <td>{{ $enrollment->course->title }}</td>
                    <td>{{ optional($enrollment->purchased_at)->format('Y-m-d H:i') }}</td>
                    <td>{{ $enrollment->certificate_number ?? '—' }}</td>
                    <td class="actions">
                        @if (!$enrollment->certificate_number)
                            <form method="POST" action="{{ route('admin.enrollments.certificate', $enrollment) }}">
                                @csrf
                                <button class="btn" type="submit">Generate</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
