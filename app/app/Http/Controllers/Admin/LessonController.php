<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index(Course $course)
    {
        $lessons = $course->lessons()->orderBy('position')->get();

        return view('admin.lessons.index', compact('course', 'lessons'));
    }

    public function create(Course $course)
    {
        return view('admin.lessons.form', [
            'course' => $course,
            'lesson' => new Lesson(),
        ]);
    }

    public function store(Request $request, Course $course)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'position' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['course_id'] = $course->id;

        Lesson::create($data);

        return redirect()->route('admin.lessons.index', $course);
    }

    public function edit(Course $course, Lesson $lesson)
    {
        if ($lesson->course_id !== $course->id) {
            abort(404);
        }

        return view('admin.lessons.form', compact('course', 'lesson'));
    }

    public function update(Request $request, Course $course, Lesson $lesson)
    {
        if ($lesson->course_id !== $course->id) {
            abort(404);
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'position' => ['nullable', 'integer', 'min:0'],
        ]);

        $lesson->update($data);

        return redirect()->route('admin.lessons.index', $course);
    }

    public function destroy(Course $course, Lesson $lesson)
    {
        if ($lesson->course_id !== $course->id) {
            abort(404);
        }

        if ($course->enrollments()->exists()) {
            return back()->withErrors(['lesson' => 'Cannot delete a lesson for a purchased course.']);
        }

        $lesson->delete();

        return redirect()->route('admin.lessons.index', $course);
    }
}
