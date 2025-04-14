@extends('layouts.admin')

@section('title', 'Quizzes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Quizzes</h2>
    <a href="{{ route('admin.quizzes.create') }}" class="btn btn-primary">Create New Quiz</a>
</div>

<div class="card">
    <div class="card-body">
        @if($quizzes->isEmpty())
            <p class="text-center text-muted my-5">No quizzes found. Create your first quiz!</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Questions</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quizzes as $quiz)
                            <tr>
                                <td>{{ $quiz->title }}</td>
                                <td>{{ $quiz->questions_count ?? 0 }}</td>
                                <td>{{ $quiz->duration }} mins</td>
                                <td>
                                    @if($quiz->is_published)
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-secondary">Draft</span>
                                    @endif
                                </td>
                                <td>{{ $quiz->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.quizzes.edit', $quiz) }}" 
                                           class="btn btn-sm btn-outline-primary">Edit</a>
                                        <a href="{{ route('admin.quizzes.show', $quiz) }}" 
                                           class="btn btn-sm btn-outline-info">View</a>
                                        <form action="{{ route('admin.quizzes.destroy', $quiz) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    onclick="return confirm('Are you sure you want to delete this quiz?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $quizzes->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
