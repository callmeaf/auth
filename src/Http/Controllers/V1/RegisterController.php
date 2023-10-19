<?php

namespace Af\Auth\Http\Controllers\V1;

use Af\Auth\Http\Requests\RegisterRequest;
use Af\Auth\Models\User;

class RegisterController extends BaseController
{
    public function register(RegisterRequest $request)
    {
        return response()->json([
            'data' => User::create($request->all()),
            'message' => 'User created successfully',
        ],200);
    }
}
