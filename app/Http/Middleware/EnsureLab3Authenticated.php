<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureLab3Authenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        $userId = (int) $request->session()->get('lab3_user_id');

        if (! $userId) {
            return redirect()->route('lab3.login')->with('status', 'Please login to access Lab 3.');
        }

        $user = User::query()->find($userId);

        if (! $user) {
            $request->session()->forget('lab3_user_id');

            return redirect()->route('lab3.login')->with('status', 'Session expired. Please login again.');
        }

        return $next($request);
    }
}
