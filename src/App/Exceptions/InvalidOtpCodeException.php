<?php

namespace Callmeaf\Auth\App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class InvalidOtpCodeException extends Exception
{
    public function render(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => __('callmeaf-auth::errors.invalid_otp_code')
        ], \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN);
    }

}
