<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::withCount('lessons')
            ->having('lessons_count', '>', 0)
            ->get();

        return response()->json([
            'data' => $courses,
        ]);
    }

    public function buy(Request $request, Course $course)
    {
        $user = $request->user();

        $already = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->exists();

        if ($already) {
            return response()->json(['message' => 'Course already purchased.'], 409);
        }

        $enrollment = Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'purchased_at' => now(),
        ]);

        return response()->json([
            'message' => 'Course purchased.',
            'data' => $enrollment,
        ], 201);
    }
}
