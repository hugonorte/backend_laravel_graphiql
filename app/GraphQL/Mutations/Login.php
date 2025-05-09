<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Cookie;

class Login
{
    public function __invoke($_, array $args)
    {
        if (! $token = Auth::guard('api')->attempt([
            'email' => $args['email'],
            'password' => $args['password'],
        ])) {
            throw ValidationException::withMessages([
                'email' => ['As credenciais estão incorretas.'],
            ]);
        }

        $refreshToken = Auth::guard('api')->factory()->refresh($token);

        Cookie::queue(
            Cookie::make(
                'refresh_token',
                $refreshToken,
                1440, // 1 dia
                '/',
                null,
                true,   // secure
                true,   // httpOnly
                false,
                'Strict'
            )
        );

        return [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
        ];
    }
}
