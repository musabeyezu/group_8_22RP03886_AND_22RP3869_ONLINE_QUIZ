<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    public function index()
    {
        $results = Result::whereHas('attempt', function ($query) {
            $query->where('student_id', Auth::id());
        })->with(['attempt.quiz'])->latest()->paginate(10);

        return view('student.results.index', compact('results'));
    }

    public function show(Result $result)
    {
        if ($result->attempt->student_id !== Auth::id()) {
            abort(403);
        }

        $result->load(['attempt.quiz', 'attempt.studentAnswers.question', 'attempt.studentAnswers.answer']);
        return view('student.results.show', compact('result'));
    }
}
