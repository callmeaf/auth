<?php

namespace Callmeaf\Auth\Http\Requests\V1\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        return validationManager(rules: [
            'mobile' => ['string', 'digits:11','starts_with:09', Rule::unique(config('callmeaf-auth.model'), 'mobile')],
            'password' => ['string','min:7'],
        ],filters: config("callmeaf-auth.validations.register_via_mobile"));
    }

}
