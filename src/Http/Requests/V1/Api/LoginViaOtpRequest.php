<?php

namespace Callmeaf\Auth\Http\Requests\V1\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class LoginViaOtpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $otpModel = config('callmeaf-otp.model');
        return collect([
            'mobile' => ['string','max:255', Rule::exists($otpModel, 'mobile')],
            'code' => ['digits:' . config('callmeaf-otp.length'),Rule::exists($otpModel,'code')],
            'remember_me' => [],
        ])->map(
            fn($values,$key) => validationManager($key,$values,config("callmeaf-auth.validations.login_via_mobile")))
            ->toArray();
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(apiResponse([
            'errors' => $validator->errors(),
        ],  (new ValidationException($validator))->getMessage(),
            Response::HTTP_UNPROCESSABLE_ENTITY,
        ),
        );
    }
}
