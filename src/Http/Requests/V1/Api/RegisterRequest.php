<?php

namespace Callmeaf\Auth\Http\Requests\V1\Api;

use Callmeaf\User\Enums\UserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

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
            'type' => [new Enum(UserType::class)],
            'first_name' => ['string','min:3','max:255'],
            'last_name' => ['string','min:3','max:255'],
            'mobile' => ['digits:11',Rule::unique(config('callmeaf-auth.model'),'mobile')],
            'national_code' => ['string','digits:10',Rule::unique(config('callmeaf-auth.model'),'national_code')],
            'email' => ['email',Rule::unique(config('callmeaf-auth.model'),'email')],
            'password' => ['string','min:7'],
        ])->map(
            fn($values,$key) => validationManager($key,$values,config("callmeaf-auth.validations.register")),
        )->toArray();
    }

}
