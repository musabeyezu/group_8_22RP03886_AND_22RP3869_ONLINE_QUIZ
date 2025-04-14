@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')
<div class="dashboard-container">
    <!-- Welcome Section -->
    <div class="welcome-section mb-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="welcome-title">
                        <i class="fas fa-graduation-cap text-primary me-2"></i>
                        Welcome back, {{ Auth::guard('student')->user()->fullname }}!
                    </h1>
                    <p class="text-muted">Here's your learning progress overview</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="btn-group">
                        <button class="btn btn-outline-primary">
                            <i class="fas fa-bell me-2"></i>Notifications
                            <span class="badge bg-danger ms-2">3</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="container mb-4">
        <div class="row g-3">
            <div class="col-md-3">
                <div class="card stat-card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-primary-subtle rounded-circle p-3 me-3">
                                <i class="fas fa-book-open text-primary fa-2x"></i>
                            </div>
                            <div>
                                <h3 class="stat-value mb-1">{{ $totalQuizzes ?? 0 }}</h3>
                                <p class="stat-label mb-0 text-muted">Available Quizzes</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-success-subtle rounded-circle p-3 me-3">
                                <i class="fas fa-check-circle text-success fa-2x"></i>
                            </div>
                            <div>
                                <h3 class="stat-value mb-1">{{ $completedQuizzes ?? 0 }}</h3>
                                <p class="stat-label mb-0 text-muted">Completed</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-warning-subtle rounded-circle p-3 me-3">
                                <i class="fas fa-star text-warning fa-2x"></i>
                            </div>
                            <div>
                                <h3 class="stat-value mb-1">{{ $averageScore ?? '0%' }}</h3>
                                <p class="stat-label mb-0 text-muted">Average Score</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-info-subtle rounded-circle p-3 me-3">
                                <i class="fas fa-clock text-info fa-2x"></i>
                            </div>
                            <div>
                                <h3 class="stat-value mb-1">{{ $timeSpent ?? '0h' }}</h3>
                                <p class="stat-label mb-0 text-muted">Time Spent</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="row g-4">
            <!-- Available Quizzes -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-list-alt text-primary me-2"></i>Available Quizzes
                            </h5>
                            <div class="btn-group">
                                <button class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-filter me-1"></i>Filter
                                </button>
                                <button class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-sort me-1"></i>Sort
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Quiz Name</th>
                                        <th>Questions</th>
                                        <th>Duration</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($quizzes ?? [] as $quiz)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="quiz-icon me-2">
                                                    <i class="fas fa-book text-primary"></i>
                                                </div>
                                                {{ $quiz->name }}
                                            </div>
                                        </td>
                                        <td>{{ $quiz->number_of_questions }} Questions</td>
                                        <td>{{ $quiz->duration }} Minutes</td>
                                        <td>
                                            @if($quiz->attempted)
                                                <span class="badge bg-success">Completed</span>
                                            @else
                                                <span class="badge bg-info">New</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!$quiz->attempted)
                                                <a href="{{ route('student.quizzes.start', $quiz->id) }}" 
                                                   class="btn btn-primary btn-sm">
                                                    <i class="fas fa-play me-1"></i>Start
                                                </a>
                                            @else
                                                <a href="{{ route('student.quizzes.review', $quiz->id) }}" 
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-eye me-1"></i>Review
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <div class="empty-state">
                                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                <h6 class="text-muted">No quizzes available yet</h6>
                                                <p class="small text-muted mb-0">Check back later for new quizzes</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity & Progress -->
            <div class="col-lg-4">
                <!-- Recent Activity -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-history text-primary me-2"></i>Recent Activity
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="activity-timeline p-3">
                            @forelse($recentActivity ?? [] as $activity)
                            <div class="activity-item pb-3 mb-3 border-bottom">
                                <div class="d-flex align-items-start">
                                    <div class="activity-icon me-3">
                                        <i class="fas fa-check-circle text-success"></i>
                                    </div>
                                    <div class="activity-content">
                                        <h6 class="mb-1">{{ $activity->title }}</h6>
                                        <p class="small text-muted mb-0">
                                            {{ $activity->description }}
                                        </p>
                                        <span class="small text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $activity->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <i class="fas fa-stream fa-2x text-muted mb-2"></i>
                                <p class="text-muted mb-0">No recent activity</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Progress Overview -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-line text-primary me-2"></i>Progress Overview
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="progress-item mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="small">Overall Progress</span>
                                <span class="small text-muted">75%</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-success" style="width: 75%"></div>
                            </div>
                        </div>
                        <div class="progress-item mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="small">Quiz Completion</span>
                                <span class="small text-muted">60%</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-primary" style="width: 60%"></div>
                            </div>
                        </div>
                        <div class="progress-item">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="small">Average Score</span>
                                <span class="small text-muted">85%</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-warning" style="width: 85%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.dashboard-container {
    background-color: #f8f9fa;
    min-height: calc(100vh - 60px);
    padding: 2rem 0;
}

.welcome-section {
    background-color: #fff;
    padding: 2rem 0;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.welcome-title {
    font-size: 1.75rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.stat-card {
    transition: transform 0.2s;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 600;
}

.stat-label {
    font-size: 0.875rem;
}

.activity-timeline {
    max-height: 400px;
    overflow-y: auto;
}

.activity-item:last-child {
    border-bottom: none !important;
    margin-bottom: 0 !important;
    padding-bottom: 0 !important;
}

.empty-state {
    padding: 2rem;
}

.quiz-icon {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(var(--bs-primary-rgb), 0.1);
    border-radius: 8px;
}

/* Custom Scrollbar */
.activity-timeline::-webkit-scrollbar {
    width: 6px;
}

.activity-timeline::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.activity-timeline::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 3px;
}

.activity-timeline::-webkit-scrollbar-thumb:hover {
    background: #999;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .welcome-section {
        text-align: center;
        padding: 1.5rem 0;
    }

    .welcome-title {
        font-size: 1.5rem;
    }

    .col-md-4.text-md-end {
        text-align: center !important;
        margin-top: 1rem;
    }

    .stat-card {
        margin-bottom: 1rem;
    }
}
</style>
@endsection
