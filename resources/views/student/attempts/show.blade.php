@extends('layouts.app')

@section('title', 'Taking Quiz: ' . $attempt->quiz->name)

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $attempt->quiz->name }}</h5>
                        <div class="quiz-timer" data-end-time="{{ $attempt->end_time }}">
                            <i class="fas fa-clock text-primary me-2"></i>
                            <span id="timer">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('student.attempts.submit', $attempt) }}" method="POST" id="quizForm">
                        @csrf
                        @foreach($attempt->quiz->questions as $index => $question)
                            <div class="question-card mb-4">
                                <div class="question-header mb-3">
                                    <h6 class="fw-bold mb-0">
                                        Question {{ $index + 1 }} of {{ $attempt->quiz->number_of_questions }}
                                    </h6>
                                    <p class="text-muted small mb-0">{{ $question->marks }} marks</p>
                                </div>
                                <div class="question-content">
                                    <p class="mb-3">{{ $question->question }}</p>
                                    <div class="options-list">
                                        @foreach(['a', 'b', 'c', 'd'] as $option)
                                            <div class="form-check custom-option mb-2">
                                                <input type="radio" 
                                                       name="answers[{{ $question->id }}]" 
                                                       value="{{ $option }}"
                                                       class="form-check-input"
                                                       id="q{{ $question->id }}_{{ $option }}"
                                                       required>
                                                <label class="form-check-label w-100" for="q{{ $question->id }}_{{ $option }}">
                                                    <span class="option-letter">{{ strtoupper($option) }}</span>
                                                    {{ $question->{"option_$option"} }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-paper-plane me-2"></i>Submit Quiz
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.question-card {
    background-color: #fff;
    border-radius: 8px;
    padding: 1.5rem;
    border: 1px solid rgba(0,0,0,0.1);
}

.custom-option {
    border: 1px solid rgba(0,0,0,0.1);
    border-radius: 8px;
    padding: 0.75rem;
    margin-bottom: 0.5rem;
    transition: all 0.2s;
}

.custom-option:hover {
    background-color: rgba(var(--bs-primary-rgb), 0.05);
}

.form-check-input:checked ~ .form-check-label {
    color: var(--bs-primary);
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

.quiz-timer {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--bs-primary);
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const timerElement = document.getElementById('timer');
    const endTime = new Date(document.querySelector('.quiz-timer').dataset.endTime).getTime();

    function updateTimer() {
        const now = new Date().getTime();
        const distance = endTime - now;

        if (distance < 0) {
            document.getElementById('quizForm').submit();
            return;
        }

        const minutes = Math.floor(distance / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        timerElement.innerHTML = `${minutes}:${seconds.toString().padStart(2, '0')}`;
    }

    updateTimer();
    setInterval(updateTimer, 1000);
});
</script>
@endpush
@endsection
