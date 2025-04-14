@extends('layouts.admin')

@section('title', 'Edit Question')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Edit Question</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.quizzes.questions.update', [$quiz, $question]) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label">Question Text</label>
                    <input type="text" class="form-control @error('question') is-invalid @enderror" 
                        name="question" value="{{ old('question', $question->question) }}" required>
                    @error('question')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Marks</label>
                    <input type="number" class="form-control @error('marks') is-invalid @enderror" 
                        name="marks" value="{{ old('marks', $question->marks) }}" min="1" required>
                    @error('marks')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="options-container">
                    <label class="form-label">Options (Select the correct answer)</label>
                    
                    <!-- Option A -->
                    <div class="mb-2">
                        <div class="input-group">
                            <div class="input-group-text">
                                <input type="radio" name="correct_answer" value="a"
                                    {{ (old('correct_answer', $question->correct_answer) === 'a') ? 'checked' : '' }} required>
                            </div>
                            <span class="input-group-text">A</span>
                            <input type="text" class="form-control @error('option_a') is-invalid @enderror" 
                                name="option_a" value="{{ old('option_a', $question->option_a) }}" required>
                            @error('option_a')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Option B -->
                    <div class="mb-2">
                        <div class="input-group">
                            <div class="input-group-text">
                                <input type="radio" name="correct_answer" value="b"
                                    {{ (old('correct_answer', $question->correct_answer) === 'b') ? 'checked' : '' }}>
                            </div>
                            <span class="input-group-text">B</span>
                            <input type="text" class="form-control @error('option_b') is-invalid @enderror" 
                                name="option_b" value="{{ old('option_b', $question->option_b) }}" required>
                            @error('option_b')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Option C -->
                    <div class="mb-2">
                        <div class="input-group">
                            <div class="input-group-text">
                                <input type="radio" name="correct_answer" value="c"
                                    {{ (old('correct_answer', $question->correct_answer) === 'c') ? 'checked' : '' }}>
                            </div>
                            <span class="input-group-text">C</span>
                            <input type="text" class="form-control @error('option_c') is-invalid @enderror" 
                                name="option_c" value="{{ old('option_c', $question->option_c) }}" required>
                            @error('option_c')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Option D -->
                    <div class="mb-2">
                        <div class="input-group">
                            <div class="input-group-text">
                                <input type="radio" name="correct_answer" value="d"
                                    {{ (old('correct_answer', $question->correct_answer) === 'd') ? 'checked' : '' }}>
                            </div>
                            <span class="input-group-text">D</span>
                            <input type="text" class="form-control @error('option_d') is-invalid @enderror" 
                                name="option_d" value="{{ old('option_d', $question->option_d) }}" required>
                            @error('option_d')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.quizzes.show', $quiz) }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Question</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
