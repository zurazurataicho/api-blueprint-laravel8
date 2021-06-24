<?php

namespace App\Repositories;

use App\Contracts\Repositories\AccountRepository;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApplicationAccountRepository implements AccountRepository
{
    private $credentials;

    public function __construct($credentials)
    {
        $this->credentials = $credentials;
    }

    public function find(): ?Application
    {
        return Application::where('email', $this->credentials['email'])
            ->where('url', $this->credentials['url'])
            ->first();
    }
}
