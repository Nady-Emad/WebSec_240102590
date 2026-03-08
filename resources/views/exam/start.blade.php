@extends('layouts.app')

@section('title', 'Start Exam')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">MCQ Exam</h1>
            <p class="text-muted mb-0">Logged in as {{ $user->name }} ({{ $user->email }})</p>
        </div>

        <div class="d-flex gap-2">
            @if (in_array($user->role, ['admin', 'instructor'], true))
                <a href="{{ route('lab3.questions.index') }}" class="btn btn-outline-secondary">Manage Questions</a>
            @endif
            <form action="{{ route('lab3.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger">Logout</button>
            </form>
        </div>
    </div>

    @if ($questions->isEmpty())
        <div class="alert alert-warning">No questions available. Please add questions first.</div>
    @else
        <form action="{{ route('lab3.exam.submit') }}" method="POST">
            @csrf
            @foreach ($questions as $index => $question)
                <div class="content-card card mb-3">
                    <div class="card-body">
                        <h2 class="h6 mb-3">Q{{ $index + 1 }}. {{ $question->question_text }}</h2>

                        @foreach (['A', 'B', 'C', 'D'] as $option)
                            @php $field = 'option_' . strtolower($option); @endphp
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" id="q{{ $question->id }}_{{ $option }}" value="{{ $option }}">
                                <label class="form-check-label" for="q{{ $question->id }}_{{ $option }}">
                                    <strong>{{ $option }}.</strong> {{ $question->{$field} }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <button type="submit" class="btn btn-success">Submit Exam</button>
        </form>
    @endif
@endsection
