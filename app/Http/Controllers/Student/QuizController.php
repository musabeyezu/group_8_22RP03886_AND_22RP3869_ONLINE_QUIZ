<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Attempt;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function index()
    {
        $availableQuizzes = Quiz::where('end_time', '>', now())
            ->orderBy('start_time')
            ->paginate(10);
        return view('student.quizzes.index', compact('availableQuizzes'));
    }

    public function show(Quiz $quiz)
    {
        if (!$quiz->isAvailable()) {
            return redirect()->route('student.quizzes.index')
                ->with('error', 'This quiz is not available.');
        }

        $attempt = Attempt::where('student_id', Auth::id())
            ->where('quiz_id', $quiz->id)
            ->latest()
            ->first();

        if ($attempt && $attempt->result) {
            return redirect()->route('student.quizzes.review', $quiz)
                ->with('info', 'You have already completed this quiz. Here are your results.');
        }

        return view('student.quizzes.show', compact('quiz'));
    }

    public function start(Quiz $quiz)
    {
        if (!$quiz->isAvailable()) {
            return redirect()->route('student.quizzes.index')
                ->with('error', 'This quiz is not available.');
        }

        $attempt = Attempt::where('student_id', Auth::id())
            ->where('quiz_id', $quiz->id)
            ->latest()
            ->first();

        if ($attempt && $attempt->result) {
            return redirect()->route('student.quizzes.review', $quiz)
                ->with('info', 'You have already completed this quiz. Here are your results.');
        }

        $existingAttempt = Attempt::where('student_id', Auth::id())
            ->where('quiz_id', $quiz->id)
            ->first();

        if ($existingAttempt) {
            return redirect()->route('student.attempts.show', $existingAttempt);
        }

        $attempt = Attempt::create([
            'student_id' => Auth::id(),
            'quiz_id' => $quiz->id,
            'start_time' => now(),
            'end_time' => now()->addMinutes($quiz->time_limit),
        ]);

        return redirect()->route('student.attempts.show', $attempt);
    }

    public function review(Quiz $quiz)
    {
        $attempt = Attempt::with(['result', 'quiz.questions', 'studentAnswers'])
            ->where('student_id', Auth::id())
            ->where('quiz_id', $quiz->id)
            ->latest()
            ->firstOrFail();

        if (!$attempt->result) {
            return redirect()->route('student.quizzes.index')
                ->with('error', 'Quiz result not available yet.');
        }

        return view('student.quizzes.review', [
            'attempt' => $attempt,
            'quiz' => $quiz,
        ]);
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
            'answers.*' => 'required|exists:answers,id',
        ]);

        foreach ($validated['answers'] as $questionId => $answerId) {
            $attempt->studentAnswers()->create([
                'question_id' => $questionId,
                'answer_id' => $answerId,
            ]);
        }

        $correctAnswers = $attempt->studentAnswers()
            ->whereHas('answer', function ($query) {
                $query->where('is_correct', true);
            })
            ->count();

        $result = Result::create([
            'attempt_id' => $attempt->id,
            'marks_obtained' => $correctAnswers,
            'total_marks' => $attempt->quiz->total_marks,
        ]);

        return redirect()->route('student.quizzes.review', $attempt->quiz)
            ->with('success', 'Quiz submitted successfully!');
    }
}
