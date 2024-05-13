<?php

namespace Callmeaf\Auth\Http\Requests\V1\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return app(config('callmeaf-password.form_request_authorizers.forgot_password'))->updatePassword();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return validationManager(rules: [
            'email_or_mobile' => ['string',Rule::exists(config('callmeaf-password.model'),'email_or_mobile')],
            'code' => ['digits:' . config('callmeaf-password.length'),Rule::exists(config('callmeaf-password.model'),'code')],
            'password' => ['string','min:7','confirmed'],
        ],filters: config("callmeaf-password.validations.update_password"));
    }

}
