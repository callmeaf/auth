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
        return app(config('callmeaf-auth.form_request_authorizers.register'))->registerViaMobile();
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
        ],filters: app(config("callmeaf-auth.validations.register"))->registerViaMobile());
    }

}
