<?php

namespace App\Services;

use App\Contracts\Services\AccountService;
use App\Models\Application;
use App\Repositories\ApplicationAccountRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ApplicationAccountService implements AccountService
{
    /** @var Request */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function find()
    {
        $credentials = $this->request->only(['email', 'url']);
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'url' => 'required|url',
        ]);
        if ($validator->fails()) {
            return null;
        }

        $foundApplication = app()->makeWith(ApplicationAccountRepository::class, ['credentials' => $credentials])->find();
        return $foundApplication ?? null;
    }
}
