@extends('layouts.app')

@section('title', 'Lab 3 Login')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="content-card card">
                <div class="card-header py-3">
                    <h1 class="h5 mb-0">Lab 3 Login</h1>
                </div>
                <div class="card-body">
                    <p class="text-muted">Login to access Users, Grades, Questions, and Exam modules.</p>
                    <form method="POST" action="{{ route('lab3.login.submit') }}" class="row g-3">
                        @csrf
                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                        <div class="col-12">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
