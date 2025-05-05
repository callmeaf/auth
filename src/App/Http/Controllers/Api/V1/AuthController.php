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
            new Middleware(middleware: 'auth:sanctum', except: ['login','loginViaPassword'])
        ];
    }

    public function login()
    {
        return $this->authRepo->login(identifier: $this->request->get('identifier'), code: $this->request->get('code'), remember: $this->request->get('remember', false));
    }

    public function loginViaPassword()
    {
        return $this->authRepo->loginViaPassword(identifier: $this->request->get('identifier'),password: $this->request->get('password'),remember: $this->request->get('remember',false));
    }

    public function user()
    {
        return $this->authRepo->user();
    }

    public function logout()
    {
        $this->authRepo->logout();

        return response()->json();
    }

    public function profileUpdate()
    {
        return $this->authRepo->updateProfile(data: $this->request->validated());
    }

    public function passwordUpdate()
    {
        return $this->authRepo->updatePassword(password: $this->request->get('password'),code: $this->request->get('code'));
    }

    public function acceptTerms()
    {
        return $this->authRepo->acceptTerms(value: $this->request->boolean('accept_terms'));
    }
}
