<?php

namespace App\Providers;

use App\Contracts\Repositories\AccountRepository;
use App\Repositories\UserAccountRepository;
use App\Services\AccountService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AccountServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public $bindings = [
        AccountRepository::class => UserAccountRepository::class,
    ];

    /**
     * Register any account services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserAccountService::class, function ($app) {
            return new UserAccountService($app->make(Request::class));
        });
    }

    /**
     * Provide any account services.
     *
     * @return array
     */
    public function provides()
    {
        return [
            UserAccountService::class,
            UserAccountRepository::class,
        ];
    }
}
