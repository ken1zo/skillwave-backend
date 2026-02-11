<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function home(): View
    {
        $courses = Course::with('lessons')
            ->latest()
            ->take(6)
            ->get();

        return view('site.home', [
            'courses' => $courses,
            'ownedCourseIds' => $this->ownedCourseIds(),
        ]);
    }

    public function catalog(): View
    {
        $courses = Course::with('lessons')
            ->latest()
            ->paginate(12);

        return view('site.catalog', [
            'courses' => $courses,
            'ownedCourseIds' => $this->ownedCourseIds(),
        ]);
    }

    public function profile(Request $request): View
    {
        $enrollments = Enrollment::with(['course.lessons'])
            ->where('user_id', $request->user()->id)
            ->latest('purchased_at')
            ->get();

        return view('site.profile', [
            'enrollments' => $enrollments,
        ]);
    }

    public function showLogin(): View
    {
        return view('site.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($credentials, true)) {
            return back()->withErrors(['email' => 'Неверный email или пароль.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        if ($request->user()?->is_admin) {
            return redirect()->route('admin.home');
        }

        return redirect()->route('profile');
    }

    public function showRegister(): View
    {
        return view('site.auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'name' => trim($data['first_name'].' '.$data['last_name']),
            'email' => $data['email'],
            'password' => $data['password'],
            'is_admin' => false,
        ]);

        Auth::login($user, true);
        $request->session()->regenerate();

        return redirect()->route('profile');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function buy(Request $request, Course $course): RedirectResponse
    {
        $exists = Enrollment::where('user_id', $request->user()->id)
            ->where('course_id', $course->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['course' => 'Этот курс уже куплен.']);
        }

        if (!$course->lessons()->exists()) {
            return back()->withErrors(['course' => 'Курс пока недоступен к покупке.']);
        }

        Enrollment::create([
            'user_id' => $request->user()->id,
            'course_id' => $course->id,
            'purchased_at' => now(),
        ]);

        return redirect()->route('profile')->with('status', 'Курс успешно добавлен в ваш профиль.');
    }

    private function ownedCourseIds(): array
    {
        $userId = Auth::id();

        if (!$userId) {
            return [];
        }

        return Enrollment::where('user_id', $userId)
            ->pluck('course_id')
            ->all();
    }
}
