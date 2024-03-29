<?php

namespace App\Repositories;

use App\Contracts\Repositories\AccountRepository;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminAccountRepository implements AccountRepository
{
    private $credentials;

    public function __construct($credentials)
    {
        $this->credentials = $credentials;
    }

    public function find(): ?Admin
    {
        return Admin::where('email', $this->credentials['email'])
            ->where('password', $this->credentials['password'])
            ->first();
    }
}
