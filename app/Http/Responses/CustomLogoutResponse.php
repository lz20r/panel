<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Fortify\Contracts\LogoutResponse;

class CustomLogoutResponse implements LogoutResponse
{
    public function toResponse($request)
    {
        $user = Auth::user();

        if ($user) {
            \App\Helpers\Logger::log(
                '🔴 Usuario cerró sesión: ' . $user->name . ' (' . $user->email . ')',
                'logout',
                [
                    'user_id' => $user->id,
                    'timestamp' => now(),
                ]
            );
        } else {
            Log::info('🚨 Usuario no autenticado al hacer logout');
        }

        return redirect('/');
    }
}
