<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\EnrollmentController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\MockCertificateController;
use App\Http\Controllers\Web\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/catalog', [SiteController::class, 'catalog'])->name('catalog');

Route::middleware('guest')->group(function () {
    Route::get('/login', [SiteController::class, 'showLogin'])->name('login');
    Route::post('/login', [SiteController::class, 'login'])->name('login.submit');
    Route::get('/register', [SiteController::class, 'showRegister'])->name('register');
    Route::post('/register', [SiteController::class, 'register'])->name('register.submit');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [SiteController::class, 'logout'])->name('logout');
    Route::post('/courses/{course}/buy', [SiteController::class, 'buy'])->name('courses.buy');
    Route::get('/profile', [SiteController::class, 'profile'])->name('profile');
});

Route::post('/get-series', [MockCertificateController::class, 'getSeries']);

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::middleware(['admin.auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', function () {
            return redirect()->route('admin.courses.index');
        })->name('home');

        Route::resource('courses', CourseController::class)->except(['show']);

        Route::get('courses/{course}/lessons', [LessonController::class, 'index'])->name('lessons.index');
        Route::get('courses/{course}/lessons/create', [LessonController::class, 'create'])->name('lessons.create');
        Route::post('courses/{course}/lessons', [LessonController::class, 'store'])->name('lessons.store');
        Route::get('courses/{course}/lessons/{lesson}/edit', [LessonController::class, 'edit'])->name('lessons.edit');
        Route::put('courses/{course}/lessons/{lesson}', [LessonController::class, 'update'])->name('lessons.update');
        Route::delete('courses/{course}/lessons/{lesson}', [LessonController::class, 'destroy'])->name('lessons.destroy');

        Route::get('enrollments', [EnrollmentController::class, 'index'])->name('enrollments.index');
        Route::post('enrollments/{enrollment}/certificate', [EnrollmentController::class, 'generate'])->name('enrollments.certificate');
    });
