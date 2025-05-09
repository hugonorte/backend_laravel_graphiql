<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

Route::post('/auth/refresh', function () {
    $refreshToken = request()->cookie('refresh_token');

    if (!$refreshToken) {
        return response()->json(['message' => 'Refresh token não encontrado.'], 401);
    }

    try {
        $newToken = Auth::guard('api')->refresh(true, false, $refreshToken);

        return response()->json([
            'access_token' => $newToken,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
        ]);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Refresh inválido'], 401);
    }
});

Route::post('/auth/logout', function () {
    Cookie::queue(Cookie::forget('refresh_token'));
    return response()->json(['message' => 'Logout realizado com sucesso']);
});
