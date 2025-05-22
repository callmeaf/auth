<?php

namespace Callmeaf\Auth\App\Http\Requests\Api\V1;

use Callmeaf\Auth\App\Repo\Contracts\AuthRepoInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AuthProfileUpdateRequest extends FormRequest
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
            'first_name' => ['required','string','max:255'],
            'last_name' => ['required','string','max:255'],
            'mobile' => ['required','digits:11','starts_with:09',Rule::unique($authRepo->getTable(),'mobile')->ignore($this->user()->id)],
            'image' => ['nullable','file','mimes:png,jpg,jpeg','max:2048']
        ];
    }
}
