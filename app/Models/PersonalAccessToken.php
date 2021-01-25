<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    use HasFactory;

    public const SPA_TOKEN = 'api-blueprint-spa-token';
    public const API_TOKEN = 'api-blueprint-api-token';

    /**
     * Check a token is in expire
     *
     * @param  string  $token
     * @return bool
     */
    public static function tokenExpireIn(string $token)
    {
        $accessToken = self::findToken($token);
        if (is_null($accessToken)) {
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
}
