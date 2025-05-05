<?php

namespace Callmeaf\Auth\App\Http\Requests\Api\V1;

use Callmeaf\Auth\App\Repo\Contracts\AuthRepoInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AuthPasswordUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(AuthRepoInterface $authRepo): array
    {
        return [
            'password' => ['required','string',Password::min(8)->numbers()->letters()->symbols()->mixedCase()->uncompromised(),'confirmed'],
            'code' => ['required'],
        ];
    }
}
