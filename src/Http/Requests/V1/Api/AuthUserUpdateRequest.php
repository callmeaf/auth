<?php

namespace Callmeaf\Auth\Http\Requests\V1\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthUserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return app(config('callmeaf-auth.form_request_authorizers.auth'))->userUpdate();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = authUser(request: $this)->id;
        return validationManager(rules: [
            'first_name' => ['string','max:50'],
            'last_name' => ['string','max:50'],
            'national_code' => ['digits:10',Rule::unique(config('callmeaf-auth.model','national_code'))->ignore($userId)],
            'email' => ['email',Rule::unique(config('callmeaf-auth.model','email'))->ignore($userId)],
        ],filters:  app(config('callmeaf-auth.validations.auth'))->userUpdate());
    }

}
