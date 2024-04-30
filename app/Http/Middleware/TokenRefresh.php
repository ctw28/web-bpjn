<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TokenRefresh
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Perbarui waktu kedaluwarsa token jika pengguna telah diotentikasi
        if (auth()->check()) {
            $user = auth()->user();
            $token = $user->currentAccessToken();
            // Periksa apakah token ditemukan
            if ($token) {
                // Perbarui waktu kedaluwarsa token
                $token->forceFill([
                    'last_used' => now(),
                ])->save();
            }
        }

        return $response;        
    }
}
