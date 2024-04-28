<?php

namespace Callmeaf\Auth\Http\Requests\V1\Web;

use Illuminate\Foundation\Http\FormRequest;

class AuthVerifyEmailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return app(config('callmeaf-auth.form_request_authorizers.auth_web'))->verifyEmail($this);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return validationManager(rules: [

        ],filters: config("callmeaf-auth.validations.verify_email"));
    }
}
