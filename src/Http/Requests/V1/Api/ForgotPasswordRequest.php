<?php

namespace Callmeaf\Auth\Http\Requests\V1\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ForgotPasswordRequest extends FormRequest
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
        $emailOrMobile = $this->get('email_or_mobile');
        return validationManager(rules: [
            'email_or_mobile' => ['string',Rule::exists(config('callmeaf-auth.model'),str($emailOrMobile)->contains('@') ? 'email' : 'mobile')],
        ],filters: config("callmeaf-password.validations.forgot_password"));
    }

}
