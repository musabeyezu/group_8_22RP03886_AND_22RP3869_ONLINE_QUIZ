@extends('layouts.admin')

@section('title', 'Add Questions')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2>Add Questions to: {{ $quiz->name }}</h2>
            <span class="badge bg-primary">{{ $quiz->questions->count() }} / {{ $quiz->number_of_questions }} Questions</span>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.quizzes.questions.store', $quiz) }}" method="POST" id="questionForm">
                @csrf
                
                <div id="questionsContainer">
                    <!-- Questions will be added here dynamically -->
                </div>

                <button type="button" class="btn btn-success mb-4" id="addQuestionBtn" 
                    data-max-questions="{{ $quiz->number_of_questions }}">
                    <i class="fas fa-plus"></i> Add New Question
                </button>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary">Back to Quizzes</a>
                    <button type="submit" class="btn btn-primary">Save Questions</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Question Template -->
<template id="questionTemplate">
    <div class="question-block border rounded p-4 mb-4">
        <div class="d-flex justify-content-between mb-3">
            <h4 class="question-number">Question #</h4>
            <button type="button" class="btn btn-danger btn-sm remove-question">
                <i class="fas fa-trash"></i> Remove
            </button>
        </div>

        <div class="mb-3">
            <label class="form-label">Question Text</label>
            <input type="text" class="form-control" name="questions[INDEX][question]" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Marks</label>
            <input type="number" class="form-control" name="questions[INDEX][marks]" min="1" value="1" required>
        </div>

        <div class="options-container">
            <label class="form-label">Options (Select the correct answer)</label>
            
            <!-- Option A -->
            <div class="mb-2">
                <div class="input-group">
                    <div class="input-group-text">
                        <input type="radio" name="questions[INDEX][correct_answer]" value="a" required>
                    </div>
                    <span class="input-group-text">A</span>
                    <input type="text" class="form-control" name="questions[INDEX][option_a]" required>
                </div>
            </div>

            <!-- Option B -->
            <div class="mb-2">
                <div class="input-group">
                    <div class="input-group-text">
                        <input type="radio" name="questions[INDEX][correct_answer]" value="b">
                    </div>
                    <span class="input-group-text">B</span>
                    <input type="text" class="form-control" name="questions[INDEX][option_b]" required>
                </div>
            </div>

            <!-- Option C -->
            <div class="mb-2">
                <div class="input-group">
                    <div class="input-group-text">
                        <input type="radio" name="questions[INDEX][correct_answer]" value="c">
                    </div>
                    <span class="input-group-text">C</span>
                    <input type="text" class="form-control" name="questions[INDEX][option_c]" required>
                </div>
            </div>

            <!-- Option D -->
            <div class="mb-2">
                <div class="input-group">
                    <div class="input-group-text">
                        <input type="radio" name="questions[INDEX][correct_answer]" value="d">
                    </div>
                    <span class="input-group-text">D</span>
                    <input type="text" class="form-control" name="questions[INDEX][option_d]" required>
                </div>
            </div>
        </div>
    </div>
</template>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addQuestionBtn = document.getElementById('addQuestionBtn');
    const questionsContainer = document.getElementById('questionsContainer');
    const questionTemplate = document.getElementById('questionTemplate');
    const maxQuestions = parseInt(addQuestionBtn.dataset.maxQuestions);
    let questionCount = 0;

    // Add initial question
    addQuestion();

    addQuestionBtn.addEventListener('click', function() {
        if (questionCount < maxQuestions) {
            addQuestion();
        } else {
            alert(`You can only add up to ${maxQuestions} questions for this quiz.`);
        }
    });

    function addQuestion() {
        const questionHtml = questionTemplate.innerHTML
            .replace(/INDEX/g, questionCount);
        
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = questionHtml;
        const questionBlock = tempDiv.firstElementChild;
        
        // Update question number
        questionBlock.querySelector('.question-number').textContent = `Question ${questionCount + 1}`;
        
        // Add remove button functionality
        questionBlock.querySelector('.remove-question').addEventListener('click', function() {
            if (document.querySelectorAll('.question-block').length > 1) {
                questionBlock.remove();
                questionCount--;
                updateQuestionNumbers();
                addQuestionBtn.disabled = false;
            } else {
                alert('You must have at least one question!');
            }
        });

        questionsContainer.appendChild(questionBlock);
        questionCount++;

        // Disable add button if max questions reached
        if (questionCount >= maxQuestions) {
            addQuestionBtn.disabled = true;
        }
    }

    function updateQuestionNumbers() {
        const questions = questionsContainer.querySelectorAll('.question-block');
        questions.forEach((question, index) => {
            question.querySelector('.question-number').textContent = `Question ${index + 1}`;
        });
    }

    // Form validation
    document.getElementById('questionForm').addEventListener('submit', function(e) {
        const questions = questionsContainer.querySelectorAll('.question-block');
        let valid = true;

        questions.forEach((question, index) => {
            // Check if a correct answer is selected
            const correctAnswer = question.querySelector('input[type="radio"]:checked');
            if (!correctAnswer) {
                alert(`Please select the correct answer for Question ${index + 1}`);
                valid = false;
            }

            // Check if all options are filled
            const options = question.querySelectorAll('input[type="text"]');
            options.forEach((option) => {
                if (!option.value.trim()) {
                    alert(`Please fill in all options for Question ${index + 1}`);
                    valid = false;
                }
            });

            // Check if marks are valid
            const marks = question.querySelector('input[name$="[marks]"]');
            if (!marks.value || marks.value < 1) {
                alert(`Please enter valid marks for Question ${index + 1}`);
                valid = false;
            }
        });

        if (!valid) {
            e.preventDefault();
        }
    });
});
</script>
@endsection
