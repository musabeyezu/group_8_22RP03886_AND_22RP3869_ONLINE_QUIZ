<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attempt;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttemptController extends Controller
{
    public function show(Attempt $attempt)
    {
        if ($attempt->student_id !== Auth::id()) {
            abort(403);
        }

        // If the attempt has a result, redirect to the result page
        if ($attempt->result) {
            return redirect()->route('student.results.show', $attempt->result);
        }

        // Load the quiz with its questions
        $attempt->load('quiz.questions');

        return view('student.attempts.show', compact('attempt'));
    }

    public function submit(Request $request, Attempt $attempt)
    {
        if ($attempt->student_id !== Auth::id()) {
            abort(403);
        }

        if (now() > $attempt->end_time) {
            return redirect()->route('student.quizzes.index')
                ->with('error', 'Time\'s up! Your answers were automatically submitted.');
        }

        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|in:a,b,c,d',
        ]);

        // Record student answers
        foreach ($validated['answers'] as $questionId => $answer) {
            $attempt->studentAnswers()->create([
                'question_id' => $questionId,
                'answer' => $answer,
            ]);
        }

        // Calculate score
        $totalQuestions = $attempt->quiz->questions()->count();
        $correctAnswers = $attempt->studentAnswers()
            ->whereHas('question', function ($query) {
                $query->whereColumn('answer', 'student_answers.answer');
            })
            ->count();

        $score = ($correctAnswers / $totalQuestions) * 100;

        // Create result
        $result = Result::create([
            'attempt_id' => $attempt->id,
            'student_id' => Auth::id(),
            'quiz_id' => $attempt->quiz_id,
            'score' => $score,
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers,
            'completed_at' => now(),
        ]);

        return redirect()->route('student.results.show', $result)
            ->with('success', 'Quiz submitted successfully!');
    }
}
