<?php

namespace Callmeaf\Auth\App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class UserAccountIsInActiveException extends Exception
{
    public function render(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => __('callmeaf-auth::errors.user_account_is_inactive')
        ], \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN);
    }

}
