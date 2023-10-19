<?php

namespace Af\Auth\Http\Requests;

use Af\Auth\Enums\UserStatus;
use Af\Auth\Enums\UserType;
use Af\Auth\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class RegisterRequest extends FormRequest
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
        return collect([
            'status' => [new Enum(UserStatus::class)],
            'type' => [new Enum(UserType::class)],
            'first_name' => ['string','min:3','max:255'],
            'last_name' => ['string','min:3','max:255'],
            'mobile' => ['string','digits:11',Rule::unique(User::class,'mobile')],
            'national_code' => ['string','digits:10',Rule::unique(User::class,'national_code')],
            'email' => ['email',Rule::unique(User::class,'email')],
        ])->map(function($values,$key) {
            if(config("af-auth.validations")[$key]) {
                return [
                  'required',
                  ...$values,
                ];
            }
            return [
                'nullable',
                ...$values,
            ];
        })->toArray();
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()->all(),
        ], 422));
    }
}
