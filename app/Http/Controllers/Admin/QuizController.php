<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::withCount('questions')->latest()->paginate(10);
        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        return view('admin.quizzes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'number_of_questions' => 'required|integer|min:1',
            'duration' => 'required|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
            'is_published' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            $quiz = Quiz::create([
                'name' => $request->name,
                'number_of_questions' => $request->number_of_questions,
                'duration' => $request->duration,
                'passing_score' => $request->passing_score,
                'is_published' => $request->boolean('is_published', false),
            ]);

            DB::commit();

            return redirect()->route('admin.quizzes.questions.create', $quiz)
                ->with('success', 'Quiz created successfully. Now add your questions.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create quiz. Please try again.');
        }
    }

    public function show(Quiz $quiz)
    {
        $quiz->load('questions');
        return view('admin.quizzes.show', compact('quiz'));
    }

    public function edit(Quiz $quiz)
    {
        return view('admin.quizzes.edit', compact('quiz'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'number_of_questions' => 'required|integer|min:1',
            'duration' => 'required|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
            'is_published' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            // Check if we can reduce the number of questions
            if ($request->number_of_questions < $quiz->number_of_questions && 
                $quiz->questions()->count() > $request->number_of_questions) {
                return back()->with('error', 'Cannot reduce number of questions as there are already more questions added.');
            }

            $quiz->update([
                'name' => $request->name,
                'number_of_questions' => $request->number_of_questions,
                'duration' => $request->duration,
                'passing_score' => $request->passing_score,
                'is_published' => $request->boolean('is_published', false),
            ]);

            DB::commit();
            return redirect()->route('admin.quizzes.index')
                ->with('success', 'Quiz updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update quiz. Please try again.');
        }
    }

    public function destroy(Quiz $quiz)
    {
        try {
            $quiz->delete();
            return redirect()->route('admin.quizzes.index')
                ->with('success', 'Quiz deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete quiz. Please try again.');
        }
    }
}
