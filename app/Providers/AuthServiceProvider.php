<?php

namespace App\Providers;

use App\Models\SSO\User;
use App\Services\Auth\SSOGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::viaRequest('sso-token', function (Request $request) {
            $user = User::byToken($request->bearerToken())->first(); 
            logger('sso-token: ', [
                'user' => $user
            ]);
            
            return $user;
        });
    }
}
