<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Student\QuizController as StudentQuizController;
use App\Http\Controllers\Student\ResultController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Student\AuthController as StudentAuthController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\AttemptController;

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    });

    // Protected routes
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Quiz routes with nested question routes
        Route::resource('quizzes', QuizController::class);
        Route::resource('quizzes.questions', QuestionController::class)->except(['index']);
        
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});

// Student Routes
Route::middleware(['auth:student'])->name('student.')->prefix('student')->group(function () {
    Route::get('dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    
    // Quiz routes
    Route::prefix('quizzes')->name('quizzes.')->group(function () {
        Route::get('/', [StudentQuizController::class, 'index'])->name('index');
        Route::get('/{quiz}', [StudentQuizController::class, 'show'])->name('show');
        Route::get('/{quiz}/start', [StudentQuizController::class, 'start'])->name('start');
        Route::get('/{quiz}/review', [StudentQuizController::class, 'review'])->name('review');
    });
    
    // Attempt routes
    Route::prefix('attempts')->name('attempts.')->group(function () {
        Route::get('/{attempt}', [AttemptController::class, 'show'])->name('show');
        Route::post('/{attempt}/submit', [AttemptController::class, 'submit'])->name('submit');
    });
    
    Route::post('/logout', [StudentAuthController::class, 'logout'])->name('logout');
});

// Guest routes
Route::middleware('guest:student')->group(function () {
    Route::get('/student/login', [StudentAuthController::class, 'showLoginForm'])->name('student.login');
    Route::post('/student/login', [StudentAuthController::class, 'login'])->name('student.login.submit');
    Route::get('/student/register', [StudentAuthController::class, 'showRegistrationForm'])->name('student.register');
    Route::post('/student/register', [StudentAuthController::class, 'register'])->name('student.register.submit');
});

// Redirect root to student login
Route::get('/', function () {
    return redirect()->route('student.login');
});
