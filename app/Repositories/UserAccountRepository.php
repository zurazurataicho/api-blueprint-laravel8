<?php

namespace App\Repositories;

use App\Contracts\Repositories\AccountRepository;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserAccountRepository implements AccountRepository
{
    private $credentials;

    public function __construct($credentials)
    {
        $this->credentials = $credentials;
    }

    public function findUser(): ?User
    {
        return User::where('email', $this->credentials['email'])
            ->where('password', $this->credentials['password'])
            ->first();
    }
}
