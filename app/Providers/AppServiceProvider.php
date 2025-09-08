<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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

        Gate::define('is_a_recruiter', function (User $user) {
            return $user->is_recruiter == true;
        });

        // Gate::define("access_admin_recruiter", function(Admin $user) {
        //     return Auth::user()->id == $user->id;
        // });
    }
}
