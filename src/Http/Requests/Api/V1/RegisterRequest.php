<?php

namespace Callmeaf\Auth\Http\Requests\Api\V1;

use Callmeaf\User\Enums\UserStatus;
use Callmeaf\User\Enums\UserType;
use Callmeaf\User\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class RegisterRequest extends FormRequest
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
            'status' => [new Enum(UserStatus::class)],
            'type' => [new Enum(UserType::class)],
            'first_name' => ['string','min:3','max:255'],
            'last_name' => ['string','min:3','max:255'],
            'mobile' => ['string','digits:11',Rule::unique(config('callmeaf-auth.model'),'mobile')],
            'national_code' => ['string','digits:10',Rule::unique(config('callmeaf-auth.model'),'national_code')],
            'email' => ['email',Rule::unique(config('callmeaf-auth.model'),'email')],
        ])->map(
            fn($values,$key) => validationManager($key,$values,config("callmeaf-auth.validations.register")),
        )->toArray();
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(apiResponse([
            'errors' => $validator->errors(),
        ], (new ValidationException($validator))->getMessage(),
            Response::HTTP_UNPROCESSABLE_ENTITY),
        );
    }
}
