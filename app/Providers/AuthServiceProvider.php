<?php

namespace App\Providers;

use App\Models\Church;
use App\Models\ContactDetails;
use App\Models\Denomination;
use App\Models\Role;
use App\Models\ServiceSchedule;
use App\Models\User;
use App\Policies\ChurchPolicy;
use App\Policies\ContactDetailsPolicy;
use App\Policies\DenominationPolicy;
use App\Policies\RolePolicy;
use App\Policies\ServiceSchedulePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        User::class             => UserPolicy::class,
        Church::class           => ChurchPolicy::class,
        ContactDetails::class   => ContactDetailsPolicy::class,
        Denomination::class     => DenominationPolicy::class,
        Role::class             => RolePolicy::class,
        ServiceSchedule::class  => ServiceSchedulePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
