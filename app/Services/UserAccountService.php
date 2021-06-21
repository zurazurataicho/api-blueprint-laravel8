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

    public function findUser()
    {
        $credentials = $this->request->only(['email', 'password']);
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return false;
        }

        $foundUser = app()->makeWith(UserAccountRepository::class, ['credentials' => $credentials])->findUser();
        return $foundUser ?? false;
    }
}
