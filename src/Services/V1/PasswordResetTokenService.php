<?php

namespace Callmeaf\Auth\Services\V1;

use Callmeaf\Auth\Events\ForgotPasswordCodeSent;
use Callmeaf\Auth\Exceptions\PasswordResetCodeWasExpiredException;
use Callmeaf\Auth\Exceptions\PasswordResetCodeWasWrongException;
use Callmeaf\Auth\Exceptions\WaitForNewPasswordResetCodeException;
use Callmeaf\Auth\Services\V1\Contracts\PasswordResetTokenServiceInterface;
use Callmeaf\Base\Services\V1\BaseService;
use Callmeaf\Sms\Services\V1\SmsService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PasswordResetTokenService extends BaseService implements PasswordResetTokenServiceInterface
{
    public function __construct(?Builder $query = null, ?Model $model = null, ?Collection $collection = null, ?JsonResource $resource = null, ?ResourceCollection $resourceCollection = null, array $defaultData = [])
    {
        parent::__construct($query, $model, $collection, $resource, $resourceCollection, $defaultData);
        $this->query = app(config('callmeaf-password.model'))->query();
        $this->resource = config('callmeaf-password.model_resource');
        $this->resourceCollection = config('callmeaf-password.model_resource_collection');
        $this->defaultData = config('callmeaf-password.default_values');
        $this->defaultData['expired_at'] = now()->addSeconds($this->lifetime());
    }

    public function smsChannel(): SmsService
    {
        return app(config('callmeaf-otp.sms_channel'));
    }

    public function sendForgotPasswordVerifyCode(string $emailOrMobile): PasswordResetTokenService
    {
        if($this->freshQuery()->where('email_or_mobile',$emailOrMobile)->where('expired_at','>',now())->exists()) {
            throw new WaitForNewPasswordResetCodeException();
        }
        $this->updateOrCreate([
            'email_or_mobile' => $emailOrMobile,
        ],[
            'email_or_mobile' => $emailOrMobile,
            'code' => $this->newCode(),
            'expired_at' => @$this->defaultData['expired_at'],
        ]);

        ForgotPasswordCodeSent::dispatch($this->model);

        return $this;
    }

    public function newCode(): string
    {
        $code = randomDigits($this->codeLength());
        if($this->freshQuery()->where('code',$code)->exists()) {
            return $this->newCode();
        }
        return $code;
    }

    public function updatePassword(string $code, string $password): PasswordResetTokenService
    {
        $model = $this->model;
        if($model->code !== $code) {
            throw new PasswordResetCodeWasWrongException();
        }

        if($model->expired_at < now()) {
            throw new PasswordResetCodeWasExpiredException();
        }

        $emailOrMobile = $model->email_or_mobile;
        $authService = app(config('callmeaf-auth.service'));
        if(str($emailOrMobile)->contains('@')) {
            $authService->where(column: 'email',valueOrOperation: $emailOrMobile);
        } else {
            $authService->where(column: 'mobile',valueOrOperation: $emailOrMobile);
        }

        $authService->first()->update(data: [
            'password' => $password
        ]);

        return $this;
    }

    private function codeLength(): int
    {
        return config('callmeaf-password.length');
    }

    private function lifetime(): int
    {
        return config('callmeaf-password.lifetime');
    }
}
