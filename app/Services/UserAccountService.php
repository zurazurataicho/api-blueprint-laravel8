<?php

namespace App\Services;

use App\Contracts\Services\AccountService;
use App\Models\User;
use App\Repositories\UserAccountRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserAccountService implements AccountService
{
    /** @var Request */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function find()
    {
        $credentials = $this->request->only(['email', 'password']);
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return null;
        }

        $foundUser = app()->makeWith(UserAccountRepository::class, ['credentials' => $credentials])->find();
        return $foundUser ?? null;
    }
}
