<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class GradeController extends Controller
{
    public function index(): View
    {
        $gradeMap = Grade::gradePointsMap();

        $gradesByTerm = Grade::query()
            ->orderBy('term')
            ->orderBy('course_code')
            ->get()
            ->groupBy('term');

        $termSummaries = [];
        $cumulativeHours = 0.0;
        $cumulativeQualityPoints = 0.0;

        foreach ($gradesByTerm as $term => $termGrades) {
            $termHours = (float) $termGrades->sum('credit_hours');
            $termQualityPoints = $this->calculateQualityPoints($termGrades, $gradeMap);
            $termGpa = $termHours > 0 ? round($termQualityPoints / $termHours, 2) : 0.0;

            $cumulativeHours += $termHours;
            $cumulativeQualityPoints += $termQualityPoints;

            $termSummaries[$term] = [
                'total_ch' => $termHours,
                'gpa' => $termGpa,
                'cch' => $cumulativeHours,
                'cgpa' => $cumulativeHours > 0 ? round($cumulativeQualityPoints / $cumulativeHours, 2) : 0.0,
            ];
        }

        return view('grades.index', [
            'gradesByTerm' => $gradesByTerm,
            'termSummaries' => $termSummaries,
            'gradeOptions' => array_keys($gradeMap),
        ]);
    }

    public function create(): View
    {
        return view('grades.create', [
            'gradeOptions' => array_keys(Grade::gradePointsMap()),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'term' => ['required', 'string', 'max:100'],
            'course_code' => ['required', 'string', 'max:20'],
            'title' => ['required', 'string', 'max:255'],
            'credit_hours' => ['required', 'numeric', 'min:0.5', 'max:6'],
            'grade' => ['required', 'string', 'in:' . implode(',', array_keys(Grade::gradePointsMap()))],
        ]);

        Grade::create($validatedData);

        return redirect()
            ->route('lab3.grades.index')
            ->with('status', 'Grade added successfully.');
    }

    public function edit(Grade $grade): View
    {
        return view('grades.edit', [
            'grade' => $grade,
            'gradeOptions' => array_keys(Grade::gradePointsMap()),
        ]);
    }

    public function update(Request $request, Grade $grade): RedirectResponse
    {
        $validatedData = $request->validate([
            'term' => ['required', 'string', 'max:100'],
            'course_code' => ['required', 'string', 'max:20'],
            'title' => ['required', 'string', 'max:255'],
            'credit_hours' => ['required', 'numeric', 'min:0.5', 'max:6'],
            'grade' => ['required', 'string', 'in:' . implode(',', array_keys(Grade::gradePointsMap()))],
        ]);

        $grade->update($validatedData);

        return redirect()
            ->route('lab3.grades.index')
            ->with('status', 'Grade updated successfully.');
    }

    public function destroy(Grade $grade): RedirectResponse
    {
        $grade->delete();

        return redirect()
            ->route('lab3.grades.index')
            ->with('status', 'Grade deleted successfully.');
    }

    private function calculateQualityPoints(Collection $grades, array $gradeMap): float
    {
        return (float) $grades->sum(function (Grade $grade) use ($gradeMap) {
            $gradePoint = $gradeMap[$grade->grade] ?? 0.0;

            return (float) $grade->credit_hours * $gradePoint;
        });
    }
}

