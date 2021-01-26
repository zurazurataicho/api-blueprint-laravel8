<?php

namespace App\Http\Middleware;

use App\Models\PersonalAccessToken;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $token = $request->bearerToken();
        if (!$token) {
            $this->unauthenticated($request, $guards);
        }

        $routeName = $request->route()->getName();

        $isApi = $routeName === RouteServiceProvider::ROUTE_NAME_API;
        $tokenName = $isApi ? PersonalAccessToken::API_TOKEN : PersonalAccessToken::SPA_TOKEN;

        if (!Sanctum::$personalAccessTokenModel::isCorrectTokenName($token, $tokenName)) {
            $this->unauthenticated($request, $guards);
        }

        if (!$isApi) {
            if (!Sanctum::$personalAccessTokenModel::tokenExpireIn($token, PersonalAccessToken::SPA_TOKEN)) {
                $this->unauthenticated($request, $guards);
            }
        }

        $this->authenticate($request, $guards);

        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
