@extends('layouts.app')

@section('title', 'Grades CRUD')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Grades Management</h1>
            <p class="text-muted mb-0">View grades grouped by academic term with GPA summaries.</p>
        </div>
        <a href="{{ route('lab3.grades.create') }}" class="btn btn-primary">Add New Grade</a>
    </div>

    @forelse ($gradesByTerm as $term => $termGrades)
        @php $summary = $termSummaries[$term]; @endphp
        <div class="content-card card mb-4">
            <div class="card-header py-3 d-flex flex-column flex-md-row justify-content-between gap-3">
                <div>
                    <h2 class="h5 mb-1">{{ $term }}</h2>
                    <div class="small text-muted">{{ $termGrades->count() }} record(s)</div>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge text-bg-secondary">CH: {{ number_format($summary['total_ch'], 1) }}</span>
                    <span class="badge text-bg-info">GPA: {{ number_format($summary['gpa'], 2) }}</span>
                    <span class="badge text-bg-dark">CCH: {{ number_format($summary['cch'], 1) }}</span>
                    <span class="badge text-bg-success">CGPA: {{ number_format($summary['cgpa'], 2) }}</span>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Course Code</th>
                                <th>Title</th>
                                <th class="text-center">CH</th>
                                <th class="text-center">Grade</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($termGrades as $grade)
                                <tr>
                                    <td>{{ $grade->course_code }}</td>
                                    <td>{{ $grade->title }}</td>
                                    <td class="text-center">{{ number_format($grade->credit_hours, 1) }}</td>
                                    <td class="text-center fw-semibold">{{ $grade->grade }}</td>
                                    <td>
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('lab3.grades.edit', $grade) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                            <form action="{{ route('lab3.grades.destroy', $grade) }}" method="POST" onsubmit="return confirm('Delete this grade?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-warning mb-0">No grades available yet.</div>
    @endforelse
@endsection

