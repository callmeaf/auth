<?php

namespace Callmeaf\Auth\App\Http\Requests\Admin\V1;

use Callmeaf\Auth\App\Repo\Contracts\AuthRepoInterface;
use Illuminate\Foundation\Http\FormRequest;

class AuthUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if($user = $this->user()) {
            /**
             * @var AuthRepoInterface $authRepo
             */
            $authRepo = app(AuthRepoInterface::class);
            return $authRepo->checkUserStatus(user: $user);
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

        ];
    }
}
