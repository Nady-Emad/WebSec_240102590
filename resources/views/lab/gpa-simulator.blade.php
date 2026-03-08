@extends('layouts.app')

@section('title', 'GPA Simulator')

@section('content')
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="content-card card h-100">
                <div class="card-header py-3">
                    <h1 class="h5 mb-0">Course Catalog</h1>
                </div>
                <div class="card-body">
                    @if (count($courseCatalog) === 0)
                        <div class="alert alert-warning mb-0">No courses available in database.</div>
                    @else
                        <div class="mb-3">
                            <label for="courseSelect" class="form-label">Course</label>
                            <select id="courseSelect" class="form-select">
                                @foreach ($courseCatalog as $course)
                                    <option value="{{ $course['code'] }}">{{ $course['code'] }} - {{ $course['title'] }} ({{ $course['credit_hours'] }} CH)</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="gradeSelect" class="form-label">Grade</label>
                            <select id="gradeSelect" class="form-select">
                                <option value="4.0">A (4.0)</option>
                                <option value="3.7">A- (3.7)</option>
                                <option value="3.3">B+ (3.3)</option>
                                <option value="3.0">B (3.0)</option>
                                <option value="2.7">B- (2.7)</option>
                                <option value="2.3">C+ (2.3)</option>
                                <option value="2.0">C (2.0)</option>
                                <option value="1.7">C- (1.7)</option>
                                <option value="1.0">D (1.0)</option>
                                <option value="0.0">F (0.0)</option>
                            </select>
                        </div>

                        <button type="button" class="btn btn-primary w-100" id="addCourseBtn">Add Course</button>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="content-card card h-100">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h2 class="h5 mb-0">Selected Courses</h2>
                    <span class="badge text-bg-info">Dynamic JavaScript GPA</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-3">
                        <table class="table table-striped align-middle" id="gpaTable">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Title</th>
                                    <th class="text-center">CH</th>
                                    <th class="text-center">Grade</th>
                                    <th class="text-center">Points</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="emptyRow">
                                    <td colspan="6" class="text-center text-muted">No courses added yet.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="alert alert-secondary mb-0" id="gpaSummary">Total CH: 0 | GPA: 0.00</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    (() => {
        const catalog = @json($courseCatalog);
        const courseSelect = document.getElementById('courseSelect');
        const gradeSelect = document.getElementById('gradeSelect');
        const addCourseBtn = document.getElementById('addCourseBtn');
        const tbody = document.querySelector('#gpaTable tbody');
        const emptyRow = document.getElementById('emptyRow');
        const gpaSummary = document.getElementById('gpaSummary');

        if (!courseSelect || !gradeSelect || !addCourseBtn) {
            return;
        }

        const selectedCourses = [];

        const updateSummary = () => {
            const totalHours = selectedCourses.reduce((sum, row) => sum + row.creditHours, 0);
            const qualityPoints = selectedCourses.reduce((sum, row) => sum + (row.creditHours * row.gradePoint), 0);
            const gpa = totalHours > 0 ? (qualityPoints / totalHours) : 0;

            gpaSummary.textContent = `Total CH: ${totalHours.toFixed(1)} | GPA: ${gpa.toFixed(2)}`;
        };

        const removeCourse = (index) => {
            selectedCourses.splice(index, 1);
            renderTable();
            updateSummary();
        };

        const renderTable = () => {
            tbody.innerHTML = '';

            if (selectedCourses.length === 0) {
                tbody.appendChild(emptyRow);
                return;
            }

            selectedCourses.forEach((row, index) => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${row.code}</td>
                    <td>${row.title}</td>
                    <td class="text-center">${row.creditHours}</td>
                    <td class="text-center">${row.gradeLabel}</td>
                    <td class="text-center">${(row.creditHours * row.gradePoint).toFixed(2)}</td>
                    <td class="text-end"><button type="button" class="btn btn-sm btn-outline-danger">Remove</button></td>
                `;

                tr.querySelector('button').addEventListener('click', () => removeCourse(index));
                tbody.appendChild(tr);
            });
        };

        addCourseBtn.addEventListener('click', () => {
            const selectedCode = courseSelect.value;
            const selectedCourse = catalog.find((course) => course.code === selectedCode);

            if (!selectedCourse) {
                return;
            }

            const gradePoint = Number(gradeSelect.value);
            const gradeLabel = gradeSelect.options[gradeSelect.selectedIndex].text.split(' ')[0];

            selectedCourses.push({
                code: selectedCourse.code,
                title: selectedCourse.title,
                creditHours: Number(selectedCourse.credit_hours),
                gradePoint,
                gradeLabel,
            });

            renderTable();
            updateSummary();
        });
    })();
</script>
@endpush
