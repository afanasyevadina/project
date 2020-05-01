<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin', function() {
            return \Auth::user()->role == 'admin';
        });

        Gate::define('manager', function() {
            return in_array(\Auth::user()->role, ['admin', 'manager']);
        });

        Gate::define('dispatcher', function() {
            return in_array(\Auth::user()->role, ['admin', 'manager', 'dispatcher']);
        });

        Gate::define('teacher', function() {
            return in_array(\Auth::user()->role, ['admin', 'manager', 'teacher']);
        });

        Gate::define('forum', function() {
            return in_array(\Auth::user()->role, ['admin', 'student', 'teacher']);
        });

        //
    }
}
