<?php

namespace App\Models;

use App\Providers\RouteServiceProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    use HasFactory;

    public const TOKEN_PREFIX = 'api-blueprint-token-';
    public const TOKEN_ADMIN = self::TOKEN_PREFIX . RouteServiceProvider::ROUTE_NAME_ADMIN;
    public const TOKEN_USER = self::TOKEN_PREFIX . RouteServiceProvider::ROUTE_NAME_USER;
    public const TOKEN_API = self::TOKEN_PREFIX . RouteServiceProvider::ROUTE_NAME_API;

    /**
     * Check a token is in expire
     *
     * @param  string  $token
     * @param  string  $name
     * @return bool
     */
    public static function tokenExpireIn(string $token, string $name = null)
    {
        $accessToken = self::findToken($token);
        if (is_null($accessToken)) {
            return false;
        }

        // distinct a token by an access token name (if specified)
        if (!is_null($name) && $accessToken->name !== $name) {
            return false;
        }

        $spaAuthTokenExpired = config('sanctum.spa_auth_token_expired');
        $spaExpiration = config('sanctum.spa_expiration');
        if (!$spaAuthTokenExpired || !$spaExpiration) {
            return true;
        }

        if ($accessToken->created_at->gte(now()->subMinutes($spaExpiration))) {
            return true;
        }

        return false;
    }

    /**
     * Check a token name
     *
     * @param  string  $token
     * @param  string  $tokenName
     * @return bool
     */
    public static function isCorrectTokenName(string $token, string $tokenName)
    {
        $accessToken = self::findToken($token);
        if (is_null($accessToken)) {
            return false;
        }

        return $accessToken->name === $tokenName;
    }
}
