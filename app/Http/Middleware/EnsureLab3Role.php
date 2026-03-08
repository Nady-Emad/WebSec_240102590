<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureLab3Role
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $userId = (int) $request->session()->get('lab3_user_id');
        $user = $userId ? User::query()->find($userId) : null;

        if (! $user) {
            return redirect()->route('lab3.login')->with('status', 'Please login to access Lab 3.');
        }

        if (! in_array($user->role, $roles, true)) {
            $defaultRoute = match ($user->role) {
                'admin' => 'lab3.users.index',
                'instructor' => 'lab3.questions.index',
                default => 'lab3.exam.start',
            };

            return redirect()->route($defaultRoute)->with('status', 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
