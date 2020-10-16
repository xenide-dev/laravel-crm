<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        // for authorization
        $configs = config("_privileges.urls");
        foreach ($configs as $config) {
            foreach ($config["access"] as $access) {
                $slug = Str::slug($access . " " . $config["name"]);
                Gate::define($slug, function($user) use ($slug) {
                    $permit = $user->userPermission()->where("slug", $slug)->count();
                    return ($permit > 0);
                });
            }
        }
    }
}
