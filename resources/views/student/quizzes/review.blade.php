@extends('layouts.app')

@section('title', 'Review Quiz: ' . $quiz->name)

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-eye text-primary me-2"></i>Quiz Review: {{ $quiz->name }}
                        </h5>
                        @if($attempt->result)
                        <div class="quiz-score">
                            <span class="badge bg-{{ $attempt->result->score >= $quiz->passing_score ? 'success' : 'danger' }} fs-6">
                                Score: {{ number_format($attempt->result->score, 1) }}%
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="quiz-summary mb-4">
                        <div class="row g-3">
                            <div class="col-sm-4">
                                <div class="d-flex align-items-center">
                                    <div class="info-icon me-2">
                                        <i class="fas fa-clock text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Time Taken</small>
                                        <strong>{{ $attempt->duration }} minutes</strong>
                                    </div>
                                </div>
                            </div>
                            @if($attempt->result)
                            <div class="col-sm-4">
                                <div class="d-flex align-items-center">
                                    <div class="info-icon me-2">
                                        <i class="fas fa-check text-success"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Correct Answers</small>
                                        <strong>{{ $attempt->result->correct_answers }} / {{ $attempt->result->total_questions }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="d-flex align-items-center">
                                    <div class="info-icon me-2">
                                        <i class="fas fa-trophy text-warning"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Pass Status</small>
                                        <strong class="text-{{ $attempt->result->score >= $quiz->passing_score ? 'success' : 'danger' }}">
                                            {{ $attempt->result->score >= $quiz->passing_score ? 'Passed' : 'Failed' }}
                                        </strong>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="questions-review">
                        @foreach($quiz->questions as $index => $question)
                            @php
                                $studentAnswer = $attempt->studentAnswers->where('question_id', $question->id)->first();
                                $isCorrect = $studentAnswer && $studentAnswer->answer === $question->answer;
                            @endphp
                            <div class="question-card mb-4 p-4 border rounded {{ $isCorrect ? 'border-success' : 'border-danger' }}">
                                <div class="question-header d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h6 class="fw-bold mb-0">Question {{ $index + 1 }}</h6>
                                        <p class="text-muted small mb-0">{{ $question->marks }} marks</p>
                                    </div>
                                    @if($attempt->result)
                                    <span class="badge bg-{{ $isCorrect ? 'success' : 'danger' }}">
                                        {{ $isCorrect ? 'Correct' : 'Incorrect' }}
                                    </span>
                                    @endif
                                </div>
                                
                                <div class="question-content">
                                    <p class="mb-3">{{ $question->question }}</p>
                                    
                                    <div class="options-list">
                                        @foreach(['a', 'b', 'c', 'd'] as $option)
                                            <div class="form-check custom-option mb-2 
                                                {{ $question->answer === $option ? 'correct-answer' : '' }}
                                                {{ $studentAnswer && $studentAnswer->answer === $option ? 'selected-answer' : '' }}">
                                                <input type="radio" 
                                                       class="form-check-input"
                                                       disabled
                                                       {{ $studentAnswer && $studentAnswer->answer === $option ? 'checked' : '' }}>
                                                <label class="form-check-label w-100">
                                                    <span class="option-letter">{{ strtoupper($option) }}</span>
                                                    {{ $question->{"option_$option"} }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>

                                    @if($attempt->result && !$isCorrect)
                                        <div class="explanation mt-3 p-3 bg-light rounded">
                                            <p class="mb-0">
                                                <i class="fas fa-info-circle text-primary me-2"></i>
                                                <strong>Correct Answer:</strong> 
                                                Option {{ strtoupper($question->answer) }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-center">
                        <a href="{{ route('student.quizzes.index') }}" class="btn btn-primary px-4">
                            <i class="fas fa-list me-2"></i>Back to Quizzes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.info-icon {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(var(--bs-primary-rgb), 0.1);
    border-radius: 8px;
}

.question-card {
    background-color: #fff;
    transition: transform 0.2s;
}

.question-card:hover {
    transform: translateY(-2px);
}

.custom-option {
    border: 1px solid rgba(0,0,0,0.1);
    border-radius: 8px;
    padding: 0.75rem;
    position: relative;
    transition: all 0.2s;
}

.custom-option.correct-answer {
    background-color: rgba(var(--bs-success-rgb), 0.1);
    border-color: var(--bs-success);
}

.custom-option.selected-answer {
    background-color: rgba(var(--bs-primary-rgb), 0.1);
    border-color: var(--bs-primary);
}

.custom-option.selected-answer:not(.correct-answer) {
    background-color: rgba(var(--bs-danger-rgb), 0.1);
    border-color: var(--bs-danger);
}

.option-letter {
    display: inline-block;
    width: 24px;
    height: 24px;
    line-height: 24px;
    text-align: center;
    border-radius: 50%;
    background-color: rgba(var(--bs-primary-rgb), 0.1);
    color: var(--bs-primary);
    margin-right: 0.5rem;
    font-weight: 600;
}

.correct-answer .option-letter {
    background-color: rgba(var(--bs-success-rgb), 0.1);
    color: var(--bs-success);
}

.selected-answer:not(.correct-answer) .option-letter {
    background-color: rgba(var(--bs-danger-rgb), 0.1);
    color: var(--bs-danger);
}
</style>
@endsection
