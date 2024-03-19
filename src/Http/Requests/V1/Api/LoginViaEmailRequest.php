<?php

namespace Callmeaf\Auth\Http\Requests\V1\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class LoginViaEmailRequest extends FormRequest
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
        return collect([
            'email' => ['string', 'email','max:255', Rule::exists(config('callmeaf-auth.model'), 'email')],
            'password' => ['string'],
            'remember_me' => [],
        ])->map(
            fn($values,$key) => validationManager($key,$values,config("callmeaf-auth.validations.login_via_email")))
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
