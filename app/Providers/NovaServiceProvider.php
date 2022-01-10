<?php

namespace App\Providers;

use App\Models\User;
use App\Nova\Metrics\AllRecords;
use App\Nova\Metrics\NewChurches;
use App\Nova\Metrics\NewOrganizations;
use App\Nova\Metrics\Visitors;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {

            return $this->isAllowed($user);

        });
    }


    /** 
     * Check if the user is already allowed to login (status = 1)
    */
    public function isAllowed(User $user) 
    {
        return $user->status === 1 ? true : false;
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [

            (new NewChurches())
                ->canSee(function($request) {
                    return $request->user()->role_id === 1;
                }),

            (new NewOrganizations())
                ->canSee(function($request) {
                    return $request->user()->role_id === 1;
                }),

            (new AllRecords())
                ->canSee(function($request) {
                    return $request->user()->role_id === 1;
                }),

            (new Visitors())
                ->width('full')
                ->canSee(function($request) {
                    return $request->user()->role_id === 1;
                })

        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        
        return [

            (new \Bolechen\NovaActivitylog\NovaActivitylog())
                ->canSee(function($request) {
                    return $request->user()->isAdmin();
                }),

        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
