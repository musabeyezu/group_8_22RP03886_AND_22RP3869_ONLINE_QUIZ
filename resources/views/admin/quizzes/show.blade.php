@extends('layouts.admin')

@section('title', $quiz->name)

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2>{{ $quiz->name }}</h2>
            <div>
                <a href="{{ route('admin.quizzes.questions.create', $quiz) }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Add Questions
                </a>
                <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Quiz
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title">Questions</h5>
                            <p class="card-text">{{ $quiz->questions->count() }} / {{ $quiz->number_of_questions }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title">Duration</h5>
                            <p class="card-text">{{ $quiz->duration }} minutes</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title">Passing Score</h5>
                            <p class="card-text">{{ $quiz->passing_score }}%</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title">Status</h5>
                            <p class="card-text">
                                @if($quiz->is_published)
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-warning">Draft</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            @if($quiz->questions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Question</th>
                                <th>Marks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quiz->questions as $index => $question)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $question->question }}</td>
                                    <td>{{ $question->marks }}</td>
                                    <td>
                                        <a href="{{ route('admin.quizzes.questions.edit', [$quiz, $question]) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.quizzes.questions.destroy', [$quiz, $question]) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Are you sure you want to delete this question?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">
                    No questions added yet. Click the "Add Questions" button to add questions to this quiz.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
