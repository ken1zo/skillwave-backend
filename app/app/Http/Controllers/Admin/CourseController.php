<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::withCount('lessons')->paginate(5);

        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.form', [
            'course' => new Course(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);
        unset($data['image']);

        $course = Course::create($data);

        if ($request->hasFile('image')) {
            $course->image_path = $this->storeImage($request->file('image'));
            $course->save();
        }

        return redirect()->route('admin.courses.index');
    }

    public function edit(Course $course)
    {
        return view('admin.courses.form', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);
        unset($data['image']);

        $course->fill($data)->save();

        if ($request->hasFile('image')) {
            $course->image_path = $this->storeImage($request->file('image'), $course->image_path);
            $course->save();
        }

        return redirect()->route('admin.courses.index');
    }

    public function destroy(Course $course)
    {
        if ($course->lessons()->exists()) {
            return back()->withErrors(['course' => 'Cannot delete a course that has lessons.']);
        }

        if ($course->image_path) {
            Storage::disk('public')->delete($course->image_path);
        }

        $course->delete();

        return redirect()->route('admin.courses.index');
    }

    private function storeImage(UploadedFile $file, ?string $existingPath = null): string
    {
        if ($existingPath) {
            Storage::disk('public')->delete($existingPath);
        }

        Storage::disk('public')->makeDirectory('courses');

        $filename = 'cw_'.Str::uuid().'.'.$file->getClientOriginalExtension();
        $path = storage_path('app/public/courses/'.$filename);

        $manager = new ImageManager(new Driver());
        $image = $manager->read($file->getPathname())->cover(400, 400);
        $image->save($path);

        return 'courses/'.$filename;
    }
}
