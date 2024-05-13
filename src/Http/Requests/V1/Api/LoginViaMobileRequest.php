<?php

namespace Callmeaf\Auth\Http\Requests\V1\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginViaMobileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return app(config('callmeaf-auth.form_request_authorizers.login'))->loginViaMobile();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return validationManager(rules: [
            'mobile' => ['string','max:255', Rule::exists(config('callmeaf-auth.model'), 'mobile')],
            'password' => ['string'],
            'remember_me' => [],
        ],filters:  app(config('callmeaf-auth.validations.login'))->loginViaMobile());
    }

}
