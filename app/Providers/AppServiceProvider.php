<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        View::composer('*', function ($view): void {
            static $resolved = false;
            static $lab3User = null;

            if (! $resolved) {
                $request = request();
                $userId = 0;

                if ($request && method_exists($request, 'hasSession') && $request->hasSession()) {
                    $userId = (int) $request->session()->get('lab3_user_id');
                }

                $lab3User = $userId
                    ? User::query()->select(['id', 'name', 'email', 'role'])->find($userId)
                    : null;

                $resolved = true;
            }

            $view->with('lab3User', $lab3User);
        });
    }
}
