<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class Lab3AuthController extends Controller
{
    public function showLogin(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('lab3_user_id')) {
            return view('lab3.login');
        }

        $role = $this->getCurrentUserRole($request);

        if (! $role) {
            $request->session()->forget('lab3_user_id');

            return view('lab3.login');
        }

        return redirect()->route($this->defaultRouteForRole($role));
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::query()->where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors(['email' => 'Invalid email or password.'])->onlyInput('email');
        }

        $request->session()->regenerate();
        $request->session()->put('lab3_user_id', $user->id);

        return redirect()->route($this->defaultRouteForRole((string) $user->role))
            ->with('status', 'Welcome to Lab 3, ' . $user->name . '.');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('lab3_user_id');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('lab3.login')->with('status', 'Logged out successfully.');
    }

    private function getCurrentUserRole(Request $request): ?string
    {
        $userId = (int) $request->session()->get('lab3_user_id');

        if (! $userId) {
            return null;
        }

        return User::query()->whereKey($userId)->value('role');
    }

    private function defaultRouteForRole(string $role): string
    {
        return match ($role) {
            'admin' => 'lab3.users.index',
            'instructor' => 'lab3.questions.index',
            default => 'lab3.exam.start',
        };
    }
}
