@php
    $isEdit = isset($grade) && $grade->exists;
@endphp

<div class="row g-3">
    <div class="col-md-6">
        <label for="term" class="form-label">Academic Term</label>
        <input type="text" id="term" name="term" class="form-control" value="{{ old('term', $isEdit ? $grade->term : '') }}" placeholder="e.g. 2026 Spring" required>
    </div>

    <div class="col-md-6">
        <label for="course_code" class="form-label">Course Code</label>
        <input type="text" id="course_code" name="course_code" class="form-control" value="{{ old('course_code', $isEdit ? $grade->course_code : '') }}" required>
    </div>

    <div class="col-md-6">
        <label for="title" class="form-label">Course Title</label>
        <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $isEdit ? $grade->title : '') }}" required>
    </div>

    <div class="col-md-3">
        <label for="credit_hours" class="form-label">Credit Hours</label>
        <input type="number" id="credit_hours" name="credit_hours" min="0.5" max="6" step="0.5" class="form-control" value="{{ old('credit_hours', $isEdit ? $grade->credit_hours : 3) }}" required>
    </div>

    <div class="col-md-3">
        <label for="grade" class="form-label">Grade</label>
        <select id="grade" name="grade" class="form-select" required>
            @php $selectedGrade = old('grade', $isEdit ? $grade->grade : 'A'); @endphp
            @foreach ($gradeOptions as $gradeOption)
                <option value="{{ $gradeOption }}" {{ $selectedGrade === $gradeOption ? 'selected' : '' }}>{{ $gradeOption }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="d-flex gap-2 pt-4">
    <button type="submit" class="btn btn-primary">{{ $buttonText }}</button>
    <a href="{{ route('lab3.grades.index') }}" class="btn btn-outline-secondary">Cancel</a>
</div>

