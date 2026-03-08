@extends('layouts.app')

@section('title', 'Questions CRUD')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Questions Management</h1>
            <p class="text-muted mb-0">Create and maintain MCQ questions for the exam module.</p>
        </div>
        <a href="{{ route('lab3.questions.create') }}" class="btn btn-primary">Add New Question</a>
    </div>

    <div class="content-card card mb-4">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('lab3.questions.index') }}" class="row g-3 align-items-end">
                <div class="col-md-10">
                    <label for="search" class="form-label">Search Question Text</label>
                    <input type="text" id="search" name="search" class="form-control" value="{{ $search }}" placeholder="Type keywords...">
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-success w-100">Search</button>
                    <a href="{{ route('lab3.questions.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="content-card card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Question</th>
                            <th>Correct</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($questions as $question)
                            <tr>
                                <td>{{ $question->id }}</td>
                                <td>{{ $question->question_text }}</td>
                                <td><span class="badge text-bg-success">{{ $question->correct_option }}</span></td>
                                <td>
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('lab3.questions.edit', $question) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form action="{{ route('lab3.questions.destroy', $question) }}" method="POST" onsubmit="return confirm('Delete this question?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">No questions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3 d-flex justify-content-between align-items-center">
        {{ $questions->links() }}
        <a href="{{ route('lab3.exam.start') }}" class="btn btn-outline-success">Start Exam</a>
    </div>
@endsection

