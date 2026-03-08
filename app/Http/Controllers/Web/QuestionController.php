<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuestionController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $questions = Question::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where('question_text', 'like', "%{$search}%");
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('questions.index', compact('questions', 'search'));
    }

    public function create(): View
    {
        return view('questions.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->validateQuestion($request);

        Question::create($validatedData);

        return redirect()
            ->route('lab3.questions.index')
            ->with('status', 'Question created successfully.');
    }

    public function edit(Question $question): View
    {
        return view('questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question): RedirectResponse
    {
        $validatedData = $this->validateQuestion($request);

        $question->update($validatedData);

        return redirect()
            ->route('lab3.questions.index')
            ->with('status', 'Question updated successfully.');
    }

    public function destroy(Question $question): RedirectResponse
    {
        $question->delete();

        return redirect()
            ->route('lab3.questions.index')
            ->with('status', 'Question deleted successfully.');
    }

    private function validateQuestion(Request $request): array
    {
        return $request->validate([
            'question_text' => ['required', 'string'],
            'option_a' => ['required', 'string', 'max:255'],
            'option_b' => ['required', 'string', 'max:255'],
            'option_c' => ['required', 'string', 'max:255'],
            'option_d' => ['required', 'string', 'max:255'],
            'correct_option' => ['required', 'in:A,B,C,D'],
        ]);
    }
}

