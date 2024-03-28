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
        if(array_key_exists('auth',config('callmeaf-auth.middlewares.verify_email'))) {
            $authUser = $this->user();
            if (! hash_equals((string) $authUser->getKey(), (string) $this->route('id'))) {
                return false;
            }

            if (! hash_equals(sha1($authUser->getEmailForVerification()), (string) $this->route('hash'))) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
