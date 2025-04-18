<?php

namespace Callmeaf\Auth\App\Http\Controllers\Api\V1;

use Callmeaf\Auth\App\Repo\Contracts\AuthRepoInterface;
use Callmeaf\Base\App\Http\Controllers\Api\V1\ApiController;
use Callmeaf\Otp\App\Repo\Contracts\OtpRepoInterface;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AuthController extends ApiController implements HasMiddleware
{
    public function __construct(protected AuthRepoInterface $authRepo, protected OtpRepoInterface $otpRepo)
    {
        parent::__construct($this->authRepo->config);
    }

    public static function middleware(): array
    {
        return [
            new Middleware(middleware: 'auth:sanctum', only: ['logout', 'user'])
        ];
    }

    public function login()
    {
        $authResource = $this->authRepo->login(identifier: $this->request->get('identifier'), code: $this->request->get('code'), remember: $this->request->get('remember', false));

        if (! isPostmanRequest()) {
            $this->request->session()->regenerate();
        }

        return $authResource;
    }

    public function user()
    {
        return $this->authRepo->user();
    }

    public function logout()
    {
        $this->authRepo->logout();

        if (! isPostmanRequest()) {
            $this->request->session()->invalidate();

            $this->request->session()->regenerateToken();
        }


        return response()->json();
    }
}
