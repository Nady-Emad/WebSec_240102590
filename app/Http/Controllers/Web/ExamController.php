<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ExamAttempt;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ExamController extends Controller
{
    public function start(Request $request): View
    {
        $user = $this->getExamUser($request);
        $questions = Question::query()->orderBy('id')->get();

        return view('exam.start', compact('questions', 'user'));
    }

    public function submit(Request $request): View
    {
        $user = $this->getExamUser($request);
        $questions = Question::query()->orderBy('id')->get();

        $rawAnswers = $request->input('answers', []);
        if (! is_array($rawAnswers)) {
            $rawAnswers = [];
        }

        Validator::make(
            ['answers' => $rawAnswers],
            [
                'answers' => ['array'],
                'answers.*' => ['nullable', 'in:A,B,C,D'],
            ]
        )->validate();

        $allowedQuestionIds = $questions
            ->pluck('id')
            ->map(fn (int $id) => (string) $id)
            ->all();

        $answers = array_intersect_key($rawAnswers, array_flip($allowedQuestionIds));

        $score = 0;

        $results = $questions->map(function (Question $question) use ($answers, &$score) {
            $selected = $answers[$question->id] ?? null;
            $isCorrect = $selected === $question->correct_option;

            if ($isCorrect) {
                $score++;
            }

            return [
                'question' => $question,
                'selected' => $selected,
                'is_correct' => $isCorrect,
            ];
        });

        $total = $questions->count();
        $percentage = $total > 0 ? round(($score / $total) * 100, 2) : 0.0;

        $attempt = ExamAttempt::query()->create([
            'user_id' => $user->id,
            'score' => $score,
            'total_questions' => $total,
            'percentage' => $percentage,
            'answers' => $answers,
        ]);

        return view('exam.result', [
            'results' => $results,
            'score' => $score,
            'total' => $total,
            'percentage' => $percentage,
            'user' => $user,
            'attempt' => $attempt,
        ]);
    }

    private function getExamUser(Request $request): User
    {
        $userId = (int) $request->session()->get('lab3_user_id');

        return User::query()->findOrFail($userId);
    }
}
