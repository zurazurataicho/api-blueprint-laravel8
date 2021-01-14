<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiTokenController extends UserController
{
    public function issue(Request $request)
    {
        return $this->loginImpl(self::API_TOKEN, $request);
    }

    public function revoke(Request $request)
    {
        return "revoke()";
    }
}
