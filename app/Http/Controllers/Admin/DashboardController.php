<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Student;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalQuizzes = Quiz::count();
        $publishedQuizzes = Quiz::where('is_published', true)->count();
        $totalStudents = Student::count();
        
        $recentQuizzes = Quiz::withCount('questions')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalQuizzes',
            'publishedQuizzes',
            'totalStudents',
            'recentQuizzes'
        ));
    }
}
