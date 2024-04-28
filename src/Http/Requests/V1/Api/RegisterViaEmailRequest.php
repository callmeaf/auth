<?php

namespace Callmeaf\Auth\Http\Requests\V1\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterViaEmailRequest extends FormRequest
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
            'email' => ['string', 'email','max:255', Rule::unique(config('callmeaf-auth.model'), 'email')],
            'password' => ['string','min:7','confirmed'],
        ],filters: config("callmeaf-auth.validations.register_via_email"));
    }

}
