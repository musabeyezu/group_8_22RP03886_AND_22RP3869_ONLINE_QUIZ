@extends('layouts.app')

@section('title', 'Available Quizzes')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-book-open text-primary me-2"></i>Available Quizzes
                        </h5>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($availableQuizzes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Quiz Name</th>
                                        <th>Questions</th>
                                        <th>Duration</th>
                                        <th>Passing Score</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($availableQuizzes as $quiz)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="quiz-icon me-2">
                                                        <i class="fas fa-file-alt text-primary"></i>
                                                    </div>
                                                    <div>
                                                        {{ $quiz->name }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $quiz->number_of_questions }}</td>
                                            <td>{{ $quiz->duration }} mins</td>
                                            <td>{{ $quiz->passing_score }}%</td>
                                            <td>
                                                @if($quiz->isAvailable())
                                                    <a href="{{ route('student.quizzes.start', $quiz) }}" 
                                                       class="btn btn-sm btn-primary">
                                                        <i class="fas fa-play me-1"></i>Start Quiz
                                                    </a>
                                                @else
                                                    <button class="btn btn-sm btn-secondary" disabled>
                                                        <i class="fas fa-lock me-1"></i>Not Available
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="p-3">
                            {{ $availableQuizzes->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <img src="{{ asset('images/no-data.svg') }}" alt="No quizzes" class="img-fluid mb-3" style="max-width: 200px;">
                            <h5 class="text-muted">No quizzes available at the moment</h5>
                            <p class="text-muted small">Please check back later for new quizzes.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.quiz-icon {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(var(--bs-primary-rgb), 0.1);
    border-radius: 8px;
}
</style>
@endsection
