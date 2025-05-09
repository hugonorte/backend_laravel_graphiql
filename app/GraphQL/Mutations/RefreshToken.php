<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\Auth;

class RefreshToken
{
    public function __invoke()
    {
        $newToken = Auth::guard('api')->refresh();

        return [
            'token' => $newToken,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
        ];
    }
}
