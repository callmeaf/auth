<?php

namespace Callmeaf\Auth\Http\Requests\V1\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AuthUserRequest extends FormRequest
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
            //
        ])->map(
            fn($values,$key) => validationManager($key,$values,config("callmeaf-auth.validations.get_user")))
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
