<?php

namespace Callmeaf\Auth\App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class UserAccountHasNoStatusException extends Exception
{
    public function render(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => __('callmeaf-auth::errors.user_account_has_no_status')
        ], \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN);
    }

}
