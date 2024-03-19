<?php

namespace Callmeaf\Auth\Http\Requests\V1\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class RegisterViaMobileRequest extends FormRequest
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
            'mobile' => ['string', 'digits:11','starts_with:09', Rule::unique(config('callmeaf-auth.model'), 'mobile')],
        ])->map(
            fn($values,$key) => validationManager($key,$values,config("callmeaf-auth.validations.register_via_mobile")))
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
