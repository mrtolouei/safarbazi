<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        if (Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password'], 'is_admin' => 1])) {
            $token = $request->user()->createToken('api')->plainTextToken;

            return self::json([
                'token' => $token,
            ], 'Login is successful');
        }

        return self::json([], 'Credential is invalid', 401);
    }
}
