@extends('layouts.admin')

@section('title', 'Create Quiz')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Create New Quiz</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.quizzes.store') }}" method="POST" id="quizForm">
                @csrf
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Quiz Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                            value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Number of Questions</label>
                        <input type="number" name="number_of_questions" min="1" 
                            class="form-control @error('number_of_questions') is-invalid @enderror" 
                            value="{{ old('number_of_questions', 1) }}" required>
                        @error('number_of_questions')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Duration (minutes)</label>
                        <input type="number" name="duration" min="1" 
                            class="form-control @error('duration') is-invalid @enderror" 
                            value="{{ old('duration', 30) }}" required>
                        @error('duration')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Passing Score (%)</label>
                        <input type="number" name="passing_score" min="0" max="100" 
                            class="form-control @error('passing_score') is-invalid @enderror" 
                            value="{{ old('passing_score', 60) }}" required>
                        @error('passing_score')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_published" class="form-check-input" 
                            value="1" {{ old('is_published') ? 'checked' : '' }}>
                        <label class="form-check-label">Publish Quiz Immediately</label>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Quiz and Add Questions</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addQuestionBtn = document.getElementById('addQuestionBtn');
    const questionsContainer = document.getElementById('questionsContainer');
    let questionCount = 0;

    addQuestionBtn.addEventListener('click', function() {
        const questionHtml = `
            <div class="question-block border rounded p-3 mb-3">
                <div class="mb-3">
                    <label class="form-label">Question ${questionCount + 1}</label>
                    <input type="text" class="form-control" name="questions[${questionCount}][text]" required>
                </div>
                
                <div class="options-container">
                    <div class="mb-2">
                        <div class="input-group">
                            <div class="input-group-text">
                                <input type="radio" name="questions[${questionCount}][correct_answer]" value="0" required>
                            </div>
                            <input type="text" class="form-control" name="questions[${questionCount}][options][]" 
                                placeholder="Option 1" required>
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="input-group">
                            <div class="input-group-text">
                                <input type="radio" name="questions[${questionCount}][correct_answer]" value="1">
                            </div>
                            <input type="text" class="form-control" name="questions[${questionCount}][options][]" 
                                placeholder="Option 2" required>
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="input-group">
                            <div class="input-group-text">
                                <input type="radio" name="questions[${questionCount}][correct_answer]" value="2">
                            </div>
                            <input type="text" class="form-control" name="questions[${questionCount}][options][]" 
                                placeholder="Option 3" required>
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="input-group">
                            <div class="input-group-text">
                                <input type="radio" name="questions[${questionCount}][correct_answer]" value="3">
                            </div>
                            <input type="text" class="form-control" name="questions[${questionCount}][options][]" 
                                placeholder="Option 4" required>
                        </div>
                    </div>
                </div>
                
                <button type="button" class="btn btn-danger btn-sm mt-2 remove-question">Remove Question</button>
            </div>
        `;

        const tempContainer = document.createElement('div');
        tempContainer.innerHTML = questionHtml;
        const questionBlock = tempContainer.firstElementChild;

        questionBlock.querySelector('.remove-question').addEventListener('click', function() {
            questionBlock.remove();
            updateQuestionNumbers();
        });

        questionsContainer.appendChild(questionBlock);
        questionCount++;
        updateQuestionNumbers();
    });

    function updateQuestionNumbers() {
        const questions = questionsContainer.querySelectorAll('.question-block');
        questions.forEach((question, index) => {
            const label = question.querySelector('.form-label');
            label.textContent = `Question ${index + 1}`;
        });
    }
});
</script>
@endsection
