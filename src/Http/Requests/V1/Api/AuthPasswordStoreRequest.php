<?php

namespace Callmeaf\Auth\Http\Requests\V1\Api;

use Illuminate\Foundation\Http\FormRequest;

class AuthPasswordStoreRequest extends FormRequest
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
        return validationManager(rules: [
            'password' => ['string','min:7','confirmed'],
        ],filters: config("callmeaf-auth.validations.password_store"));
    }

}
