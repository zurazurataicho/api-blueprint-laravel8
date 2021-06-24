<?php

namespace App\Http\Middleware;

use App\Models\PersonalAccessToken;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Log;

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
    public function handle($request, Closure $next, ...$guards)
    {
        $token = $request->bearerToken();
        if (!$token) {
            $this->unauthenticated($request, $guards);
        }

        $routeName = $request->route()->getName();
        $tokenName = PersonalAccessToken::TOKEN_PREFIX . $routeName;

        if (!Sanctum::$personalAccessTokenModel::isCorrectTokenName($token, $tokenName)) {
            $this->unauthenticated($request, $guards);
        }

        $isApi = $routeName === RouteServiceProvider::ROUTE_NAME_API;
        if (!$isApi) {
            if (!Sanctum::$personalAccessTokenModel::tokenExpireIn($token, $tokenName)) {
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
