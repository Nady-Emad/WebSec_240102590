@extends('layouts.app')

@section('title', 'Transcript')

@section('content')
    @php
        $totalHours = array_sum(array_column($courses, 'credit_hours'));
    @endphp

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="content-card card h-100">
                <div class="card-header py-3">
                    <h1 class="h5 mb-0">Student Info</h1>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="small text-muted">Name</div>
                        <div class="fw-semibold">{{ $student['name'] }}</div>
                    </div>
                    <div class="mb-3">
                        <div class="small text-muted">Student ID</div>
                        <div class="fw-semibold">{{ $student['id'] }}</div>
                    </div>
                    <div class="mb-3">
                        <div class="small text-muted">Major</div>
                        <div class="fw-semibold">{{ $student['major'] }}</div>
                    </div>
                    <div class="mb-3">
                        <div class="small text-muted">Email</div>
                        <div class="fw-semibold">{{ $student['email'] ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="small text-muted">Total Registered CH</div>
                        <div class="fw-semibold">{{ $totalHours }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="content-card card h-100">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h2 class="h5 mb-0">Transcript</h2>
                    <span class="badge text-bg-secondary">{{ count($courses) }} Courses</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Course Code</th>
                                    <th>Title</th>
                                    <th class="text-center">Credit Hours</th>
                                    <th class="text-center">Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($courses as $course)
                                    <tr>
                                        <td>{{ $course['code'] }}</td>
                                        <td>{{ $course['title'] }}</td>
                                        <td class="text-center">{{ $course['credit_hours'] }}</td>
                                        <td class="text-center fw-semibold">{{ $course['grade'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">No transcript courses in database.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

