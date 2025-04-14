@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Total Quizzes</h5>
                <p class="card-text display-4">{{ $totalQuizzes ?? 0 }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Total Students</h5>
                <p class="card-text display-4">{{ $totalStudents ?? 0 }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Total Attempts</h5>
                <p class="card-text display-4">{{ $totalAttempts ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Quizzes</h5>
            </div>
            <div class="card-body">
                @if(isset($recentQuizzes) && $recentQuizzes->count() > 0)
                    <div class="list-group">
                        @foreach($recentQuizzes as $quiz)
                            <a href="{{ route('admin.quizzes.show', $quiz) }}" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $quiz->title }}</h6>
                                    <small>{{ $quiz->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1">{{ Str::limit($quiz->description, 100) }}</p>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">No quizzes created yet.</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Attempts</h5>
            </div>
            <div class="card-body">
                @if(isset($recentAttempts) && $recentAttempts->count() > 0)
                    <div class="list-group">
                        @foreach($recentAttempts as $attempt)
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $attempt->student->name }}</h6>
                                    <small>{{ $attempt->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1">
                                    Quiz: {{ $attempt->quiz->title }}<br>
                                    Score: {{ $attempt->score }}%
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">No attempts recorded yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
