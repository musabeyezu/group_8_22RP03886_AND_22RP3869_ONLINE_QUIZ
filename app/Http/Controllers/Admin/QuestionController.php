<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    public function create(Quiz $quiz)
    {
        return view('admin.questions.create', compact('quiz'));
    }

    public function store(Request $request, Quiz $quiz)
    {
        $request->validate([
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.option_a' => 'required|string',
            'questions.*.option_b' => 'required|string',
            'questions.*.option_c' => 'required|string',
            'questions.*.option_d' => 'required|string',
            'questions.*.correct_answer' => 'required|in:a,b,c,d',
            'questions.*.marks' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Check if we're not exceeding the number of questions
            $currentCount = $quiz->questions()->count();
            $newCount = count($request->questions);
            
            if ($currentCount + $newCount > $quiz->number_of_questions) {
                return back()->with('error', 'Cannot add more questions than specified in the quiz settings.');
            }

            // Create questions
            foreach ($request->questions as $questionData) {
                $quiz->questions()->create([
                    'question' => $questionData['question'],
                    'option_a' => $questionData['option_a'],
                    'option_b' => $questionData['option_b'],
                    'option_c' => $questionData['option_c'],
                    'option_d' => $questionData['option_d'],
                    'correct_answer' => $questionData['correct_answer'],
                    'marks' => $questionData['marks'],
                ]);
            }

            DB::commit();

            // Check if we need more questions
            $remainingQuestions = $quiz->number_of_questions - ($currentCount + $newCount);
            
            if ($remainingQuestions > 0) {
                return redirect()->route('admin.quizzes.questions.create', $quiz)
                    ->with('success', "Questions added successfully! Please add {$remainingQuestions} more questions.");
            }

            return redirect()->route('admin.quizzes.show', $quiz)
                ->with('success', 'All questions have been added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to add questions. Please try again.');
        }
    }

    public function edit(Quiz $quiz, Question $question)
    {
        return view('admin.questions.edit', compact('quiz', 'question'));
    }

    public function update(Request $request, Quiz $quiz, Question $question)
    {
        $request->validate([
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:a,b,c,d',
            'marks' => 'required|integer|min:1',
        ]);

        try {
            $question->update($request->all());
            return redirect()->route('admin.quizzes.show', $quiz)
                ->with('success', 'Question updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update question. Please try again.');
        }
    }

    public function destroy(Quiz $quiz, Question $question)
    {
        try {
            $question->delete();
            return redirect()->route('admin.quizzes.show', $quiz)
                ->with('success', 'Question deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete question. Please try again.');
        }
    }
}
