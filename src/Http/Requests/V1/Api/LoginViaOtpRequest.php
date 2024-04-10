<?php

namespace Callmeaf\Auth\Http\Requests\V1\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginViaOtpRequest extends FormRequest
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
        $otpModel = config('callmeaf-otp.model');
        return validationManager(rules: [
            'mobile' => ['string','max:255', Rule::exists($otpModel, 'mobile'),Rule::exists(config('callmeaf-auth.model'), 'mobile')],
            'code' => ['digits:' . config('callmeaf-otp.length'),Rule::exists($otpModel,'code')],
            'remember_me' => [],
        ],filters: config("callmeaf-auth.validations.login_via_otp"));
    }

}
