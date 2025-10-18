<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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

        Gate::before(function ($user, $ability) {
        // Only check hasRole if it's an instance of User (not Member)
        if ($user instanceof User && method_exists($user, 'hasRole')) {
            return $user->hasRole('Super Admin') ? true : null;
        }
        return null;
    });

        // view()->composer('*', function ($view) {
        // $company = Company::first(); // get the first company
        // $view->with('appCompany', $company);
        // });
    }
}
