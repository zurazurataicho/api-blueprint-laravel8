<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SpaAuthController extends UserController
{
    public function login(Request $request)
    {
        return $this->loginImpl(self::SPA_TOKEN, $request);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return [
            'status' => 200,
            'message' => 'logged out',
        ];
    }
}
