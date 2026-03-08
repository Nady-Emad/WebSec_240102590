@extends('layouts.app')

@section('title', 'Exam Result')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Exam Result</h1>
            <p class="text-muted mb-0">Student: {{ $user->name }} ({{ $user->email }})</p>
        </div>
        <form action="{{ route('lab3.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger">Logout</button>
        </form>
    </div>

    <div class="alert alert-success">
        Exam score saved in database successfully. Attempt ID: <strong>#{{ $attempt->id }}</strong>
    </div>

    <div class="content-card card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="border rounded p-3 h-100 bg-light">
                        <div class="small text-muted">Score</div>
                        <div class="h4 mb-0">{{ $score }} / {{ $total }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="border rounded p-3 h-100 bg-light">
                        <div class="small text-muted">Percentage</div>
                        <div class="h4 mb-0">{{ number_format($percentage, 2) }}%</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="border rounded p-3 h-100 bg-light">
                        <div class="small text-muted">Status</div>
                        <div class="h4 mb-0 {{ $percentage >= 60 ? 'text-success' : 'text-danger' }}">{{ $percentage >= 60 ? 'Pass' : 'Fail' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-card card mb-4">
        <div class="card-header py-3">
            <h2 class="h5 mb-0">Detailed Review</h2>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Question</th>
                            <th>Your Answer</th>
                            <th>Correct Answer</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($results as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item['question']->question_text }}</td>
                                <td>{{ $item['selected'] ?? 'Not Answered' }}</td>
                                <td>{{ $item['question']->correct_option }}</td>
                                <td>
                                    <span class="badge {{ $item['is_correct'] ? 'text-bg-success' : 'text-bg-danger' }}">
                                        {{ $item['is_correct'] ? 'Correct' : 'Wrong' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No exam data found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <a href="{{ route('lab3.exam.start') }}" class="btn btn-primary">Try Again</a>
@endsection

