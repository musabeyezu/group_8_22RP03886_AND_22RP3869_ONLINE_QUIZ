<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Attempt;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;
use stdClass;

class DashboardController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();
        
        // Get total available quizzes
        $totalQuizzes = Quiz::count();
        
        // Get completed quizzes
        $completedQuizzes = Attempt::where('student_id', $student->id)
            ->distinct('quiz_id')
            ->count();
        
        // Calculate average score
        $averageScore = Result::where('student_id', $student->id)
            ->avg('score');
        $averageScore = $averageScore ? round($averageScore) . '%' : '0%';
        
        // Calculate total time spent
        $timeSpent = Attempt::where('student_id', $student->id)
            ->sum('duration');
        $timeSpent = $timeSpent ? round($timeSpent / 60, 1) . 'h' : '0h';
        
        // Get available quizzes with attempt status
        $quizzes = Quiz::select('quizzes.*')
            ->selectRaw('COUNT(attempts.id) > 0 as attempted')
            ->leftJoin('attempts', function($join) use ($student) {
                $join->on('quizzes.id', '=', 'attempts.quiz_id')
                    ->where('attempts.student_id', '=', $student->id);
            })
            ->groupBy('quizzes.id')
            ->orderBy('quizzes.created_at', 'desc')
            ->get();
        
        // Get recent activity
        $recentActivity = collect();
        
        // Add quiz attempts to activity
        $attempts = Attempt::with('quiz')
            ->where('student_id', $student->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        foreach ($attempts as $attempt) {
            $activity = new stdClass();
            $activity->title = 'Attempted Quiz';
            $activity->description = "You attempted {$attempt->quiz->name}";
            $activity->created_at = $attempt->created_at;
            $recentActivity->push($activity);
        }
        
        // Add quiz results to activity
        $results = Result::with('quiz')
            ->where('student_id', $student->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        foreach ($results as $result) {
            $activity = new stdClass();
            $activity->title = 'Quiz Result';
            $activity->description = "You scored {$result->score}% in {$result->quiz->name}";
            $activity->created_at = $result->created_at;
            $recentActivity->push($activity);
        }
        
        // Sort activity by date and limit to 5 items
        $recentActivity = $recentActivity
            ->sortByDesc('created_at')
            ->take(5)
            ->values();

        return view('student.dashboard', compact(
            'totalQuizzes',
            'completedQuizzes',
            'averageScore',
            'timeSpent',
            'quizzes',
            'recentActivity'
        ));
    }
}
