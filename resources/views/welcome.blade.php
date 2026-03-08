@extends('layouts.app')

@section('title', 'Home')

@push('styles')
<style>
    .home-hero {
        border: 0;
        border-radius: 1rem;
        background: linear-gradient(135deg, #ffffff 0%, #f5f8ff 100%);
        box-shadow: 0 1rem 2.2rem rgba(15, 23, 42, 0.08);
    }

    .lab-card {
        border: 0;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 0.8rem 1.8rem rgba(15, 23, 42, 0.08);
    }

    .lab-header {
        font-weight: 700;
        letter-spacing: 0.01em;
        text-align: center;
    }

    .lab1-header {
        background: #eef2ff;
        color: #1e293b;
    }

    .lab2-header {
        background: #e8f7ff;
        color: #0f172a;
    }

    .lab3-header {
        background: #e9fcef;
        color: #14532d;
    }

    .lab-btn {
        border-radius: 0.75rem;
        font-weight: 600;
        min-height: 5.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .lab-btn + .lab-btn {
        margin-top: 0.55rem;
    }
</style>
@endpush

@section('content')

    <div class="card home-hero mb-4">
        <div class="card-body p-4 p-lg-5 text-center">
            <h1 class="h3 mb-2">Welcome to WebSecService</h1>
            <p class="text-muted mb-0">Integrated Laravel project with real database-backed modules.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card lab-card h-100">
                <div class="card-header lab-header lab1-header">Lab 1</div>
                <div class="card-body d-grid">
                    <a class="btn btn-outline-secondary lab-btn" href="{{ route('lab1.even') }}">Even Numbers</a>
                    <a class="btn btn-outline-secondary lab-btn" href="{{ route('lab1.odd') }}">Odd Numbers</a>
                    <a class="btn btn-outline-secondary lab-btn" href="{{ route('lab1.prime') }}">Prime Numbers</a>
                    <a class="btn btn-outline-secondary lab-btn" href="{{ route('lab1.square') }}">Square Numbers</a>
                    <a class="btn btn-outline-secondary lab-btn" href="{{ route('lab1.multiplication') }}">Multiplication</a>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card lab-card h-100">
                <div class="card-header lab-header lab2-header">Lab 2</div>
                <div class="card-body d-grid">
                    <a class="btn btn-outline-primary lab-btn" href="{{ route('lab1.products.index') }}">Products CRUD</a>
                    <a class="btn btn-outline-primary lab-btn" href="{{ route('lab2.products.index') }}">Products + Cart</a>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card lab-card h-100">
                <div class="card-header lab-header lab3-header">Lab 3</div>
                <div class="card-body d-grid">
                    @if (! $lab3User)
                        <a class="btn btn-outline-success lab-btn" href="{{ route('lab3.login') }}">Login to Lab 3</a>
                    @else
                        <a class="btn btn-outline-success lab-btn" href="{{ route('lab2.transcript') }}">Transcript</a>
                        <a class="btn btn-outline-success lab-btn" href="{{ route('lab2.gpa_simulator') }}">GPA Simulator</a>

                        @if ($lab3User->role === 'admin')
                            <a class="btn btn-outline-success lab-btn" href="{{ route('lab3.users.index') }}">Users CRUD</a>
                        @endif

                        @if (in_array($lab3User->role, ['admin', 'instructor'], true))
                            <a class="btn btn-outline-success lab-btn" href="{{ route('lab3.grades.index') }}">Grades CRUD</a>
                            <a class="btn btn-outline-success lab-btn" href="{{ route('lab3.questions.index') }}">Questions CRUD</a>
                        @endif

                        <a class="btn btn-outline-success lab-btn" href="{{ route('lab3.exam.start') }}">MCQ Exam</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection





