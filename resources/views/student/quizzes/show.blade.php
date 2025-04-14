@extends('layouts.app')

@section('title', $quiz->name)

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-file-alt text-primary me-2"></i>{{ $quiz->name }}
                        </h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="quiz-info mb-4">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="info-icon me-2">
                                        <i class="fas fa-question-circle text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Number of Questions</small>
                                        <strong>{{ $quiz->number_of_questions }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="info-icon me-2">
                                        <i class="fas fa-clock text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Duration</small>
                                        <strong>{{ $quiz->duration }} minutes</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="info-icon me-2">
                                        <i class="fas fa-award text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Passing Score</small>
                                        <strong>{{ $quiz->passing_score }}%</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="info-icon me-2">
                                        <i class="fas fa-star text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Marks per Question</small>
                                        <strong>{{ $quiz->marks_per_question }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="quiz-instructions mb-4">
                        <h6 class="fw-bold mb-3">Instructions:</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Read each question carefully before answering
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                You cannot go back to previous questions once answered
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                The quiz will auto-submit when the time is up
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Ensure you have a stable internet connection
                            </li>
                        </ul>
                    </div>

                    <div class="text-center">
                        <form action="{{ route('student.quizzes.start', $quiz) }}" method="GET">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-play me-2"></i>Start Quiz
                            </button>
                        </form>
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

.quiz-instructions li {
    display: flex;
    align-items: center;
}
</style>
@endsection
