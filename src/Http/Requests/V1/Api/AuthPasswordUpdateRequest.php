<?php

namespace Callmeaf\Auth\Http\Requests\V1\Api;

use Illuminate\Foundation\Http\FormRequest;

class AuthPasswordUpdateRequest extends FormRequest
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
            'current_password' => ['string'],
            'new_password' => ['string','min:7','confirmed'],
        ])->map(
            fn($values,$key) => validationManager($key,$values,config("callmeaf-auth.validations.password_update")))
            ->toArray();
    }

}
