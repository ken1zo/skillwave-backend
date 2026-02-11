<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class MyCourseController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $courses = $user->courses()->withCount('lessons')->get();

        return response()->json([
            'data' => $courses,
        ]);
    }

    public function lessons(Request $request, Course $course)
    {
        $user = $request->user();

        $hasEnrollment = $user->enrollments()
            ->where('course_id', $course->id)
            ->exists();

        if (!$hasEnrollment) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $lessons = $course->lessons()->orderBy('position')->get();

        return response()->json([
            'data' => $lessons,
        ]);
    }
}
